angular.module('ExaminationsForm', [])
	.controller('ExaminationsController', function($scope)
	{
		var csrfToken = $('meta[name="csrf-token"]').attr("content");
		$scope.EXAMINATION_ID = false;
		$scope.LETTERS = ['a', 'b', 'c', 'd'];
		$scope.SUCCESS = 1;
		$scope.questionNum = 1;
		$scope.answered = 0;

		$scope.test = {};
		$scope.questions = [];		
		$scope.toSave = []; 

		$scope.Init = function(id, testId)
		{console.log(id);
			$scope.EXAMINATION_ID = id;
			var testId = testId || false;

			if(testId)
				$scope.NewExaminationInit(id, testId);
			else
				$scope.ContinueExaminationInit(id);
		}

		$scope.ContinueExaminationInit = function(id)
		{
			var url = $("#urlToGetExamination").val() + '&id=' + id;

			$.get(url, function(data){
				if(data.status == $scope.SUCCESS){
					$scope.Load(data);
				}
			});
		}

		$scope.CountAnswers = function()
		{
			angular.forEach($scope.questions, function(question, key){
				if(question.hasOwnProperty('selected'))
					$scope.answered++;
			});
		}

		$scope.NewExaminationInit = function(id, testId)
		{
			$scope.test.id = testId;
			var url = $("#urlToGetNewExamination").val() + '&testId=' + testId;

			$.get(url, function(data){
				if(data.status == $scope.SUCCESS){
					$scope.Load(data);
				}
			});
		}

		$scope.Load = function(data)
		{
			console.log(data);
			$scope.test = data.test;
			$scope.questions = data.questions;
			$scope.current = $scope.questions[0];
			$scope.CountAnswers();
			$scope.$apply();
		}

		$scope.GetStatus = function()
		{
			return $scope.toSave.lenght ? 'Guardar' : "Guardado";
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

		$scope.Mark = function(key)
		{
			var isForFirstTimeSelected = !$scope.HasSelected();
			
			if( isForFirstTimeSelected ) $scope.answered++;
			
			$scope.current.selected = $scope.current.options[key].id;
			$scope.toSave.push($scope.current);
			$scope.Save();
		}

		$scope.Save = function()
		{
			var url = $("#urlToSaveExaminationAnswers").val();

			$.post(url, {
				_csrf: csrfToken,
				examinationId: $scope.EXAMINATION_ID,
				answers: $scope.toSave
			}, function(data){
				console.log(data);
				if(data == $scope.SUCCESS){
					$scope.$apply(function(){
						$scope.toSave = [];
					});
				}
			});
		}

		$scope.IsSelected = function(key)
		{
			return $scope.current.selected == $scope.current.options[key].id;
		}

		$scope.HasSelected = function()
		{
			return !angular.isUndefined($scope.current.selected);
		}
	}
);