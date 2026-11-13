<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = $model->isNewRecord ? 'Новый аккаунт' : 'Редактирование аккаунта';
?>
<section class="lb-admin-page">
 <header class="lb-crud-header"><div><p class="eyebrow">УПРАВЛЕНИЕ АККАУНТАМИ</p><h1><?= Html::encode($this->title) ?></h1><p>Заполни данные участника и выбери уровень доступа.</p></div><?= Html::a('← К пользователям',['index'],['class'=>'lb-crud-ghost']) ?></header>
 <div class="lb-crud-form-card">
  <?php $form=ActiveForm::begin(['options'=>['class'=>'lb-admin-form']]); ?>
   <div class="lb-form-grid">
    <?= $form->field($model,'name')->textInput(['maxlength'=>true,'placeholder'=>'Имя пользователя']) ?>
    <?= $form->field($model,'mail')->input('email',['maxlength'=>true,'placeholder'=>'name@example.com']) ?>
    <?= $form->field($model,'role')->dropDownList(['user'=>'Пользователь','admin'=>'Администратор']) ?>
    <?= $form->field($model,'newPassword')->passwordInput(['maxlength'=>true,'placeholder'=>$model->isNewRecord?'Придумай пароль':'Оставь пустым, чтобы не менять'])->label($model->isNewRecord?'Пароль':'Новый пароль') ?>
   </div>
   <div class="lb-form-note">Пароль хранится в базе только в виде защищённого хеша.</div>
   <div class="lb-form-actions"><?= Html::submitButton('Сохранить аккаунт',['class'=>'lb-crud-primary']) ?> <?= Html::a('Отмена',['index'],['class'=>'lb-crud-ghost']) ?></div>
  <?php ActiveForm::end(); ?>
 </div>
</section>
