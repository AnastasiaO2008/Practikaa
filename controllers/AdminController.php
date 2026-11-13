<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use app\models\Account;
use app\models\Language;
use app\models\Words;
use app\models\History;
use app\models\FavoriteWord;

/**
 * Главная административная панель Language Bloom.
 */
class AdminController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [[
                    'allow' => true,
                    'roles' => ['@'],
                    'matchCallback' => static function () {
                        return !Yii::$app->user->isGuest
                            && Yii::$app->user->identity->role === 'admin';
                    },
                ]],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index', [
            'stats' => [
                'accounts' => (int) Account::find()->count(),
                'languages' => (int) Language::find()->count(),
                'words' => (int) Words::find()->count(),
                'histories' => (int) History::find()->count(),
                'favorites' => (int) FavoriteWord::find()->count(),
            ],
            'recentAccounts' => Account::find()->select(['id', 'name', 'mail', 'role'])
                ->orderBy(['id' => SORT_DESC])->limit(6)->all(),
            'recentWords' => Words::find()->with('language0')
                ->orderBy(['id' => SORT_DESC])->limit(6)->all(),
        ]);
    }
}
