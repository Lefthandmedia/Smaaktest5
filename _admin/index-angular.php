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
{{states.state}}
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
                                <td>{{item.id}}</td>
                                <td>{{item.locatie}}</td>
                                <td>
                                    <button ng-click="locationCtrl.editLocation(item.id)">Bewerken</button>
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

                    <form class="form-horizontal" role="form" novalidate="">

                        <div class="form-group">
                            <label for="locatienaam" class="col-sm-2 control-label">locatienaam</label>

                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="locatienaam" placeholder="locatienaam"
                                       ng-model="locatienaam" value="{{locatienaam}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="photo1">File input</label>
                            <input type="file" id="photo1" ng-model="photo1" value="{{photo1}}">
                            <img ng-src="/uploads/{{photo1}}" alt=""/>

                            <p class="help-block">Kies de foto.</p>
                        </div>

                        <div class="form-group">
                            <label for="thumb">File input</label>
                            <input type="file" id="thumb" ng-model="thumb">
                            <img ng-src="/uploads/{{thumb}}" alt=""/>

                            <p class="help-block">Kies de thumbnail.</p>
                        </div>

                        <div class="checkbox">
                            <label>
                                <input type="checkbox" ng-model="actief" checked="{{actief}}"> activeer locatie
                            </label>
                        </div>


                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-default" ng-click="">Bewaar</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div id="stats" ng-show="states.state === 'stats'" ng-controller="statsController as statsCtrl">
                    statistics

                </div>


            </div>

        </div>
    </div>
</div>


<script src="/_js/libs.min.js" type="text/javascript"></script>
<script src="/src/scripts/admin/admin.js" type="text/javascript"></script>
<script src="/src/scripts/admin/locationModule.js" type="text/javascript"></script>
<script src="/src/scripts/admin/editModule.js" type="text/javascript"></script>


</body>
</html>