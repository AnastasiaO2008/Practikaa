<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title=$model->isNewRecord?'Добавить язык':'Изменить язык';
?>
<section class="lb-admin-page">
 <header class="lb-crud-header"><div><p class="eyebrow">КАТАЛОГ ЯЗЫКОВ</p><h1><?= Html::encode($this->title) ?></h1><p>Название появится в списках выбора языка.</p></div><?= Html::a('← К языкам',['index'],['class'=>'lb-crud-ghost']) ?></header>
 <div class="lb-crud-form-card"><?php $form=ActiveForm::begin(['options'=>['class'=>'lb-admin-form']]); ?>
  <?= $form->field($model,'name')->textInput(['maxlength'=>true,'placeholder'=>'Например, Японский']) ?>
  <div class="lb-form-actions"><?= Html::submitButton('Сохранить язык',['class'=>'lb-crud-primary']) ?> <?= Html::a('Отмена',['index'],['class'=>'lb-crud-ghost']) ?></div>
 <?php ActiveForm::end(); ?></div>
</section>
