<?php
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

/** @var yii\web\View $this */
/** @var app\models\LoginForm $model */
$this->title = 'Вход';
?>

<section class="auth-page">
  <div class="auth-card">

    <!-- ===== Бренд ===== -->
    <div class="auth-brand">
      <span class="auth-brand-flower">✿</span>
      <span>Language Bloom</span>
    </div>

    <!-- ===== Заголовок ===== -->
    <p class="eyebrow">РАДА ТЕБЯ ВИДЕТЬ</p>
    <h1>С возвращением!</h1>
    <p class="auth-intro">
      Войди в свой дневник и продолжай изучать языки в своём ритме.
    </p>

    <!-- ===== Форма входа ===== -->
    <?php $form = ActiveForm::begin([
        'id'      => 'login-form',
        'options' => ['class' => 'auth-form'],
    ]); ?>

      <?= $form->field($model, 'username')
          ->textInput([
              'autofocus'    => true,
              'autocomplete' => 'email',
              'placeholder'  => 'name@example.com',
          ])
          ->label('Электронная почта') ?>

      <?= $form->field($model, 'password')
          ->passwordInput([
              'autocomplete' => 'current-password',
              'placeholder'  => 'Твой пароль',
          ])
          ->label('Пароль') ?>

      <?= $form->field($model, 'rememberMe')
          ->checkbox()
          ->label('Запомнить меня') ?>

      <?= Html::submitButton('Войти в дневник', [
          'class' => 'auth-submit',
          'name'  => 'login-button',
      ]) ?>

    <?php ActiveForm::end(); ?>

    <!-- ===== Переход к регистрации ===== -->
    <p class="auth-switch">
      Впервые здесь? <?= Html::a('Создать аккаунт', ['/site/register']) ?>
    </p>

  </div>
</section>