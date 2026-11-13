<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
$this->title = 'Избранное';
$success = Yii::$app->session->getFlash('success');
$error = Yii::$app->session->getFlash('error');
?>
<section class="page lb-favorites">
  <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin()): ?>
    <div class="lb-favorites-admin-back">
      <?= Html::a('← Вернуться в админ-панель', ['/admin/index'], ['class' => 'lb-admin-quiet-button']) ?>
    </div>
  <?php endif; ?>
  <div class="page-heading">
    <div><p class="eyebrow">ТВОЯ ЛИЧНАЯ КОЛЛЕКЦИЯ</p><h1>Избранные слова</h1><p class="page-subtitle">Самые важные слова всегда под рукой — возвращайся к ним в любой момент.</p></div>
    <span class="profile-sparkle" aria-hidden="true">♡</span>
  </div>

  <?php if ($success): ?><div class="lb-notice notice-success"><?= Html::encode($success) ?></div><?php endif; ?>
  <?php if ($error): ?><div class="lb-notice notice-error"><?= Html::encode($error) ?></div><?php endif; ?>

  <div class="lb-favorites-toolbar">
    <div><span class="eyebrow">ТВОЯ ПОДБОРКА</span><h2><?= count($favorites) ?> <?= count($favorites) === 1 ? 'слово' : 'слов' ?></h2><p>Сохраняй полезную лексику, чтобы повторять её позже.</p></div>
    <div class="lb-favorite-count">♡ <strong><?= count($favorites) ?></strong></div>
  </div>

  <article class="lb-add-favorite">
    <div class="lb-add-icon">＋</div>
    <div class="lb-add-content"><h3>Добавить слово в коллекцию</h3><p>Выбери слово из общего словаря Language Bloom.</p>
      <?php $form = ActiveForm::begin(['action' => ['/favorite/add'], 'method' => 'post', 'options' => ['class' => 'lb-add-form']]); ?>
        <?= Html::dropDownList('wordId', null,
          ArrayHelper::map($words, 'id', function ($word) {
            return ($word->language0 ? $word->language0->name . ' · ' : '') . $word->word . ' — ' . $word->translation;
          }),
          ['class' => 'form-control', 'prompt' => 'Выбери слово из словаря', 'required' => true]) ?>
        <?= Html::submitButton('Добавить в избранное', ['class' => 'lb-primary-button']) ?>
      <?php ActiveForm::end(); ?>
    </div>
  </article>

  <?php if ($words): ?>
    <div class="lb-available-words">
      <h2>Добавить одним нажатием</h2>
      <p>Нажми на сердечко рядом со словом, чтобы сохранить его.</p>
      <div class="lb-available-grid">
        <?php foreach ($words as $word): ?>
          <article class="lb-available-card">
            <div><small><?= Html::encode($word->language0 ? $word->language0->name : 'Словарь') ?></small>
              <strong><?= Html::encode($word->word) ?></strong>
              <span><?= Html::encode($word->translation) ?></span></div>
            <?= Html::beginForm(['/favorite/add'], 'post', ['class' => 'lb-remove-form']) ?>
              <?= Html::hiddenInput('wordId', (int)$word->id) ?>
              <?= Html::submitButton('♡', ['class' => 'lb-remove-heart lb-heart-add', 'title' => 'Добавить в избранное', 'aria-label' => 'Добавить слово в избранное', 'aria-pressed' => 'false']) ?>
            <?= Html::endForm() ?>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  <?php endif; ?>

  <?php if (!$favorites): ?>
    <div class="lb-favorites-empty"><div>♡</div><h2>Здесь пока тихо</h2><p>Добавь первое слово — и оно появится в твоей личной коллекции.</p></div>
  <?php else: ?>
    <div class="lb-favorite-grid">
      <?php foreach ($favorites as $favorite): ?>
        <?php if (!$favorite->word) continue; ?>
        <article class="lb-word-card">
          <div class="lb-word-top"><span><?= Html::encode($favorite->word->language0 ? $favorite->word->language0->name : 'Мой словарь') ?></span><span class="lb-heart" aria-hidden="true">♥</span></div>
          <h3><?= Html::encode($favorite->word->word) ?></h3>
          <?php if ($favorite->word->transcription): ?><p class="lb-transcription"><?= Html::encode($favorite->word->transcription) ?></p><?php endif; ?>
          <div class="lb-word-translation"><?= Html::encode($favorite->word->translation) ?></div>
          <div class="lb-word-footer">
            <small>В твоём избранном</small>
            <?= Html::beginForm(['/favorite/remove'], 'post', ['class' => 'lb-remove-form']) ?>
              <?= Html::hiddenInput('favoriteId', (int)$favorite->id) ?>
              <?= Html::submitButton('♥', [
                  'class' => 'lb-remove-heart',
                  'aria-label' => 'Удалить слово из избранного',
                  'title' => 'Удалить из избранного',
                  'aria-pressed' => 'true',
              ]) ?>
            <?= Html::endForm() ?>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</section>
