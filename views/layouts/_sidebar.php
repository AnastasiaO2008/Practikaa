<?php
/** @var string $assetBase */
use yii\helpers\Html;

$controllerId = Yii::$app->controller->id;
$actionId = Yii::$app->controller->action->id;
$isAdmin = !Yii::$app->user->isGuest && Yii::$app->user->identity->isAdmin();

// Проверяем и контроллер, и действие: action index есть у многих страниц.
$navigation = [
    ['route' => ['/site/index'], 'icon' => 'house', 'label' => 'Главная', 'active' => $controllerId === 'site' && $actionId === 'index'],
    ['route' => ['/site/words'], 'icon' => 'globe-2', 'label' => 'Слова', 'active' => $controllerId === 'site' && $actionId === 'words'],
    ['route' => ['/favorite/index'], 'icon' => 'star', 'label' => 'Избранное', 'active' => $controllerId === 'favorite'],
    ['route' => ['/site/profile'], 'icon' => 'user-round', 'label' => 'Профиль', 'active' => $controllerId === 'site' && $actionId === 'profile'],
    ['route' => ['/site/achievements'], 'icon' => 'award', 'label' => 'Достижения', 'active' => $controllerId === 'site' && $actionId === 'achievements'],
];
if ($isAdmin) {
    $navigation[] = ['route' => ['/admin/index'], 'icon' => 'layout-dashboard', 'label' => 'Админ-панель',
        'active' => in_array($controllerId, ['admin', 'account', 'language', 'words', 'history'], true)];
}
?>
<aside class="sidebar" aria-label="Основная навигация">
    <?= Html::a('<img class="brand-logo" src="' . Html::encode($assetBase) . '/logo-language-bloom.png" alt=""><span>Language<br>Bloom</span>', ['/site/index'], [
        'class' => 'brand', 'aria-label' => 'Language Bloom — главная', 'encode' => false,
    ]) ?>
    <nav class="side-nav">
        <?php foreach ($navigation as $item): ?>
            <?= Html::a('<i data-lucide="' . Html::encode($item['icon']) . '"></i><span>' . Html::encode($item['label']) . '</span>',
                $item['route'], ['class' => 'nav-link' . ($item['active'] ? ' active' : ''), 'encode' => false,
                    'aria-current' => $item['active'] ? 'page' : null]) ?>
        <?php endforeach; ?>
    </nav>
    <div class="sidebar-note"><p>Расти в своём темпе</p></div>
    <div class="sidebar-bottom"><span class="online-dot"></span> Твой уютный уголок</div>
</aside>
