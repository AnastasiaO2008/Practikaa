<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\AccessControl;
use app\models\Words;
use app\models\Language;
use yii\helpers\ArrayHelper;

class ApiController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['create-word'],
                'rules' => [['allow' => true, 'roles' => ['@']]],
            ],
        ];
    }

    public function beforeAction($action)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return parent::beforeAction($action);
    }

    public function actionWords()
    {
        $rows = Words::find()->with('language0')->orderBy(['id' => SORT_DESC])->all();
        $result = [];
        foreach ($rows as $row) {
            $result[] = [
                'id' => (int)$row->id,
                'language' => $row->language0 ? $row->language0->name : '',
                'word' => $row->word,
                'transcription' => $row->transcription,
                'translation' => $row->translation,
                'kind' => $row->pos === 'expression' ? 'Выражение' : 'Существительное',
                'status' => 'learning',
            ];
        }
        return ['success' => true, 'words' => $result];
    }

    public function actionCreateWord()
    {
        $body = Yii::$app->request->post();
        $languageName = trim((string)($body['language'] ?? ''));
        $wordText = trim((string)($body['word'] ?? ''));
        $transcription = trim((string)($body['transcription'] ?? ''));
        $translation = trim((string)($body['translation'] ?? ''));

        if ($languageName === '' || $wordText === '' || $translation === '') {
            Yii::$app->response->statusCode = 422;
            return ['success' => false, 'message' => 'Заполни язык, слово и перевод.'];
        }

        $language = Language::find()->where(['name' => $languageName])->one();
        if (!$language) {
            $language = new Language(['name' => $languageName]);
            if (!$language->save()) {
                Yii::$app->response->statusCode = 422;
                return ['success' => false, 'message' => 'Не удалось сохранить язык.', 'errors' => $language->errors];
            }
        }

        $model = new Words();
        $model->language = $language->id;
        $model->word = $wordText;
        $model->transcription = $transcription !== '' ? $transcription : '—';
        $model->translation = $translation;
        $model->pos = 'noun';

        if (!$model->save()) {
            Yii::$app->response->statusCode = 422;
            return ['success' => false, 'message' => 'Не удалось сохранить слово.', 'errors' => $model->errors];
        }

        return ['success' => true, 'id' => (int)$model->id];
    }
}
