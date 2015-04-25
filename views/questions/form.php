<?php

use yii\helpers\Html;
use yii\helpers\Url;

switch($mode){
	case 'create': default:
		$this->title = "Nueva pregunta";
		$panelStyle = "success";
		$questionBtnClass = "btn-success createBtn";
		$questionBtnText = "Crear";
		$questionBtnHandler = "Create()";
		$additionalAngularJsInits = "";
		break;

	case 'edit':
		$this->title = "Editar pregunta";
		$panelStyle = "info";
		$questionBtnClass = "btn-primary editAnchor";
		$questionBtnText = "Editar";
		$questionBtnHandler = "Edit($id)";
		$additionalAngularJsInits = "ng-init='Load( ".$id." )'";
		break;
}

$this->params['breadcrumbs'][] = ['label' => 'Preguntas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<style>
	.option{
		padding: 3px;
		margin: 2px;
	}

	.marged{
		margin: 0px 2px 0px 2px;
	}

	#optionsSection{
		margin-top: 10px;
	}
</style>

<div id="main-view-wrapper" class="panel panel-<?= $panelStyle ?>" ng-app="QuestionsForm" 
	ng-controller="QuestionsController" <?= $additionalAngularJsInits ?>>
<!-- ng-init="Init('<?php //Yii::$app->request->getCsrfToken()?>', '<?php //Url::to('questions/create') ?>'"> -->

	<!-- FIRST Panel Header -->
	<div class="panel-heading">
		<div class="row">
			<div class="col-lg-10">
				<h1 class="panel-title"><?= Html::encode($this->title) ?></h1>	
			</div>
			<div class="col-lg-2">
				<button id="questionBtn" class="pull-right btn btn-lg <?= $questionBtnClass ?>" 
					type="button" ng-disabled="CanNotCreateIt()" ng-click="<?= $questionBtnHandler ?>">
					<?= $questionBtnText ?>
				</button>	
			</div>
		</div>
	</div>

	<!-- FIRST Panel Body -->
	<div class="panel-body">		
		<div class="row">
			<div class="col-lg-12">
				<textarea id="questionText" rows="5" max-length="255" class="form-control"
				placeholder="Texto de la pregunta (max: 255 caracteres)" ng-model="question.text"></textarea>
			</div>
		</div>

		<!-- SECOND (INNER) PANEL -->
		<div class="panel panel-primary" id="optionsSection">
			<div class="panel-heading">
				<h4 class="panel-title">Opciones</h4>
			</div>

			<div class="panel-body">
				<div class="row-fluid">
					<div class="col-lg-12 alert alert-danger" ng-hide="HasOptions()">
						<p>No hay opciones. Crea al menos dos para que sea una pregúnta válida.</p>
					</div>
					<div class="col-lg-12 alert alert-warning" ng-show="HasOnlyOneOption()">
						<p>¡Bien hecho! Añade una más para que sea una pregúnta válida.</p>
					</div>
					<div class="col-lg-12 alert alert-success" ng-show="JustNeedsCorrectOption()">
						<p>Ahora solo te queda marcar la opción correcta para que sea una pregúnta válida.</p>
					</div>			
					<div class="col-lg-12 alert alert-info option" ng-repeat="(key, option) in options">
						<p style="padding-left: 10px;">
							<b style="padding-right: 30px;">#{{ key +1 }}</b> {{ option.text }}				
							<button class="correct btn pull-right marged" ng-click="MarkAsCorrect(key)" 
							ng-class="{'btn-success': option.correct, 'btn-danger': !option.correct}">
								<i class="glyphicon glyphicon-ok"></i>
							</button>
							<button class="rmOption btn btn-danger pull-right marged" ng-click="RemoveOption(key)">
								<i class="glyphicon glyphicon-remove"></i>
							</button>
						</p>
					</div>	
				</div>

				<div class="row-fluid" ng-hide="LimitReached()">
					<div class="col-lg-12" style="padding-bottom: 10px; margin-top: 10px;">
						<textarea id="optionText" rows="2" max-length="255" class="form-control"
						placeholder="Nueva opción (max: 255 caracteres)" ng-model="newOption.text"></textarea>
					</div>
					<div class="col-lg-12">
						<button id="addOptionBtn" class="btn btn-warning pull-right" ng-click="AddOption()">
							Añadir
							<i class="glyphicon glyphicon-plus"></i>
						</button>
					</div>
				</div>

				<div class="row-fluid">
					<div class="col-lg-10 alert alert-success" ng-show="created == SUCCESS">
						Tanto la pregunta como sus opciones han sido registradas satisfactoriamente.
					</div>
					<div class="col-lg-10 alert alert-danger" ng-show="created == ERROR">
						Ocurrió un error en el servidor. Revisa los datos e intentalo de nuevo.
					</div>
					<div class="col-lg-10" ng-show="created == UNTOUCHED"><br></div>
				</div>
			</div>
		</div>

	<!-- END First Panel Body -->
	</div>

	<input type="hidden" name="csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
	<input type="hidden" name="urlToCreateQuestions" value="<?= Yii::$app->urlManager->createUrl('questions/create') ?>" />
	<input type="hidden" id="urlToGetQuestion" value="<?= Yii::$app->urlManager->createUrl('questions/get') ?>" />
	<input type="hidden" id="urlToEditQuestion" value="<?= Yii::$app->urlManager->createUrl('questions/edit') ?>" />	

</div>
