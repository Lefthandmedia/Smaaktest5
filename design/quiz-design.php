<?php
/**
 * @author Lefthandmedia <ralph@lefthandmedia.com>
 */

include 'HEAD.php';

 ?>

<section id="quiz" ng-controller="quizController as quizCtrl" >
    <div class="container">
        <div class="row">
            <div class="col-md-8">

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
                    <div><img ng-src="/uploads/aankomst op texel duinen 1.jpg" alt=""/></div>

                </div>
            </div>
        </div>
    </div>
</section>

<?php
include 'footer.php';
?>