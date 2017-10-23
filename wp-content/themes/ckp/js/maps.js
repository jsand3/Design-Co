// When the window has finished loading create our google map below
google.maps.event.addDomListener(window, 'load', init);

function init()
{
    // Map
    var lat =  40.00158;
    var lon = -86.05776;
    var location = new google.maps.LatLng(lat, lon);
    var center = new google.maps.LatLng(lat + 0.015, lon);
    var mapOptions = {
        zoom: 11,
        scrollwheel: false,
        center: center,
        //styles: [{featureType:'all',stylers:[{saturation:-100},{gamma:1}]}]
    };
    var mapElement = document.getElementById('map');
    var map = new google.maps.Map(mapElement, mapOptions);

    // Marker
    var marker1 = new MarkerWithLabel({
        position: new google.maps.LatLng(40.043915, -86.013126),
        draggable: false,
        map: map,
        labelContent: 'CKP Noblesville Office',
        labelClass: 'map-label',
        labelAnchor: new google.maps.Point(-20, 20),
        labelStyle: {
            fontWeight: 'bold',
            fontSize: '12px',
            textShadow: '2px 2px 1px #fff',
            textAlign: 'left',
        },
    }), marker2 = new MarkerWithLabel({
        position: new google.maps.LatLng(39.9551972, -86.1564824),
        draggable: false,
        map: map,
        labelContent: 'CKP Carmel Office',
        labelClass: 'map-label',
        labelAnchor: new google.maps.Point(-20, 20),
        labelStyle: {
            fontWeight: 'bold',
            fontSize: '12px',
            textShadow: '2px 2px 1px #fff',
            textAlign: 'left',
        },
    });

    // Info Window
    var boxText1 = document.createElement('div');
    boxText1.style.cssText = 'padding: 20px 27px 27px; font-size: 12px; font-family: "Roboto", Arial, sans-serif; font-weight: normal; text-align: left; background: #fff; width: 210px; height: 112px; color: #333;';
    boxText1.innerHTML = '<strong>Campbell Kyle Proffitt LLP</strong><br>198 South 9th Street<br>Noblesville, IN 46060<br>Phone: (317) 773-2090';
    var boxText2 = document.createElement('div');
    boxText2.style.cssText = 'padding: 20px 27px 27px; font-size: 12px; font-family: "Roboto", Arial, sans-serif; font-weight: normal; text-align: left; background: #fff; width: 210px; height: 112px; color: #333;';
    boxText2.innerHTML = '<strong>Campbell Kyle Proffitt LLP</strong><br>11595 North Meridian St. Suite 701<br>Carmel, IN 46032<br>Phone: (317) 846-6514';
    var options1 = {
        content: boxText1,
        disableAutoPan: false,
        maxWidth: 0,
        pixelOffset: new google.maps.Size(-113, -105),
        zIndex: null,
        boxStyle: { 
            //background: "url('tipbox.gif') no-repeat",
            //opacity: 1,
            //width: "280px",
        },
        //closeBoxMargin: "10px 2px 2px 2px",
        //closeBoxURL: "http://www.google.com/intl/en_us/mapfiles/close.gif",
        infoBoxClearance: new google.maps.Size(1, 1),
        isHidden: false,
        pane: "floatPane",
        enableEventPropagation: false,
    }, options2 = {
        content: boxText2,
        disableAutoPan: false,
        maxWidth: 0,
        pixelOffset: new google.maps.Size(-113, -105),
        zIndex: null,
        boxStyle: { 
            //background: "url('tipbox.gif') no-repeat",
            //opacity: 1,
            //width: "280px",
        },
        infoBoxClearance: new google.maps.Size(1, 1),
        isHidden: false,
        pane: "floatPane",
        enableEventPropagation: false,
    };
    //options2.content = boxText2;
    var infowindow1 = new InfoBox(options1);
    var infowindow2 = new InfoBox(options2);

    // Click events
    google.maps.event.addListener(marker1, 'click', function() {
        infowindow1.open(map, marker1);
    });

    google.maps.event.addListener(marker2, 'click', function() {
        infowindow2.open(map, marker2);
    });

    // Open the infowindow right away
    //infowindow1.open(map, marker1);
    //infowindow2.open(map, marker2);
    //Mobile Menu Pop Out
        function toggleCP(){
            var cp = document.getElementById("cp");
            cp.style.height = window.innerHeight - 60+"px";
            if(cp.style.right == "0px"){
                cp.style.right = "-260px";
            } else {
                cp.style.right = "0px";
            }
        }
}

