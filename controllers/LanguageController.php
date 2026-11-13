<?php
namespace app\controllers;

use Yii;
use app\models\Language;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class LanguageController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => ['class' => AccessControl::class, 'rules' => [[
                'allow' => true, 'roles' => ['@'],
                'matchCallback' => function () { return !Yii::$app->user->isGuest && Yii::$app->user->identity->role === 'admin'; },
            ]]],
            'verbs' => ['class' => VerbFilter::class, 'actions' => ['delete' => ['POST']]],
        ];
    }
    public function actionIndex() { return $this->render('index', ['models' => Language::find()->orderBy(['id'=>SORT_DESC])->all()]); }
    public function actionCreate() { $m = new Language(); if ($m->load(Yii::$app->request->post()) && $m->save()) return $this->redirect(['index']); return $this->render('form',['model'=>$m]); }
    public function actionUpdate($id) { $m=$this->findModel($id); if ($m->load(Yii::$app->request->post()) && $m->save()) return $this->redirect(['index']); return $this->render('form',['model'=>$m]); }
    public function actionDelete($id) { try {
            $model = $this->findModel($id);
            if ($model->delete() === false) {
                Yii::$app->session->setFlash('error', 'Не удалось удалить запись.');
            } else {
                Yii::$app->session->setFlash('success', 'Запись удалена.');
            }
        } catch (\yii\db\IntegrityException $e) {
            Yii::$app->session->setFlash('error', 'Нельзя удалить запись: с ней связаны другие данные. Сначала удалите зависимые записи.');
        }
        return $this->redirect(['index']); }
    protected function findModel($id) { $m=Language::findOne($id); if ($m) return $m; throw new NotFoundHttpException('Язык не найден.'); }
}
