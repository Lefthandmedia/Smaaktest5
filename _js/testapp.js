/**
 * @author Lefthandmedia <ralph@lefthandmedia.com>
 */

    // record

(function () {
    var app = angular.module('smaaktest5', []);

    app.controller('FormController', function () {
        this.naw = {};

        this.submit = function (naw) {
            console.log(naw);
        }
    });


})();
