$(document).ready(function(){

    // Marker
    $(".marker").parent('div').on('mouseover', function(){
        $(this).css("z-index", "999");
    });
    $(".marker").parent('div').on('mouseleave', function(){
        $(this).css("z-index", "-1");
    });

    $(".marker").hover(function(){
        eventMarkerInfo($(this));
    });

    $(".marker").on('click', function(){
        eventMarkerInfo($(this));
    });

    // Find Me
    let click=false;
    $("#find-me").on("click",function(){
        
        //if(!click)
        {
            click=true;
            var spinnerBtn= "<div class='spinner-border spinner-border-sm img-center' role='status'><span class='visually-hidden'>Loading...</span></div> ";
            $(this).append(spinnerBtn);
            $(this).css('background-image', 'url("")');
            
            findStation();            
        }
    });
});

var initPoint = new naver.maps.LatLng(37.572025, 127.005028);
var mapDiv = document.getElementById('map');
var map = new naver.maps.Map(mapDiv, {
    center: initPoint,
    zoom: 5
});

function eventMarkerInfo(selector){
    var date = $(selector).find('span.date').data('date');
    var grade = $(selector).data('grade');
    var msg = $(selector).find('span.msg').data('msg');
    var pm10 = $(selector).find('span.pm10').data('pm10');
    var pm25 = $(selector).find('span.pm25').data('pm25');
    var city = $(selector).find('span.city').data('city');
    var stationName = $(selector).find('span.station').data('station');

    $(selector).find('span.marker-bg').addClass('bg_'+grade);
    $("#markerDetail").removeClass();
    $("#markerDetail").addClass('alert alert-success d-block');
    $("#markerDetail").addClass('bg_'+grade);
    
    // Set station Content
    $("#msg").empty().text(msg);
    $("#pm10").empty().text(pm10);
    $("#pm25").empty().text(pm25);
    $("#city").empty().text(city);
    $("#stationName").empty().text(stationName);
    $("#emoticonDetail").attr('src', '/img/'+grade+'.png');

    // Set Chart
    setChartStationTimeFlow(date, city, stationName);    
}


function addMarker(grade, msg, date, x, y, pm10=0, pm25=0, city, station){
    var icon = 'grade'+grade;
    var position = new naver.maps.LatLng(x, y);
    var markerOptions = // new naver.maps.Marker(
    {
        position: position,
        icon: 
        {
            content: '<span class="marker '+icon+'" data-grade="'+icon+'">'
                    +'<span class="emoticon"></span>'
                    +'<span class="pm10" data-pm10="'+pm10+'"></span><span class="pm25" data-pm25="'+pm25+'"></span><span class="station" data-station="'+station+'"></span><span class="city" data-city="'+city+'"></span><span class="msg" data-msg="'+msg+'"></span><span class="date" data-date="'+date+'"></span>'
                    +'<span class="marker-bg"></sapn>'
                    +'</span>',
            size: new naver.maps.Size(27, 34),
            origin: new naver.maps.Point(0, 0),
            anchor: new naver.maps.Point(11, 34)
        }
    };
    
    // Marker Zoom-In
    var marker = new naver.maps.Marker(markerOptions);
    marker.setMap(map);

    naver.maps.Event.addListener(marker, 'click', function() {        
        zoomIn(position);
    });
}

function zoomIn(position){
    var delta = 0,
        zoom = map.getZoom();

    delta = 13 - zoom;
    map.zoomBy(delta, position, true);
}

function setChartStationTimeFlow(date, city, station){
    let obj_label = [];
    let obj_pm10 = [];
    let obj_pm25 = [];
    let setDate = date.substring(0,10);

    // Get Time Info
    $.ajax({
        method:"GET",
        url:"/api/find/station/timeflow/"+setDate+"/"+city+"/"+station,
        dataType : 'JSON',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success : function(rs){
            var jsonStringify = JSON.stringify(rs);
            
            $.each(rs, function(){
                obj_label.push((this.time).substring(0.2));
                obj_pm10.push(this['data']['pm10']);
                obj_pm25.push(this['data']['pm25']);
            });

            // Set Chart
            var lineChartData = {
                labels: obj_label,
                datasets: [{
                    label: '미세먼지',
                    borderColor: 'rgba(255, 206, 86)',
				    backgroundColor: 'rgba(255, 206, 86)',
                    fill: false,
                    data: obj_pm10,
                    yAxisID: 'y-axis-1',
                }, {
                    label: '초미세먼지',
                    borderColor: 'rgba(255, 99, 132)',
				    backgroundColor: 'rgba(255, 99, 132)',
                    fill: false,
                    data: obj_pm25,
                    yAxisID: 'y-axis-2'
                }]
            };
            var ctx = document.getElementById('myChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'line',
                data: lineChartData,
                // {
                //     labels: obj_label,
                //     datasets: [{
                //         label: '미세먼지',
                //         borderColor: window.chartColors.red,
                //         backgroundColor: window.chartColors.red,        
                //         data: obj_pm10,
                //         // pointBackgroundColor: [
                //         //     'rgba(255, 99, 132)',
                //         //     'rgba(54, 162, 235)',
                //         //     'rgba(255, 206, 86)',
                //         //     'rgba(75, 192, 192)',
                //         //     'rgba(153, 102, 255)',
                //         //     'rgba(255, 159, 64)'
                //         // ],
                //         borderWidth: 1
                //     }]
                // },
                options: {
                    responsive: true,
					hoverMode: 'index',
					stacked: false,
                    title: {
						display: true,
						text: date
					},
                    scales: {
						yAxes: [{
							type: 'linear', // only linear but allow scale type registration. This allows extensions to exist solely for log scale for instance
							display: true,
							position: 'left',
							id: 'y-axis-1',
						}, {
							type: 'linear', // only linear but allow scale type registration. This allows extensions to exist solely for log scale for instance
							display: true,
							position: 'right',
							id: 'y-axis-2',

							// grid line settings
							gridLines: {
								drawOnChartArea: false, // only want the grid lines for one axis to show up
							},
						}],
					}
                }
            });

        },
        error : function(error){
            console.log('Error>'+error);
        }
    });    

}

function findStation()
{
    function success(position) {
        const x  = position.coords.latitude;
        const y = position.coords.longitude;

        // MongoDB - 비교(Comparison) 연산자
        // operator	설명
        // $eq	(equals) 주어진 값과 일치하는 값
        // $gt	(greater than) 주어진 값보다 큰 값
        // $gte	(greather than or equals) 주어진 값보다 크거나 같은 값
        // $lt	(less than) 주어진 값보다 작은 값
        // $lte	(less than or equals) 주어진 값보다 작거나 같은 값
        // $ne	(not equal) 주어진 값과 일치하지 않는 값
        // $in	주어진 배열 안에 속하는 값
        // $nin	주어빈 배열 안{{에 속하지 않는 값

        // db.KairspecApiMsrstnAll.find({'dmX':{$eq:'37.544656'}, 'dmY':{$eq:'126.835094'} ,'today':'2021-03-14'}).pretty()
        // db.KairspecApiMsrstnAll.find( { $and: [ {'dmX':{$lte:'37.546362099999996'}}, {'dmY':{$lte:'126.86998949999999'}}, {'today':'2021-03-14'} ] } ).pretty()
        // db.KairspecApiMsrstnAll.findOne( { $and: [ {'dmX':{$lte:'37.95994899497005'}}, {'dmY':{$lte:'124.72368552268148'}}, {'today':'2021-03-14'} ] } )

        // Spinner
        $("#find-me").text('');
        $("#find-me").css('background-image', 'url("/img/point.png")');
        
        $.ajax({
            method:"GET",
            url:"/api/find/station/"+x+"/"+y,
            dataType : 'JSON',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success : function(rs){
                //var jsonStringify = JSON.stringify(rs);
                
                var date = rs.mesure_date;
                var grade = rs.grade;
                var msg = rs.msg;
                var city = rs.city;
                var stationName = rs.stationName;
                var pm10 = rs.mesure_pm10;
                var pm25 = rs.mesure_pm25;
                
                // Set Marker Detail
                $("#markerDetail").removeClass();
                $("#markerDetail").addClass('alert alert-success d-block');
                $("#markerDetail").addClass('bg_grade'+grade);
                
                // Set station Content
                $("#msg").empty().text(msg);
                $("#pm10").empty().text(pm10);
                $("#pm25").empty().text(pm25);
                $("#city").empty().text(city);
                $("#stationName").empty().text(stationName);
                $("#emoticonDetail").attr('src', '/img/grade'+grade+'.png');

                setChartStationTimeFlow(date, city, stationName)

                // Auto Zoom
                zoomIn(new naver.maps.LatLng(rs.dmX, rs.dmY));

                click = true;
            },
            error : function(error){
                console.log('Error>'+error);
                click=false;
            }
        });
    }        
    function error() {
        alert('ERR>Unable to retrieve your location.');
        click=false;
    }

    if(navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(success, error);
    }
}