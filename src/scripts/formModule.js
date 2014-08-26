/**
 * @author Lefthandmedia <ralph@lefthandmedia.com>
 */

(function () {

    var app = angular.module('formModule',[]);

    //---------------- FORMCONTROLLER ---------------
    app.controller('formController', [ '$scope', '$http', 'dataFactory', function ($scope, $http, dataFactory) {
        this.naw = {};
        $scope.df = dataFactory;
        dit = this;


        //--- make age dropdown ---
        $scope.ages = [];
        for (var i = 0; i < 99; i++) {
            $scope.ages.push({'name': i, 'value': i})
        }

        //---------- verstuur NAW form---------------
        this.submit = function () {
            console.log(dit.naw);

            $http({method:'get',url:'/submit.php'}).success(function(data){
                $scope.naw = data;
                $scope.df.setQuiz(data);
                // console.log(data);
            });
        };
    }]);
    //---- end FormController


})();