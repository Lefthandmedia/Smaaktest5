/**
 * Created by ralph on 9/13/14.
 */

(function() {
	var app = angular.module('editModule', []);
	//-----------------------------------------
	app.controller('locationController', ['$rootScope', '$scope', 'adminFactory', function($rootScope, $scope, adminFactory) {
		var ac = {};
		var _this = this;

		ac.getLocations = function() {
			adminFactory.getLocations().then(function(data) {
				$scope.locations = data.locaties;
				console.log(data.locaties);
			}, function(data) {
				alert(data);
			});
		};

		ac.updateLocation = function(id) {
			console.log('updateLocation');
			$scope.locid.id = id;
			$scope.setactual(id);
			$scope.states.state = 'edit';

			//			var vo = {taak: 'new', locatienaam: $scope.locatienaam};
			//			adminFactory.createLocation(vo).then(function(data) {
			//				console.log('ec.createLocation');
			//				console.log(data);
			//				$scope.locid = data.id;
			//
			//			}, function(data) {
			//				alert(data);
			//			});
		};

		return ac;
	}]);
	//-----------------------------------------
	app.controller('editController', ['$rootScope', '$scope', '$timeout' ,'$upload',  'adminFactory', function($rootScope, $scope, $timeout, $upload, adminFactory) {
		var ec = {};


		ec.submitlocation = function() {
			console.log('submitlocation');
			if(!$scope.locid.id)
			{
				console.log('make new');
				ec.createLocation();
			} else
			{
				console.log('update');
				ec.updateLocation();
			}
		};

		ec.createLocation = function() {
			var vo = {taak: 'new', locatienaam: $scope.locatienaam};
			adminFactory.createLocation(vo).then(function(data) {
				console.log('ec.createLocation');
				console.log(data);
				$scope.locid.id = data.id;

			}, function(data) {
				alert(data);
			});
		};

		ec.updateLocation = function() {
			var vo = {taak: 'new', locatienaam: $scope.locatienaam};
			adminFactory.createLocation(vo).then(function(data) {
				console.log('ec.createLocation');
				console.log(data);
				$scope.locid = data.id;

			}, function(data) {
				alert(data);
			});
		};

		//=========== UPLOAD METHODS ====================

		$scope.fileReaderSupported = window.FileReader != null && (window.FileAPI == null || FileAPI.html5 != false);
		$scope.uploadRightAway = false;

		$scope.changeAngularVersion = function() {
			window.location.hash = $scope.angularVersion;
			window.location.reload(true);
		};
		$scope.hasUploader = function(index) {
			return $scope.upload[index] != null;
		};
		$scope.abort = function(index) {
			$scope.upload[index].abort();
			$scope.upload[index] = null;
		};

		$scope.onFileSelect = function($files, phototag) {

			console.log(phototag);

			$scope.selectedFiles = [];
			$scope.progress = [];
			// stop alle ladres
			if($scope.upload && $scope.upload.length > 0)
			{
				for(var i = 0; i < $scope.upload.length; i++)
				{
					if($scope.upload[i] != null)
					{
						$scope.upload[i].abort();
					}
				}
			}
			$scope.upload = [];
			$scope.uploadResult = [];
			$scope.selectedFiles = $files;
			$scope.dataUrls = [];

			for(var i = 0; i < $files.length; i++)
			{
				var $file = $files[i];
				console.log($file);
				if($scope.fileReaderSupported && $file.type.indexOf('image') > -1)
				{
					var fileReader = new FileReader();
					fileReader.readAsDataURL($files[i]);

					var loadFile = function(fileReader, index) {
						fileReader.onload = function(e) {
							$timeout(function() {
								$scope.dataUrls[index] = e.target.result;
							});
						}
					}(fileReader, i);
				}
				$scope.progress[i] = -1;
			}
		};


		$scope.start = function(index) {
			$scope.progress[index] = 0;
			$scope.errorMsg = null;
			$scope.upload[index] = $upload.upload({
				                                      url: '/rest/admin/setLocation.php',
				                                      method: 'PUT',
				                                      headers: {'my-header': 'my-header-value'},
				                                      data: {
					                                      myModel: {taak: 'update', locid: $scope.locid, phototag: },
					                                      errorCode: $scope.generateErrorOnServer && $scope.serverErrorCode,
					                                      errorMessage: $scope.generateErrorOnServer && $scope.serverErrorMsg
				                                      },
				                                      file: $scope.selectedFiles[index],
				                                      fileFormDataName: 'myFile'
			                                      });
			$scope.upload[index].then(function(response) {
				$timeout(function() {
					$scope.uploadResult.push(response.data);
				});
			}, function(response) {
				if(response.status > 0) $scope.errorMsg = response.status + ': ' + response.data;
			}, function(evt) {
				// Math.min is to fix IE which reports 200% sometimes
				$scope.progress[index] = Math.min(100, parseInt(100.0 * evt.loaded / evt.total));
			});
			$scope.upload[index].xhr(function(xhr) {
				//				xhr.upload.addEventListener('abort', function() {console.log('abort complete')}, false);
			});

		};
		//=======================================================================

		return ec;
	}]);
	//-----------------------------------------
	app.controller('tagController', ['$rootScope', '$scope', 'adminFactory', function($rootScope, $scope, adminFactory) {
		var tc = {};


		return tc;
	}]);


})();