
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
    <style>
        #map {
            height: 100%;
            margin-bottom: 15px;
        }
        .btn-color
        {
            background-color: #cc0001;
        }
        .extra-padding
        {
            padding: 20px;
        }
    </style>
    <title>Find Address</title>
</head>

<body ng-app="findApp" ng-controller="findControl">
<nav class="navbar navbar-expand-lg navbar-primary navbar-color">
    <a class="navbar-brand text-color" href="#">Find Digital Address</a>
    <button class="navbar-toggler btn-warning" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarText">
        <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                          <a class="nav-link text-color" href="index.php">Generate Digital Address</a>
                        </li>
        </ul>
    </div>
</nav>
<div class="container">


    <div class="row row-allign">
        <div class="col-sm-4">
            <!-- <center> -->
            <div class="form-border spacing-top">
                <div class="card-header" style="background:#cc0001; color:#ffff"><center><h5>Enter Digital Address</h5></center></div>
                <div class="extra-padding">

                    <form ng-submit="fetchadd()" class="custom-form">
                        <div class="">
                            <div class="">
                                <div class="form-group input-group-sm">
                                    <label for="digiadd" class="animated-label">Digital Address</label>
                                    <input type="text" class="form-control rounded-0 textbox-depth textbox-border" id="digiadd" ng-model="digiaddress"/>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-color btn-block rounded-0" style="color:#ffff">Find</button>
                        </div>
                    </form>
                </div>
            </div>
            <br>
        </div>
        <div class="col-sm-8 map-align" ng-init="initMap()">
            <div id="map" class="extra-padding"></div>
        </div>

    </div>
</div>



<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAXtUgIJI39fpYsM2y2FwAs0KynuS_qmP8">
</script>
<script src="js/functionality.js">
</script>
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
</body>
</html>