<?php
use yii\helpers\Html;
$this->title='Словарь';
?>
<section class="lb-admin-page">
 <?php foreach (['success', 'error'] as $flashType): ?>
   <?php if (Yii::$app->session->hasFlash($flashType)): ?>
     <div class="lb-notice <?= $flashType === 'error' ? 'notice-error' : 'notice-success' ?>"><?= Html::encode(Yii::$app->session->getFlash($flashType)) ?></div>
   <?php endif; ?>
 <?php endforeach; ?>
 <header class="lb-crud-header"><div><p class="eyebrow">УПРАВЛЕНИЕ ЛЕКСИКОЙ</p><h1>Словарь</h1><p>Все слова и выражения, которые доступны в Language Bloom.</p></div><div class="lb-crud-actions"><?= Html::a('← Админ-панель',['/admin/index'],['class'=>'lb-crud-ghost']) ?> <?= Html::a('+ Добавить слово',['create'],['class'=>'lb-crud-primary']) ?></div></header>
 <div class="lb-crud-summary"><span class="lb-crud-summary-icon">✎</span><div><strong><?= count($models) ?></strong><small>слов и выражений</small></div></div>
 <div class="lb-crud-card"><div class="lb-crud-table-wrap"><table class="lb-crud-table"><thead><tr><th>ID</th><th>Язык</th><th>Слово</th><th>Транскрипция</th><th>Перевод</th><th>Тип</th><th>Действия</th></tr></thead><tbody>
 <?php foreach($models as $m): ?><tr><td class="lb-id-cell"><?= (int)$m->id ?></td><td><?= Html::encode($m->language0?$m->language0->name:'—') ?></td><td><b class="lb-word-primary"><?= Html::encode($m->word) ?></b></td><td><?= Html::encode($m->transcription) ?></td><td><?= Html::encode($m->translation) ?></td><td><span class="lb-role-tag"><?= $m->pos==='expression'?'Выражение':'Слово' ?></span></td><td class="lb-row-actions"><?= Html::a('Изменить',['update','id'=>$m->id]) ?><?= Html::beginForm(['delete', 'id' => $m->id], 'post', ['class' => 'lb-inline-delete', 'onsubmit' => 'return confirm("Удалить эту запись?");']) . Html::submitButton('Удалить', ['class' => 'lb-delete-button']) . Html::endForm() ?></td></tr><?php endforeach; ?>
 <?php if(!$models): ?><tr><td colspan="7" class="lb-empty-row">Словарь пока пуст. Добавь первое слово.</td></tr><?php endif; ?>
 </tbody></table></div></div>
</section>
