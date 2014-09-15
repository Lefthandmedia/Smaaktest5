<!DOCTYPE html>
<html ng-app="adminApp">
<head>
    <title>smaaktest</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>


</head>
<body>

<div class="container" ng-controller="adminController as adminCtrl">
    <div class="row">
        <div class="col-md-3"><h4>Main menu</h4>
            {{4+1}}
            <ul class="gallery clearfix">
                <li ><button ng-click="adminCtrl.showLocations()">Locatie aanmaken</button></li>
                <li ng-click="goto(1)">Locatie bewerken</li>
                <li ng-click="goto(1)">Tags toevoegen</li>
                <li ng-click="goto(1)">Uitslagen</li>
            </ul>
        </div>

        <div class="col-md-9">
            <div class="container">
                <div class="row">

                    <section id="locationlist" ng-controller="locationController as locationCtrl">
                        <div ng-repeat="item in locations"></div>
                    </section>

                    <section id="create-location">

                    </section>

                    <section id="stats">


                    </section>



                </div>
            </div>
        </div>
    </div>
</div>


<script src="/_js/libs.min.js" type="text/javascript"></script>
<script src="/src/scripts/admin/admin.js" type="text/javascript"></script>
<script src="/src/scripts/admin/locationModule.js" type="text/javascript"></script>




</body>
</html>