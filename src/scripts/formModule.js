/**
 * @author Lefthandmedia <ralph@lefthandmedia.com>
 */

(function () {

    var app = angular.module('formModule', []);

    //---------------- FORMCONTROLLER ---------------
    app.controller('formController', [ '$rootScope', '$scope', '$http', 'dataFactory', function ($rootScope, $scope, $http, dataFactory) {
        var dit = this;
        $rootScope.step = 1;

        $scope.naw = {};
        $scope.df = dataFactory;
        $scope.formData = [];

        //----------------------
        this.getForm = function (dit) {
            console.log('getForm');
            $http({method: 'get', url: '/rest/form.php'})
                .success(function (data) {
                    $scope.formData = data.form;
                })
                .error(function (data) {
                    // what to do on err
                })
        };

        //---------- verstuur NAW form---------------
        this.submit = function () {
            console.log($scope.naw);
            $http.post('/rest/submit.php', $scope.naw).success(function (data) {
                // $scope.naw = data;
                $scope.df.setQuiz(data);
                $rootScope.step = 2;
            });
        };
    }]);
    //---- end FormController
})();