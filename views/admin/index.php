<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Администрирование';
$cards = [
    ['icon' => '♙', 'label' => 'Пользователи', 'value' => $stats['accounts'], 'tone' => 'blue'],
    ['icon' => '✎', 'label' => 'Слова в словаре', 'value' => $stats['words'], 'tone' => 'pink'],
    ['icon' => '文', 'label' => 'Языки', 'value' => $stats['languages'], 'tone' => 'green'],
    ['icon' => '◷', 'label' => 'Занятия', 'value' => $stats['histories'], 'tone' => 'yellow'],
];
?>
<section class="lb-admin">
    <header class="lb-admin-header">
        <div>
            <span class="lb-admin-eyebrow">LANGUAGE BLOOM · WORKSPACE</span>
            <h1>Панель управления</h1>
            <p>Всё самое важное для управления твоей языковой платформой — в одном месте.</p>
        </div>
        <div class="lb-admin-header-actions">
            <?= Html::a('← На сайт', ['/site/index'], ['class' => 'lb-admin-quiet-button']) ?>
            <?= Html::a('+ Добавить слово', ['/words/create'], ['class' => 'lb-admin-primary-button']) ?>
        </div>
    </header>

    <div class="lb-admin-welcome">
        <div class="lb-admin-welcome-icon">✿</div>
        <div><strong>Добро пожаловать в рабочее пространство!</strong><p>Здесь можно управлять словарём, языками, пользователями и учебной активностью.</p></div>
    </div>

    <div class="lb-admin-section-heading">
        <div><span>ОБЗОР ПРОЕКТА</span><h2>Сводка</h2></div>
        <small>Актуальные данные из базы данных</small>
    </div>
    <div class="lb-admin-stats">
        <?php foreach ($cards as $card): ?>
            <article class="lb-admin-stat <?= Html::encode($card['tone']) ?>">
                <div class="lb-admin-stat-top"><span><?= Html::encode($card['label']) ?></span><i><?= Html::encode($card['icon']) ?></i></div>
                <strong><?= (int)$card['value'] ?></strong>
                <small>Всего в системе</small>
            </article>
        <?php endforeach; ?>
    </div>

    <div class="lb-admin-section-heading lb-admin-tools-heading">
        <div><span>БЫСТРЫЙ ДОСТУП</span><h2>Что хочешь сделать?</h2></div>
    </div>
    <div class="lb-admin-tools">
        <a class="lb-admin-tool" href="<?= Url::to(['/words/index']) ?>"><span class="tool-icon pink">✎</span><span><b>Словарь</b><small>Добавлять, изменять и удалять слова</small></span><i>→</i></a>
        <a class="lb-admin-tool" href="<?= Url::to(['/language/index']) ?>"><span class="tool-icon green">文</span><span><b>Языки</b><small>Управлять языками словаря</small></span><i>→</i></a>
        <a class="lb-admin-tool" href="<?= Url::to(['/account/index']) ?>"><span class="tool-icon blue">♙</span><span><b>Пользователи</b><small>Просматривать аккаунты и роли</small></span><i>→</i></a>
        <a class="lb-admin-tool" href="<?= Url::to(['/history/index']) ?>"><span class="tool-icon yellow">◷</span><span><b>История занятий</b><small>Проверять учебную активность</small></span><i>→</i></a>
        <a class="lb-admin-tool" href="<?= Url::to(['/favorite/index']) ?>"><span class="tool-icon lilac">♡</span><span><b>Избранное</b><small>Открыть раздел сохранённых слов</small></span><i>→</i></a>
        <a class="lb-admin-tool" href="<?= Url::to(['/words/create']) ?>"><span class="tool-icon green">＋</span><span><b>Новое слово</b><small>Быстро пополнить словарь</small></span><i>→</i></a>
    </div>

    <div class="lb-admin-bottom-grid">
        <section class="lb-admin-table-card">
            <div class="lb-admin-card-heading"><div><span>НОВЫЕ ЗАПИСИ</span><h2>Последние пользователи</h2></div><?= Html::a('Все пользователи →', ['/account/index']) ?></div>
            <?php if (!$recentAccounts): ?>
                <p class="lb-admin-empty">Пользователей пока нет.</p>
            <?php else: ?>
                <div class="lb-admin-table-wrap"><table class="lb-admin-table">
                    <thead><tr><th>Пользователь</th><th>Email</th><th>Роль</th></tr></thead>
                    <tbody><?php foreach ($recentAccounts as $account): ?>
                        <tr>
                            <td><span class="lb-admin-user-avatar"><?= Html::encode(mb_strtoupper(mb_substr((string)$account->name, 0, 1, 'UTF-8'), 'UTF-8')) ?></span><?= Html::encode($account->name) ?></td>
                            <td><?= Html::encode($account->mail) ?></td>
                            <td><span class="lb-admin-role <?= $account->role === 'admin' ? 'is-admin' : '' ?>"><?= $account->role === 'admin' ? 'Администратор' : 'Пользователь' ?></span></td>
                        </tr>
                    <?php endforeach; ?></tbody>
                </table></div>
            <?php endif; ?>
        </section>

        <section class="lb-admin-table-card">
            <div class="lb-admin-card-heading"><div><span>НАПОЛНЕНИЕ</span><h2>Недавно добавленные слова</h2></div><?= Html::a('Весь словарь →', ['/words/index']) ?></div>
            <?php if (!$recentWords): ?>
                <p class="lb-admin-empty">В словаре пока нет слов. Добавь первое!</p>
            <?php else: ?>
                <div class="lb-admin-recent-words">
                    <?php foreach ($recentWords as $word): ?>
                        <div class="lb-admin-word-row"><span class="lb-admin-word-dot">✿</span><div><b><?= Html::encode($word->word) ?></b><small><?= Html::encode($word->translation) ?></small></div><span class="lb-admin-word-language"><?= Html::encode($word->language0 ? $word->language0->name : '—') ?></span></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
    </div>
    <footer class="lb-admin-footer">Language Bloom <span>·</span> пространство заботливого управления</footer>
</section>
