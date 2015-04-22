<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = "Tests";
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-primary" ng-app="TestsIndex" ng-controller="TestsController"
		ng-init="Init()">
			<div class="panel-heading">
				<h4 class="panel-title">Tests</h4>
			</div>
			<div class="panel-body">
				<div class="row" style="padding-bottom: 10px;">
					<div class="col-lg-8">
						<a href="<?= Yii::$app->urlManager->createUrl('tests/create') ?>"
						 class="btn btn-success">
							Nuevo test
						</a>
					</div>
					<div class="col-lg-4">
						<?php if(isset($infoMessage)): ?>
						<div class="alert alert-info" style="text-align: center;">
							<?= $infoMessage ?>
						</div>
						<?php endif; ?>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<table id="table" class="table table-striped table-bordered">
							<thead>
								<tr>
									<th>#</th>
									<th>Test</th>
									<th style="text-align: center">Acciones</th>
								</tr>
							</thead>
							<tbody>
								<tr ng-repeat="(key, test) in tests">
									<td>{{ key + 1 }}</td>
									<td>{{ test.name }}</td>
									<td style="text-align: center; width: 200px;">
										<span ng-hide="TryToDelete(key)">
											<a href="index.php?r=tests/update&id={{ test.id }}" 
											title="Editar" class="btn-lg">
												<i class="glyphicon glyphicon-pencil"></i>
											</a>
											<a href="index.php?r=examinations/new&testId={{ test.id }}" 
											title="Realizar" class="btn-lg">
												<i class="glyphicon glyphicon-check"></i>
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
	</div>
</div>

<input type="hidden" id="urlToGetAllTests" value="<?= Yii::$app->urlManager->createUrl('tests/list') ?>">
<input type="hidden" id="urlToDeleteTest" value="<?= Yii::$app->urlManager->createUrl('tests/delete') ?>">