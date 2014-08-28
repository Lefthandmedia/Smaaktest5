/**
 * @author Lefthandmedia <ralph@lefthandmedia.com>
 */

(function () {

    var app = angular.module('formModule', []);

//---------------- FORMCONTROLLER ---------------
    app.controller('formController', [ '$rootScope', '$scope', '$http', 'dataFactory', function ($rootScope, $scope, $http, dataFactory) {

	    this.naw = {};
        $scope.df = dataFactory;
        $rootScope.step = 1;
	    $scope.voorkeur = 'leeg';

        dit = this;


        //--- make age dropdown ---
        $scope.ages = [];
        for (var i = 0; i < 99; i++) {
            $scope.ages.push({'name': i, 'value': i})
        }

	    this.getForm = function(){
		    $http({method:'get',url:'/rest/form.php'})
			    .success(function(data){
			           $scope.formData = data;                 //what to do with form JSON
		                            })
			    .error(function(data){
			                           // what to do on err
		                           })
	    };

	    this.getForm();

        //---------- verstuur NAW form---------------
        this.submit = function () {
            console.log(dit.naw);

            $http({method: 'get', url: '/submit.php'}).success(function (data) {
                $scope.naw = data;
                $scope.df.setQuiz(data);
                $rootScope.step = 2;
            });
        };
    }]);
    //---- end FormController


})();