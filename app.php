<?php
require_once('rest/db.class.php');
$db = new db_class;

if(!$db->connect()){
    $db->print_last_error(false);
}

?>
<!DOCTYPE html>
<html ng-app='smaaktest5'>
<head>
    <title>STAGING SMAAKTEST</title>
    <link rel="stylesheet" href="_css/bootstrap.min.css"/>
    <link rel="stylesheet" href="_css/main.min.css"/>
    <script src="_js/libs/jquery.min.js" type="text/javascript"></script>
    <script src="_js/libs/angular.min.js" type="text/javascript"></script>
    <script src="_js/libs/angular-route.min.js" type="text/javascript"></script>
</head>

<body>


<section id="nawform" ng-controller="formController as nawformCrtl" ng-show="step === 1">
    <div class="container">
        <div class="row">
            <div class="col-md-8 well">

                <form name="nawform" ng-submit="nawformCrtl.submit()" novalidate>



                    <div ng-repeat="element in formData">

                       test {{element[0][0].label}}
                    </div>
                    ------------------
                    <div>

                        <div class="form-group" ng-repeat="row in formData">
                            <label for="vraag1">kies een voorkeur</label>

                            <select ng-model="nawformCrtl.naw.voorkeur" ng-options="item.value as item.label for item in formData.voorkeur">
                                <option value="">-- kies een voorkeur --</option>
                            </select>

                        </div>

                    </div>

                    ------------------
                    <div class="form-group">
                        <label for="vraag1">een vraag</label>

                        <select ng-model="age" ng-options="age.name for age in ages">
                            <option value="">-- kies een leeftijd --</option>
                        </select>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input ng-model="nawformCrtl.naw.box" type="checkbox"> Check me out
                        </label>
                    </div>

                    <button type="submit" class="btn btn-default">Submit</button>

                </form>

                                {{nawformCrtl.naw.naam}},
                                {{nawformCrtl.naw.email}},
                                {{nawformCrtl.naw.vraag}},
                                {{nawformCrtl.naw.voorkeur}},
                                {{state}}

                <br/>
            </div>
        </div>
    </div>
</section>


<section id="quiz" ng-controller="quizController as quizCtrl" ng-show="step === 2">
    <div class="container">
        <div class="row">
            <div class="col-md-8">

                <div ng-show="startup">
                    <h1>hier een kleine introductie etc.</h1>
                    <button ng-click="quizCtrl.startQuiz()" class="btn btn-primary"> START</button>
                </div>

                <div ng-show="!startup">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default" ng-click="quizCtrl.vote(1)">1</button>
                        <button type="button" class="btn btn-default" ng-click="quizCtrl.vote(2)">2</button>
                        <button type="button" class="btn btn-default" ng-click="quizCtrl.vote(3)">3</button>
                        <button type="button" class="btn btn-default" ng-click="quizCtrl.vote(4)">4</button>
                        <button type="button" class="btn btn-default" ng-click="quizCtrl.vote(5)">5</button>
                        <button type="button" class="btn btn-default" ng-click="quizCtrl.vote(6)">6</button>
                        <button type="button" class="btn btn-default" ng-click="quizCtrl.vote(7)">7</button>
                        <button type="button" class="btn btn-default" ng-click="quizCtrl.vote(8)">8</button>
                        <button type="button" class="btn btn-default" ng-click="quizCtrl.vote(9)">9</button>
                        <button type="button" class="btn btn-default" ng-click="quizCtrl.vote(10)">10</button>
                    </div>
                    <div><img ng-src="{{actualPic}}" alt=""/></div>

                </div>
            </div>
        </div>
    </div>
</section>

<section ng-show="step === 3">
    <div>
        eind resultaat

    </div>

</section>


<script src="src/scripts/app.js" type="text/javascript"></script>
<script src="src/scripts/quizModule.js" type="text/javascript"></script>
<script src="src/scripts/formModule.js" type="text/javascript"></script>


</body>
</html>