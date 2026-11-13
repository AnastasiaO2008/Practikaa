<?php
use yii\helpers\Html;
$this->title='Занятие №'.$model->id;
?>
<section class="lb-admin-page"><header class="lb-crud-header"><div><p class="eyebrow">УЧЕБНАЯ АКТИВНОСТЬ</p><h1>Занятие №<?= (int)$model->id ?></h1><p>Подробная информация о записи.</p></div><div class="lb-crud-actions"><?= Html::a('← К истории',['index'],['class'=>'lb-crud-ghost']) ?> <?= Html::a('Изменить',['update','id'=>$model->id],['class'=>'lb-crud-primary']) ?></div></header>
<div class="lb-crud-form-card lb-detail-grid"><div><small>Участник</small><b><?= Html::encode($model->account?$model->account->name:'—') ?></b></div><div><small>Язык</small><b><?= Html::encode($model->language0?$model->language0->name:'—') ?></b></div><div><small>Дата</small><b><?= Html::encode($model->date) ?></b></div><div><small>Тип урока</small><b><?= Html::encode($model->lesson) ?></b></div><div><small>Длительность</small><b><?= Html::encode($model->time) ?></b></div><div><small>Статус</small><b><?= Html::encode($model->status) ?></b></div></div></section>
