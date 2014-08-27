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
        dit = this;


        //--- make age dropdown ---
        $scope.ages = [];
        for (var i = 0; i < 99; i++) {
            $scope.ages.push({'name': i, 'value': i})
        }

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