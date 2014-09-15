<?php
/**
 * @author Lefthandmedia <ralph@lefthandmedia.com>
 */

include 'HEAD.php';

?>



    <section id="nawform" ng-controller="formController as nawformCrtl" ng-show="step === 1" ng-init="nawformCrtl.getForm()">
        <div class="container">
            <div class="row well">
                <div class="col-md-8 col-md-offset-2 col-sm-offset-0">



                        <form name="nawform" ng-submit="nawformCrtl.submit()" novalidate>

                            <div ng-repeat="element in formData">
                                <div class="form-group">
                                    <label for="vraag1"> {{element.label}} {{element.veld}}</label>
                                    <select ng-model="naw[element.veld]"
                                            ng-options="item.value as item.label for item in element.value">
                                        <option value=""> -- Maak een keuze --</option>
                                    </select>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-default btn-primary pull-right">Submit</button>

                        </form>

                    <br/>
                </div>
            </div>
        </div>
    </section>



<?php
include 'footer.php';
?>