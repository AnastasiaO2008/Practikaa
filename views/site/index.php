<?php
use yii\helpers\Html;

/** @var array $languageCards */
/** @var array $stats */
$this->title = 'Главная';

// --- Данные стрика ---
$currentStreak = (int) $stats['currentStreak'];
$hasStreak     = $currentStreak > 0;
?>

<section class="page active" id="page-home" aria-labelledby="home-title">

  <!-- ===== Шапка страницы ===== -->
  <div class="page-heading home-heading">
    <div>
      <p class="eyebrow">ТВОЙ ЯЗЫКОВОЙ ДНЕВНИК</p>
      <h1 id="home-title">Привет, <span id="welcomeName">Настя</span>!</h1>
      <p class="page-subtitle">Твой маленький прогресс каждый день</p>
    </div>
    <div class="date-label">
      <span id="todayDate">28 октября 2026</span>
      <i data-lucide="calendar-days"></i>
    </div>
  </div>

  <!-- ===== Сетка главной ===== -->
  <div class="home-grid">

    <!-- Текущая сессия -->
    <article class="card current-card">
      <img class="current-art-image"
           src="<?= Yii::$app->request->baseUrl ?>/images/fuji-sakura-cutout.png"
           alt="Гора Фудзи, солнце и цветущая сакура без фона">
      <p class="muted">Текущая сессия</p>
      <h2>Японский <span class="dot-separator">·</span> <small>Грамматика</small></h2>
      <div class="session-meta">
        <span>25 минут</span>
        <span class="level-pill pink-pill">A2</span>
      </div>
      <button class="primary-button" id="continueSession">
        Продолжить <i data-lucide="arrow-right"></i>
      </button>
    </article>

    <!-- Карточки языков -->
    <?php foreach ($languageCards as $languageCard): ?>
      <?php $isJapanese = $languageCard['flag'] === '🇯🇵'; ?>
      <article class="card language-card <?= $isJapanese ? 'japanese-card' : 'italian-card' ?>">
        <div class="language-top">
          <span class="language-emoji-flag"><?= Html::encode($languageCard['flag']) ?></span>
        </div>
        <h2><?= Html::encode($languageCard['name']) ?></h2>
        <span class="level-pill <?= $isJapanese ? 'pink-pill' : 'green-pill' ?>">В изучении</span>
        <div class="progress-label">
          <span><?= (int) $languageCard['progress'] ?>%</span>
        </div>
        <div class="progress <?= $isJapanese ? 'plum-progress' : '' ?>">
          <span style="width:<?= (int) $languageCard['progress'] ?>%"></span>
        </div>
        <p class="card-foot"><?= (int) $languageCard['count'] ?> слов в словаре</p>
      </article>
    <?php endforeach; ?>

    <!-- Мой ритм -->
    <article class="card rhythm-card">
      <div class="card-title-row">
        <h2><i data-lucide="chart-no-axes-column-increasing"></i>Мой ритм</h2>
        <button class="outline-button" data-go="achievements">
          Подробная статистика <i data-lucide="chevron-right"></i>
        </button>
      </div>
      <p class="muted">Активность за неделю</p>
      <div class="chart" aria-label="График активности за неделю">
        <div class="chart-y">
          <span>60</span><span>30</span><span>0</span>
        </div>
        <div class="chart-bars">
          <div class="bar-wrap"><span class="bar"           style="height:70%"></span><small>пн</small></div>
          <div class="bar-wrap"><span class="bar pale-bar"  style="height:90%"></span><small>вт</small></div>
          <div class="bar-wrap"><span class="bar"           style="height:78%"></span><small>ср</small></div>
          <div class="bar-wrap"><span class="bar pale-bar"  style="height:70%"></span><small>чт</small></div>
          <div class="bar-wrap"><span class="bar"           style="height:100%"></span><small>пт</small></div>
          <div class="bar-wrap"><span class="bar"           style="height:70%"></span><small>сб</small></div>
          <div class="bar-wrap"><span class="bar pale-bar"  style="height:40%"></span><small>вс</small></div>
        </div>
      </div>
    </article>

    <!-- Твой стрик -->
    <article class="card streak-card">
      <div class="mini-title"><i data-lucide="sun"></i> Твой стрик</div>
      <div class="streak-number"><?= $currentStreak ?> <span>дней подряд</span></div>
      <p>
        <strong><?= $hasStreak ? 'Молодец!' : 'Начни свою серию!' ?></strong>
        <?= $hasStreak
            ? 'Продолжай, чтобы не прерывать серию'
            : 'Заверши занятие сегодня — это будет первый шаг' ?>
      </p>
    </article>

    <!-- Открытка -->
    <article class="card postcard-card">
      <p class="muted">Ты разблокировала карточку!</p>
      <div class="postcard-content">
        <div>
          <h3>Mai, mai, mai arrendersi!</h3>
          <p>Никогда, никогда, никогда не сдавайся!</p>
        </div>
        <img class="postcard-image"
             src="<?= Yii::$app->request->baseUrl ?>/images/italy-card-amalfi.png"
             alt="Иллюстрация итальянского побережья">
      </div>
    </article>

  </div>

  <!-- ===== Слова на повторение ===== -->
  <section class="repeat-section">
    <div class="section-heading">
      <h2><i data-lucide="book-heart"></i>Слова на повторение</h2>
      <button class="text-button" data-go="words">
        Все слова <i data-lucide="chevron-right"></i>
      </button>
    </div>
    <div class="repeat-grid" id="repeatWords"></div>
  </section>

</section>