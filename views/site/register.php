<?php
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
$this->title = 'Регистрация';
?>
<section class="auth-page">
  <div class="auth-card">
    <div class="auth-brand"><span class="auth-brand-flower">✿</span><span>Language Bloom</span></div>
    <p class="eyebrow">ТВОЙ ЯЗЫКОВОЙ ПУТЬ НАЧИНАЕТСЯ ЗДЕСЬ</p>
    <h1>Создай аккаунт</h1>
    <p class="auth-intro">Сохраняй новые слова, отмечай прогресс и возвращайся к любимым темам.</p>
    <?php $form = ActiveForm::begin(['id' => 'registration-form', 'options' => ['class' => 'auth-form']]); ?>
      <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'autocomplete' => 'name', 'placeholder' => 'Как к тебе обращаться?']) ?>
      <?= $form->field($model, 'mail')->input('email', ['maxlength' => true, 'autocomplete' => 'email', 'placeholder' => 'name@example.com']) ?>
      <?= $form->field($model, 'password')->passwordInput(['autocomplete' => 'new-password', 'placeholder' => 'Не менее 8 символов']) ?>
      <?= $form->field($model, 'passwordRepeat')->passwordInput(['autocomplete' => 'new-password', 'placeholder' => 'Повтори пароль']) ?>
      <?= Html::submitButton('Создать аккаунт', ['class' => 'auth-submit']) ?>
    <?php ActiveForm::end(); ?>
    <p class="auth-switch">Уже есть аккаунт? <?= Html::a('Войти', ['/site/login']) ?></p>
  </div>
</section>
