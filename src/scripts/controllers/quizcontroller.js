/**
 * @author Lefthandmedia <ralph@lefthandmedia.com>
 */

app.controller("QuizController", function($scope) {

	var q = {name: 'test', url: "testurlxassqwzzassxxaaazzzz"};

	$scope.test = function($t) {
		console.log($t);
	};

	$scope.quiz = q;


});