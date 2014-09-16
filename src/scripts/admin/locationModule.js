/**
 * Created by ralph on 9/13/14.
 */

(function() {
	var app = angular.module('locationModule', []);

	app.controller('locationController', ['$rootScope', '$scope', 'adminFactory', function($rootScope,$scope, adminFactory) {

		var ac = {};
		var _this = this;
		$scope.locations = {};
		$scope.state = 'poop';

		$scope.$on(adminFactory.const.showlocations,function(){
			// $rootScope.state = 'list';


		});

		ac.getLocations = function() {
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
})();