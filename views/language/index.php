<?php
use yii\helpers\Html;
$this->title='Языки';
?>
<section class="lb-admin-page">
 <?php foreach (['success', 'error'] as $flashType): ?>
   <?php if (Yii::$app->session->hasFlash($flashType)): ?>
     <div class="lb-notice <?= $flashType === 'error' ? 'notice-error' : 'notice-success' ?>"><?= Html::encode(Yii::$app->session->getFlash($flashType)) ?></div>
   <?php endif; ?>
 <?php endforeach; ?>
 <header class="lb-crud-header"><div><p class="eyebrow">КАТАЛОГ ЯЗЫКОВ</p><h1>Языки</h1><p>Добавляй языки, для которых можно вести словарь и занятия.</p></div><div class="lb-crud-actions"><?= Html::a('← Админ-панель',['/admin/index'],['class'=>'lb-crud-ghost']) ?> <?= Html::a('+ Добавить язык',['create'],['class'=>'lb-crud-primary']) ?></div></header>
 <div class="lb-crud-summary"><span class="lb-crud-summary-icon">文</span><div><strong><?= count($models) ?></strong><small>языка в каталоге</small></div></div>
 <div class="lb-language-grid">
 <?php foreach($models as $model): ?>
  <article class="lb-language-admin-card"><span class="lb-language-flag"><?= mb_stripos($model->name,'япон')!==false?'🇯🇵':(mb_stripos($model->name,'итал')!==false?'🇮🇹':'🌐') ?></span><div><h2><?= Html::encode($model->name) ?></h2><small><?= (int)$model->getWords()->count() ?> слов в словаре</small></div><div class="lb-row-actions"><?= Html::a('Изменить',['update','id'=>$model->id]) ?><?= Html::beginForm(['delete', 'id' => $model->id], 'post', ['class' => 'lb-inline-delete', 'onsubmit' => 'return confirm("Удалить эту запись?");']) . Html::submitButton('Удалить', ['class' => 'lb-delete-button']) . Html::endForm() ?></div></article>
 <?php endforeach; ?>
 <?php if(!$models): ?><p class="lb-empty-row">Пока нет языков. Добавь первый язык.</p><?php endif; ?>
 </div>
</section>
