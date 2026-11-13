<?php
use yii\helpers\Html;

$user = Yii::$app->user;
$isGuest = $user->isGuest;
$identity = $isGuest ? null : $user->identity;
$initial = $identity ? mb_strtoupper(mb_substr((string) $identity->name, 0, 1, 'UTF-8'), 'UTF-8') : 'Н';
?>
<header class="topbar">
    <div class="topbar-spacer"></div>
    <button class="icon-button notification-button" id="notificationButton" aria-label="Уведомления" title="Уведомления"><i data-lucide="bell"></i><span class="notification-dot"></span></button>
    <div class="topbar-auth">
        <?php if ($isGuest): ?>
            <?= Html::a('Войти', ['/site/login'], ['class' => 'lb-auth-link lb-auth-login']) ?>
            <?= Html::a('Регистрация', ['/site/register'], ['class' => 'lb-auth-link lb-auth-register']) ?>
        <?php else: ?>
            <?php if ($identity->isAdmin()): ?>
                <?= Html::a('Админ-панель', ['/admin/index'], ['class' => 'lb-auth-link lb-auth-login']) ?>
            <?php endif; ?>
            <?= Html::beginForm(['/site/logout'], 'post', ['class' => 'd-inline']) ?>
                <?= Html::submitButton('Выйти', ['class' => 'lb-auth-link lb-auth-login lb-logout-button']) ?>
            <?= Html::endForm() ?>
        <?php endif; ?>
    </div>
    <?= Html::a('<span class="avatar-small">' . Html::encode($initial) . '</span><i data-lucide="user-round"></i>',
        $isGuest ? ['/site/login'] : ['/site/profile'], [
            'class' => 'user-menu',
            'id' => 'userMenu',
            'title' => $isGuest ? 'Войти' : 'Мой профиль',
            'aria-label' => $isGuest ? 'Войти в аккаунт' : 'Открыть мой профиль',
            'encode' => false,
        ]) ?>
</header>
