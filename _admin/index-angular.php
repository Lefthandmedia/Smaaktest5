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
            aa{{$scope.state}}<br/>
            zz{{$rootScope.state}}<br/>
            zz{{adminCtrl.state}}<br/>
            yy{{state}}<br/>

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
                    <button ng-click="adminCtrl.stats()">Uitslagen</button>
                </li>
            </ul>
        </div>

        <div class="col-md-8">
            <div class="container">
                <div class="row">

                    <section id="locationlist" ng-controller="locationController as locationCtrl" ng-init="locationCtrl.getLocations()" ng-show="state == list">

                        <ul>
                            <li ng-repeat="item in locations" class="row">
                                <div class="col-md-1"> {{item.id}}</div>
                                <div class="col-md-3"> {{item.locatie}}</div>
                                <div class="col-md-1" ng-click="locationCtrl.editLocation(item.id)"> Bewerken</div>
                                <div class="col-md-1" ng-click="locationCtrl.removeLocation()"> verwijderen</div>
                            </li>
                        </ul>

                    </section>


                    <section id="create-location" ng-show="state == new">

                        create / edit location

                    </section>

                    <section id="stats" ng-show="state == stats">
                        statistics

                    </section>


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