<?php
use yii\helpers\Html;
use yii\helpers\Url;
use app\assets\AppAsset;

AppAsset::register($this);
$assetBase = Yii::$app->request->baseUrl . '/images';
$currentAction = Yii::$app->controller->action->id;
$this->beginPage();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Language Bloom — твой уютный дневник изучения иностранных языков.">
    <meta name="theme-color" content="#594653">
    <meta name="csrf-token" content="<?= Html::encode(Yii::$app->request->csrfToken) ?>">
    <title><?= Html::encode(($this->title ?: 'Главная') . ' — Language Bloom') ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Playfair+Display:wght@600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<script>
window.languageBloomAssetPath = <?= json_encode($assetBase, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>;
window.languageBloomRoutes = <?= json_encode([
    'home' => Url::to(['/']),
    'words' => Url::to(['/site/words']),
    'profile' => Url::to(['/site/profile']),
    'achievements' => Url::to(['/site/achievements']),
    'grammar' => Url::to(['/site/grammar']),
    'wordsApi' => Url::to(['/api/words']),
    'createWordApi' => Url::to(['/api/create-word']),
    'completeLesson' => Url::to(['/site/complete-lesson']),
    'favoriteIndex' => Url::to(['/favorite/index']),
    'register' => Url::to(['/site/register']),
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>;
</script>
<div class="app-shell">
    <?= $this->render('_sidebar', ['currentAction' => $currentAction, 'assetBase' => $assetBase]) ?>
    <div class="main-column">
        <?= $this->render('_topbar', ['assetBase' => $assetBase]) ?>
        <main id="mainContent">
            <div id="screenContainer" aria-live="polite"><?= $content ?></div>
        </main>
        <?= $this->render('_footer') ?>
    </div>
</div>
<?= $this->render('_mobile-nav', ['currentAction' => $currentAction]) ?>
<?= $this->render('_modals', ['assetBase' => $assetBase]) ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
