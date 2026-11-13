<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\RegistrationForm;
use app\models\Words;
use app\models\History;
use app\models\Language;
use app\models\FavoriteWord;

/** Главный контроллер страниц Language Bloom. */
class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'profile'],
                'rules' => [[
                    'actions' => ['logout', 'profile'],
                    'allow' => true,
                    'roles' => ['@'],
                ]],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => ['logout' => ['post']],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => ['class' => 'yii\web\ErrorAction'],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        $stats = $this->getLearningStats();
        $languages = Language::find()->orderBy(['id' => SORT_ASC])->all();
        $languageCards = [];
        foreach ($languages as $language) {
            $count = (int) Words::find()->where(['language' => $language->id])->count();
            $languageCards[] = [
                'id' => (int)$language->id,
                'name' => $language->name,
                'count' => $count,
                'progress' => min(100, (int)round($count / 500 * 100)),
                'flag' => mb_stripos($language->name, 'япон') !== false ? '🇯🇵' : (mb_stripos($language->name, 'итал') !== false ? '🇮🇹' : '🌐'),
            ];
        }
        $this->view->title = 'Главная';
        return $this->render('index', ['stats' => $stats, 'languageCards' => $languageCards]);
    }

    public function actionWords()
    {
        return $this->renderPage('Слова', 'words');
    }

    public function actionProfile()
    {
        $stats = $this->getLearningStats();
        return $this->render('profile', ['stats' => $stats]);
    }

    public function actionAchievements()
    {
        $stats = $this->getLearningStats();
        $this->view->title = 'Достижения';
        return $this->render('achievements', ['stats' => $stats]);
    }

    /**
     * Все показатели рассчитываются по фактическим данным БД.
     * В текущей схеме words не привязана к account_id, поэтому это общий
     * словарь проекта; история занятий и избранное считаются для текущего пользователя.
     */
    private function getLearningStats(): array
    {
        $accountId = (int) Yii::$app->user->id;
        $wordCount = (int) Words::find()->count();
        $completedQuery = History::find()
            ->where(['id_account' => $accountId, 'status' => 'Завершено']);
        $completedSessions = (int) (clone $completedQuery)->count();
        $languageCount = (int) History::find()
            ->select('language')
            ->where(['id_account' => $accountId])
            ->distinct()
            ->count('language');
        $favoriteCount = (int) FavoriteWord::find()
            ->where(['account_id' => $accountId])
            ->count();

        $dates = History::find()
            ->select('date')
            ->where(['id_account' => $accountId, 'status' => 'Завершено'])
            ->distinct()
            ->orderBy(['date' => SORT_DESC])
            ->column();

        $uniqueDates = [];
        foreach ($dates as $date) {
            $day = date('Y-m-d', strtotime((string) $date));
            $uniqueDates[$day] = true;
        }
        $days = array_keys($uniqueDates);
        rsort($days);

        $today = new \DateTimeImmutable('today', new \DateTimeZone(Yii::$app->timeZone ?: date_default_timezone_get()));
        $currentStreak = 0;
        if ($days) {
            $latest = new \DateTimeImmutable($days[0]);
            $gap = (int) $today->diff($latest)->format('%r%a');
            if ($gap === 0 || $gap === -1) {
                $expected = $latest;
                foreach ($days as $day) {
                    $actual = new \DateTimeImmutable($day);
                    if ($actual->format('Y-m-d') !== $expected->format('Y-m-d')) {
                        break;
                    }
                    $currentStreak++;
                    $expected = $expected->modify('-1 day');
                }
            }
        }

        $bestStreak = 0;
        $run = 0;
        $previous = null;
        $ascending = $days;
        sort($ascending);
        foreach ($ascending as $day) {
            $date = new \DateTimeImmutable($day);
            if ($previous !== null && $date->diff($previous)->days === 1) {
                $run++;
            } else {
                $run = 1;
            }
            $bestStreak = max($bestStreak, $run);
            $previous = $date;
        }

        $activityDates = [];
        $calendar = new \DateTimeImmutable('today', new \DateTimeZone(Yii::$app->timeZone ?: date_default_timezone_get()));
        for ($offset = 6; $offset >= 0; $offset--) {
            $activityDates[] = $calendar->modify('-' . $offset . ' days')->format('Y-m-d');
        }

        return [
            'activityDates' => $activityDates,
            'activeDates' => array_values(array_keys($uniqueDates)),
            'wordCount' => $wordCount,
            'completedSessions' => $completedSessions,
            'languageCount' => $languageCount,
            'favoriteCount' => $favoriteCount,
            'currentStreak' => $currentStreak,
            'bestStreak' => $bestStreak,
            'streakGoal' => 14,
            'wordGoal' => 500,
            'sessionGoal' => 50,
        ];
    }

    public function actionCompleteLesson()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->user->isGuest) {
            Yii::$app->response->statusCode = 401;
            return ['success' => false, 'message' => 'Войди в аккаунт, чтобы сохранить занятие.'];
        }

        $language = Language::find()
            ->where(['like', 'name', 'япон'])
            ->one();
        if (!$language) {
            $language = Language::find()->orderBy(['id' => SORT_ASC])->one();
        }
        if (!$language) {
            Yii::$app->response->statusCode = 422;
            return ['success' => false, 'message' => 'В базе пока нет языков. Добавь японский язык через панель администратора.'];
        }

        $today = date('Y-m-d');
        $accountId = (int)Yii::$app->user->id;
        $existing = History::find()->where([
            'id_account' => $accountId,
            'date' => $today,
            'language' => $language->id,
            'lesson' => 'Грамматика',
            'status' => 'Завершено',
        ])->one();

        if (!$existing) {
            $history = new History();
            $history->id_account = $accountId;
            $history->date = $today;
            $history->language = $language->id;
            $history->lesson = 'Грамматика';
            $history->time = '25 минут';
            $history->status = 'Завершено';
            if (!$history->save()) {
                Yii::$app->response->statusCode = 422;
                return ['success' => false, 'message' => 'Не удалось сохранить занятие.', 'errors' => $history->errors];
            }
        }

        return [
            'success' => true,
            'alreadyCompleted' => (bool)$existing,
            'streak' => $this->getLearningStats()['currentStreak'],
        ];
    }

    public function actionGrammar()
    {
        return $this->renderPage('Грамматика', 'grammar');
    }

    private function renderPage(string $title, string $view): string
    {
        $this->view->title = $title;
        return $this->render($view);
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['/site/profile']);
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(['/site/profile']);
        }

        $model->password = '';
        return $this->render('login', ['model' => $model]);
    }

    public function actionRegister()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['/site/profile']);
        }

        $model = new RegistrationForm();
        if ($model->load(Yii::$app->request->post()) && $model->register()) {
            $account = \app\models\Account::findByEmail($model->mail);
            if ($account) {
                Yii::$app->user->login($account);
            }
            Yii::$app->session->setFlash('success', 'Регистрация прошла успешно. Добро пожаловать!');
            return $this->redirect(['/site/profile']);
        }

        return $this->render('register', ['model' => $model]);
    }

    public function actionLogout(): Response
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');
            return $this->refresh();
        }
        return $this->render('contact', ['model' => $model]);
    }
}
