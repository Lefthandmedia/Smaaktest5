/**
 * Created by ralph on 8/22/14.
 */
(function () {

    var app = angular.module('quizModule', []);
    //-------------- Quiz controller------------------
    app.controller('quizController', ['$rootScope', '$scope', '$http', 'dataFactory', function ($rootScope, $scope, $http, dataFactory) {
        qc = {};
        dit = this;
        $scope.startup = true;
        var df = dataFactory;
        $scope.actual = 0;
        $scope.actualPic = '/locations/Biogewas.jpg';
        $scope.voteVO = {};

        qc.locations = [];

        qc.startQuiz = function () {
            $scope.startup = false;
            dit.refreshData();
            dit.updateLocation();
        };


        qc.vote = function (v) {

           //  send in the vote
            $scope.actual++;
            if ($scope.actual > qc.locations.length) {
                $rootScope.step = 3;
            } else {
                dit.updateLocation();
            }

        };

        //------- private -----------

        this.refreshData = function () {
            qc.locations = df.getQuiz();
        };

        this.updateLocation = function () {
            console.log("updateLocation");
            var actlocation = qc.locations[$scope.actual];
            console.log(actlocation);
            $scope.actualLocation = actlocation;
        }

        return qc;
    }]);
//------------------------------------------------
})();
