<?php
use yii\helpers\Html;
$this->title='История занятий';
$rows=$dataProvider->getModels();
?>
<section class="lb-admin-page">
 <?php foreach (['success', 'error'] as $flashType): ?>
   <?php if (Yii::$app->session->hasFlash($flashType)): ?>
     <div class="lb-notice <?= $flashType === 'error' ? 'notice-error' : 'notice-success' ?>"><?= Html::encode(Yii::$app->session->getFlash($flashType)) ?></div>
   <?php endif; ?>
 <?php endforeach; ?>
 <header class="lb-crud-header"><div><p class="eyebrow">УЧЕБНАЯ АКТИВНОСТЬ</p><h1>История занятий</h1><p>Завершённые и текущие уроки участников.</p></div><div class="lb-crud-actions"><?= Html::a('← Админ-панель',['/admin/index'],['class'=>'lb-crud-ghost']) ?> <?= Html::a('+ Добавить запись',['create'],['class'=>'lb-crud-primary']) ?></div></header>
 <div class="lb-crud-card"><div class="lb-crud-table-wrap"><table class="lb-crud-table"><thead><tr><th>ID</th><th>Участник</th><th>Дата</th><th>Язык</th><th>Урок</th><th>Время</th><th>Статус</th><th>Действия</th></tr></thead><tbody>
 <?php foreach($rows as $m): ?><tr><td class="lb-id-cell"><?= (int)$m->id ?></td><td><?= Html::encode($m->account?$m->account->name:'—') ?></td><td><?= Html::encode($m->date) ?></td><td><?= Html::encode($m->language0?$m->language0->name:'—') ?></td><td><?= Html::encode($m->lesson) ?></td><td><?= Html::encode($m->time) ?></td><td><span class="lb-role-tag <?= $m->status==='Завершено'?'admin':'' ?>"><?= Html::encode($m->status) ?></span></td><td class="lb-row-actions"><?= Html::a('Открыть',['view','id'=>$m->id]) ?><?= Html::a('Изменить',['update','id'=>$m->id]) ?><?= Html::beginForm(['delete', 'id' => $m->id], 'post', ['class' => 'lb-inline-delete', 'onsubmit' => 'return confirm("Удалить эту запись?");']) . Html::submitButton('Удалить', ['class' => 'lb-delete-button']) . Html::endForm() ?></td></tr><?php endforeach; ?>
 <?php if(!$rows): ?><tr><td colspan="8" class="lb-empty-row">Записей пока нет. Они появятся после завершения занятий.</td></tr><?php endif; ?>
 </tbody></table></div><div class="lb-crud-pagination"><?= \yii\widgets\LinkPager::widget(['pagination'=>$dataProvider->pagination]) ?></div></div>
</section>
