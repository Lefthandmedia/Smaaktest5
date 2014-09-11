/**
 * Created by ralph on 8/22/14.
 */
(function() {

	var app = angular.module('quizModule', []);
	//-------------- Quiz controller------------------
	app.controller('quizController', ['$rootScope', '$scope', '$http', 'dataFactory', function($rootScope, $scope, $http, dataFactory) {
		qc = {};
		dit = this;
		df = dataFactory;
		$scope.startup = true;
		$scope.actual = 0;
		$scope.actualPic = '/locations/Biogewas.jpg';
		$scope.voteVO = {};
		$scope.df = df;

		qc.locations = [];

		qc.vote = function(v) {
			df.vote(v);
			$scope.actual++;
			if($scope.actual > qc.locations.length)
			{
				$rootScope.step = 4;
				$rootScope.$broadcast(d.startvar);
			} else
			{
				dit.updateLocation();
			}

		};

		$scope.$on('START_QUIZ', function(evt) {
			var dff = df;
			console.log(evt);
			dit.refreshData();
			dit.updateLocation();
		});

		$scope.$on(undefined, function(evt) {
			console.log(evt);
			console.log('NEXT Q');
		});

		//------- private -----------

		this.refreshData = function() {
			qc.locations = df.getQuiz();
			$scope.totallocations = qc.locations.length;
		};

		this.updateLocation = function() {
			var actualLocation = qc.locations[$scope.actual];
			$scope.actualLocation = actualLocation;
		}

		return qc;
	}]);
	//------------------------------------------------
})();
