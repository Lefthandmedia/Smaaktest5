/**
 * Created by ralph on 9/12/14.
 */

(function () {

    var bpp = angular.module('resultModule', []);

    bpp.controller('resultController', ['$scope','dataFactory', function ( $scope, dataFactory) {

        var rs = {};
        var _this = this;
        var df = dataFactory;
        var top3 = [];
        var uwtop3 = [];

        df.test = function(){
            console.log('result test');
        };

        $scope.$on(df.const.result, function (evt, data) {
            //var res = data;

            $scope.top3 = data.top3;
            $scope.uwtop3 = data.uwtop3;
            _this.top3 = data.uwtop3;
            console.log(data.uwtop3);
        });

       return rs;

    }]);

})();