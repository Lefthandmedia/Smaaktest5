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
		var vote;
		var df = {const: {}};
		df.const.start = "START_QUIZ";
		df.const.nextq = "NEXT_QUESTION";
		df.const.result = "START_QUIZ";
		df.data = [];

//		df.getForm = function() {
//			console.log('df.getform');
//			return $http({method: 'get', url: '/rest/form.php'})
//				.success(function(data) {
//					         console.log(data.form);
//					         return  data.form;
//				         })
//				.error(function(data) {
//					       return 'error';
//					       // what to do on err
//				       })
//		};

		df.fetchQuiz = function(nawObj) {
			console.log('FETCh QUIZ');
			console.log(nawObj);
			$http.post('/rest/submit.php', nawObj).success(function(data) {
                console.log(data);
				df.setQuiz(data);

			});
		};

		//--- haal alle vragen op op basis van NAWid ---
		df.setQuiz = function(dat) {
			console.log(dat);

			df.usersession = dat.user_id;

			df.data = dat.locaties.entries;
			$rootScope.step = 3;
			$rootScope.$broadcast(df.const.start);

		};

		df.vote = function(vote) {
			vote.user_id = df.usersession;

			console.log(vote);

			$http.post('/rest/vote.php', vote).success(function(data) {
				console.log(data);
				console.log('test' + df.const.nextq);
				$rootScope.$broadcast(df.const.nextq);
			});
		}


		df.getQuiz = function() {
			return df.data;
		};

		//---
		return df;
	}]);
	//------------- end quizFactory ----------


})();
