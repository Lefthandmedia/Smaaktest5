/**
 * Created by ralph on 8/22/14.
 */
(function() {

	var app = angular.module('quizModule', []);
	//-------------- Quiz controller------------------
	app.controller('quizController', ['$rootScope', '$scope', '$http', 'dataFactory', function($rootScope, $scope, $http, dataFactory) {
		var qc = {};
		var _this = this;
		var df = dataFactory;
		var actualLocation = {};
		//	$scope.startup = true;
		$scope.actual = 0;
		//	$scope.actualPic = '/locations/Biogewas.jpg';
		//	$scope.voteVO = {};
		//	$scope.df = df;

		qc.locations = [];

		qc.vote = function(v) {
			df.vote({cijfer: v, location: '_'+ actualLocation.id});
		};

		$scope.$on(df.const.start, function() {
			_this.refreshData();
			_this.updateLocation();
		});

		$scope.$on(df.const.nextq, function(evt) {
			console.log(evt);
			console.log(df.const.nextq);
			$scope.actual++;

			if($scope.actual > qc.locations.length)
			{
				$rootScope.step = 4;
				$rootScope.$broadcast(df.const.result);
			} else
			{
				_this.updateLocation();
			}
		});

		//------- private -----------

		this.refreshData = function() {
			qc.locations = df.getQuiz();
			$scope.totallocations = qc.locations.length;
		};

		this.updateLocation = function() {
			actualLocation = qc.locations[$scope.actual];
			$scope.actualLocation = actualLocation;
		}

		return qc;
	}]);
	//------------------------------------------------
})();
