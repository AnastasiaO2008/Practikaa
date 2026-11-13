<?php
/** @var $this yii\web\View */
$this->title = 'Грамматика';
?>

<section class="page grammar-page" id="page-grammar" aria-labelledby="grammar-title">

  <!-- ===== Кнопка "назад" ===== -->
  <button class="back-link" id="backFromGrammar">
    <i data-lucide="arrow-left"></i> На главную
  </button>

  <!-- ===== Шапка урока ===== -->
  <div class="grammar-hero">
    <div class="grammar-hero-copy">
      <p class="eyebrow">ЯПОНСКИЙ · УРОВЕНЬ A2</p>
      <h1 id="grammar-title">Частицы は и が</h1>
      <p class="page-subtitle">Почувствуй разницу и научись выбирать нужную частицу в предложении.</p>
      <span class="lesson-time">
        <i data-lucide="clock-3"></i> 25 минут · Грамматика
      </span>
    </div>
  </div>

  <!-- ===== Сетка урока ===== -->
  <div class="grammar-layout">

    <!-- 01 · Теория -->
    <article class="grammar-card grammar-intro">
      <span class="lesson-step">01 · ЗАПОМНИ</span>
      <h2>В чём разница?</h2>
      <p><strong>は (wa)</strong> обозначает тему высказывания — то, о чём мы говорим.</p>
      <p><strong>が (ga)</strong> выделяет подлежащее или новую важную информацию — кто именно или что именно.</p>
    </article>

    <!-- Пример 1 -->
    <article class="grammar-card example-card">
      <span class="lesson-step">ПРИМЕР 1</span>
      <h3>私は学生です。</h3>
      <p class="romanization">Watashi wa gakusei desu.</p>
      <p>Я — студент(ка). Здесь мы говорим о себе как о теме предложения.</p>
      <span class="grammar-tag">は · тема предложения</span>
    </article>

    <!-- Пример 2 -->
    <article class="grammar-card example-card">
      <span class="lesson-step">ПРИМЕР 2</span>
      <h3>猫がいます。</h3>
      <p class="romanization">Neko ga imasu.</p>
      <p>Есть кошка. Частица が выделяет то, что именно существует.</p>
      <span class="grammar-tag">が · новая информация</span>
    </article>

    <!-- 02 · Практика -->
    <article class="grammar-card practice-card">
      <span class="lesson-step">02 · ПОПРОБУЙ САМА</span>
      <h2>Выбери частицу</h2>
      <p>私___ Настяです。</p>
      <div class="grammar-choices">
        <button class="chip" data-grammar-choice="は">は</button>
        <button class="chip" data-grammar-choice="が">が</button>
      </div>
      <p class="grammar-feedback" id="grammarFeedback" role="status">
        Подумай, о ком идёт речь в предложении.
      </p>
    </article>

    <!-- Финал урока -->
    <article class="grammar-card grammar-finish">
      <div>
        <h2>Ты справляешься!</h2>
        <p>Маленькая практика каждый день помогает языку расцвести.</p>
        <button class="primary-button" id="finishGrammar">Завершить урок</button>
      </div>
    </article>

  </div>
</section>