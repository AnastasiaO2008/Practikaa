<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title=$model->isNewRecord?'Добавить слово':'Редактировать слово';
?>
<section class="lb-admin-page">
 <header class="lb-crud-header"><div><p class="eyebrow">УПРАВЛЕНИЕ ЛЕКСИКОЙ</p><h1><?= Html::encode($this->title) ?></h1><p>Заполни карточку — слово появится в общем словаре.</p></div><?= Html::a('← К словарю',['index'],['class'=>'lb-crud-ghost']) ?></header>
 <div class="lb-crud-form-card"><?php $form=ActiveForm::begin(['options'=>['class'=>'lb-admin-form']]); ?>
  <div class="lb-form-grid">
   <?= $form->field($model,'language')->dropDownList($languages,['prompt'=>'Выбери язык']) ?>
   <?= $form->field($model,'pos')->dropDownList(['noun'=>'Слово','expression'=>'Выражение']) ?>
   <?= $form->field($model,'word')->textInput(['maxlength'=>true,'placeholder'=>'Напиши слово']) ?>
   <?= $form->field($model,'transcription')->textInput(['maxlength'=>true,'placeholder'=>'Например, [konnichiwa]']) ?>
   <?= $form->field($model,'translation')->textInput(['maxlength'=>true,'placeholder'=>'Перевод на русский']) ?>
  </div>
  <div class="lb-form-actions"><?= Html::submitButton('Сохранить слово',['class'=>'lb-crud-primary']) ?> <?= Html::a('Отмена',['index'],['class'=>'lb-crud-ghost']) ?></div>
 <?php ActiveForm::end(); ?></div>
</section>
