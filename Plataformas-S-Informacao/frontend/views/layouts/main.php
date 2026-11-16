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
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1']);
$this->registerMetaTag(['name' => 'description', 'content' => 'Descubra museus, monumentos e experiências culturais. Planeie a sua próxima visita com o InforMuseus.']);

$route = Yii::$app->controller->route;
$isHome = $route === 'site/index';
$nav = [
    ['Início',      Url::to(['/site/index']),                          $isHome],
    ['Museus',      Url::to(['/site/index', 'tipo' => 'museu', '#' => 'espacos']),     false],
    ['Monumentos',  Url::to(['/site/index', 'tipo' => 'monumento', '#' => 'espacos']), false],
    ['Exposições',  Url::to(['/site/index', '#' => 'exposicoes']),     false],
    ['Roteiros',    '#',                                               false],
    ['Contactos',   Url::to(['/site/contact']),                        $route === 'site/contact'],
];
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <title><?= Html::encode($this->title ?: 'InforMuseus — Descubra o mundo através da arte') ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column min-vh-100">
<?php $this->beginBody() ?>

<header class="imh-header">
    <div class="im-container imh-header-inner">
        <a class="imh-brand" href="<?= Url::home() ?>"><i class="fas fa-university" aria-hidden="true"></i> Infor<span>Museus</span></a>

        <nav class="imh-nav" aria-label="Navegação principal">
            <?php foreach ($nav as [$label, $href, $active]): ?>
                <a href="<?= $href ?>"<?= $active ? ' class="is-active" aria-current="page"' : '' ?>><?= $label ?></a>
            <?php endforeach; ?>
        </nav>

        <div class="imh-actions">
            <a class="imh-icon-btn" href="<?= Url::to(['/site/index', '#' => 'pesquisa']) ?>" aria-label="Pesquisar"><i class="fas fa-search"></i></a>
            <?php if (Yii::$app->user->isGuest): ?>
                <a class="imh-icon-btn" href="<?= Url::to(['/site/login']) ?>" aria-label="Iniciar sessão" title="Iniciar sessão"><i class="far fa-user"></i></a>
            <?php else: ?>
                <?php $imUser = Yii::$app->user->identity; ?>
                <span class="imh-user"><i class="far fa-user"></i> <?= Html::encode(strtok((string) ($imUser->nome ?? $imUser->username), ' ')) ?></span>
                <?= Html::beginForm(['/site/logout'], 'post', ['class' => 'imh-logout-form']) ?>
                <button class="imh-logout" type="submit">Sair</button>
                <?= Html::endForm() ?>
            <?php endif; ?>
            <button class="imh-burger" type="button" data-bs-toggle="offcanvas" data-bs-target="#imMenu"
                    aria-controls="imMenu" aria-label="Abrir menu"><i class="fas fa-bars"></i></button>
        </div>
    </div>
</header>

<div class="offcanvas offcanvas-end im-offcanvas" tabindex="-1" id="imMenu" aria-labelledby="imMenuLabel">
    <div class="offcanvas-header">
        <span class="im-brand" id="imMenuLabel">Infor<span>Museus</span></span>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Fechar"></button>
    </div>
    <div class="offcanvas-body">
        <nav class="im-menu" aria-label="Menu móvel">
            <?php foreach ($nav as [$label, $href]): ?>
                <a href="<?= $href ?>"><?= $label ?></a>
            <?php endforeach; ?>
            <hr>
            <?php if (Yii::$app->user->isGuest): ?>
                <a href="<?= Url::to(['/site/login']) ?>">Iniciar sessão</a>
                <a href="<?= Url::to(['/site/signup']) ?>">Criar conta</a>
            <?php else: ?>
                <?= Html::beginForm(['/site/logout'], 'post') ?>
                <?= Html::submitButton('Terminar sessão', ['class' => 'im-logout']) ?>
                <?= Html::endForm() ?>
            <?php endif; ?>
        </nav>
    </div>
</div>

<main class="flex-grow-1">
    <?php if (!empty($this->params['fullWidth'])): ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    <?php else: ?>
        <div class="im-inner-page container py-5">
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    <?php endif; ?>
</main>

<footer class="imh-footer">
    <div class="im-container imh-footer-grid">
        <div class="imh-footer-brand">
            <a class="imh-brand imh-brand-light" href="<?= Url::home() ?>"><i class="fas fa-university" aria-hidden="true"></i> Infor<span>Museus</span></a>
            <p>Promovemos o património cultural e aproximamos as pessoas da história, arte e conhecimento.</p>
            <div class="imh-social">
                <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                <a href="#" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
            </div>
        </div>

        <div>
            <h4>Links úteis</h4>
            <ul class="imh-footer-links">
                <li><a href="<?= Url::to(['/site/index']) ?>">Início</a></li>
                <li><a href="<?= Url::to(['/site/index', 'tipo' => 'museu', '#' => 'espacos']) ?>">Museus</a></li>
                <li><a href="<?= Url::to(['/site/index', 'tipo' => 'monumento', '#' => 'espacos']) ?>">Monumentos</a></li>
                <li><a href="<?= Url::to(['/site/index', '#' => 'exposicoes']) ?>">Exposições</a></li>
                <li><a href="#">Lembranças</a></li>
                <li><a href="<?= Url::to(['/site/contact']) ?>">Contactos</a></li>
            </ul>
        </div>

        <div>
            <h4>Contactos</h4>
            <ul class="imh-footer-contacts">
                <li><i class="fas fa-map-marker-alt"></i> Rua Exemplo, 123<br>Cidade, País</li>
                <li><i class="fas fa-phone-alt"></i> +351 210 000 000</li>
                <li><i class="far fa-envelope"></i> geral@informuseus.com</li>
            </ul>
        </div>
    </div>

    <div class="imh-footer-bottom">
        <div class="im-container imh-footer-bottom-inner">
            <small>&copy; <?= date('Y') ?> InforMuseus. Todos os direitos reservados. · Template por <a href="https://htmlcodex.com" target="_blank" rel="noopener">HTML Codex</a></small>
            <small><a href="#">Política de Privacidade</a> <span class="imh-sep">|</span> <a href="#">Termos de Utilização</a></small>
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
