/**
 * @author Lefthandmedia <ralph@lefthandmedia.com>
 */

(function() {

	var app = angular.module('formModule', []);

	//---------------- FORMCONTROLLER ---------------
	app.controller('formController', [ '$rootScope', '$scope', '$http', 'dataFactory', function($rootScope, $scope, $http, dataFactory) {
		var _this = this;
		var df = dataFactory;
		$rootScope.step = 1;
		$scope.formData = [];
		$scope.naw = {};

		this.getForm = function() {
			console.log('getform');
			$scope.formData = df.getForm();
			console.log('last');
			console.log($scope.formData);
		};

		//----------------------
//		this.getForm = function(dit) {
//			console.log('getForm');
//			$http({method: 'get', url: '/rest/form.php'})
//				.success(function(data) {
//					         $scope.formData = data.form;
//				         })
//				.error(function(data) {
//					       // what to do on err
//				       })
//		};

		//---------- verstuur NAW form---------------
		this.submit = function() {
			df.fetchQuiz($scope.naw);
		};
	}]);
	//---- end FormController
})();
