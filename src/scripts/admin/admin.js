/**
 * Created by ralph on 9/13/14.
 */


(function () {
    var app = angular.module('adminApp', ['locationModule']);

    app.controller('adminController', ['$scope', function ($scope) {
        var ac = {};
        // var af = adminFactory;

        ac.showLocations = function () {
            console.log('showlocations');
        };

        ac.got = function () {
        };

        return ac;

    }]);

    app.factory('adminFactory', ['$rootScope', '$http' , function ($rootScope, $http) {
        var af = {const: {}};
        af.const.getloc = "GET_LOCATIONS";
        af.const.editloc = "EDIT_LOCATION";
        af.const.result = "SEE_RESULTS";
        af.data = [];
        af.result = [];
//----------------
        return {getLocations:getLocations};
//----------------
        function getLocations() {
            var request = $http({
                method: "get",
                url: "rest/getLocations.php"
            });

            return( request.then( handleSuccess, handleError ) );
        };
//----------------
        function editLocation() {
            var request = $http({
                method: "get",
                url: "rest/editLocations.php"
            });

            return( request.then( handleSuccess, handleError ) );
        };



    }]);


})();
