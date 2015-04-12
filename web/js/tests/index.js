angular.module('TestsIndex', [])
	.controller('TestsController', function($scope)
	{
		var csrfToken = $('meta[name="csrf-token"]').attr("content");
		$scope.SUCCESS = 1;
		$scope.NONE = -1;

		$scope.tests = [];
		$scope.deletionTarget = $scope.NONE;

		$scope.Init = function()
		{
			var url = $("#urlToGetAllTests").val();

			$.get(url, function(data){
				$scope.$apply(function(){
					$scope.tests = data;
				});
				$("#table").dataTable();
			});
		}

		$scope.Delete = function(key)
		{
			$scope.deletionTarget = key;
		}

		$scope.TryToDelete = function(key)
		{
			return $scope.deletionTarget === key;
		}

		$scope.ConfirmDeletion = function()
		{
			var url = $("#urlToDeleteTest").val();
			var id = $scope.tests[$scope.deletionTarget].id;

			$.post(url, {
				_csrf: csrfToken,
				id: id
			}, function(data){
				if(data == $scope.SUCCESS)
					$scope.$apply(function(){
						$scope.tests.splice($scope.deletionTarget, 1);
					});
			});
		}

		$scope.CancelDeletion = function()
		{
			$scope.deletionTarget = $scope.NONE;
		}

	}
);