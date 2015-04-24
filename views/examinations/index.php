<?php
$this->title = 'Autoevaluaciones';

$this->params['breadcrumbs'][] = $this->title;
?>

<style>
	.fa-lock{
		color: red;
	}
	.fa-unlock-alt{
		color: green;
	}
</style>

<div class="panel panel-primary" ng-app="ExaminationsIndex" ng-controller="ExaminationsController" ng-init="Init()">
	<div class="panel-heading">
		<h4 class="panel-title"><?= $this->title ?></h4>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-lg-12">
				<a href="<?= Yii::$app->urlManager->createUrl('examinations/new') ?>" class="btn btn-success">
					Nueva autoevaluación
				</a>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12" style="padding-top: 10px;">
				<table id="table" class="table table-striped table-bordered">
					<thead>
						<tr>
							<th>#</th>
							<th><center>Test</center></th>
							<th><center>Fecha</center></th>
							<th><center>Estado</center></th>
							<th><center>Acciones</center></th>
						</tr>
					</thead>
					<tbody>
						<tr ng-repeat="(key, examination) in examinations">
							<td>{{ key +1 }}</td>
							<td><center>{{ examination.test.name }}</center></td>
							<td><center>{{ examination.examination.date }}</center></td>
							<td><center>
								<i class="fa fa-lg" ng-class="{'fa-unlock-alt': IsOpen(key), 'fa-lock': IsClosed(key)}"></i>
								{{ GetFormattedStatus(key) }}
							</center></td>
							<td style="text-align: center;">
								<span ng-hide="TryToDelete(key)">
									<a href="index.php?r=examinations/continue&id={{ examination.examination.id }}" 
									title="Continuar" ng-if="IsOpen(key)" class="btn-lg">
										<i class="glyphicon glyphicon-check"></i>
									</a>
									<a href="index.php?r=examinations/results&id={{ examination.examination.id }}" 
									title="Ver resultados" ng-if="IsClosed(key)" class="btn-lg">
										<i class="fa fa-bar-chart"></i>
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
</div>

<input type="hidden" id="urlToGetExaminations" value="<?= Yii::$app->urlManager->createUrl('examinations/list') ?>">