<?php
/** @var array $stats */
$this->title = 'Достижения';

// --- Данные ---
$streak       = (int) $stats['currentStreak'];
$words        = (int) $stats['wordCount'];
$sessions     = (int) $stats['completedSessions'];
$languages    = (int) $stats['languageCount'];
$best         = (int) $stats['bestStreak'];

// --- Прогресс по целям (0–100%) ---
$streakPct  = min(100, round($streak   / max(1, $stats['streakGoal'])  * 100));
$wordPct    = min(100, round($words    / max(1, $stats['wordGoal'])    * 100));
$sessionPct = min(100, round($sessions / max(1, $stats['sessionGoal']) * 100));
?>

<section class="page" id="page-achievements" aria-labelledby="achievements-title">

  <!-- ===== Заголовок страницы ===== -->
  <div class="page-heading">
    <div>
      <p class="eyebrow">ТВОИ ПОБЕДЫ</p>
      <h1 id="achievements-title">Достижения</h1>
      <p class="page-subtitle">Каждый день — ещё один повод гордиться собой.</p>
    </div>
  </div>

  <!-- ===== Верхний блок: стрик + ритм ===== -->
  <div class="achievement-top">

    <article class="card streak-large yellow-card">
      <div class="section-heading">
        <h2>Твой стрик</h2>
        <i data-lucide="flame"></i>
      </div>
      <div class="streak-number"><?= $streak ?> <span>дней подряд</span></div>
      <div class="streak-days">
        <?php foreach ($stats['activityDates'] as $activityDate): ?>
          <span class="<?= in_array($activityDate, $stats['activeDates'], true) ? 'is-active' : '' ?>">
            <?= date('d', strtotime($activityDate)) ?>
          </span>
        <?php endforeach; ?>
      </div>
      <p>Молодец! Продолжай в том же ритме.</p>
    </article>

    <article class="card rhythm-large">
      <div class="section-heading">
        <h2>Мой ритм</h2>
        <small>Последние 7 дней</small>
      </div>
      <p>
        <?= $sessions ?> завершённых занятий всего
        <span class="growth">по данным дневника</span>
      </p>
      <div class="achievement-chart">
        <div style="height:70%"><b>40</b></div>
        <div style="height:48%"><b>27</b></div>
        <div style="height:78%"><b>44</b></div>
        <div style="height:48%"><b>27</b></div>
        <div style="height:94%"><b>53</b></div>
        <div style="height:70%"><b>40</b></div>
        <div style="height:36%"><b>20</b></div>
      </div>
      <div class="chart-days">
        <span>пн</span><span>вт</span><span>ср</span><span>чт</span>
        <span>пт</span><span>сб</span><span>вс</span>
      </div>
    </article>

  </div>

  <!-- ===== Сводная статистика ===== -->
  <div class="stats-grid">
    <article><strong><?= $words ?></strong><span>слов в общем словаре</span></article>
    <article><strong><?= $sessions ?></strong><span>завершённых сессий</span></article>
    <article><strong><?= $languages ?></strong><span>языка в истории занятий</span></article>
    <article><strong><?= $best ?> дней</strong><span>лучшая серия</span></article>
  </div>

  <!-- ===== Полученные достижения ===== -->
  <section class="profile-section">
    <div class="section-heading">
      <h2>Твои достижения</h2>
      <span class="muted">Показатели обновляются по данным твоей БД</span>
    </div>

    <div class="earned-grid">

      <article class="earned-card pink-card">
        <i data-lucide="sprout"></i>
        <small>1 октября</small>
        <h3>Первый шаг</h3>
        <p>Первая сессия в дневнике. Всё начинается с малого.</p>
        <span>✓ Получено</span>
      </article>

      <article class="earned-card yellow-card">
        <i data-lucide="book-open"></i>
        <small>12 октября</small>
        <h3>100 слов</h3>
        <p>Первая сотня слов — уже целый мир новых смыслов.</p>
        <span>✓ Получено</span>
      </article>

      <article class="earned-card green-card postcard-earned">
        <div>
          <small>КАРТОЧКА ЗА 7 ДНЕЙ ПОДРЯД</small>
          <h3>Mai, mai, mai arrendersi!</h3>
          <p>Никогда, никогда, никогда не сдаваться!</p>
          <span>✓ Разблокировано 28 октября</span>
        </div>
        <img class="postcard-image"
             src="<?= Yii::$app->request->baseUrl ?>/images/italy-card-amalfi.png"
             alt="Иллюстрация итальянского побережья">
      </article>

    </div>
  </section>

  <!-- ===== Заблокированные достижения ===== -->
  <section class="profile-section">
    <div class="section-heading">
      <h2>Всё ещё впереди</h2>
      <span class="muted">Маленькие цели для больших открытий</span>
    </div>

    <div class="locked-grid">

      <article class="locked-card">
        <i data-lucide="flame"></i>
        <h3>Две недели в ритме</h3>
        <p>Занимайся 14 дней без перерыва</p>
        <div class="progress"><span style="width:<?= $streakPct ?>%"></span></div>
        <small><?= $streak ?> из 14 дней <i data-lucide="lock-keyhole"></i></small>
      </article>

      <article class="locked-card">
        <i data-lucide="library"></i>
        <h3>Коллекционер слов</h3>
        <p>Собери 500 слов в своём словаре</p>
        <div class="progress"><span style="width:<?= $wordPct ?>%"></span></div>
        <small><?= $words ?> из 500 слов <i data-lucide="lock-keyhole"></i></small>
      </article>

      <article class="locked-card">
        <i data-lucide="notebook-pen"></i>
        <h3>50 встреч с языком</h3>
        <p>Заверши 50 учебных сессий</p>
        <div class="progress"><span style="width:<?= $sessionPct ?>%"></span></div>
        <small><?= $sessions ?> из 50 сессий <i data-lucide="lock-keyhole"></i></small>
      </article>

    </div>
  </section>

</section>