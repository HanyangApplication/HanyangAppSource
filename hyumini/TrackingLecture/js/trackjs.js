/**
 * Created by Lak on 2016. 6. 3..
 *	Author: Hyunglak Kim
 *
 *	@Description
 *	사용자가 직접 클릭을 해서 자신의 좌표를 지정하고, 각 건물의 위치검색과 지도검색이 가능하게 만들어 졌다 
 *
 *  @Function
 *
 *  initialize(): 구글지도를 가져오기위한 초기화
 *  detectBrowser(): 사용자의 폰크기에 맞도록 모바일 OS를 감지하여 화면 사이즈 조절
 *  PickMap(): 현재 위치를 지도상에서 클릭하여 나타낼 수 있도록한 함수
 *  Search_Map(): 지도 검색을 하 수 있도록 제공하는 함수
 *  fn_drawObjects(): XmL데이터를 가져와서 1, 2, 3 공학관을 표시할 좌표 생성
 *  fn_createMarker(address, store, note, lat, lon): 각 좌표에 맞도록 맵에 포인트 생성
 *  trackingLecture(): 최단거리를 알고자 할때 사용
 *  clearObjects(): 맵의 모든 정보를 없에는 역활
 *  parseXml(str): MxL형태의 데이터를 가져오는 함수
 *  downloadUrl(url, callback) :XML형태의 데이터를 가져오기 위한 함수
 *
 */
var geocoder;

var map;
var markers = [];
var infowindows = [];
var image = 'image/flag.png';
var curr_x;//현재 위도와 경도를 넘겨주기 위한 변수
var curr_y;
var MarkerCount=5;
var good="";


//초기 구글지도를 뛰우주기 위한 함수
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

    getSID();
    console.log(good);
    fn_drawObjects(); // 주요 빌딩목록을 표시한다.
    //Curr_Position(); // 현재 위치를 나타낸다
    PickMap(); //사용자 본인의 좌표를 찍어준다
    Search_Map(); //사용자가 건물 검색을 할 수 있도록 제공
    return false;

}
google.maps.event.addDomListener(window, 'load', initialize);

function getSID()
{
    $.ajax({
        url: "http://selab.hanyang.ac.kr/hyumini/session.php",
        type: 'get',
        async: false,
        success: function (data) {
            console.log('성공 - ', data);
            if (data != null) {
                var obj = JSON.stringify(data);
                var st = JSON.parse(obj);
                console.log(st.studentInfo.SID);
                console.log(st.studentInfo);
                $("#getName").css("border","1px solid blue").text(st.studentInfo.name+"님의 강의실 목록");
                good = String(st.studentInfo.SID);
            }
        },
        error: function (xhr) {
            alert("로그인정보가 없습니다");
            window.location.href = "http://selab.hanyang.ac.kr/hyumini/login/login.html";
        }
    });

}

//사용자가 맵위에 자신의 좌표를 찍을 수 있도록
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
        alert("GPS정보를 가져올 수 없습니다.");

    }
}
//사용자가 현재 맵에서 건물을 검색할 수 있도록 하는 함수
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

function fn_drawObjects() { //기본적인 제1공학관, 제2공학관 , 제 3공학관을 지도상에 나타내기 위해 위도와 경도를 불러오는 함수

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
//마커정보를 가져와서 실제 구글지도에 뿌려주는 부분
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

//MXL형태의 데이터를 가져오기 위한 함수
function downloadUrl(url, callback) { // 동기식
    var request = window.ActiveXObject ?
        new ActiveXObject('Microsoft.XMLHTTP') :
        new XMLHttpRequest;
    request.open('GET', url, false);
    request.send(null);
    callback(request.responseText, request.status);
}

//MXL형태의 데이터를 가져오기 위한 함수
function parseXml(str) {
    if (window.ActiveXObject) {
        var doc = new ActiveXObject('Microsoft.XMLDOM');
        doc.loadXML(str);
        return doc;
    } else if (window.DOMParser) {
        return (new DOMParser).parseFromString(str, 'text/xml');
    }
}

function clearObjects() { //지도상의 자표를 없에기 위해서
    for (var i = 0; i < markers.length; i++) {
        markers[i].setMap(null);
    }
    markers.length = 0;

    for (var i = 0; i < infowindows.length; i++) {
        infowindows[i].close();
    }
    infowindows.length = 0;
}
function detectBrowser() { //현재 브라우져에 맞게 맵 크기를 조절하기 위해서
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
function trackingLecture(curr_x,curr_y) //자신의 좌표를 다른 파일에 보내기 위한 함수
{//트렉킹을 위한 위치 이동
    if(isNaN(curr_x))
    {
        alert("현재 위치를 설정하지 않았습니다")
    }
    else{
        
        window.location.href = "./gotofile.html?index=" + curr_x+"?index="+curr_y+"?index="+good;
    }
}

