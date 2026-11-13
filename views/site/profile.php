<?php
use yii\helpers\Html;
$this->title = 'Мой профиль';
$user = Yii::$app->user->identity;
$initial = mb_strtoupper(mb_substr((string)$user->name, 0, 1, 'UTF-8'), 'UTF-8');
?>
<section class="page lb-profile">
  <div class="page-heading">
    <div><p class="eyebrow">ТВОЙ ЯЗЫКОВОЙ ДНЕВНИК</p><h1>Мой профиль</h1><p class="page-subtitle">Каждый выученный день складывается в большую историю.</p></div>
    <span class="profile-sparkle" aria-hidden="true">✿</span>
  </div>

  <article class="lb-profile-hero">
    <div class="lb-avatar"><?= Html::encode($initial) ?></div>
    <div class="lb-profile-person">
      <span class="lb-kicker">РАДА ТЕБЯ ВИДЕТЬ</span>
      <h2><?= Html::encode($user->name) ?></h2>
      <p><?= Html::encode($user->mail) ?></p>
    </div>
    <span class="lb-role"><?= $user->role === 'admin' ? '✦ Администратор' : '✿ Участник' ?></span>
  </article>

  <div class="lb-section-title"><div><p class="eyebrow">ТВОЙ ПРОГРЕСС</p><h2>Маленькие шаги — большие открытия</h2></div></div>
  <div class="lb-profile-stats">
    <article class="lb-stat-card stat-pink"><span class="lb-stat-icon">✎</span><strong><?= (int)$stats['wordCount'] ?></strong><span>слов в общем словаре</span></article>
    <article class="lb-stat-card stat-green"><span class="lb-stat-icon">♡</span><strong><?= (int)$stats['favoriteCount'] ?></strong><span>слов в избранном</span></article>
    <article class="lb-stat-card stat-yellow"><span class="lb-stat-icon">☼</span><strong><?= (int)$stats['completedSessions'] ?></strong><span>завершённых занятий</span></article>
    <article class="lb-stat-card stat-lilac"><span class="lb-stat-icon">⌘</span><strong><?= (int)$stats['languageCount'] ?></strong><span>языка в занятиях</span></article>
  </div>

  <article class="lb-streak-panel">
    <div class="lb-streak-copy"><p class="eyebrow">ТВОЙ РИТМ</p><h2>Ты растёшь с каждым днём</h2><p>Серия считается по датам завершённых занятий в твоей истории.</p></div>
    <div class="lb-streak-number"><strong><?= (int)$stats['currentStreak'] ?></strong><span>дней подряд</span></div>
    <div class="lb-streak-best"><span>Лучшая серия</span><strong><?= (int)$stats['bestStreak'] ?> дней</strong></div>
  </article>

  <div class="lb-profile-links">
    <?= Html::a('<span>♡</span><span><b>Моё избранное</b><small>Слова, к которым хочется вернуться</small></span><i>→</i>', ['/favorite/index'], ['class'=>'lb-link-card']) ?>
    <?= Html::a('<span>✧</span><span><b>Все достижения</b><small>Смотри, как растёт твой прогресс</small></span><i>→</i>', ['/site/achievements'], ['class'=>'lb-link-card']) ?>
  </div>
</section>
