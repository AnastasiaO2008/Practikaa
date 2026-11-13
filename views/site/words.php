<?php
/** @var yii\web\View $this */
$this->title = 'Слова';

// --- Данные для фильтров (заглушки; лучше брать из БД) ---
$totalWords      = 365;
$totalItalian    = 120;
$totalJapanese   = 245;

$totalReview     = 12;
$totalLearning   = 85;
$totalLearned    = 268;

$reviewToday     = 12;
$reviewMinutes   = 5;
$reviewItalian   = 5;
$reviewJapanese  = 7;

$shownNow        = 6;
?>

<section class="page" id="page-words" aria-labelledby="words-title">

  <!-- ===== Заголовок страницы ===== -->
  <div class="page-heading">
    <div>
      <p class="eyebrow">ТВОЯ КОЛЛЕКЦИЯ</p>
      <h1 id="words-title">Слова</h1>
      <p class="page-subtitle">Собирай слова, возвращайся к ним и запоминай.</p>
    </div>
  </div>

  <!-- ===== Фильтр по языку + кнопка добавления ===== -->
  <div class="filter-row language-filters">
    <button class="chip active" data-language="all">
      Все языки · <?= $totalWords ?>
    </button>
    <button class="chip" data-language="Итальянский">
      Итальянский · <?= $totalItalian ?>
    </button>
    <button class="chip" data-language="Японский">
      Японский · <?= $totalJapanese ?>
    </button>
    <button class="primary-button add-language" id="addWordButton">
      <i data-lucide="plus"></i> Добавить слово
    </button>
  </div>

  <!-- ===== Баннер повторения ===== -->
  <article class="review-banner">
    <div>
      <h2>Слова ждут встречи</h2>
      <p><?= $reviewToday ?> слов на сегодня · примерно <?= $reviewMinutes ?> минут</p>
      <small>Итальянский — <?= $reviewItalian ?> слов, японский — <?= $reviewJapanese ?> слов</small>
    </div>
    <button class="primary-button" id="startReview">
      <i data-lucide="rotate-ccw"></i> Начать повторение
    </button>
  </article>

  <!-- ===== Поиск и сортировка ===== -->
  <div class="word-tools">
    <label class="search-box">
      <i data-lucide="search"></i>
      <input type="search"
             id="wordSearch"
             placeholder="Найти слово, перевод или пример"
             aria-label="Поиск слов">
    </label>
    <select id="wordSort" aria-label="Сортировка слов">
      <option value="new">Сначала новые</option>
      <option value="az">По алфавиту</option>
    </select>
  </div>

  <!-- ===== Фильтр по статусу ===== -->
  <div class="filter-row status-filters">
    <button class="chip active" data-status="all">
      Все слова · <?= $totalWords ?>
    </button>
    <button class="chip" data-status="review">
      На повторение · <?= $totalReview ?>
    </button>
    <button class="chip" data-status="learning">
      Изучаю · <?= $totalLearning ?>
    </button>
    <button class="chip" data-status="learned">
      Выучено · <?= $totalLearned ?>
    </button>
    <span class="shown-count" id="shownCount">
      Показано <?= $shownNow ?> из <?= $totalWords ?>
    </span>
  </div>

  <!-- ===== Сетка слов (рендер через JS) ===== -->
  <div class="words-grid" id="wordsGrid"></div>

  <!-- ===== Пагинация ===== -->
  <div class="pagination">
    <button class="icon-button" aria-label="Предыдущая страница" id="prevPage">
      <i data-lucide="arrow-left"></i>
    </button>
    <span class="page-indicator">‹ 1/1 ›</span>
    <button class="icon-button" aria-label="Следующая страница" id="nextPage">
      <i data-lucide="arrow-right"></i>
    </button>
  </div>

</section>