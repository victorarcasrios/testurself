angular.module('QuestionsForm', [])
	.controller('QuestionsController', function($scope, $http)
	{
		var csrfToken = $('meta[name="csrf-token"]').attr("content");

		$scope.SUCCESS = 1;
		$scope.ERROR = 0;
		$scope.UNTOUCHED = -1;

		$scope.created = $scope.UNTOUCHED;

		$scope.question = {id: null, text: null};
		$scope.options = [
		];

		$scope.Load = function(id)
		{
			var url = $("#urlToGetQuestion").val();
			var urlWithParams = url+"&id="+id;

			$.get(urlWithParams, function(data){
				if(data.status == $scope.SUCCESS)
					$scope.Fill(data.question);
			});
		}

		$scope.Fill = function(question)
		{
			console.log(question);
			$scope.question.id = question.id;
			$scope.question.text = question.text;
			$scope.options = question.options;
			$scope.$apply();
		}

		$scope.Edit = function(id)
		{
			console.log($scope.question, $scope.options);
			var url = $("#urlToEditQuestion").val();

			if( $scope.CanCreate() ){
				$.post(url, {
					_csrf: csrfToken,
					question: {
						id: id,
						text: $scope.question.text,
						options: $scope.options
					}
				}, function(data){
					console.log(data);
					$scope.created = data;
				});
			}
		}

		$scope.Create = function()
		{
			var url = $("[name='urlToCreateQuestions']").val();

			if( $scope.CanCreate() ){
				$.post(url, {
					_csrf: csrfToken,
					question: {
						text: $scope.question.text,
						options: $scope.options
					}
				}, function(data){
					$scope.created = data;
					if(data == $scope.SUCCESS)
						$scope.AfterCreation();
				});
			}
		}		

		$scope.AfterCreation = function()
		{
			$scope.question.text = null;
			$scope.options = [];
			$("#questionText").focus();
		}

		$scope.AddOption = function()
		{
			if ($scope.CanAdd()){
				$scope.options.push({text: $scope.newOption.text, correct: false});
				$scope.newOption.text = null;
				$("#optionText").focus();
			}
		}

		$scope.RemoveOption = function(key)
		{
			$scope.options.splice(key, 1);
		}

		/**
		 * Boolean methods
		 */

		$scope.MarkAsCorrect = function(key){
			angular.forEach($scope.options, function(option, key){
				option.correct = false;
			});
			$scope.options[key].correct = true;
		}

		$scope.JustNeedsCorrectOption = function(){
			var hasNoCorrectOneYet = ! $scope.HasCorrect();

			return $scope.HasAtLeastTwoOptions() && hasNoCorrectOneYet;
		}

		$scope.HasCorrect = function(){
			var has = false;
			angular.forEach($scope.options, function(option, key){
				if( option.correct )
					has = true;
			});
			return has;
		}

		$scope.HasAtLeastTwoOptions = function(){ return $scope.options.length >= 2; }

		$scope.HasOnlyOneOption = function(){ return $scope.options.length === 1; }

		$scope.HasOptions = function(){ return $scope.options.length; }

		$scope.LimitReached = function(){ return $scope.options.length >= 4; }

		$scope.CanAdd = function(){ return !$scope.LimitReached() && $scope.IsValidOption(); }

		$scope.IsValidOption = function(){ 
			var notTooLongOption = !$scope.TooLongOption();
			return $scope.IsNewOptionDefined() && notTooLongOption && $scope.IsUniqueOption(); 
		}

		$scope.TooLongOption = function(){
			var charsCount = $scope.newOption.text.length;
			var isTooLong = charsCount > 255;

			if(isTooLong) alert('La opción no puede exceder los 255 carácteres ('+charsCount+' actualmente)');
			return isTooLong;
		}

		$scope.IsUniqueOption = function()
		{
			var unique = true;
			angular.forEach($scope.options, function(option){
				if(option.text === $scope.newOption.text)
					unique = false;
			});
			return unique;
		}

		$scope.IsNewOptionDefined = function(){ return typeof $scope.newOption !== "undefined"; }

		$scope.HasProperText = function()
		{
			if(! $scope.HasText ) return false;
			var charsCount = $scope.question.text.length;
			var isTooLong = charsCount > 255;

			return isTooLong;
		}

		$scope.HasText = function()
		{ 
			return typeof $scope.question !== "undefined" && typeof $scope.question.text !== "undefined" 
				&& $scope.question.text !== null && $scope.question.text.length; 
		}

		$scope.CanCreate = function()
		{ 
			return $scope.HasProperText() && $scope.HasAtLeastTwoOptions() && $scope.HasCorrect(); 
		}



		$scope.CanNotCreateIt = function(){ return ! $scope.CanCreate() };
	}
);