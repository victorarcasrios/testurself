<?php

use yii\helpers\Html;
use yii\helpers\Url;

switch($mode){
	case 'create': default:
		$this->title = "Nuevo test";
		$panelStyle = "success";
		$questionBtnClass = "btn-success createBtn";
		$questionBtnText = "Crear";
		$questionBtnHandler = "Create()";
		$additionalAngularJsInits = "";
		break;

	case 'edit':
		$this->title = "Editar test";
		$panelStyle = "info";
		$questionBtnClass = "btn-primary editAnchor";
		$questionBtnText = "Editar";
		$questionBtnHandler = "Edit($id)";
		$additionalAngularJsInits = "Load( ".$id." )";
		break;
}

$this->params['breadcrumbs'][] = ['label' => 'Tests', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="row" ng-app="TestsForm" ng-controller="TestsController" ng-init="Init(); <?= $additionalAngularJsInits ?>">
	<div class="col-lg-12">
		<!-- MAIN TEST PANEL -->
		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="row">
					<div class="col-lg-10">
						<h4 class="title"><?= $this->title ?></h4>
					</div>
					<div class="col-lg-2">
						<button class="btn btn-lg <?= $questionBtnClass ?> pull-right" 
							ng-disabled="CanNotSubmit()" ng-click="<?= $questionBtnHandler ?>">
							<?= $questionBtnText ?>
						</button>
					</div>
				</div>
			</div>
			<div class="panel-body">
				<div class="row-fluid">
					<div class="col-lg-12 alert alert-success" style="text-align: center" 
					ng-show="BothQuestionsCollapsed() && created === SUCCESS">
						Test creado satisfactoriamente. Abre la sección Autoevaluaciones
						para comenzar a resolverla, o crea otra más.
					</div>
					<div class="col-lg-12 alert alert-danger" style="text-align: center"
					ng-show="created === ERROR">
						Lo sentimos. Ocurrió un error mientras creábamos el test. 
						Inténtalo de nuevo en un rato o contacta con soporte
					</div>
				</div>
				<div class="row" style="padding-bottom: 10px;">
					<div class="col-lg-6 col-lg-offset-3 form-horizontal">
						<div class="input-group">
							<div class="input-group-addon">
								<strong>Nombre</strong>
							</div>
							<input type="text" class="form-control" ng-model="test.name">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<!-- INNER CURRENT QUESTIONS PANEL -->
						<div class="panel panel-primary">
							<div class="panel-heading">
								<div class="row">
									<div class="col-lg-10">
										<h4 class="panel-title">Preguntas del test</h4>
									</div>
									<div class="col-lg-2">
										<button class="btn btn-info btn-sm pull-right"
										data-toggle="collapse" data-target="#currentQuestions"
										ng-click='currentQuestionsCollapsed = !currentQuestionsCollapsed'>
											<i class="glyphicon" ng-class="{'glyphicon-minus': !currentQuestionsCollapsed,
											 'glyphicon-plus': currentQuestionsCollapsed}"></i>
										</button>
									</div>
								</div>
							</div>
							<div class="panel-body collapse in" id="currentQuestions">
								<div class="alert alert-warning" ng-show="test.questions.length < MIN_QUESTIONS">
									Añade al menos {{MIN_QUESTIONS}} preguntas para poder crear un test
								</div>
								<!-- CURRENT QUESTIONS TABLE -->
								<table id="currentQuestionsTable" class="table table-striped" ng-show="test.questions.length">
									<tbody>
										<tr ng-repeat="(key, question) in test.questions">
											<th>{{ key + 1 }}</th>
											<td>{{ question.text }}</td>
											<td>
												<button class="btn btn-danger pull-right" ng-click="RemoveQuestion(key)">
													Quitar <i class="glyphicon glyphicon-minus"></i>
												</button>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<!-- END INNER CURRENT QUESTIONS PANEL -->
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<!-- INNER REMAINING QUESTIONS PANEL -->
						<div class="panel panel-info">
							<div class="panel-heading">
								<div class="row">
									<div class="col-lg-10">
										<h4 class="panel-title">Resto de preguntas</h4>
									</div>
									<div class="col-lg-2">
										<button class="btn btn-info btn-sm pull-right"
										data-toggle="collapse" data-target="#remainingQuestions"
										ng-click='remainingQuestionsCollapsed = !remainingQuestionsCollapsed'>
											<i class="glyphicon" ng-class="{'glyphicon-minus': !remainingQuestionsCollapsed,
											 'glyphicon-plus': remainingQuestionsCollapsed}"></i>
										</button>
									</div>
								</div>
							</div>
							<div class="panel-body collapse in" id="remainingQuestions">
								<!-- REMAINING QUESTIONS TABLE -->
								<table datatable="" id="remainingQuestionsTable" class="table table-striped" ng-show="remainingQuestions.length">
									<thead>
										<tr>
											<th>#</th>
											<th>Pregunta</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										<tr ng-repeat="(key, question) in remainingQuestions">
											<td>{{ key + 1 }}</th>
											<td>{{ question.text }}</td>
											<td>
												<button class="btn btn-success pull-right" ng-click="AddQuestion(key)">
													Añadir <i class="glyphicon glyphicon-plus"></i>
												</button>
											</td>
										</tr>
									</tbody>
								</table>
								<div class='alert alert-danger' ng-show="!remainingQuestions.length && !test.questions.length">
									No tienes preguntas. 
									<b><a href="<?= Yii::$app->urlManager->createUrl('questions/create') ?>" style="color: green">Crea alguna primero</a></b>
									 para poder crear un test
								</div>
							</div>
						</div>
						<!-- END INNER REMAINING QUESTIONS PANEL -->
					</div>
				</div>
			</div>
		</div>
		<!-- END MAIN TEST PANEL -->
	</div>
</div>

<input type="hidden" id="urlToGetAllQuestions" value="<?= Yii::$app->urlManager->createUrl('questions/list') ?>">