<?php

$this->title = 'Autoevaluación';

$this->params['breadcrumbs'][] = ['label' => 'Tests', 'url' => ['tests/index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="panel panel-primary" ng-app="ExaminationsForm" ng-controller="ExaminationsController" 
ng-init="Init(<?= $testId ?>)">
	<div class="panel-heading">
		<div class="row">
			<div class="col-lg-2">
				<button class="btn btn-lg btn-info" ng-hide="IsFirst()" ng-click="Previous()">
					<i class="glyphicon glyphicon-menu-left"></i>
				</button>
			</div>
			<div class="col-lg-8">
				<center><h4 class="title">Pregunta #{{questionNum}}</h4><p><b>Test:</b> {{test.name}}</p></center>
			</div>
			<div class="col-lg-2">
				<button class="btn btn-lg btn-info pull-right" ng-hide="IsLast()" ng-click="Next()">
					<i class="glyphicon glyphicon-menu-right"></i>
				</button>
			</div>
		</div>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-lg-12">
				<div class="alert alert-info" style="text-align:center;">{{ current.question.text }}</div>				
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12" ng-repeat="(key, option) in current.options">
				<div class="alert" style="text-align: center;" ng-click="Mark(key)"
				ng-class="{'alert-warning': !HasSelected(), 'alert-success': IsSelected(key), 'alert-danger': !IsSelected(key) && HasSelected()}">
					{{ option.text }}
				</div>
			</div>
		</div>
	</div>
	<div class="panel-heading" style="background: cornflowerblue;">
		<div class="row">
			<div class="col-lg-4">
				<button class="btn btn-lg btn-info" ng-hide="IsFirst()" ng-click="Previous()">
					<i class="glyphicon glyphicon-menu-left"></i>
				</button>
			</div>
			<div class="col-lg-3 col-lg-offset-1">
				<center>
					<div class="input-group">
						<div class="input-group-addon alert-info" title="Preguntas contestadas">
							{{answered}}/{{questions.length}}
						</div>
						<button class="btn btn-primary btn-lg">Finalizar</button>
					</div>
				</center>
			</div>
			<div class="col-lg-4">
				<button class="btn btn-lg btn-info pull-right" ng-hide="IsLast()" ng-click="Next()">
					<i class="glyphicon glyphicon-menu-right"></i>
				</button>
			</div>
		</div>
	</div>
</div>

<input type="hidden" id="urlToGetNewExamination" value="<?= Yii::$app->urlManager->createUrl('examinations/get-new-for-test') ?>">