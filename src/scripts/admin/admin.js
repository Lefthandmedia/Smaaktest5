/**
 * Created by ralph on 9/13/14.
 */


(function() {
	var app = angular.module('adminApp', ['locationModule', 'editModule'])	;


	app.controller('adminController', ['$scope','$rootScope', function($scope, $rootScope) {
		var ac = {};
		$scope.states = {state:'list'};
		
		ac.init = function(){
			ac.showLocations();
			console.log("INIT");
		};

		ac.showLocations = function() {
			console.log('showLocations');
			$scope.states.state = 'list';
		};

		ac.addLocation = function() {
			console.log('addLocation');
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
		service.result = [];
		//----------------

		service.getLocations = function() {
			console.log('getLocations');
			var deferred = $q.defer();
			$http({
				      method: "get",
				      url: "/rest/admin/getLocations.php"
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
		service.editLocation = function(id) {
            console.log(id);
            console.log('getLocations');
            var deferred = $q.defer();
            $http({
                method: "get",
                url: "/rest/editLocations.php"
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
