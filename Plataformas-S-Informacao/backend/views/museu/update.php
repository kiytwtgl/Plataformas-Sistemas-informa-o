<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
/** @var \common\models\Museu $model */
/** @var \common\models\Localizacao $localizacao */

$this->title = 'Editar Museu: ' . $model->nome;
$this->params['breadcrumbs'][] = [
    'label' => 'Gestão de Museus',
    'url' => ['index']
];
$this->params['breadcrumbs'][] = 'Editar';
?>

<div class="museu-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="card card-primary">
        <div class="card-body">

            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'tipo')->dropDownList([
                'Museu' => 'Museu',
                'Monumento' => 'Monumento',
                'Exposição' => 'Exposição',
            ], ['prompt' => 'Selecionar tipo']) ?>

            <?= $form->field($model, 'descricao')->textarea(['rows' => 4]) ?>

            <?= $form->field($model, 'morada')->textInput(['maxlength' => true]) ?>

            <?= $form->field($localizacao, 'latitude')->input('number', [
                'step' => '0.0000001',
                'placeholder' => 'Ex: 39.7436',
            ]) ?>

            <?= $form->field($localizacao, 'longitude')->input('number', [
                'step' => '0.0000001',
                'placeholder' => 'Ex: -8.8071',
            ]) ?>


            <?= $form->field($model, 'preco')->input('number', [
                'step' => '0.01',
                'min' => '0',
            ]) ?>

            <?= $form->field($model, 'horario_abertura')->input('time') ?>

            <?= $form->field($model, 'horario_fecho')->input('time') ?>

            <?= $form->field($model, 'telefone')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'email')->input('email', ['maxlength' => true]) ?>

            <div class="form-group mt-3">

                <?= Html::submitButton('Guardar Alterações', [
                    'class' => 'btn btn-primary',
                ]) ?>

                <?= Html::a('Cancelar', ['index'], [
                    'class' => 'btn btn-secondary',
                ]) ?>

            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>

</div>