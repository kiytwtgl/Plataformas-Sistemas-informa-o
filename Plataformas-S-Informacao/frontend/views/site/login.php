<?php

declare(strict_types=1);

/** @var yii\web\View $this */
/** @var \frontend\models\LoginForm $model */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = 'Iniciar sessão — InforMuseus';
$this->params['fullWidth'] = true;
?>
<section class="im-auth">
    <div class="im-container">
        <div class="im-auth-card">
            <aside class="im-auth-brand">
                <a class="im-brand" href="<?= Url::home() ?>">Infor<span>Museus</span></a>
                <div>
                    <h1>Bem-vindo<br>de volta.</h1>
                    <p>Inicie sessão para continuar a descobrir museus e monumentos e a planear as suas visitas.</p>
                    <ul class="im-auth-points">
                        <li>Guarde os espaços que quer visitar</li>
                        <li>Consulte e gira os seus bilhetes</li>
                        <li>Acompanhe o seu histórico de visitas</li>
                    </ul>
                </div>
            </aside>

            <div class="im-auth-form">
                <p class="im-auth-kicker">ÁREA DE UTILIZADOR</p>
                <h2>Iniciar sessão</h2>
                <p class="im-auth-sub">Introduza as suas credenciais para continuar.</p>

                <?php $form = ActiveForm::begin([
                    'id' => 'login-form',
                    'options' => ['class' => 'im-form', 'novalidate' => true],
                    'errorCssClass' => 'im-has-error',
                    'successCssClass' => '',
                    'fieldConfig' => [
                        'options' => ['class' => 'im-field'],
                        'template' => "{label}\n{input}\n{error}",
                        'labelOptions' => ['class' => 'im-label'],
                        'inputOptions' => ['class' => 'im-input'],
                        'errorOptions' => ['tag' => 'div', 'class' => 'im-error'],
                    ],
                ]); ?>

                <?= $form->field($model, 'email')->textInput([
                    'type' => 'email',
                    'autofocus' => true,
                    'autocomplete' => 'email',
                    'placeholder' => 'nome@exemplo.pt',
                ])->label('Email') ?>

                <?= $form->field($model, 'password')->passwordInput([
                    'autocomplete' => 'current-password',
                    'placeholder' => 'A sua password',
                ])->label('Password') ?>

                <?= $form->field($model, 'rememberMe')->checkbox([
                    'label' => 'Manter sessão iniciada',
                    'labelOptions' => ['class' => 'im-check'],
                    'template' => '{input}',
                ]) ?>

                <?= Html::submitButton('ENTRAR <span aria-hidden="true">→</span>', [
                    'class' => 'im-button im-button-gold im-submit',
                    'name' => 'login-button',
                ]) ?>

                <?php ActiveForm::end(); ?>

                <div class="im-auth-links">
                    <?= Html::a('Esqueceu-se da password?', ['/site/request-password-reset']) ?>
                </div>

                <div class="im-auth-links im-auth-switch">
                    Ainda não tem conta? <?= Html::a('Criar conta', ['/site/signup']) ?>
                </div>
            </div>
        </div>
    </div>
</section>
