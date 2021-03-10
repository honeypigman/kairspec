$(document).ready(function(){
    $(".marker").hover(function(){
        var grade = $(this).data('grade');
        $(this).addClass('bg_grade');
        $(this).find('span.marker_back').css('display', 'inline-block');
        $("#markerDetail").removeClass('d-none');
        $("#markerDetail").addClass('d-block');
        $("#markerDetail").addClass('bg_'+grade);
    }, function(){
        var grade = $(this).data('grade');
        $(this).removeClass('bg_grade');
        $("#markerDetail").removeClass('d-block');
        $("#markerDetail").addClass('d-none');
        $("#markerDetail").removeClass('bg_'+grade);
    });
});

var initWhich = new naver.maps.LatLng(37.572025, 127.005028);
var mapDiv = document.getElementById('map');
var map = new naver.maps.Map(mapDiv, {
    center: initWhich,
    content: '<div class="alert alert-primary" role="alert">A simple primary alert—check it out!</div>',
    zoom: 1
});


function addMarker(x, y, icon, pm10=0, pm25=0) 
{
    var position = new naver.maps.LatLng(x, y);
    var markerOptions = // new naver.maps.Marker(
    {
        position: position,
        icon: 
        {
            //url: '/img/'+icon+'.png',
            //content: '<span class="emoticon '+icon+'" data-grade="'+icon+'"></span>',
            //content: '<span class="marker '+icon+' marker_around" data-grade="'+icon+'"><span class="emoticon"></span></span> <span class="marker_pop '+icon+' data-grade="'+icon+'"><span class="emoticon"></span></span>',
            //content: '<span class="marker '+icon+'" data-grade="'+icon+'"><span class="emoticon"></span></span> <span class="marker_pop '+icon+' data-grade="'+icon+'"><span class="emoticon"></span></span>',
            //content: '<span class="marker '+icon+' marker_around" data-grade="'+icon+'"><span class="emoticon"></span><span class="marker_back">'+pm10+'/'+pm25+'</span></span>',
            content: '<span class="marker '+icon+' marker_around" data-grade="'+icon+'"><span class="emoticon"></span><span class="stationName"></span></span>',
            size: new naver.maps.Size(27, 34),
            origin: new naver.maps.Point(0, 0),
            anchor: new naver.maps.Point(11, 34)
        }
    };
    
    var marker = new naver.maps.Marker(markerOptions);
    marker.setMap(map);

    // Marker Zoom-InOut
    naver.maps.Event.addListener(marker, 'click', function() {
        var delta = 0,
            zoom = map.getZoom();

        if (zoom < 12) {
            delta = 12 - zoom;
        } else {
            delta = 5 - zoom;
        }

        map.zoomBy(delta, marker.getPosition(), true);
    });
}