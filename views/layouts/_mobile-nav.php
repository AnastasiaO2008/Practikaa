<?php
use yii\helpers\Html;
$controllerId = Yii::$app->controller->id;
$actionId = Yii::$app->controller->action->id;
$items = [
    [['/site/index'], 'house', 'Главная', $controllerId === 'site' && $actionId === 'index'],
    [['/site/words'], 'globe-2', 'Слова', $controllerId === 'site' && $actionId === 'words'],
    [['/favorite/index'], 'star', 'Избранное', $controllerId === 'favorite'],
    [['/site/profile'], 'user-round', 'Профиль', $controllerId === 'site' && $actionId === 'profile'],
    [['/site/achievements'], 'award', 'Достижения', $controllerId === 'site' && $actionId === 'achievements'],
];
?>
<nav class="mobile-nav" aria-label="Мобильная навигация">
    <?php foreach ($items as [$route, $icon, $label, $active]): ?>
        <?= Html::a('<i data-lucide="' . $icon . '"></i><span>' . Html::encode($label) . '</span>',
            $route, ['class' => $active ? 'active' : '', 'aria-current' => $active ? 'page' : null, 'encode' => false]) ?>
    <?php endforeach; ?>
</nav>
