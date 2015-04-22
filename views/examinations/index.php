<?php
$this->title = 'Autoevaluaciones';

$this->params['breadcrumbs'][] = $this->title;
?>

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
							<th>Test</th>
							<th>Fecha</th>
							<th>Estado</th>
							<th>Acciones</th>
						</tr>
					</thead>
					<tbody>
						<tr ng-repeat="(key, examination) in examinations">
							<td>{{ key +1 }}</td>
							<td>{{ examination.test.name }}</td>
							<td>{{ examination.examination.date }}</td>
							<td>{{ examination.examination.status }}</td>
							<td></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<input type="hidden" id="urlToGetExaminations" value="<?= Yii::$app->urlManager->createUrl('examinations/list') ?>">