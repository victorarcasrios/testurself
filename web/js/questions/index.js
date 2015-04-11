angular.module('QuestionsList', [])
	.controller('QuestionsController', function($scope)
	{
		var csrfToken = $('meta[name="csrf-token"]').attr("content");
		$scope.SUCCESS = 1;
		$scope.ERROR = 0;
		$scope.LOADING = 2;

		$scope.deletionTarget = -1;
		$scope.inited = $scope.LOADING;
		$scope.confirmation = false;
		$scope.questions = [];

		$scope.Init = function()
		{
			var url = $("#urlToGetAllQuestions").val();
			
			$.get(url, function(data){
				if(data.status == $scope.SUCCESS)
					$scope.FillTable(data);				
			});
		}

		$scope.FillTable = function(data)
		{
			$scope.questions = data.questions;
			$scope.inited = data.status;
			$scope.$apply();
			$("#table").dataTable();
		}

		$scope.Delete = function(key)
		{
			$scope.deletionTarget = key;
			$scope.confirmation = true;
			console.log(key, $scope.confirmation);
		}

		$scope.ConfirmDeletion = function(key)
		{
			var url = $("#urlToRemoveQuestions").val();
			var id = $scope.questions[key].id;

			$.post(url, {_csrf: csrfToken, id: id}, function(data){
				if(data == 1)
					$scope.RemoveFromList(key);
			});
		}

		$scope.RemoveFromList = function(key)
		{
			$scope.questions.splice(key, 1);
			$scope.confirmation = false;
			$scope.$apply();
			$("#table").dataTable();
			console.log($scope.questions);
		}

		$scope.CancelDeletion = function()
		{
			$scope.confirmation = false;
		}

		$scope.TryToDelete = function(key)
		{
			var isTarget = $scope.deletionTarget === key;
			return isTarget && $scope.confirmation;
		}
	}
);