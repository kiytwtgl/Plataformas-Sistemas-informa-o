<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'InforMuseus — Descubra Museus e Monumentos';
$this->params['fullWidth'] = true; // esta página gere os seus próprios containers

// DADOS DE EXEMPLO: mais tarde isto vem da BD (controller -> view).
// Imagens em web/img/museus/ — podes trocar por fotos reais mantendo o nome do ficheiro.
$destaques = [
    ['nome' => 'Museu do Louvre',                'local' => 'Paris, França',   'img' => 'img/museus/louvre.jpg'],
    ['nome' => 'Coliseu',                        'local' => 'Roma, Itália',    'img' => 'img/museus/coliseu.jpg'],
    ['nome' => 'Museu do Prado',                 'local' => 'Madrid, Espanha', 'img' => 'img/museus/prado.jpg'],
    ['nome' => 'Museu Nacional de Arte Antiga',  'local' => 'Lisboa, Portugal', 'img' => 'img/museus/mnaa.jpg'],
];

$categorias = [
    ['',          'Todos',       'fa-th-large'],
    ['museu',     'Museus',      'fa-university'],
    ['monumento', 'Monumentos',  'fa-landmark'],
    ['exposicao', 'Exposições',  'fa-image'],
];
$tipoAtual = (string) Yii::$app->request->get('tipo', '');

$this->registerJs(<<<'JS'
document.querySelectorAll('.imh-fav').forEach(function (b) {
    b.addEventListener('click', function () {
        var on = b.classList.toggle('is-on');
        b.setAttribute('aria-pressed', on ? 'true' : 'false');
    });
});
JS);
?>

<!-- Hero + pesquisa -->
<section class="imh-hero" id="pesquisa">
    <div class="imh-hero-bg" style="background-image:url('<?= Yii::getAlias('@web/img/museus/louvre.jpg') ?>')"></div>
    <div class="im-container imh-hero-inner">
        <h1>Descubra<br><span>Museus e Monumentos</span></h1>
        <p>Explore, aprenda e viva a cultura.</p>

        <?= Html::beginForm(['/site/index'], 'get', ['class' => 'imh-search', 'role' => 'search']) ?>
        <i class="fas fa-search" aria-hidden="true"></i>
        <input type="search" name="q" placeholder="Pesquisar museus, monumentos, exposições…"
            value="<?= Html::encode(Yii::$app->request->get('q')) ?>" aria-label="Pesquisar">
        <?php if ($tipoAtual !== ''): ?><input type="hidden" name="tipo" value="<?= Html::encode($tipoAtual) ?>"><?php endif; ?>
        <button type="submit">Pesquisar</button>
        <?= Html::endForm() ?>
    </div>
</section>

<div class="imh-page">
    
<!-- Categorias -->
<section class="im-container imh-tiles" aria-label="Categorias">
    <?php foreach ($categorias as [$valor, $rotulo, $icone]): ?>
        <a href="<?= Url::to(['/site/index', 'tipo' => $valor ?: null, '#' => 'espacos']) ?>"
           class="imh-tile<?= $tipoAtual === $valor ? ' is-active' : '' ?>">
            <i class="fas <?= $icone ?>" aria-hidden="true"></i>
            <span><?= $rotulo ?></span>
        </a>
    <?php endforeach; ?>
</section>

<!-- Catálogo de museus e monumentos -->
<section class="im-container imh-section" id="espacos">

    <div class="imh-section-head">
        <h2>Espaços em destaque</h2>
        <a href="<?= Url::to(['/site/index', '#' => 'espacos']) ?>" class="imh-see-all">
            Ver todos <i class="fas fa-arrow-right" aria-hidden="true"></i>
        </a>
    </div>

    <div class="imh-grid">

        <?php if (empty($museus)): ?>

            <p class="text-center text-muted py-4">
                Ainda não existem museus ou monumentos registados.
            </p>

        <?php else: ?>

            <?php foreach ($museus as $m): ?>

                <article class="imh-card">

                    <a href="<?= Url::to(['/site/informacao', 'id' => $m['id_museu']]) ?>"
                       class="imh-card-img">

                        <?= Html::img('@web/img/museus/prado.jpg', [
                            'alt' => $m['nome'],
                            'loading' => 'lazy'
                        ]) ?>

                    </a>

                    <div class="imh-card-body">

                        <div>
                            <h3><?= Html::encode($m['nome']) ?></h3>

                            <p>
                                <i class="fas fa-map-marker-alt" aria-hidden="true"></i>
                                <?= Html::encode($m['morada']) ?>
                            </p>
                        </div>

                        <button type="button"
                                class="imh-fav"
                                aria-pressed="false"
                                aria-label="Guardar nos favoritos">
                            <i class="far fa-heart" aria-hidden="true"></i>
                        </button>

                    </div>

                </article>

            <?php endforeach; ?>

        <?php endif; ?>

    </div>
</section>
    <!-- Banner exposições -->
    <section class="im-container imh-banner-wrap" id="exposicoes">
        <div class="imh-banner" style="background-image:url('<?= Yii::getAlias('@web/img/museus/coliseu.jpg') ?>')">
            <div class="imh-banner-text">
                <h2>Uma viagem pela história</h2>
                <p>Descubra exposições temporárias em diferentes museus e monumentos do mundo.</p>
                <a href="#" class="imh-btn-gold">Ver exposições <i class="fas fa-arrow-right" aria-hidden="true"></i></a>
            </div>
        </div>
    </section>
</div>