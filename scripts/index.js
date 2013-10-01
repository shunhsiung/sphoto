var myapp = angular.module('myapp',['ui.bootstrap']); 

var fb = {};

function myalbum($scope, $http) {

	$scope.fblogined = false;

	window.fbAsyncInit = function() {
		FB.init({
			appId: $scope.fai,
			cookie: true,
			status: true,
			oauth: true,
			fileUpload: true,
			xfbml: true
   	 	});

		FB.getLoginStatus(function(res) {
			if (res.authResponse) {
				$scope.fblogined = true;
			}
		});	
	}

	$scope.image_list = {};
	$scope.show_buttoned = false;

	$scope.show_button = function(){
		var t = false
		for ( x in $scope.image_list) {
			if ($scope.image_list[x]) {
				t = true;
				break;
			}
		}	

		$scope.show_buttoned = t;
	};

	$scope.fblogin = function() {
		FB.login(function(res){
		if (res.authResponse) {
			if (res.status == 'connected') {
				$scope.fblogined = true;
			} else {
				alert('授權特定權限失敗!!');
			}
		} else {
            alert('Facebook 登入失敗!!');
		}

	},{ scope: 'email,user_photos,user_videos,publish_stream,photo_upload' });

	}

	$scope.upload = function(image_file) {
		FB.getLoginStatus(function(response){
			if (response.authResponse) {
				if (response.status == 'connected' ) {

					var data = {
						op : 'upload_facebook',
						access_token : response.authResponse.accessToken,
						fid  : response.authResponse.userID,
						message : $scope.message,
						image : image_file
							}

//						data.image = image_file;	

/*
						console.log(image_file);
					for ( x in $scope.image_list) {

						data.image = x;
*/
						$scope.progressed = true;	
						$http.post('ms.php',$.param(data),http_config).success(function(json,status){
							if (json.success) {
								$scope.progressed = false;
							}	
						}).error(function(){$scope.progressed = false; ms_error()});
/*
						
					}
*/
				}
			}

		});
	}

	$scope.info = function(image) {
		var data = {
			op : 'get_image',
			basedir : $scope.image_base_dir,
			image : image
			}

		$http.post('ms.php',$.param(data),http_config).success(function(json,status){
			if (json.success) {
				$scope.info_list = json.show_info.split('::');
				$scope.show_image_file = $scope.image_base_dir + '/' + image;
			}
		}).error(function(){ms_error()});
	}

	$scope.change = function(up_dir,dir) {
		var data = {
			op : 'change_dir',
			up_dir : up_dir,
			basedir : dir
			};	

		$scope.info_list = [];
		$scope.show_image_file = "";
//		$scope.show_buttoned = false;
		$http.post('ms.php',$.param(data),http_config).success(function(json,status){
			if (json.success) {
				if (json.ndl != "") {
					$scope.ng_dir_list = json.ndl.split(',');
				} else {
					$scope.ng_dir_list =[];
				}

				$scope.up_dir = json.ibd;

				if (json.nfl != "") {
					$scope.ng_file_list = json.nfl.split(',');
				} else {
					$scope.ng_file_list = [];
				}

				$scope.up_show = json.up_show;
				$scope.image_base_dir = json.ibd;
			}
		}).error(function(){ms_error()});
	}	
}
