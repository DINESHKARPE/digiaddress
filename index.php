<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>

    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAXtUgIJI39fpYsM2y2FwAs0KynuS_qmP8">
    </script>
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="js/functionality.js">
    </script>
    <style>
        #map {
            height: 100%;
            margin-bottom: 15px;
        }

        .btn-color {
            background-color: #cc0001;
        }

    </style>
    <title>Digital Address</title>
</head>
<body ng-app="indexApp" ng-controller="digiAddressGenerator">
<nav class="navbar navbar-expand-lg navbar-primary navbar-color">
    <a class="navbar-brand text-color" href="#">Generate Digital Address</a>
    <button class="navbar-toggler btn-warning" type="button" data-toggle="collapse" data-target="#navbarText"
            aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarText">
        <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                          <a class="nav-link text-color" href="findaddress.php">Find Address</a>
                        </li>
        </ul>
    </div>
</nav>
<div class="container">


    <div class="row row-allign">
        <div class="col-sm-4">
            <!-- <center> -->
            <div class="form-border spacing-top">
                <div class="card-header" style="background:#cc0001; color:#ffff">
                    <center><h5>Enter Address</h5></center>
                </div>
                <div class="extra-padding">

                    <form ng-submit="processForm()" class="custom-form">
                        <div class="">


                            <div class="">
                                <div class="form-group input-group-sm">
                                    <label for="sector">State</label>
                                    <input type="text" class="form-control rounded-0 textbox-border" id="state"
                                           placeholder="" ng-model="address.state"
                                           ng-blur="geocodeAddress(address,'state')" required=""/>
                                </div>
                            </div>
                            <div class="">
                                <div class="form-group input-group-sm">
                                    <label for="inputZip" class="animated-label">Zip</label>
                                    <input type="text" class="form-control rounded-0 textbox-depth textbox-border"
                                           id="zip" ng-model="address.zip"
                                           ng-blur="geocodeAddress(address,'zip')" required=""/>
                                </div>
                            </div>
                            <div class="">
                                <div class="form-group input-group-sm">
                                    <label for="street">Street</label>
                                    <input type="text" class="form-control rounded-0 textbox-border" id="street"
                                           placeholder="" ng-model="address.street"
                                           ng-blur="geocodeAddress(address,'street')" required=""/>
                                </div>
                            </div>

                            <div class="">
                                <div class="form-group input-group-sm">
                                    <label for="town">Town</label>
                                    <input type="text" class="form-control rounded-0 textbox-border textbox-depth"
                                           id="town" placeholder="" ng-model="address.town"
                                           ng-blur="geocodeAddress(address,'town')" required=""/>
                                </div>
                            </div>

                            <div class="">
                                <div class="form-group input-group-sm">
                                    <label for="housenumber">House</label>
                                    <input type="text" class="form-control rounded-0 textbox-border" id="housenumber"
                                           placeholder="" ng-model="address.housenumber"
                                           ng-blur="geocodeAddress(address,'housenumber')" required=""/>
                                </div>
                            </div>
                            <div class="">
                                <div class="form-group input-group-sm">
                                    <input type="hidden" ng-model="address.lat"/>
                                </div>
                            </div>
                            <div class="">
                                <div class="form-group input-group-sm">
                                    <input type="hidden" ng-model="address.long"/>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-color btn-block rounded-0" style="color:#ffff">Verify
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <br>
            <div class="p-1 mb-2 bg-danger text-white border border-white" ng-show="">
                <h4>
                    <center ng-bind="myWelcome.value1"></center>
                </h4>
            </div>
            <!-- </center> -->
        </div>
        <div class="col-sm-8 map-align" ng-init="initMap()">
            <div id="map" class="extra-padding"></div>
            <div class="alert alert-color rounded-0" id="lt" ng-show="latlong" ng-model="lt"></div>
            <div class="alert alert-color rounded-0" id="padd" ng-show="addr" ng-model="padd"></div>
        </div>

    </div>

    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content rounded-0 form-border">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="printbody">
                    <div class="row">
                        <div class="col-sm-7"></br></br></br>
                            <div class="align-middle">
                                <h2><span ng-model="digiaddlabel" ng-bind="digiaddlabel"></span></h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
<!--                    <button type="button" class="btn btn-primary" ng-click="printQR('printbody')">Print</button>-->
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>