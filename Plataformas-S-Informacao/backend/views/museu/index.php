<?php

/** @var yii\data\ActiveDataProvider $dataProvider */
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Gestão de Museus e Monumentos';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="museu-index">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><?= Html::encode($this->title) ?></h1>

        <?= Html::a('Adicionar Museu', ['create'], [
            'class' => 'btn btn-success',
        ]) ?>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => [
            'class' => 'table table-striped table-bordered table-hover',
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_museu',
            'nome',
            'tipo',
            'morada',
            'horario_abertura',
            'horario_fecho',
            'telefone',
            'email',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'header' => 'Ações',
                'buttons' => [
                    'update' => function ($url) {
                        return Html::a('Editar', $url, [
                            'class' => 'btn btn-primary btn-sm',
                        ]);
                    },
                    'delete' => function ($url) {
                        return Html::a('Desativar', $url, [
                            'class' => 'btn btn-danger btn-sm',
                            'data-method' => 'post',
                            'data-confirm' => 'Tens a certeza de que queres desativar este espaço?',
                        ]);
                    },
                ],

            ],
        ],
    ]); ?>

</div>