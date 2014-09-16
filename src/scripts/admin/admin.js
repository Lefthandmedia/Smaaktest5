/**
 * Created by ralph on 9/13/14.
 */


(function() {
	var app = angular.module('adminApp', ['locationModule', 'editModule'])	;


	app.controller('adminController', ['$scope','$rootScope', function($scope, $rootScope) {
		var ac = {};
		$scope.state = '';
		
		ac.init = function(){
			ac.showLocations();
			console.log("INIT");
		};

		ac.showLocations = function() {
			console.log('showLocations');
			$scope.state = 'list';
		};

		ac.addLocation = function() {
			console.log('addLocation');
			$scope.state = 'new';
		};
		ac.addTags = function() {
			console.log('addTags');
			$scope.state = 'tags';
		};
		ac.showStats = function() {
			console.log('showStats');
			$scope.state = 'stats';
		};


		return ac;

	}]);


	app.factory('adminFactory', ['$rootScope', '$http' , '$q' , function($rootScope, $http, $q) {

		var service = {const: {}};
		service.const.getloc = "GET_LOCATIONS";
		service.const.showlocations = "SHOW_LOCATIONS";
		service.const.editloc = "EDIT_LOCATION";
		service.const.result = "SEE_RESULTS";
		service.data = [];
		service.result = [];
		//----------------

		service.getLocations = function() {
			console.log('getLocations');
			var deferred = $q.defer();
			$http({
				      method: "get",
				      url: "/rest/getLocations.php"
			      })
				.success(function(data) {
					         // console.log(data);
					         deferred.resolve(data);
				         })
				.error(function(data) {
					       //console.log(data);
					       deferred.reject('error');
				       })

			return deferred.promise;
		}
		//----------------
		service.editLocation = function() {
			var request = $http({
				                    method: "get",
				                    url: "/rest/editLocations.php"
			                    });

			return( request.then(handleSuccess, handleError) );
		}

		return service;

	}]);


})();
