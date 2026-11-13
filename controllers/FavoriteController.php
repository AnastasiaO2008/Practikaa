<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\FavoriteWord;
use app\models\Words;

class FavoriteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [['allow' => true, 'roles' => ['@']]],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => ['add' => ['POST'], 'remove' => ['POST']],
            ],
        ];
    }

    public function actionIndex()
    {
        $favorites = FavoriteWord::find()
            ->where(['account_id' => Yii::$app->user->id])
            ->with('word.language0')
            ->orderBy(['id' => SORT_DESC])
            ->all();

        $savedIds = array_map(static function ($favorite) { return (int) $favorite->word_id; }, $favorites);
        $wordQuery = Words::find()->with('language0')->orderBy(['word' => SORT_ASC]);
        if ($savedIds) {
            $wordQuery->andWhere(['not in', 'id', $savedIds]);
        }
        $words = $wordQuery->all();
        return $this->render('index', ['favorites' => $favorites, 'words' => $words]);
    }

    public function actionAdd()
    {
        // wordId приходит из POST-формы, а не из URL.
        $wordId = (int) Yii::$app->request->post('wordId');
        $word = Words::findOne($wordId);
        if (!$word) {
            throw new NotFoundHttpException('Слово не найдено.');
        }

        $favorite = FavoriteWord::findOne([
            'account_id' => Yii::$app->user->id,
            'word_id' => $word->id,
        ]);
        if (!$favorite) {
            $favorite = new FavoriteWord([
                'account_id' => Yii::$app->user->id,
                'word_id' => $word->id,
                'created_at' => time(),
            ]);
            if (!$favorite->save()) {
                Yii::$app->session->setFlash('error', 'Не удалось добавить слово в избранное.');
            } else {
                Yii::$app->session->setFlash('success', 'Слово добавлено в избранное.');
            }
        }
        return $this->redirect(['index']);
    }

    public function actionRemove()
    {
        $id = (int) Yii::$app->request->post('favoriteId', Yii::$app->request->get('id', 0));
        $favorite = FavoriteWord::findOne([
            'id' => $id,
            'account_id' => Yii::$app->user->id,
        ]);
        if ($favorite) {
            if ($favorite->delete() !== false) {
                Yii::$app->session->setFlash('success', 'Слово удалено из избранного.');
            } else {
                Yii::$app->session->setFlash('error', 'Не удалось удалить слово. Попробуй ещё раз.');
            }
        } else {
            Yii::$app->session->setFlash('error', 'Запись избранного не найдена.');
        }
        return $this->redirect(['index']);
    }
}
