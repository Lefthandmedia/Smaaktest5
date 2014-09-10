<?php
/**
 * @author Lefthandmedia <ralph@lefthandmedia.com>
 */

include 'HEAD.php';

?>



    <section id="intro" ng-controller="formController as nawformCrtl" ng-show="step === 1" ng-init="nawformCrtl.getForm()">
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
                        <a href="quiz_total.php" class="btn btn-large btn-primary center-block">Start de test</a></div>


                    <!-- InstanceEndEditable --></div>


                <button type="submit" class="btn btn-default btn-primary pull-right">Submit</button>
                <br/>

            </div>
        </div>
    </section>



<?php
include 'footer.php';
?>