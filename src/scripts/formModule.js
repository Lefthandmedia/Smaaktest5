/**
 * @author Lefthandmedia <ralph@lefthandmedia.com>
 */

(function() {

	var app = angular.module('formModule', []);

	//---------------- FORMCONTROLLER ---------------
	app.controller('formController', [ '$rootScope', '$scope', '$http', 'dataFactory', function($rootScope, $scope, $http, dataFactory) {

		this.naw = {};

		$scope.df = dataFactory;
		$rootScope.step = 1;
		$scope.formData = [];

		var dit = this;


		//--- make age dropdown ---
		$scope.ages = [];
		for(var i = 0; i < 99; i++)
		{
			$scope.ages.push({'name': i, 'value': i})
		}
		//----------------------
		var getForm = function(dit) {

			function toObject(arr) {
				var rv = {};
				for(var i = 0; i < arr.length; ++i)
					rv[i] = arr[i];
				return rv;
			}

			$http({method: 'get', url: '/rest/form.php'})
				.success(function(data) {
					         var formData = [];
					         var form = data.form;

					         for(var key in form)
					         {
						         formData[form[key].label] = angular.fromJson(form[key].value);
					         }
					         console.log(formData);
					         $scope.formData = formData;


				         })
				.error(function(data) {
					       // what to do on err
				       })
		};

		getForm();

		//---------- verstuur NAW form---------------
		this.submit = function() {
			console.log(dit.naw);

			$http({method: 'get', url: '/submit.php'}).success(function(data) {
				$scope.naw = data;
				$scope.df.setQuiz(data);
				$rootScope.step = 2;
			});
		};
	}]);
	//---- end FormController

	this.service = function(data) {
		console.log('Test root');
	};


})();