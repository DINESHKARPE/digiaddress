var geocoder = null;
var resmap = null;
var marker = null;
var rectangle = null;
var tempadd = null;
var add1 = "";
var lat, long;
var latlong;


var app = angular.module('indexApp', []);

app.controller('digiAddressGenerator', function ($scope, $http) {

    $scope.initMap = function () {
        $(window).load(function () {
            resmap = new google.maps.Map(document.getElementById('map'), {
                zoom: 5,
                center: {lat: 37.387474, lng: -122.05754339999999}
            });
            geocoder = new google.maps.Geocoder();
            resmap.addListener('click', function (event) {
                addMarker(event.latLng);
            });
        });

    };

    function addMarker(location) {
        removeMarker();
        removeRectangle();
        latlong = null;
        //console.log(location);
        lat = location.lat();
        long = location.lng();
        $scope.address.lat = lat;
        $scope.address.long = long;
        latlong = lat + ", " + long;
        myEl = angular.element(document.querySelector('#lt'));
        myEl.html("GeoCoordinates: " + latlong);
        $scope.latlong = true;
        console.log("lat " + latlong);
        marker = new google.maps.Marker({
            position: location,
            map: resmap
        });
        getAddress(location);
    }

    function removeMarker() {
        if (marker !== null) {
            marker.setMap(null);
        }
    }

    function removeRectangle() {
        if (rectangle !== null) {
            rectangle.setMap(null);
        }
    }


    $scope.geocodeAddress = function (address, field) {
        if (address[field]) {
            if (address !== null) {
                var add = "";
                var arr = [];
                for (var key in address) {
                    // add hasOwnPropertyCheck if needed
                    if (key !== 'lat' && key !== 'long')
                        arr.push(address[key].toString());
                }
                for (var i = arr.length - 1; i >= 0; i--) {
                    if (add === "")
                        add = arr[i].toString();
                    else
                        add = add + ',' + arr[i].toString();
                }
                if (add !== add1) {
                    $http({
                        method: 'POST',
                        url: 'geoimplement.php',
                        data: {address: add},
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'}

                    }).then(function successCallback(results) {
                        if (results.data !== "false") {
                            console.log(results);
                            removeMarker();
                            removeRectangle();
                            $scope.address.lat = lat;
                            $scope.address.long = long;
                            lat = results.data.geometry.location.lat;
                            long = results.data.geometry.location.lng;
                            console.log("Latitude:" + lat + "Longitude:" + long);
                            marker = new google.maps.Marker({
                                map: resmap,
                                position: results.data.geometry.location
                            });
                            myEl = angular.element(document.querySelector('#lt'));
                            myEl.html("GeoCoordinate: " + lat + "," + long);
                            $scope.latlong = true;
                            myEl = angular.element(document.querySelector('#padd'));
                            myEl.html("GeoAddress: " + add);
                            $scope.addr = true;
                            if (results.data.geometry.viewport) {
                                rectangle = new google.maps.Rectangle({
                                    strokeColor: '#FF0000',
                                    strokeOpacity: 0.8,
                                    strokeWeight: 2,
                                    fillColor: '#FF0000',
                                    fillOpacity: 0.35,
                                    map: resmap,
                                    bounds: {
                                        north: results.data.geometry.viewport.northeast.lat, //19.185108,
                                        south: results.data.geometry.viewport.southwest.lat, //19.1251106,
                                        east: results.data.geometry.viewport.northeast.lng, //72.94776869999998,
                                        west: results.data.geometry.viewport.southwest.lng//72.88884499999995
                                    }
                                });
                                resmap.setCenter(new google.maps.LatLng(lat, long));
                                var googleBounds = new google.maps.LatLngBounds(results.data.geometry.viewport.southwest, results.data.geometry.viewport.northeast);

                                resmap.fitBounds(googleBounds);
                            }

                        } else {
                            myEl = angular.element(document.querySelector('#lt'));
                            myEl.html("Place not found.Please select location on map");
                            $scope.latlong = true;
                            removeRectangle();

                        }

                    }, function errorCallback(results) {
                    });

                }
                ;
            }
        }
    };


    function getAddress(latlong) {
        geocoder.geocode({
            'latLng': latlong
        }, function (results, status) {
            if (status === google.maps.GeocoderStatus.OK) {
                if (results[1]) {
                    console.log(results[1].formatted_address);
                    myEl = angular.element(document.querySelector('#padd'));
                    myEl.html("GeoAddress: " + results[1].formatted_address);
                    $scope.addr = true;
                } else {
                    console.log('No results found');
                }
            } else {
                console.logs('Geocoder failed due to: ' + status);
            }
        });
    };

    $scope.processForm = function () {

        var digiAdd = "";
        $http({
            method: 'POST',
            url: 'collectDigitalAddress.php',
            data: $scope.address,
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).then(function (response) {
                if (!response.data.status) {
                    $scope.status = "Failed ";
                    console.log(response);
                }
                else if (response.data.status) {
                    digiadd = response.data.status;
                    $scope.digiaddlabel = response.data.status;
                    $scope.pincode = null;
                    $scope.sector = null;
                    $scope.street = null;
                    $scope.landmark = null;
                    $scope.bhname = null;
                    $scope.hfno = null;

                    $scope.digiadd = digiadd;
                    $('#exampleModalCenter').modal('show');
                }
            },
            function (response) {
                console.log(response.statusText);
            });


    };
});


var addapp = angular.module('findApp',[]);

addapp.controller('findControl', function($scope, $http){
    $scope.initMap = function () {
        $(window).load(function (){
            resmap = new google.maps.Map(document.getElementById('map'), {
                zoom: 5,
                center: {lat: 24.122681, lng: 76.4269941}
            });
            geocoder = new google.maps.Geocoder();
        });

    };

    $scope.fetchadd = function(){
        var lat;
        var long;
        var qrcode;
        $http({
            method : 'POST',
            url : 'fetchaddress.php',
            data : {digiaddress: $scope.digiaddress}
        }).then(function(response){
                console.log(response);
                if(response.data.error)
                {
                    $scope.adderror = response.data.error.add;
                    console.log(response.data.error.add);
                }
                else
                {
                    console.log(response.data);
                    if(!response.data.latlong)
                    {
                        console.log("1");
                        $scope.qrcode = "";
                        $scope.qrcode = false;
                        $scope.adderror = "Digital Address not found";
                        resmap.setZoom(5);
                        resmap.setCenter(new google.maps.LatLng(24.122681, 76.4269941));
                    }
                    else if (response.data.latlong)
                    {
                        $scope.adderror = "";
                        $scope.adderror = false;
                        console.log("2");
                        var jsonlatlong = JSON.parse(response.data.latlong);
                        $scope.lat = jsonlatlong.latitude;
                        $scope.long = jsonlatlong.longitude;

                        //console.log(response.data);
                        console.log(jsonlatlong.latitude);
                        console.log(jsonlatlong.longitude);
                        console.log(jsonlatlong.digital_address);
                        marker = new google.maps.Marker({
                            position: new google.maps.LatLng(jsonlatlong.latitude, jsonlatlong.longitude),
                            map: resmap
                        });

                        resmap.setCenter(new google.maps.LatLng(jsonlatlong.latitude, jsonlatlong.longitude));
                        resmap.setZoom(18);
                        $scope.qrcode = "qroutput/"+jsonlatlong.digital_address+".png";
                    }

                }
            },
            function(response){
                console.log(response.statusText);
            });
    };

    $scope.printQR = function(printbody) {
        console.log("in print");
        var printContents = document.getElementById(printbody).innerHTML;
        var printWindow = window.open('', '_blank', 'width=600,height=700,scrollbars=no,menubar=no,toolbar=no,location=no,status=no,titlebar=no');
        printWindow.document.open();
        printWindow.document.write('<html><head><link rel="stylesheet" type="text/css" href="style.css" /></head><body onload="window.print()">' + printContents + '</html>');
        printWindow.document.close();
    };

});
