/**
 * Created by Lak on 2016. 5. 30..
 */
var geocoder;

var map;
var markers = [];
var infowindows = [];
var image = 'image/flag.png';
var curr_x;//현재 위도와 경도를 넘겨주기 위한 변수
var curr_y;
var MarkerCount=5;




function initialize() {
    geocoder = new google.maps.Geocoder();

    var latlng = new google.maps.LatLng(37.2978, 126.8370);// 디폴트로 한양대학교

    var myOptions = {
        zoom: 17,
        mapTypeControlOptions: {style: google.maps.NavigationControlStyle.ANDROID},
        center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    }


    detectBrowser(); //안드로이드와 아이폰에 맞도록 페이지 크기 변경

    map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);//맵을 그려줌


    fn_drawObjects(); // 주요 빌딩목록을 표시한다.
    //Curr_Position(); // 현재 위치를 나타낸다

    PickMap();
    Search_Map();
    return false;

}
google.maps.event.addDomListener(window, 'load', initialize);

function PickMap() {
    console.log(markers.length);
    var geocoder = new google.maps.Geocoder();

        google.maps.event.addListener(map, 'click', function(event) {
            var location = event.latLng;
            geocoder.geocode({
              'latLng' : location
            },
            function(results,status) {
                if(status == google.maps.GeocoderStatus.OK){

                    alert("Current Position is set");
                    console.log(results[0].geometry.location.lat()+"    " +results[0].geometry.location.lng());
                    curr_x = results[0].geometry.location.lat();
                    curr_y = results[0].geometry.location.lng();
                    if(markers.length == MarkerCount)
                    {
                        markers[MarkerCount-1].setMap(null);
                        MarkerCount++;
                    }
                    var latlng = new google.maps.LatLng(curr_x,curr_y);
                    var marker = new google.maps.Marker({
                        map: map,
                        draggable:false,
                        animation: google.maps.Animation.BOUNCE,
                        position: location,
                        title: "현재 고객님의 위치입니다."
                    });

                    markers.push(marker);
                }
                else{
                    alert("Geocoder Failed"+status);
                }
            }
            )
        });

}

function Curr_Position() {

    if (navigator.geolocation) {
        navigator.geolocation.watchPosition(success,error);
    }
    function success(position) {
        curr_x= position.coords.latitude;
        curr_y= position.coords.longitude;

        var latlng = new google.maps.LatLng(curr_x, curr_y);
            map = new google.maps.Marker({
            position: latlng,
            animation: google.maps.Animation.BOUNCE,
            map: map
        });
    }
    function error(msg) {
        var s = document.querySelector('#map_canvas');
        s.innerHTML = typeof msg == 'string' ? msg : "failed";
        s.className = 'fail';

    }
}
function Search_Map() {

    var input = /** @type {HTMLInputElement} */(document.getElementById('address'));
    var autocomplete = new google.maps.places.Autocomplete(input);
    autocomplete.bindTo('bounds', map);

    var infowindow = new google.maps.InfoWindow();
    var marker = new google.maps.Marker({
        map: map
    });

    google.maps.event.addListener(autocomplete, 'place_changed', function() {
        infowindow.close();
        marker.setVisible(false);
        input.className = '';
        var place = autocomplete.getPlace();

        if (!place.geometry) {
            // Inform the user that the place was not found and return.
            input.className = 'notfound';
            return;
        }

        // If the place has a geometry, then present it on a map.
        if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
        } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17);  // Why 17? Because it looks good.
        }

        marker.setIcon(/** @type {google.maps.Icon} */({
            url: place.icon,
            size: new google.maps.Size(71, 71),
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(17, 34),
            scaledSize: new google.maps.Size(35, 35)
        }));

        //위치 등록 부분
        marker.setPosition(place.geometry.location);
        marker.setVisible(true);
        //alert(place.geometry.location);


        var address = '';
        if (place.address_components) {
            address = [
                (place.address_components[2] && place.address_components[2].short_name || ''),
                (place.address_components[1] && place.address_components[1].short_name || ''),
                (place.address_components[0] && place.address_components[0].short_name || '')
            ].join(' ');
        }

        infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
        infowindow.open(map, marker);
    });

    // Sets a listener on a radio button to change the filter type on Places
    // Autocomplete.
    autocomplete.setTypes([]); // 전체 주소

}

function fn_drawObjects() {

    clearObjects();  // 마커, 인포윈도우 삭제

    // 마커정보 가져오기
    var searchUrl = 'markerInfo.xml';
    downloadUrl(searchUrl, function(data, status){
        var xml = parseXml(data);

        var markerNodes = xml.documentElement.getElementsByTagName("marker");

        // 기존 마커 모두 삭제
        for (var i = 0; i < markerNodes.length; i++) {
            var address = markerNodes[i].getAttribute("address");
            var store = markerNodes[i].getAttribute("name");
            var note = markerNodes[i].getAttribute("note");
            var lat = markerNodes[i].getAttribute("lat");
            var lon = markerNodes[i].getAttribute("lon");

            fn_createMarker(address, store, note, lat,lon);
        } // end for
    });
}
var index =1;
function fn_createMarker(address, store, note, lat, lon) {
    var latlng = new google.maps.LatLng(lat,lon);
    var marker = new google.maps.Marker({
        map: map,
        draggable:false,
        animation: google.maps.Animation.DROP,
        position: latlng,
        title: store+"<br>"+address
    });
    markers.push(marker);
    var infowindow = new google.maps.InfoWindow({
        content: store
    });
   // infowindow.open(map,marker);
    google.maps.event.addListener(marker, 'click', function() {   infowindow.open(map,marker); });
}

function downloadUrl(url, callback) { // 동기식
    var request = window.ActiveXObject ?
        new ActiveXObject('Microsoft.XMLHTTP') :
        new XMLHttpRequest;
    request.open('GET', url, false);
    request.send(null);
    callback(request.responseText, request.status);
}
function parseXml(str) {
    if (window.ActiveXObject) {
        var doc = new ActiveXObject('Microsoft.XMLDOM');
        doc.loadXML(str);
        return doc;
    } else if (window.DOMParser) {
        return (new DOMParser).parseFromString(str, 'text/xml');
    }
}

function clearObjects() {
    for (var i = 0; i < markers.length; i++) {
        markers[i].setMap(null);
    }
    markers.length = 0;

    for (var i = 0; i < infowindows.length; i++) {
        infowindows[i].close();
    }
    infowindows.length = 0;
}
function detectBrowser() {
    var useragent = navigator.userAgent;
    var mapdiv = document.getElementById("map_canvas");

  //  if(useragent.indexOf('Android') != -1){
     //   alert("위치추적에 동의하시면 자신의 위치를 보실수있습니다.");
    //}

    if (useragent.indexOf('iPhone') != -1 || useragent.indexOf('Android') != -1 ) {
        mapdiv.style.width = '400px';
        mapdiv.style.height = '400px';

    } else {
        mapdiv.style.width = '400px';
        mapdiv.style.height = '400px';

    }
}
function trackingLecture(curr_x,curr_y)
{//트렉킹을 위한 위치 이동
    if(isNaN(curr_x))
    {
        alert("현재 위치를 설정하지 않았습니다")
    }
    else{
        window.location.href = "gotofile.html?index=" + curr_x+"?index="+curr_y;
    }
}

