/**
 * Created by ralph on 8/22/14.
 */
(function () {

    var app = angular.module('quizModule', []);
    //-------------- Quiz controller------------------
    app.controller('quizController', ['$rootScope', '$scope', '$http', 'dataFactory', function ($rootScope, $scope, $http, dataFactory) {
        qc = {};
        this.df = dataFactory;
        dit = this;
        $scope.startup = true;
        $scope.df = dataFactory;
        $scope.actual = -1;
        $scope.actualPic = '/pictures/Biogewas.jpg';

        qc.pictures = [
            {url: '/hier.jpg', name: 'plaatje test'},
            {url: '/hier1.jpg', name: 'plaatje1 test'},
            {url: '/hier2.jpg', name: 'plaatje2 test'}
        ];

        qc.startQuiz = function () {
            $scope.startup = false;
            console.log('startup');
            console.log($scope.pictures);
            refreshData();
            console.log($scope.pictures);
        };


        qc.vote = function (v) {
            console.log(dit);
            $scope.actual++;
            if($scope.actual++ > qc.pictures.length){
                $rootScope.step = 3;
            }else{
                dit.updatePic();
            }

        };

        //------- private -----------

        function refreshData() {
            qc.pictures = $scope.df.getQuiz();
        };

        this.updatePic = function () {
            var url = qc.pictures[$scope.actual]['url'];
            console.log(url);
            $scope.actualPic = url;
        }

        return qc;
    }]);
//------------------------------------------------
})();
