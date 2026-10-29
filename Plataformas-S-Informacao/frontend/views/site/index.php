<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

$this->title = 'InforMuseus';
$this->params['fullWidth'] = true; // esta página gere os seus próprios containers

// DADOS DE EXEMPLO: mais tarde isto vem da BD (controller -> view).
// Imagens em web/img/museus/ (ilustrações); podes trocar por fotos reais com o mesmo nome
$catalogo = [
    ['nome' => 'Museu do Louvre', 'local' => 'Paris, França',   'img' => 'img/museus/louvre.jpg'],
    ['nome' => 'Coliseu',         'local' => 'Roma, Itália',    'img' => 'img/museus/coliseu.jpg'],
    ['nome' => 'Museu do Prado',  'local' => 'Madrid, Espanha', 'img' => 'img/museus/prado.jpg'],
];

$destaque = [
    'nome'  => 'Museu Nacional de Arte Antiga',
    'local' => 'Lisboa, Portugal',
    'desc'  => 'Coleções que contam séculos de história, arte e cultura.',
    'img'   => 'img/museus/mnaa.jpg',
];
?>

<!-- 1. Pesquisa e filtros -->
<section class="im-search">
    <div class="container">
        <?= Html::beginForm(['/site/index'], 'get') ?>
        <div class="im-search-row">
            <label class="im-search-box">
                <i class="fas fa-search"></i>
                <input type="search" name="q"
                       placeholder="Pesquisar museus, monumentos, cidades…"
                       value="<?= Html::encode(Yii::$app->request->get('q')) ?>">
            </label>
            <button type="button" class="im-btn-gold" data-bs-toggle="collapse" data-bs-target="#imFiltros"
                    aria-expanded="false" aria-controls="imFiltros">
                Filtros <i class="fas fa-sliders-h ms-1"></i>
            </button>
        </div>

        <div class="collapse" id="imFiltros">
            <div class="im-filtros row g-2">
                <div class="col-md-5">
                    <select name="pais" class="form-select">
                        <option value="">País</option>
                        <option>Portugal</option>
                        <option>Espanha</option>
                        <option>França</option>
                        <option>Itália</option>
                    </select>
                </div>
                <div class="col-md-5">
                    <select name="tipo" class="form-select">
                        <option value="">Tipo</option>
                        <option value="museu">Museu</option>
                        <option value="monumento">Monumento</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="im-btn-gold w-100">Aplicar</button>
                </div>
            </div>
        </div>
        <?= Html::endForm() ?>
    </div>
</section>

<div class="container">
    <div class="im-panel">

        <!-- 2. Catálogo internacional -->
        <div class="row g-4">
            <?php foreach ($catalogo as $m): ?>
                <div class="col-md-4">
                    <a href="#" class="im-card">
                        <?= Html::img('@web/' . $m['img'], ['alt' => $m['nome']]) ?>
                        <h3><?= Html::encode($m['nome']) ?></h3>
                        <p><?= Html::encode($m['local']) ?></p>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- 3. Preview do espaço -->
        <article class="im-feature row g-0">
            <div class="col-md-6">
                <?= Html::img('@web/' . $destaque['img'], ['alt' => $destaque['nome']]) ?>
            </div>
            <div class="col-md-6 im-feature-body">
                <h2><?= Html::encode($destaque['nome']) ?></h2>
                <div class="im-local"><i class="fas fa-map-marker-alt"></i> <?= Html::encode($destaque['local']) ?></div>
                <p><?= Html::encode($destaque['desc']) ?></p>
                <a href="#" class="im-link">Ver detalhes</a>
            </div>
        </article>

        <!-- 4. Bilhetes e lembranças -->
        <div class="row g-4 mt-1">
            <div class="col-md-6" id="bilhetes">
                <a href="#" class="im-action">
                    <div class="im-action-icon navy"><i class="fas fa-ticket-alt"></i></div>
                    <div class="im-action-body">
                        <h3>Bilhetes</h3>
                        <p>Compre bilhetes<br>para exposições.</p>
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </a>
            </div>
            <div class="col-md-6" id="lembrancas">
                <a href="#" class="im-action">
                    <div class="im-action-icon gold"><i class="fas fa-shopping-bag"></i></div>
                    <div class="im-action-body">
                        <h3>Lembranças</h3>
                        <p>Descubra recordações<br>exclusivas.</p>
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </a>
            </div>
        </div>

    </div>
</div>
