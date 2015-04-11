<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

$this->title = 'Iniciar sesión';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login col-lg-4 col-lg-offset-4">
    <h1><?= Html::encode($this->title) ?></h1>
    <br>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'options' => ['class' => 'form-horizontal'],        
    ]); ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'password')->passwordInput() ?>

    <hr>
    <div class="row">
        <div class="col-lg-12 center-block">
            <?= Html::submitButton('Login', ['class' => 'btn btn-primary center-block', 'name' => 'login-button']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
