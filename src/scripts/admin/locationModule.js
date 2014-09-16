/**
 * Created by ralph on 9/13/14.
 */

(function() {
	var app = angular.module('locationModule', []);

	app.controller('locationController', ['$rootScope', '$scope', 'adminFactory', function($rootScope,$scope, adminFactory) {

		var ac = {};
		var _this = this;

		ac.getLocations = function() {
			$rootScope.state = 'test ing 123'

			adminFactory.getLocations().then(function(data) {
				$scope.locations = data.locaties;
				console.log(data.locaties);
			}, function(data) {
				alert(data);
			});
		};

		ac.editLocation = function(id) {
			adminFactory.editLocation(id).then(function(data) {
				$scope.locations = data.locaties;
				console.log(data.locaties);
			}, function(data) {
				alert(data);
			});
		};

		return ac;

	}]);

    app.controller('editController',['$rootScope', '$scope', 'adminFactory', function($rootScope,$scope, adminFactory) {


    }]);

    app.controller('tagController',['$rootScope', '$scope', 'adminFactory', function($rootScope,$scope, adminFactory) {


    }]);

    app.controller('statController',['$rootScope', '$scope', 'adminFactory', function($rootScope,$scope, adminFactory) {


    }]);

})();