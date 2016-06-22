/**
 * Created by Lak on 2016. 6. 3..
 */

var Point=[]; //0번쨰 위도, 1번째 경도
//현 위치에서 1, 3, 4공학관의 문의 위치를 설정하는 배열

var str="";
//현재 사용자 위치의 자표를 가져와서 데이터로 변환하는 함수
function getIndex(sParam){
    var sPageURL = window.location.search.substring(1);
    var sURLVariables = sPageURL.split('?');
    var count=0;
    for (var i = 0; i < sURLVariables.length; i++)
    {
        var sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] == sParam)
        {
            Point[count++]=sParameterName[1];
        }
    }
}
getIndex("index");
console.log(Point[0]+"   "+Point[1]);


var lectrueInfo = []; //데이터 베이스에서 사용자의 정보를 가져오는 변수
var Lecture =[]; // 강의실 번호를 가져오는 변수
//"http://selab.hanyang.ac.kr/hyumini/TrackingLecture/test.php"

//
function GetLectureData(){
    $.ajax({
        url: "http://selab.hanyang.ac.kr/hyumini/TrackingLecture/test.php",
        dataType: "jsonp",
        jsonpCallback: 'callback',
        type: 'get',
        success: function(data) {
            console.log('성공 - ', data);
            if(data != null)    {
                for(var i=0; i<data.length;i++)
                {
                    var flags=true;
                    lectrueInfo=data[i].classroom.split('-');
                    Lecture[i] = lectrueInfo[1];//강의 정보에서 정확한 호수를 알기 위해서
                    Lecture[i] = Lecture[i].slice(1,4)+"호";
                    for(var j=0;j<i; j++)
                    {
                        if(Lecture[i]==Lecture[j])
                        {
                            flags = false;
                        }
                    }
                    if(flags == true)
                    {
                        Create(Lecture[i]);
                    }

                }
            }
        },
        error: function(xhr) {
            console.log('실패 - ', xhr);
        }
    });
}


GetLectureData();

// 동적으로 강의실 버튼을 생성해주는 function
function Create(lectureinfo)
{
    //DV.innerHTML= lectureinfo;
    var btnObj= document.createElement("input");
    btnObj.type = "button";
    btnObj.value = lectureinfo;
    btnObj.style.cursor = "hand";
    btnObj.style.with = "80px";
    btnObj.style.width = "120px";
    btnObj.style.background ="#35B62C";
    btnObj.onclick = resultLecture;
    DV1.appendChild(btnObj);
}
function resultLecture()
{// 최단거리 나오는
    var LectureName = this.value;
    var sd =LectureName.slice(0,3);// 강의실
    var sj =LectureName.slice(0,1);//층

    $("#get").css("border","1px solid blue").text(LectureName);
    $("#get1").css("border","1px solid blue").text(shortPath(sd, sj));

}
function shortPath(LectureName, floor){
    var EngineeringBuilding = [
        [775,690,11], //1공 게스트하우스 방향 문
        [769,670,12], //1공 구름 사다리 문
        [761,649,31], //3공 구름 사다리 문
        [736,590,32], //3공 도서관 쪽 문
        [710,600,41] //4공 도서관 쪽 문
    ];
    var x = Point[0].toString();
    var y = Point[1].toString();
    x=x.slice(5,8);
    y=y.slice(6,9);
    console.log(x+"and"+y);
    var result=[];
    var arr = [];
    var cnt = 0;
    var PositionEng = [];
    SearchRoom(LectureName, arr);
    console.log(arr[0]+"    "+arr[1]);
    var getCount = String(arr[0]).slice(0,1);
    console.log(getCount);

    for(var i=0 ; i < EngineeringBuilding.length; i++)
    {
        if(String(EngineeringBuilding[i][2]).slice(0,1)==getCount)
        {
                var Dx = EngineeringBuilding[i][0];
                var Dy = EngineeringBuilding[i][1];
                result[cnt++] = Number(Math.sqrt(Math.pow(Math.abs(x - Dx), 2) + Math.pow(Math.abs(y - Dy), 2)).toFixed(0));//두 좌표 거리 계산(피타고라스)
                console.log(result[cnt-1] + "\n");
                PositionEng[cnt] = EngineeringBuilding[i][2];
        }
    }

    if(getCount !=4)
    {
        if(result[0] > result[1])
        {
            result[0] = result[1];
            PositionEng[1] = PositionEng[2];
        }
    }

    console.log("최단거리는"+result[0]+"입니다.");
    console.log("최단거리의 빌딩은"+PositionEng[1]+"입니다.");
    makeImage(PositionEng[1]);
    var str="";

    for(var i=0 ; i < PositionPS.length; i++)
    {
        if(PositionEng[1] == PositionPS[i][0])
        {
            str = PositionPS[i][1];
            if(PositionPS[i][1]==12||PositionPS[i][1]==31||PositionPS[i][1]==32)
            {
                str = "최단거리는"+str+"\n"+"계단으로 올라와 "+floor+"층에서 "+arr[1]+"으로 이동합니다.";
            }
            else{
                str = "최단거리는"+str+"\n"+floor+"층에서 내려 "+arr[1]+"으로 이동합니다.";
            }
            break;
        }
    }

    console.log(str);
    return str;


}
function SearchRoom(LectureName, arr)
{
    for(var i = 0; i < LectureRoomNo.length; i++)
    {
        if(LectureName == LectureRoomNo[i][1])
        {
            arr[0]=LectureRoomNo[i][0];
            arr[1]=LectureRoomNo[i][2];
            return arr;
        }
    }

}
var cnt = 0;
function  makeImage(NumImage) {

    if(document.getElementById('image').firstChild)
    {
        document.getElementById('image').firstChild.src = 'image/' + NumImage.toString() + '.png';
    }
    else {
        var img = document.createElement('img');
        img.src = 'image/' + NumImage.toString() + '.png'; // 이미지 경로 설정 (랜덤)
        img.style.cursor = 'pointer'; // 커서 지정
        document.getElementById('image').appendChild(img); // board DIV 에 이미지 동적 추가
    }

}

function getSID()
{
        $.ajax({
            url: "./../session.php",
           // dataType: "json",
            //jsonpCallback: 'callback',
            type: 'get',
            success: function (data) {
                console.log('성공 - ', data);
                if (data != null) {
                    var obj = JSON.stringify(data);
                    var st = JSON.parse(obj);
                    SID = st.studentInfo.SID;
                    console.log(SID);
                }
            },
            error: function (xhr) {
                alert("로그인정보가 없습니다");
            }
        });

}
function newLectureData(){
    $.ajax({
        url: "http://selab.hanyang.ac.kr/hyumini/TrackingLecture/test.php",
        dataType: "jsonp",
        jsonpCallback: 'callback',
        type: 'get',
        
        success: function(data) {
            console.log('성공 - ', data);
            if(data != null)    {
                for(var i=0; i<data.length;i++)
                {
                    var flags=true;
                    lectrueInfo=data[i].classroom.split('-');
                    Lecture[i] = lectrueInfo[1];//강의 정보에서 정확한 호수를 알기 위해서
                    Lecture[i] = Lecture[i].slice(1,4)+"호";
                    for(var j=0;j<i; j++)
                    {
                        if(Lecture[i]==Lecture[j])
                        {
                            flags = false;
                        }
                    }
                    if(flags == true)
                    {
                        Create(Lecture[i]);
                    }

                }
            }
        },
        error: function(xhr) {
            console.log('실패 - ', xhr);
        }
    });
}


