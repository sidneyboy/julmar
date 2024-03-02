<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap4.min.css">

    <link rel="stylesheet" href="{{ asset('css/ol.css') }}" type="text/css">
    <script src="{{ asset('js/ol.js') }}"></script>
    <title>VS Customer Map</title>
    <style type="text/css">
        html,
        body {
            font-family: calibri;
        }

        #map {
            position: absolute;
            width: 100%;
            height: 100%;
        }


        .ol-tooltip * {
            font-family: Arial, Helvetica, sans-serif;
            font-weight: 300
        }

        .ol-tooltip {
            display: flex;
            overflow: hidden;
            padding: 3px;
            margin: 3px 0px;
            border-radius: 6px;
        }

        .ol-tooltip:hover {
            background: rgba(102, 51, 153, 0.062)
        }

        .ol-tooltip img {
            float: left;
            padding: 5px;
            width: 40px;
            height: 40px;
        }

        .ol-tooltip-job a {
            font-size: 15px;
            padding: 2px;
            text-decoration: none;
            color: #0050b8;
            font-weight: bold;
            white-space: nowrap;
        }

        .ol-tooltip-job a:hover {
            color: #c90083;
        }

        .ol-tooltip-salary {
            font-size: 14px;
            padding: 2px;
            white-space: nowrap;
        }

        .ol-tooltip-company {
            font-size: 13px;
            padding: 2px;
        }

        .ol-popup {
            position: absolute;
            background-color: white;
            filter: drop-shadow(0 1px 4px rgba(0, 0, 0, 0.1));
            padding: 10px;
            border-radius: 10px;
            border: 1px solid #cccccc2a;
            bottom: 12px;
            width: 210px;
            transform: translate(-50%, 0%);
            margin-bottom: 10px;
        }

        .ol-popup:after,
        .ol-popup:before {
            top: 100%;
            border: solid transparent;
            content: " ";
            height: 0;
            width: 0;
            position: absolute;
            pointer-events: none;
        }

        .ol-popup:after {
            border-top-color: white;
            border-width: 10px;
            left: 120px;
            margin-left: -16px;
        }

        .ol-popup:before {
            border-top-color: #cccccc2a;
            border-width: 11px;
            left: 120px;
            margin-left: -16px;
        }

        .marker {
            background: #222 !important;
        }

        .animated {
            position: relative;
            -webkit-animation-duration: 1s;
            animation-duration: 1s;
            -webkit-animation-fill-mode: both;
            animation-fill-mode: both;
        }

        .animated:hover {
            -webkit-animation-iteration-count: infinite;
            animation-iteration-count: infinite;
        }

        @keyframes hop {
            0% {
                margin-bottom: 0px;
            }

            50% {
                margin-bottom: 30px;
            }

            100% {
                margin-bottom: 0px;
            }
        }

        .hop {
            -webkit-animation-name: hop;
            animation-name: hop;
            animation-iteration-count: infinite;
            animation-duration: 2s;
        }
    </style>

</head>

<body>
    <!-- Popup click -->
    <div id="popupClick" class="ol-popup">
        <a id="popup-closer" class="ol-popup-closer"></a>
        <div id="popup-content-click"></div>
    </div>

    <div id="map"></div>
    <!-- Popup hover -->
    <div id="popup" class="ol-popup">
        <a id="popup-closer" class="ol-popup-closer"></a>
        <div id="popup-content"></div>
    </div>

    <input type="text" id="open" value="{{ asset('images/disconnected_accounts_marker.png') }}">


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
    </script>

    <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI="
        crossorigin="anonymous"></script>

    <script>
        var open = $('#open').val();


        var straitSource = new ol.source.Vector({
            wrapX: true
        });
        var straitsLayer = new ol.layer.Vector({
            source: straitSource
        });


        var map = new ol.Map({
            target: 'map',
            layers: [
                new ol.layer.Tile({
                    // source: new ol.source.OSM()
                    source: new ol.source.XYZ({
                        attributions: 'None',
                        attributionsCollapsible: true,
                        url: 'http://mt0.google.com/vt/lyrs=y&hl=en&x={x}&y={y}&z={z}'
                    })
                }),
                straitsLayer
            ],
            view: new ol.View({
                center: ol.proj.fromLonLat([124.64970709949716, 8.483466116291813]),
                maxZoom: 26,
                zoom: 13
            })
        });

        // Popup showing the position the hovered marker
        var container = document.getElementById('popup');
        var popup = new ol.Overlay({
            element: container,
            autoPan: false,
            autoPanAnimation: {
                duration: 450
            }
        });
        map.addOverlay(popup);

        // Popup showing the position the user clicked
        var containerClick = document.getElementById('popupClick');
        var popupClick = new ol.Overlay({
            element: containerClick,
            autoPan: true,
            autoPanAnimation: {
                duration: 250
            }
        });
        map.addOverlay(popupClick);

        // Popup part
        var content = document.getElementById('popup-content');
        var contentClick = document.getElementById('popup-content-click');
        var selected = null;



        // Hover popup
        map.on('pointermove', function(evt) {
            var feature = map.forEachFeatureAtPixel(evt.pixel, function(feat, layer) {
                return feat;
            });
            if (map.hasFeatureAtPixel(evt.pixel) === true) {
                if (selected != feature) {
                    // Event coordinates
                    // popup.setPosition(evt.coordinate);
                    // Lon Lat coordinates
                    var postion = ol.proj.transform([feature.get('lon'), feature.get('lat')], 'EPSG:4326',
                        'EPSG:3857');
                    content.innerHTML = feature.get('desc');
                    // Show marker on top
                    MarkerOnTop(feature, true);
                    // Show popup
                    popup.setPosition(postion);
                }
            } else {
                straitSource.getFeatures().forEach((f) => {
                    // Hide markers zindex 999
                    MarkerOnTop(f, false);
                });
                // Hide popup
                popup.setPosition(undefined);
            }

        });

        // Click popup
        map.on('click', function(evt) {
            var feature = map.forEachFeatureAtPixel(evt.pixel, function(feat, layer) {
                selected = feat;
                return feat;
            });
            if (map.hasFeatureAtPixel(evt.pixel) === true) {
                // Event coordinates
                // popup.setPosition(evt.coordinate);
                // Lon Lat coordinates
                var postion = ol.proj.transform([feature.get('lon'), feature.get('lat')], 'EPSG:4326', 'EPSG:3857');
                contentClick.innerHTML = feature.get('desc');
                // Show marker on top
                MarkerOnTop(feature, true);
                // Show Popup
                popupClick.setPosition(postion);
            } else {
                selected = null;
                // Hide markers zindex 999
                straitSource.getFeatures().forEach((f) => {
                    MarkerOnTop(f, false);
                });
                popupClick.setPosition(undefined);
            }
        });

        // Show marker on top
        function MarkerOnTop(feature, show = false) {
            var style = feature.getStyle();
            if (show) {
                style.zIndex = 9999;
                style.zIndex_ = 9999;
            } else {
                style.zIndex = 999;
                style.zIndex_ = 999;
            }
            feature.setStyle(style);
        }

        // Data from database here :)
        var data = <?php echo json_encode($customer_map_data); ?>;

        // Create markers function
        // icon.imageDiv.className += "name"
        function addPointGeom(data) {
            data.forEach(function(item) { //iterate through array...
                var MarkerIcon = new ol.style.Icon({
                    anchor: [0.5, 50],
                    anchorXUnits: 'fraction',
                    anchorYUnits: 'pixels',
                    src: open,
                    scale: 0.7
                });


                var iconFeature = new ol.Feature({
                        geometry: new ol.geom.Point(ol.proj.transform([item.Lon, item.Lat], 'EPSG:4326',
                            'EPSG:3857')),
                        type: 'Point',
                        // desc: ToolTip(desc),
                        lon: item.Lon,
                        lat: item.Lat,
                        desc: 'Store Name : ' + item.Store_name +
                            '<br>Store Type: ' + item.Store_type + '<br>Contact Person: ' + item.Contact_person +
                            '<br /> Contact Number: ' + item.Contact_number + 
                            '<br /> Barangay: ' + item.Barangay +
                            '<br /> Address: ' + item.Address
                    }),
                    iconStyle = new ol.style.Style({
                        image: MarkerIcon
                    });
                iconFeature.setStyle(iconStyle);
                straitSource.addFeature(iconFeature);
            });
        }

        // Add markers now
        addPointGeom(data);
    </script>
</body>

</html>
