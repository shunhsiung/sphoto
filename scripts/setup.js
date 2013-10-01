angular.module('myapp',['ui.bootstrap']);

function myaction($scope,$http) {
	$scope.data = [];
	$scope.readmed = false;

	$scope.save = function(data){

		data.op = 'save_option';

		$http.post('ms.php',$.param(data.toObject()),http_config).success(function(json,status){
			ms_success(json,status);
		}).error(function(){ms_error()});

	};

	$scope.show_readme = function() {
		$scope.readmed = true;
		console.log($scope.readmed);
	}
}

