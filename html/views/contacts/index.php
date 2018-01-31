<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyChQwAXEXRThQkqgC-xW18anW640loh6IA&sensor=false&libraries=places&v=3"></script>

<div class='container' style='padding-bottom:100px;'>

    <script>
        app.controller('mapCtrl', ['$scope', '$http', function ($scope, $http) {
                $scope.initMap = function () {
                    var lat = 49.23384937, lng = 28.41922224;

                    $scope.latlng = new google.maps.LatLng(lat, lng);
                    var myOptions = {
                        zoom: 16,
                        draggable: true,
                        zoomControl: true,
                        scrollwheel: false,
                        disableDoubleClickZoom: true,
                        center: $scope.latlng,
                        mapTypeId: google.maps.MapTypeId.ROADMAP
                    };

                    $scope.map = new google.maps.Map(document.getElementById("map"), myOptions);

                    var marker = new google.maps.Marker({//устанавливаем маркер
                        map: $scope.map,
                        position: $scope.latlng
                    });
                }

                $scope.initMap();
            }]);
    </script>

    <style>
        #map_block{
            width:100%;
            height:500px;
            background: black;
            position:relative;
        }
        #map_block #map{
            width:100%;
            height: 100%;
        }
        #map_block .map_info{
            position: absolute;
            right: 0px;
            top:40px;
            width:350px;
            height: 150px;
            border-radius: 10px;
            background: white;
            padding:50px 20px;
            z-index:100;
            font-size: 14px;
            color: #222;
            font-weight:bold;
        }
        #map_block .map_info span{
            display:inline-block;
            vertical-align: middle;
            width:70px;
            color: #777;
        }
    </style>

    <div id="map_block" ng-controller="mapCtrl">
        <div class='container' style='position:relative;'>
            <div class='map_info'>
                <div><span>Адресс:</span> Хмельницкое шоссе 81/47</div>
                <div><span>Телефон:</span>0980920792</div>
            </div>
        </div>
        <div id='map'></div>
    </div>

</div>