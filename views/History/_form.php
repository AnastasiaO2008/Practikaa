<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\Account;
use app\models\Language;
$this->title=$model->isNewRecord?'Добавить занятие':'Изменить занятие';
?>
<section class="lb-admin-page">
 <header class="lb-crud-header"><div><p class="eyebrow">УЧЕБНАЯ АКТИВНОСТЬ</p><h1><?= Html::encode($this->title) ?></h1><p>Укажи участника, язык и статус занятия.</p></div><?= Html::a('← К истории',['index'],['class'=>'lb-crud-ghost']) ?></header>
 <div class="lb-crud-form-card"><?php $form=ActiveForm::begin(['options'=>['class'=>'lb-admin-form']]); ?>
 <div class="lb-form-grid">
  <?= $form->field($model,'id_account')->dropDownList(ArrayHelper::map(Account::find()->orderBy(['name'=>SORT_ASC])->all(),'id','name'),['prompt'=>'Выбери пользователя']) ?>
  <?= $form->field($model,'language')->dropDownList(ArrayHelper::map(Language::find()->orderBy(['name'=>SORT_ASC])->all(),'id','name'),['prompt'=>'Выбери язык']) ?>
  <?= $form->field($model,'date')->input('date') ?>
  <?= $form->field($model,'lesson')->dropDownList(['Грамматика'=>'Грамматика','Лексика'=>'Лексика']) ?>
  <?= $form->field($model,'time')->textInput(['maxlength'=>true,'placeholder'=>'25 минут']) ?>
  <?= $form->field($model,'status')->dropDownList(['Текущая'=>'Текущая','Завершено'=>'Завершено']) ?>
 </div><div class="lb-form-actions"><?= Html::submitButton('Сохранить запись',['class'=>'lb-crud-primary']) ?> <?= Html::a('Отмена',['index'],['class'=>'lb-crud-ghost']) ?></div>
 <?php ActiveForm::end(); ?></div>
</section>
