angular.module('ExaminationsForm', [])
	.controller('ExaminationsController', function($scope)
	{
		$scope.SUCCESS = 1;
		$scope.questionNum = 1;

		$scope.test = {};
		$scope.questions = [];

		$scope.Init = function(testId)
		{
			$scope.test.id = testId;
			var url = $("#urlToGetNewExamination").val() + '&testId=' + testId;

			$.get(url, function(data){
				if(data.status == $scope.SUCCESS){
					$scope.test = data.test;
					$scope.questions = data.questions;
					$scope.current = $scope.questions[0];
					console.log($scope.current);
					$scope.$apply();
				}
			});
		}

		$scope.IsFirst = function()
		{
			return $scope.current == $scope.questions[0];
		}

		$scope.IsLast = function()
		{
			return $scope.current == $scope.questions[$scope.questions.length-1];
		}

		$scope.Previous = function()
		{
			if( $scope.IsFirst() ) return;

			$scope.current = $scope.questions[$scope.questions.indexOf($scope.current) - 1];
			$scope.questionNum--;
		}

		$scope.Next = function()
		{
			if( $scope.IsLast() ) return;

			$scope.current = $scope.questions[$scope.questions.indexOf($scope.current) + 1];	
			$scope.questionNum++;
		}
	}
);