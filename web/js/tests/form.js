var currentQuestionsTable;
var remainingQuestionsTable;

angular.module('TestsForm', [])
	.controller('TestsController', function($scope)
	{
		var csrfToken = $('meta[name="csrf-token"]').attr("content");
		$scope.MIN_QUESTIONS = 3;
		$scope.SUCCESS = 1;
		$scope.ERROR = -1;
		$scope.UNTOUCHED = 0;
		$scope.TEST_NOT_FOUND = -2;
		$scope.created = $scope.UNTOUCHED;
		$scope.updated = $scope.UNTOUCHED;

		$scope.test = {
			id: undefined,
			name: undefined,
			questions: []
		};
		$scope.remainingQuestions = [];

		$scope.currentQuestionsCollapsed = false;
		$scope.remainingQuestionsCollapsed = false;

		$scope.Init = function()
		{
			$scope.LoadRemainingQuestions();
		}

		$scope.Load = function(id)
		{
			var url = $("#urlToGetTest").val() + '&id=' +id;

			$.get(url, function(data){
				if(data.status == $scope.SUCCESS){
					$scope.test = data.test;
					$scope.ReloadQuestions(data.questions);					
				}
				else if(data.status == $scope.TEST_NOT_FOUND)
					$scope.updated = $scope.TEST_NOT_FOUND;
				else
					$scope.updated = $scope.ERROR;
			});
		}

		$scope.ReloadQuestions = function(questions)
		{
			$scope.test.questions = questions;	
			$scope.RemoveQuestionFromRemainingsTable(questions);
			$scope.$apply();
		}

		$scope.RemoveQuestionFromRemainingsTable = function(questions)
		{
			angular.forEach(questions, function(target, key){
				$scope.remainingQuestions = $scope.remainingQuestions.filter(function(current){ 
					return current.id != target.id;
				});
			}); 
		}

		$scope.Edit = function(key)
		{
			if($scope.CanNotSubmit()) return;

			var url = $("#urlToUpdateTest").val();

			$.post(url, {
				_csrf: csrfToken,
				test: $scope.test
			}, function(data){
				if(data.status == $scope.SUCCESS)
					$scope.updated = $scope.SUCCESS;
				else
					$scope.updated = ERROR;
			});
		}

		$scope.LoadRemainingQuestions = function()
		{
			var url = $("#urlToGetAllQuestions").val();

			$.get(url, function(data){
				if(data.status !== $scope.SUCCESS) return;

				$scope.$apply(function(){
					$scope.remainingQuestions = data.questions;
				});
			});
		}

		$scope.AddQuestion = function(key)
		{
			$scope.test.questions.push($scope.remainingQuestions[key]);
			$scope.remainingQuestions.splice(key, 1);
		}

		$scope.RemoveQuestion = function(key)
		{
			$scope.remainingQuestions.push($scope.test.questions[key]);
			$scope.test.questions.splice(key, 1);
		}

		$scope.CanNotSubmit = function()
		{
			return $scope.test.questions.length < $scope.MIN_QUESTIONS || angular.isUndefined($scope.test.name);
		}

		$scope.Create = function()
		{
			if($scope.CanNotSubmit()) return;
			var url = $("#urlToCreateTest").val();

			$.post(url, {
				_csrf: csrfToken,
				test: $scope.test
			}, function(data){
				if(data == $scope.SUCCESS)
					$scope.OnTestCreated();
				else
					$scope.created = $scope.ERROR;
			});
		}

		$scope.OnTestCreated = function()
		{
			$scope.remainingQuestions.push.apply($scope.remainingQuestions, $scope.test.questions);
			$scope.test = {
				name: undefined,
				questions: []
			};
			$scope.$apply(function(){
				$scope.currentQuestionsCollapsed = true;
				$scope.remainingQuestionsCollapsed = true;
				$scope.created = $scope.SUCCESS;
			});			
		}

		$scope.BothQuestionPanelsCollapsed = function()
		{
			return $scope.currentQuestionsCollapsed && $scope.remainingQuestionsCollapsed;
		}
	}
);

// window.onload = function()
// {
// 	remainingQuestionsTable = $('#remainingQuestionsTable').dataTable({
// 	  	"pageLength": 5,
// 		"lengthChange": false,
// 		"columnDefs": [
// 			{"orderable": false, "targets": 2},
// 			{"searchable":false, "targets": 0}
// 		]
// 	});
// }