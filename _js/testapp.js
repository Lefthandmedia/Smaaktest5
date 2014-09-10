/**
 * @author Lefthandmedia <ralph@lefthandmedia.com>
 */

	// record

(function() {
	var app = angular.module('smaaktest5', ['quizModule', 'formModule'])
		.value('step', 1);


	//--------------- config ---------------
	//app.config(function($routeProvider){

	// $routeProvider.when('/',{controller:'formController',templateUrl:'templates/form.html'})
	// .when('/smaaktest',{controller:'quizController',templateUrl:'templates/quiz.html'})
	// .otherwise({redirectTo:'/'});

	//NB bij routing moet er ook een directive ng-view zijn ; <div ng-view=''></div>
	//});


	//-------- quizFactory --------
	app.factory('dataFactory', ['$rootScope', '$http' , function($rootScope, $http) {
		var df = {};

		df.startvar = "START_QUIZ";
		df.nextq = "NEXT_QUESTION";
		df.startvar = "START_QUIZ";
		df.data = [];

		//--- haal alle vragen op op basis van NAWid ---
		df.setQuiz = function(dat) {
			df.usersession = dat.user_id;
			df.data = dat.locaties.entries;

		};

		df.vote = function(cijfer) {
			$vote = {'cijfer':cijfer, 'user_id':df.usersession}
			$http.post('/rest/vote.php', $vote).success(function(data) {
							$rootScope.$broadcast(df.nextq);
						});
			console.log('factory vote');
			console.log(cijfer);
		}


		df.getQuiz = function() {
			return df.data;
		};

		//---
		return df;
	}]);
	//------------- end quizFactory ----------


})();
