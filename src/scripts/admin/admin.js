/**
 * Created by ralph on 9/13/14.
 */


(function() {
	var app = angular.module('adminApp', ['editModule', 'statsModule', 'angularFileUpload']);


	app.controller('adminController', ['$scope', 'adminFactory', function($scope, adminFactory) {
		var ac = {};
		$scope.states = {state: 'list'};
		$scope.locid = {id: null};
		$scope.locations = {};
		$scope.actualLocation = {};

		$scope.setactual = function(id) {
			console.log('setactual');
			console.log(adminFactory.locations);
			for(var i = 0; i < adminFactory.locations.length; i++)
			{
				if(adminFactory.locations[i].id === id){
					console.log('HIT' + id);
					return adminFactory.locations[i];
				}
			}
			return false
		};

		ac.init = function() {
			ac.showLocations();
			console.log("INIT");
		};

		ac.showLocations = function() {
			console.log('showLocations');
			$scope.states.state = 'list';
		};

		ac.addLocation = function() {
			console.log('addLocation');
			$scope.locid = {id: null};
			$scope.states.state = 'edit';
		};
		ac.addTags = function() {
			console.log('addTags');
			$scope.states.state = 'tags';
		};
		ac.showStats = function() {
			console.log('showStats');
			$scope.states.state = 'stats';
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
		service.locations = [];
		//----------------

		service.getLocations = function() {
			console.log('getLocations');
			var deferred = $q.defer();
			$http({
				      method: "get",
				      url: "/rest/admin/getLocations.php"
			      })
				.success(function(data) {
					         console.log(data);
					         service.locations = data.locaties;
					         deferred.resolve(data);
				         })
				.error(function(data) {
					       //console.log(data);
					       deferred.reject('error');
				       })

			return deferred.promise;
		}

		//----------------
		service.createLocation = function(vo) {
			console.log('createLocation');
			var deferred = $q.defer();
			$http({
				      method: "post",
				      url: "/rest/admin/setLocation.php",
				      data: vo
			      })
				.success(function(data) {
					         console.log(data);
					         deferred.resolve(data);
				         })
				.error(function(data) {
					       //console.log(data);
					       deferred.reject('error');
				       })

			return deferred.promise;
		}

		//----------------
		service.editLocation = function(id) {
			console.log(id);
			console.log('getLocations');
			var vo = {id: id};
			var deferred = $q.defer();
			$http({
				      method: "get",
				      url: "/rest/editLocations.php",
				      data: vo
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


		return service;

	}]);


})();
