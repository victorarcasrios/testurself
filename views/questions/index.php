<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = "Preguntas";
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="panel panel-primary" ng-app="QuestionsList" ng-controller="QuestionsController">
	<div class="panel-heading">
		<h4 class="panel-title"><?= Html::encode($this->title) ?></h4>
	</div>
	<div class="panel-body">
		<div class="row-fluid">
			<div class="col-lg-2">
				<?= Html::a(
					'Nueva pregunta', 
		            ['create'], 
		            ['class' => 'btn btn-success']
		        ); ?>
			</div>
			<div class="col-lg-10" ng-switch="inited">
				<div class="alert alert-info" ng-switch-when="LOADING">
					Cargando datos de preguntas
				</div>
				<div class="alert alert-danger" ng-switch-when="ERROR">
					Ocurrió un error al cargar los datos de las preguntas
				</div>
			</div>
		</div>

		<div class="row-fluid">
			<div class="col-lg-12">
				<br>
				<table id="table" class="table table-striped table-bordered" ng-init="Init()">
					<thead>
						<tr>
							<th>#</th>
							<th>Pregunta</th>
							<th style="text-align: center;">Acciones</th>
						</tr>
					</thead>
					<tbody>
						<tr ng-repeat="(key, question) in questions">
							<td>{{ key + 1 }}</td>
							<td>{{ question.text }}</td>
							<td style="text-align:center;">								
								<span ng-hide="TryToDelete(key)">
									<!--<a href="index.php?r=questions/view&id={{ question.id }}" 
									title="Ver">
										<i class="glyphicon glyphicon-eye-open"></i>
									</a>-->
									<a href="index.php?r=questions/edit&id={{ question.id }}" 
									title="Editar" class="btn-lg">
										<i class="glyphicon glyphicon-pencil"></i>
									</a>
							        <a href="javascript:void(0);" 
							        ng-click="Delete(key)" class="btn-lg" title="Eliminar">
							        	<i class="glyphicon glyphicon-trash"></i>
							        </a>
							    </span>
						        <span ng-show="TryToDelete(key)">
						        	¿Eliminar?
							        <button class="btn btn-success btn-sm" 
							        ng-click="ConfirmDeletion(key)">
										<i class="glyphicon glyphicon-ok"></i>
							    	</button>
							        <button class="btn btn-danger btn-sm" 
							        ng-click="CancelDeletion()">
							        	<i class="glyphicon glyphicon-remove"></i>
							    	</button>
							    </span>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<input type="hidden" id="urlToGetAllQuestions" value="<?= Yii::$app->urlManager->createUrl('questions/list') ?>">
	<input type="hidden" id="urlToRemoveQuestions" value="<?= Yii::$app->urlManager->createUrl('questions/delete') ?>">
</div>