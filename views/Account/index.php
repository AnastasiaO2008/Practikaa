<?php
use yii\helpers\Html;
$this->title = 'Пользователи';
$rows = $dataProvider->getModels();
?>
<section class="lb-admin-page">
 <?php foreach (['success', 'error'] as $flashType): ?>
   <?php if (Yii::$app->session->hasFlash($flashType)): ?>
     <div class="lb-notice <?= $flashType === 'error' ? 'notice-error' : 'notice-success' ?>"><?= Html::encode(Yii::$app->session->getFlash($flashType)) ?></div>
   <?php endif; ?>
 <?php endforeach; ?>
  <header class="lb-crud-header"><div><p class="eyebrow">УПРАВЛЕНИЕ АККАУНТАМИ</p><h1>Пользователи</h1><p>Участники Language Bloom и их права доступа.</p></div><div class="lb-crud-actions"><?= Html::a('← Админ-панель',['/admin/index'],['class'=>'lb-crud-ghost']) ?> <?= Html::a('+ Создать аккаунт',['create'],['class'=>'lb-crud-primary']) ?></div></header>
  <div class="lb-crud-summary"><span class="lb-crud-summary-icon">♙</span><div><strong><?= (int)$dataProvider->getTotalCount() ?></strong><small>аккаунтов в системе</small></div><span class="lb-crud-summary-note">Данные обновляются автоматически</span></div>
  <div class="lb-crud-card">
    <div class="lb-crud-card-heading"><div><span class="eyebrow">СПИСОК АККАУНТОВ</span><h2>Все пользователи</h2></div></div>
    <?php $form = \yii\widgets\ActiveForm::begin(['method'=>'get','options'=>['class'=>'lb-filter-form']]); ?>
      <?= $form->field($searchModel,'name')->textInput(['placeholder'=>'Поиск по имени'])->label(false) ?>
      <?= $form->field($searchModel,'mail')->textInput(['placeholder'=>'Поиск по email'])->label(false) ?>
      <?= $form->field($searchModel,'role')->dropDownList(['user'=>'Пользователь','admin'=>'Администратор'],['prompt'=>'Все роли'])->label(false) ?>
      <?= Html::submitButton('Найти',['class'=>'lb-crud-filter-button']) ?>
      <?= Html::a('Сбросить',['index'],['class'=>'lb-crud-reset']) ?>
    <?php \yii\widgets\ActiveForm::end(); ?>
    <div class="lb-crud-table-wrap"><table class="lb-crud-table"><thead><tr><th>#</th><th>Пользователь</th><th>Email</th><th>Роль</th><th>Действия</th></tr></thead><tbody>
    <?php if (!$rows): ?><tr><td colspan="5" class="lb-empty-row">Ничего не найдено. Попробуй изменить запрос.</td></tr><?php endif; ?>
    <?php foreach ($rows as $i=>$model): ?><tr>
      <td class="lb-id-cell"><?= (int)$model->id ?></td>
      <td><div class="lb-table-person"><span><?= Html::encode(mb_strtoupper(mb_substr((string)$model->name,0,1,'UTF-8'),'UTF-8')) ?></span><b><?= Html::encode($model->name) ?></b></div></td>
      <td><?= Html::encode($model->mail) ?></td>
      <td><span class="lb-role-tag <?= $model->role==='admin'?'admin':'' ?>"><?= $model->role==='admin'?'Администратор':'Пользователь' ?></span></td>
      <td class="lb-row-actions"><?= Html::a('Открыть',['view','id'=>$model->id]) ?><?= Html::a('Изменить',['update','id'=>$model->id]) ?><?= Html::beginForm(['delete', 'id' => $model->id], 'post', ['class' => 'lb-inline-delete', 'onsubmit' => 'return confirm("Удалить эту запись?");']) . Html::submitButton('Удалить', ['class' => 'lb-delete-button']) . Html::endForm() ?></td>
    </tr><?php endforeach; ?>
    </tbody></table></div>
    <div class="lb-crud-pagination"><?= \yii\widgets\LinkPager::widget(['pagination'=>$dataProvider->pagination]) ?></div>
  </div>
</section>
