<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

$this->title = 'Nueva cuenta';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup col-lg-6 col-lg-offset-3">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([
        'id' => 'site-form',
        'options' => ['class' => 'form-horizontal']
    ]); ?>

    <?= $form->field($model, 'username') ?>

    <?= $form->field($model, 'email') ?>

    <?= $form->field($model, 'password')->passwordInput() ?>
	
	<div class="row">
		<label for="repeatPassword" id="repeatPasswordLabel">Repite la contraseña</label>
		<input type="password" name="repeatPassword" id="repeatPassword" 
			class="form-control" required>
		<p class="help-block help-block-error hide" style="color: #A94442;">
			Las contraseñas no coinciden
		</p>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<hr>
		</div>
	</div>

	<div class="row">
	    <div class="col-lg-12 center-block">
            <?= Html::submitButton('Registrarse', ['class' => 'btn btn-success center-block', 'name' => 'signup-button']) ?>
	    </div>
	</div>

    <?php ActiveForm::end(); ?>
</div>

<?php 
$this->registerJsFile('js/jquery.min.js'); 
$this->registerJsFile('js/repeatPassword.js'); 
?>
