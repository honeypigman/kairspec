$(document).ready(function(){
  $(".emoticon").hover(function(){
      var grade = $(this).data('grade');
      $(this).addClass('marker_around');
      $(this).addClass('bg_'+grade);
      
  }, function(){
      var grade = $(this).data('grade');
      $(this).removeClass('marker_around');
      $(this).removeClass('bg_'+grade);
  });
});


var mapDiv = document.getElementById('map');

var map = new naver.maps.Map(mapDiv, {
center: new naver.maps.LatLng(37.572025, 127.005028),
zoom: 1
});
// var jeju = new naver.maps.LatLng(33.3590628, 126.534361),
// busan = new naver.maps.LatLng(35.1797865, 129.0750194),
// dokdo = new naver.maps.LatLngBounds(
//             new naver.maps.LatLng(37.2380651, 131.8562652),
//             new naver.maps.LatLng(37.2444436, 131.8786475)),
// seoul = new naver.maps.LatLngBounds(
//             new naver.maps.LatLng(37.42829747263545, 126.76620435615891),
//             new naver.maps.LatLng(37.7010174173061, 127.18379493229875));
// map.panToBounds(dokdo);

function addMarker(y, x, icon) 
{
var position = new naver.maps.LatLng(y, x);
var markerOptions = // new naver.maps.Marker(
    {
        position: position,
        icon: 
        {
            //url: '/img/'+icon+'.png',
            content: '<span class="emoticon '+icon+'" data-grade="'+icon+'"></span>',
            size: new naver.maps.Size(27, 34),
            origin: new naver.maps.Point(0, 0),
            anchor: new naver.maps.Point(11, 34)
        }
    };
    
    var marker = new naver.maps.Marker(markerOptions);
    marker.setMap(map);

}