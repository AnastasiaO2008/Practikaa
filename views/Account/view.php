<?php
use yii\helpers\Html;
$this->title='Аккаунт · '.$model->name;
?>
<section class="lb-admin-page">
 <header class="lb-crud-header"><div><p class="eyebrow">КАРТОЧКА ПОЛЬЗОВАТЕЛЯ</p><h1><?= Html::encode($model->name) ?></h1><p>Информация об аккаунте Language Bloom.</p></div><div class="lb-crud-actions"><?= Html::a('← К списку',['index'],['class'=>'lb-crud-ghost']) ?> <?= Html::a('Изменить',['update','id'=>$model->id],['class'=>'lb-crud-primary']) ?></div></header>
 <div class="lb-detail-card"><div class="lb-detail-avatar"><?= Html::encode(mb_strtoupper(mb_substr((string)$model->name,0,1,'UTF-8'),'UTF-8')) ?></div><div><span class="eyebrow">УЧАСТНИК</span><h2><?= Html::encode($model->name) ?></h2><p><?= Html::encode($model->mail) ?></p><span class="lb-role-tag <?= $model->role==='admin'?'admin':'' ?>"><?= $model->role==='admin'?'Администратор':'Пользователь' ?></span></div><dl><dt>ID аккаунта</dt><dd><?= (int)$model->id ?></dd><dt>Электронная почта</dt><dd><?= Html::encode($model->mail) ?></dd></dl></div>
</section>
