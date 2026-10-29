<?php

/** @var \yii\web\View $this */
/** @var string $content */

use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column min-vh-100">
<?php $this->beginBody() ?>

<!-- Header -->
<header class="im-header">
    <div class="container d-flex align-items-center justify-content-between">
        <a class="im-brand" href="<?= Url::home() ?>">Infor<span>Museus</span></a>
        <div class="d-flex align-items-center gap-4">
            <span class="im-lang">PT</span>
            <button class="im-menu-btn" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#imMenu" aria-controls="imMenu">
                Menu <i class="fas fa-bars ms-1"></i>
            </button>
        </div>
    </div>
</header>

<!-- Menu lateral -->
<div class="offcanvas offcanvas-end im-offcanvas" tabindex="-1" id="imMenu" aria-labelledby="imMenuLabel">
    <div class="offcanvas-header">
        <span class="im-brand" id="imMenuLabel">Infor<span>Museus</span></span>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Fechar"></button>
    </div>
    <div class="offcanvas-body">
        <nav class="im-menu">
            <a href="<?= Url::to(['/site/index']) ?>">Catálogo</a>
            <a href="<?= Url::to(['/site/index', '#' => 'bilhetes']) ?>">Bilhetes</a>
            <a href="<?= Url::to(['/site/index', '#' => 'lembrancas']) ?>">Lembranças</a>
            <a href="<?= Url::to(['/site/about']) ?>">Sobre</a>
            <a href="<?= Url::to(['/site/contact']) ?>">Contacto</a>
            <hr>
            <?php if (Yii::$app->user->isGuest): ?>
                <a href="<?= Url::to(['/site/login']) ?>">Login</a>
                <a href="<?= Url::to(['/site/signup']) ?>">Registo</a>
            <?php else: ?>
                <?= Html::beginForm(['/site/logout']) ?>
                <?= Html::submitButton(
                    'Logout (' . Html::encode(Yii::$app->user->identity->username) . ')',
                    ['class' => 'btn btn-link im-logout']
                ) ?>
                <?= Html::endForm() ?>
            <?php endif; ?>
        </nav>
    </div>
</div>

<!-- Conteúdo -->
<main class="flex-grow-1">
    <?php if (!empty($this->params['fullWidth'])): ?>
        <?= $content ?>
    <?php else: ?>
        <div class="container py-5">
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    <?php endif; ?>
</main>

<!-- Footer -->
<footer class="im-footer">
    <div class="container d-flex flex-column flex-md-row justify-content-between gap-2">
        <div>
            <a class="im-brand im-brand-sm" href="<?= Url::home() ?>">Infor<span>Museus</span></a>
            <div class="mt-1">Catálogo internacional de museus e monumentos</div>
        </div>
        <div class="text-md-end">
            &copy; InforMuseus <?= date('Y') ?><br>
            <!-- O template é gratuito: o crédito tem de se manter -->
            Template por <a href="https://htmlcodex.com" target="_blank" rel="noopener">HTML Codex</a>
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
