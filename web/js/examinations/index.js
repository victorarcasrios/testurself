angular.module('ExaminationsIndex', [])
	.controller('ExaminationsController', function($scope)
	{
		$scope.OPEN = 1;
		$scope.CLOSED = 0;

		$scope.examinations = [];

		$scope.Init = function()
		{
			var url = $("#urlToGetExaminations").val();

			$.get(url, function(data){
				$scope.$apply(function(){
					$scope.examinations = data;
				});
				$("#table").dataTable();
			});
		}

		$scope.GetFormattedStatus = function(key)
		{
			return $scope.examinations[key].examination.status == $scope.OPEN 
					? 'Por finalizar' : 'Cerrado';
		}

		$scope.IsOpen = function(key)
		{
			return $scope.examinations[key].examination.status == $scope.OPEN;
		}

		$scope.IsClosed = function(key)
		{
			return $scope.examinations[key].examination.status == $scope.CLOSED;
		}
	}
);