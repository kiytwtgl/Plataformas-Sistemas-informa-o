<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

if (!isset($model)) {
    $model = new \yii\base\Model();
}

if (!isset($perfil)) {
    $perfil = new \yii\base\Model();
}

$this->title = "Editar Utilizador: {$model->username}";
$this->params['breadcrumbs'][] = ['label' => 'Utilizadores', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Editar';
?>
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="user-form">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

        <?= $form->field($perfil, 'nome')->textInput(['maxlength' => true, 'name' => 'PerfilUtilizador[nome]']) ?>

        <?= $form->field($perfil, 'tipo')->textInput(['maxlength' => true, 'name' => 'PerfilUtilizador[tipo]']) ?>

        <?= $form->field($model, 'new_password')->passwordInput([
            'placeholder' => 'Deixe em branco se não quiser alterar a password'
        ])->label('Nova Password') ?>

        <div class="form-group" style="margin-top: 15px;">
            <?= Html::submitButton('Guardar Alterações', ['class' => 'btn btn-success']) ?>
            <?= Html::a('Cancelar', ['index'], ['class' => 'btn btn-secondary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

</div>