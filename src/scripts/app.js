/**
 * @author Lefthandmedia <ralph@lefthandmedia.com>
 */

	// record

(function() {
	var app = angular.module('smaaktest5', ['quizModule', 'formModule','resultModule'])
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
		df.const.result = "RESULT_QUIZ";
		df.data = [];
        df.result = [];

		df.fetchQuiz = function(nawObj) {
			$http.post('/rest/submit.php', nawObj).success(function(data) {
                console.log(data);
				df.setQuiz(data);

			});
		};

		//--- haal alle vragen op op basis van NAWid ---
		df.setQuiz = function(dat) {
			df.usersession = dat.user_id;
			
			console.log(dat);
			df.data = dat.locaties.entries;
			$rootScope.step = 3;
			$rootScope.$broadcast(df.const.start);

		};

		df.vote = function(vote) {
			vote.user_id = df.usersession;

			console.log(vote);

			$http.post('/rest/vote.php', vote).success(function(data) {
				$rootScope.$broadcast(df.const.nextq);
			});
		}
        df.getResult = function(){
            $rootScope.step = 4;

            $http.post('/rest/result.php', {id:df.usersession}).success(function(data) {
                console.log(data);
                console.log('test' + df.const.result);
                df.result = data;
                $rootScope.$broadcast(df.const.result,data);
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
