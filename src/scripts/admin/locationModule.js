/**
 * Created by ralph on 9/13/14.
 */

(function () {
    var app = angular.module('locationModule',[]);

    app.controller('locationController', ['$scope','adminFactory', function ($scope,adminFactory) {

        var ac = {};
        var _this = this;
        var ff = adminFactory;
        $scope.locations = [];

        ac.getLocations = function(){
            $scope.locations = af.getLocations;
        };


        return ac;

    }]);
})();