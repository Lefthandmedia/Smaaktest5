/**
 * Created by ralph on 8/22/14.
 */
(function() {

	var app = angular.module('quizModule', []);
	//-------------- Quiz controller------------------
	app.controller('quizController', ['$rootScope', '$scope', '$http', 'dataFactory', function($rootScope, $scope, $http, dataFactory) {
		qc = {};
		dit = this;
		$scope.startup = true;
		$scope.actual = 0;
		$scope.actualPic = '/locations/Biogewas.jpg';
		$scope.voteVO = {};

		var df = dataFactory;
		var actualLocation = {};
		var actualindex;

		qc.locations = [];

		qc.vote = function(v) {
			//  send in the vote
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

		$scope.$on('START_QUIZ', function() {
			dit.refreshData();
			dit.updateLocation();
		});

		$scope.$on(df.nextq, function() {
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
