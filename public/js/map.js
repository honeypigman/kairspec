$(document).ready(function(){$(".marker").hover(function(){var a=$(this).data("grade");$(this).addClass("bg_grade"),$(this).find("span.marker_back").css("display","inline-block"),$("#markerDetail").removeClass("d-none"),$("#markerDetail").addClass("d-block"),$("#markerDetail").addClass("bg_"+a)},function(){var a=$(this).data("grade");$(this).removeClass("bg_grade"),$("#markerDetail").removeClass("d-block"),$("#markerDetail").addClass("d-none"),$("#markerDetail").removeClass("bg_"+a)})});var initWhich=new naver.maps.LatLng(37.572025,127.005028),mapDiv=document.getElementById("map"),map=new naver.maps.Map(mapDiv,{center:initWhich,content:'<div class="alert alert-primary" role="alert">A simple primary alert—check it out!</div>',zoom:1});function addMarker(a,e,n,r=0,s=0){var t={position:new naver.maps.LatLng(a,e),icon:{content:'<span class="marker '+n+' marker_around" data-grade="'+n+'"><span class="emoticon"></span><span class="stationName"></span></span>',size:new naver.maps.Size(27,34),origin:new naver.maps.Point(0,0),anchor:new naver.maps.Point(11,34)}},i=new naver.maps.Marker(t);i.setMap(map),naver.maps.Event.addListener(i,"click",function(){var a=0,e=map.getZoom();a=e<12?12-e:5-e,map.zoomBy(a,i.getPosition(),!0)})}
