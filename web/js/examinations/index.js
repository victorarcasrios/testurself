angular.module('ExaminationsIndex', [])
	.controller('ExaminationsController', function($scope)
	{
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
	}
);