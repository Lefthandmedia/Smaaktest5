/**
 * Created by ralph on 8/22/14.
 */
(function() {

	var app = angular.module('quizModule', []);

	app.controller('quizController', ['$scope', '$http', 'dataFactory', function($scope, $http, dataFactory) {
		qc = {};
		dit = this;

		$scope.df = dataFactory;
		$scope.actual = 0;
		$scope.actualPic = '/pictures/Biogewas.jpg';

		$scope.pictures = [
			{'url': '/hier.jpg', name: 'plaatje test'},
			{'url': '/hier1.jpg', name: 'plaatje1 test'},
			{'url': '/hier2.jpg', name: 'plaatje2 test'}
		];

		this.updatePic = function() {
			console.log(dit.actual);
			console.log(this.actual);
			console.log($scope.actual);
			var url = $scope.pictures[$scope.actual]['url'];
			console.log(url);
			$scope.actualPic = url;

		}

		qc.vote = function(v) {
			console.log(dit);
			$scope.actual++;
			dit.updatePic();
		};

		qc.testquizController = function(v) {
			$scope.df.facttest();
			console.log('vote = ' + v);
		};

		return qc;


	}]);
})();
