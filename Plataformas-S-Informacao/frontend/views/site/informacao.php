
<?php

/** @var yii\web\View $this */
/** @var array $museu */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $museu['nome'];

$formatarHora = static function ($hora) {
    return $hora ? substr((string) $hora, 0, 5) : null;
};

$horarioAbertura = $formatarHora($museu['horario_abertura'] ?? null);
$horarioFecho = $formatarHora($museu['horario_fecho'] ?? null);

$temCoordenadas = isset($museu['latitude'], $museu['longitude'])
    && $museu['latitude'] !== null
    && $museu['longitude'] !== null;
?>

<div class="py-3">

    <!-- Cabeçalho da informação -->
    <section class="p-4 p-lg-5 rounded-3 mb-4 text-white"
             style="background-color: #102b45; border-bottom: 4px solid #d5a344;">

        <a href="<?= Url::to(['/site/index']) ?>"
           class="text-decoration-none mb-4 d-inline-block"
           style="color: #e7c16b;">
            <i class="fas fa-arrow-left me-2"></i>
            Voltar ao catálogo
        </a>

        <div class="mb-2">
            <span class="badge rounded-pill"
                  style="background-color: #d5a344; color: #102b45;">
                <?= Html::encode(ucfirst($museu['tipo'] ?: 'Espaço cultural')) ?>
            </span>
        </div>

        <h1 class="display-5 fw-bold mb-3 text-white">
            <?= Html::encode($museu['nome']) ?>
        </h1>

        <p class="mb-0 text-white-50">
            <i class="fas fa-map-marker-alt me-2"></i>
            <?= Html::encode($museu['morada'] ?: 'Morada não disponível') ?>
        </p>

    </section>

    <!-- Conteúdo principal -->
    <div class="row g-4">

        <!-- Coluna esquerda -->
        <div class="col-lg-8">

            <!-- Descrição -->
            <div class="card border-0 shadow-sm rounded-3 mb-4">

                <div class="card-body p-4">

                    <span class="small fw-bold text-uppercase"
                          style="color: #b1832b; letter-spacing: 2px;">
                        Descobrir
                    </span>

                    <h2 class="h4 fw-bold mt-2 mb-3"
                        style="color: #102b45;">
                        <i class="fas fa-landmark me-2"
                           style="color: #d5a344;"></i>
                        Sobre este espaço
                    </h2>

                    <?php if (!empty($museu['descricao'])): ?>

                        <p class="mb-0 text-secondary"
                           style="line-height: 1.9;">
                            <?= nl2br(Html::encode($museu['descricao'])) ?>
                        </p>

                    <?php else: ?>

                        <p class="text-muted mb-0">
                            A descrição deste espaço ainda não está disponível.
                        </p>

                    <?php endif; ?>

                </div>
            </div>

            <!-- Localização -->
            <div class="card border-0 shadow-sm rounded-3">

                <div class="card-body p-4">

                    <span class="small fw-bold text-uppercase"
                          style="color: #b1832b; letter-spacing: 2px;">
                        Como chegar
                    </span>

                    <h2 class="h4 fw-bold mt-2 mb-4"
                        style="color: #102b45;">
                        <i class="fas fa-map-marked-alt me-2"
                           style="color: #d5a344;"></i>
                        Localização
                    </h2>

                    <div class="d-flex align-items-start gap-3 mb-3">

                        <i class="fas fa-map-marker-alt mt-1"
                           style="color: #b1832b;"></i>

                        <div>
                            <strong>Morada</strong>
                            <p class="text-secondary mb-0">
                                <?= Html::encode($museu['morada'] ?: 'Não disponível') ?>
                            </p>
                        </div>

                    </div>

                    <?php if ($temCoordenadas): ?>

                        <div class="d-flex align-items-start gap-3 mb-4">

                            <i class="fas fa-globe mt-1"
                               style="color: #b1832b;"></i>

                            <div>
                                <strong>Coordenadas</strong>
                                <p class="text-secondary mb-0">
                                    <?= Html::encode($museu['latitude']) ?>,
                                    <?= Html::encode($museu['longitude']) ?>
                                </p>
                            </div>

                        </div>

                        <a href="https://www.google.com/maps?q=<?= rawurlencode($museu['latitude'] . ',' . $museu['longitude']) ?>"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="btn btn-sm text-white"
                           style="background-color: #102b45;">
                            <i class="fas fa-directions me-2"></i>
                            Ver no Google Maps
                        </a>

                    <?php else: ?>

                        <p class="text-muted small mb-0">
                            As coordenadas deste espaço ainda não estão disponíveis.
                        </p>

                    <?php endif; ?>

                </div>
            </div>

        </div>

        <!-- Coluna direita -->
        <div class="col-lg-4">

            <!-- Horário -->
            <div class="card border-0 shadow-sm rounded-3 mb-4">

                <div class="card-body p-4">

                    <span class="small fw-bold text-uppercase"
                          style="color: #b1832b; letter-spacing: 2px;">
                        Planeia a tua visita
                    </span>

                    <h2 class="h4 fw-bold mt-2 mb-4"
                        style="color: #102b45;">
                        <i class="fas fa-clock me-2"
                           style="color: #d5a344;"></i>
                        Horário
                    </h2>

                    <?php if ($horarioAbertura && $horarioFecho): ?>

                        <div class="p-3 rounded-3"
                             style="background-color: #f4f0e8; border-left: 3px solid #d5a344;">

                            <div class="d-flex align-items-center gap-3">

                                <i class="fas fa-door-open fs-4"
                                   style="color: #b1832b;"></i>

                                <div>
                                    <strong class="d-block">
                                        Horário de funcionamento
                                    </strong>

                                    <span class="text-secondary">
                                        <?= Html::encode($horarioAbertura) ?>
                                        –
                                        <?= Html::encode($horarioFecho) ?>
                                    </span>
                                </div>

                            </div>
                        </div>

                        <p class="text-muted small mt-3 mb-0">
                            Confirme eventuais alterações antes da visita.
                        </p>

                    <?php else: ?>

                        <p class="text-muted mb-0">
                            Horário de funcionamento não disponível.
                        </p>

                    <?php endif; ?>

                </div>
            </div>

            <!-- Contactos -->
            <div class="card border-0 shadow-sm rounded-3">

                <div class="card-body p-4">

                    <span class="small fw-bold text-uppercase"
                          style="color: #b1832b; letter-spacing: 2px;">
                        Entra em contacto
                    </span>

                    <h2 class="h4 fw-bold mt-2 mb-4"
                        style="color: #102b45;">
                        <i class="fas fa-address-card me-2"
                           style="color: #d5a344;"></i>
                        Contactos
                    </h2>

                    <?php if (!empty($museu['telefone'])): ?>

                        <div class="d-flex align-items-start gap-3 mb-4">

                            <i class="fas fa-phone mt-1"
                               style="color: #b1832b;"></i>

                            <div>
                                <strong class="d-block">Telefone</strong>

                                <?= Html::a(
                                    Html::encode($museu['telefone']),
                                    'tel:' . preg_replace('/[^0-9+]/', '', $museu['telefone']),
                                    ['class' => 'text-decoration-none']
                                ) ?>
                            </div>

                        </div>

                    <?php else: ?>

                        <p class="text-muted small mb-3">
                            Telefone não disponível.
                        </p>

                    <?php endif; ?>

                    <?php if (!empty($museu['email'])): ?>

                        <div class="d-flex align-items-start gap-3">

                            <i class="fas fa-envelope mt-1"
                               style="color: #b1832b;"></i>

                            <div>
                                <strong class="d-block">Email</strong>

                                <?= Html::mailto(
                                    Html::encode($museu['email']),
                                    $museu['email'],
                                    ['class' => 'text-decoration-none']
                                ) ?>
                            </div>

                        </div>

                    <?php else: ?>

                        <p class="text-muted small mb-0">
                            Email não disponível.
                        </p>

                    <?php endif; ?>

                </div>
            </div>

        </div>

    </div>

    <!-- Informação de atualização -->
    <div class="alert mt-4 mb-0 d-flex align-items-center gap-2"
         style="background-color: #fff; border: 1px solid rgba(16,43,69,.15); color: #102b45;">

        <i class="fas fa-sync-alt"
           style="color: #b1832b;"></i>

        <small>
            Informação apresentada a partir dos dados registados no InforMuseus.
        </small>

    </div>

</div>
