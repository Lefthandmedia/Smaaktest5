<!DOCTYPE html>
<html ng-app="adminApp">
<head>
    <title>smaaktest</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <link rel="stylesheet" href="/_css/app.min.css"/>

</head>
<body>

<div class="container" ng-controller="adminController as adminCtrl" ng-init="adminCtrl.init()">
    <div class="row">
        <div class="col-md-3"><h4>Main menu</h4>
            {{4+1}}<br/>
            state = {{states.state}}<br/>
            locid.id = {{locid.id}}<br/>
            <ul class="gallery clearfix">
                <li>
                    <button ng-click="adminCtrl.showLocations()">Locaties</button>
                </li>
                <li>
                    <button ng-click="adminCtrl.addLocation()">nieuwe Locatie toevoegen</button>
                </li>
                <li>
                    <button ng-click="adminCtrl.addTags()">Tags toevoegen</button>
                </li>
                <li>
                    <button ng-click="adminCtrl.showStats()">Uitslagen</button>
                </li>
            </ul>
        </div>

        <div class="col-md-8">
            <div class="row">

                <!-- ================= LIST ===============-->

                <div id="locationlist" ng-controller="locationController as locationCtrl"
                        ng-init="locationCtrl.getLocations()" ng-show="states.state === 'list'">

                    <div class="col-md-8">
                        <table class="table">
                            <tr ng-repeat="item in locations">
                                <td>
                                    <input type="checkbox" ng-model="actief" ng-checked="{{item.actief}}" ng-true-value="1" ng-false-value="0">
                                </td>
                                <td>{{item.id}}</td>
                                <td>{{item.locatie}}</td>
                                <td>
                                    <button ng-click="locationCtrl.updateLocation(item.id)">Bewerken</button>
                                </td>
                                <td>
                                    <button ng-click="locationCtrl.removeLocation(item.id)">verwijderen</button>
                                </td>
                                <td></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!--========================EDIT=================-->
                <div id="create-location" ng-show="states.state === 'edit'" ng-controller="editController as editCtrl">

                    <h2>create / edit location</h2>

                    <form class="form-horizontal" role="form" novalidate="" ng-submit="editCtrl.submitlocation()">

                        <div class="form-group">
                            <label for="locatienaam" class="col-sm-2 control-label">locatienaam</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="locatienaam" placeholder="locatienaam"
                                        ng-model="locatienaam" value="{{locatienaam}}">
                            </div>
                            locid.id = {{locid.id}}<br/>
                        </div>
                        <div ng-show="locid.id">
                            <div class="form-group">



                                <div ng-file-select="onFileSelect($files,'thumb')" data-multiple="false" title="select file" onclick="this.value = null" class="btn btn-primary">kies een foto</div>

                                ===========================
                                <div ng-show="selectedFiles != null">

                                    <div class="sel-file" ng-repeat="f in selectedFiles">
                                        {{($index + 1) + '.'}}
                                        <img ng-show="dataUrls[$index]" ng-src="{{dataUrls[$index]}}" width="30">

                                        <button class="button" ng-click="start($index,'thumb')" ng-show="progress[$index] < 0">Start</button>
                                				<span class="progress" ng-show="progress[$index] >= 0">
                                					<div style="width:{{progress[$index]}}%">{{progress[$index]}}%</div>
                                				</span>

                                        <button class="button" ng-click="abort($index)" ng-show="hasUploader($index) && progress[$index] < 100">Abort</button>
                                        {{f.name}} - size: {{f.size}}B - type: {{f.type}}
                                    </div>
                                </div>
                                ===================================

                            </div>


                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" ng-model="actief" checked="{{actief}}"> activeer locatie
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-default" ng-click="">Bewaar</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!--======================== TAGS =================-->
                <div id="tags" ng-controller="tagController as tagCtrl" ng-show="states.state === 'tags'">

                    tags
                </div>

                <!--======================== STATS =================-->
                <div id="stats" ng-controller="statsController as statsCtrl" ng-show="states.state === 'stats'">
                    statistics

                </div>


            </div>

        </div>
    </div>
</div>


<script src="/_js/libs.min.js" type="text/javascript"></script>
<script src="/src/scripts/admin/admin.js" type="text/javascript"></script>
<script src="/src/scripts/admin/editModule.js" type="text/javascript"></script>
<script src="/src/scripts/admin/statsModule.js" type="text/javascript"></script>


</body>
</html>