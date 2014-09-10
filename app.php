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

    <link rel="stylesheet" href="_css/app.min.css"/>
</head>

<body>
<div class="container" class="border">
    <div id="header">
        <div class="row">
            <div class="col-md-8">
                <div style="float:left;width:500px" class="clearfix">
                    <a href="/"><img src="/images/header2.gif" alt="Smaaktest Texel" width="700" height="65" border="0"></a>
                </div>
            </div>
        </div>
    </div>


    <section id="intro" ng-show="step === 1">
        <div class="container">
            <div class="row ">
                <div class="col-md-8 col-md-offset-2 col-sm-offset-0">


                    <div class="btn-group " style="float:right">
                        <a href="meerinfo.htm" class="rightLink btn">achtergrondinformatie</a><a href="colofon.htm" class="rightLink btn">colofon</a>
                    </div>
                    <p>&nbsp;</p>

                    <p>&nbsp;</p>

                    <p>
                        <strong>Is dit Typisch Texels? Of zou dit zomaar Typisch Texels kunnen worden? Past zoiets op Texel? Is dit mooi genoeg voor Texel? </strong>
                    </p>

                    <p><strong>Geef uw rapportcijfer van 1 tot 10!</strong></p>

                    <p>In deze ‘Smaaktest Texel’ kunt u uw oordeel geven over zaken die nu op Texel aanwezig (Texel Nu) en over inspiratiebeelden voor de toekomst van Texel (Texel Straks).</p>

                    <p>Wanneer de test is afgerond, wordt uw persoonlijke top 3 getoond en ook de gemiddelde top 3.</p>

                    <p>De inhoud van de Smaaktest zal gedurende het project dynamisch zijn, zo kunnen veel beelden getest worden. Doel is om uw oordeel te gebruiken als input voor de Internationale Architectuur Biennale Rotterdam: IABR–2014–URBAN BY NATURE. Het het IABR–projectatelier Planet Texel zal resulteren in een vergezicht op de toekomst van Texel.</p>

                    <p>Wanneer de test is afgerond, wordt uw persoonlijke top 3 getoond en ook de gemiddelde top 3.</p>

                    <p>Wilt u op de hoogte worden gehouden van deze activiteiten van Planet Texel? Vul dan uw emailadres in na het maken van de test. De emailgegevens en de gegevens die bij de Smaaktest ingevuld worden zijn niet aan elkaar gekoppeld: de Smaaktest is anoniem!</p>

                    <div class="well ">
                        <a ng-click="step=2" class="btn btn-large btn-primary ">Start de test</a>

                    </div>


                </div>


            </div>
        </div>
    </section>


    <section id="nawform" ng-controller="formController as nawformCrtl" ng-show="step === 2" ng-init="nawformCrtl.getForm()">
        <div class="container">
            <div class="row">
                <div class="col-md-8 well">

                    <form name="nawform" ng-submit="nawformCrtl.submit()" novalidate>

                        <div ng-repeat="element in formData">
                            <div class="form-group">
                                <label for="vraag1"> {{element.label}} </label>
                                <select ng-model="naw[element.veld]"
                                        ng-options="item.value as item.label for item in element.value">
                                    <option value=""> -- Maak een keuze --</option>
                                </select>
                            </div>
                        </div>
                        <!--                        {{naw | json}}-->
                        <button type="submit" class="btn btn-default">Submit</button>

                    </form>
                    <br/>
                </div>
            </div>
        </div>
    </section>


    <section id="quiz" ng-controller="quizController as quizCtrl" ng-show="step === 3">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div> {{actual+1}}/{{totallocations}}
                        <!--                        {{actualLocation}}-->

                        <div class="btn-group pull-right">
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
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div><img id="mainpic" ng-src="/uploads/{{actualLocation.photos[0]}}" alt=""/></div>

                </div>
            </div>
        </div>
    </section>

    <section ng-show="step === 4">
        <div>
            eind resultaat

        </div>

    </section>

    <div id="footer">
      <span style="float:left;">
      <a href="http://www.texel.nl/"><img src="/images/gemTxl-footer.gif" alt="Gemeente Texel" width="320" height="47" border="0"></a>
          &nbsp;&nbsp; <a href="http://www.iabr.nl"><img src="/images/IABR-logo.gif" alt="IABR-2014"></a> <img src="/images/ism.gif" width="71" height="47">
      <a href="http://www.faro.nl"><img src="/images/faro.gif" alt="FARO architecten" width="130" height="47" border="0"></a>
      <a href="http://www.la4sale.nl"><img src="/images/la4sale.gif" alt="La4sale"></a>

      </span> <a href="colofon.htm" class="colofon">colofon</a></div>

    <!-- end container-->

</div>


<script src="_js/libs.min.js" type="text/javascript"></script>

<script src="src/scripts/app.js" type="text/javascript"></script>
<script src="src/scripts/quizModule.js" type="text/javascript"></script>
<script src="src/scripts/formModule.js" type="text/javascript"></script>


</body>
</html>