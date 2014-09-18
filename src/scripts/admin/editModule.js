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

		ac.editLocation = function(id) {
			console.log('updateLocation');
			$scope.locid.id = id;
			//$scope.setactual(id);
			$scope.states.state = 'edit';
			$rootScope.$broadcast(adminFactory.const.editloc);
		};

		ac.setActive = function(id, $event) {
			var actief = ($event.target.checked) ? "1" : "0";
			var vo = {actief: actief, locid: id};
			adminFactory.setActive(vo).then(function(locaties) {
				console.log("ac.setActive");
				console.log(locaties);
				$scope.locations = locaties;

			}, function(data) {
				alert(data);
			});
		};

		return ac;
	}]);
	//-----------------------------------------
	app.controller('editController', ['$rootScope', '$scope', '$timeout' , '$upload', 'adminFactory', function($rootScope, $scope, $timeout, $upload, adminFactory) {
		var ec = {};


		ec.init = function() {
			ec.resetUploadQueue();
			ec.setActual();
		};

		$scope.$on(adminFactory.const.editloc, function() {
			console.log('on ' + adminFactory.const.editloc);
			ec.init();
		});

		ec.submitlocation = function() {
			console.log('submitlocation');
			if(!$scope.locid.id)
			{
				console.log('make new');
				ec.createLocation();
			} else
			{
				console.log('update');
				ec.editLocation();
			}
		};

		ec.createLocation = function() {
			var vo = {taak: 'new', locatienaam: $scope.locatienaam};
			adminFactory.createLocation(vo).then(function(data) {
				$scope.locid.id = data.id;

			}, function(data) {
				alert(data);
			});
		};

		ec.editLocation = function() {
			var vo = {taak: 'edit', locatienaam: $scope.actual.locatie, actief: $scope.actual.actief, locid: $scope.locid};
			adminFactory.editLocation(vo).then(function(data) {


			}, function(data) {
				alert(data);
			});
		};

		ec.setActive = function() {
			var vo = {actief: $scope.actual.actief, locid: $scope.locid};
			adminFactory.setActive(vo).then(function(data) {
				//console.log("ec.setActive");
				//console.log(data);

			}, function(data) {
				alert(data);
			});
		};


		ec.resetUploadQueue = function() {
			console.log('ec.resetView');
			$scope.fileReaderSupported = window.FileReader != null && (window.FileAPI == null || FileAPI.html5 != false);
			$scope.uploadRightAway = true;
			$scope.selectedFiles = {};
			$scope.dataUrls = {};
			$scope.upload = [];
			$scope.uploadResult = [];
		};

		ec.setActual = function() {
			if($scope.locid.id && $scope.locid.id > 0)
			{
				$scope.actual = adminFactory.setactual($scope.locid.id);
			} else
			{
				$scope.actual = null;
			}
		};

		//=========== UPLOAD METHODS ====================


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

		ec.onFileSelect = function($files, p) {
			var phototag = p;
			$scope.selectedFiles[phototag] = [];
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
			$scope.upload[phototag] = [];
			$scope.uploadResult[phototag] = [];
			$scope.selectedFiles[phototag] = $files;
			$scope.dataUrls[phototag] = [];

			for(var i = 0; i < $files.length; i++)
			{
				var $file = $files[i];

				if($scope.fileReaderSupported && $file.type.indexOf('image') > -1)
				{
					var fileReader = new FileReader();
					fileReader.readAsDataURL($files[i]);

					var loadFile = function(fileReader, index, phototag) {
						fileReader.onload = function(e) {
							$timeout(function() {
								$scope.dataUrls[phototag][index] = e.target.result;
							});
						}
					}(fileReader, i, phototag);
				}
				$scope.progress[i] = -1;
				if($scope.uploadRightAway)
				{
					$scope.startPhotoUpload(i, phototag);
				}
			}
		};


		$scope.startPhotoUpload = function(index, phototag) {

			$scope.progress[index] = 0;
			$scope.errorMsg = null;
			$scope.upload[phototag][index] = $upload.upload({
				                                                url: '/rest/admin/setPhoto.php',
				                                                method: 'POST',
				                                                headers: {'my-header': 'my-header-value'},
				                                                data: {
					                                                photoData: {taak: 'photo', locid: $scope.locid.id, phototag: phototag },
					                                                errorCode: $scope.generateErrorOnServer && $scope.serverErrorCode,
					                                                errorMessage: $scope.generateErrorOnServer && $scope.serverErrorMsg
				                                                },
				                                                file: $scope.selectedFiles[phototag][index],
				                                                fileFormDataName: 'myFile'
			                                                });
			$scope.upload[phototag][index].then(function(response) {
				console.log(response.data);
				$timeout(function() {
					$scope.uploadResult[phototag].push(response.data);
				});
			}, function(response) {
				if(response.status > 0) $scope.errorMsg = response.status + ': ' + response.data;
			}, function(evt) {
				// Math.min is to fix IE which reports 200% sometimes
				$scope.progress[index] = Math.min(100, parseInt(100.0 * evt.loaded / evt.total));
			});
			$scope.upload[phototag][index].xhr(function(xhr) {
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