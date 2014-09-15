<?php
/**
 * @author Lefthandmedia <ralph@lefthandmedia.com>
 */

include 'HEAD.php';
?>

    <section id="result">
        <div class="container">
            <div class="row">
                <div class="col-md-4"> De resultaten van Smaaktest worden in het najaar van 2013 gebruikt als input voor het project Planet Texel; een vergezicht dat gemaakt wordt in het kader van de Internationale Architectuur Biënnale Rotterdam 2014. Ontwerpvoorstellen die dan gemaakt worden kunnen in de volgende versie van de Smaaktest Texel opnieuw beoordeeld worden.

                    <br/><br/>
                    Wilt u op de hoogte worden gehouden over het verloop of de uitslagen van de verkiezing. Vul dan uw emailadres in

                    <form action="" ng-submit>
                        <input type="text"/>  <button type="submit" class="btn btn-default">Submit</button>
                        <div>Let op: deze e-mailgegevens en de gegevens die bij de peiling ingevuld worden zijn niet gekoppeld</div>
                    </form>
                </div>

                <div class="col-md-4 toplist">
                    <div class=" "><h2>Algemene top3</h2>
                        <!--1 row loop this -->
                        <div class="row toplist-row">
                            <div class="col-md-4 col-sm-6">
                                <img src="/uploads/1.jpg" alt=""/>
                            </div>
                            <div class="col-md-8 col-sm-6">
                                locatienaam
                                gemiddled cijfer: 6,7
                            </div>
                        </div>
                        <!--end-->
                    </div>
                </div>

                <div class="col-md-4 toplist"><h2>Uw top3</h2>
                    <!--1 row-->
                    <div class="row toplist-row">
                        <div class="col-md-4">
                            <img src="/uploads/1.jpg" alt=""/>
                        </div>
                        <div class="col-md-8">
                            locatienaam
                            gemiddled cijfer: 6,7
                        </div>
                    </div>
                    <!--end -->
                </div>
            </div>
        </div>
    </section>



<?php
include 'footer.php';
?>