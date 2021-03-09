<!--
    Title : Api Layout 
    Date : 2021.03.09
//-->
@extends('layout/header')
@section('content')
<style>
  /**
  *   Feather icon Size
  */
  .feather-16{
      width: 16px;
      height: 16px;
  }
  .feather-26{
      width: 26px;
      height: 26px;
  }
  .feather-36{
      width: 36px;
      height: 36px;
  }

  .emoticon{
    width:35px;
    height:35px;
    display: inline-block;
    background: no-repeat 50% 50%;
    background-size: contain;
    cursor:pointer;
  }

  .grade01{
    background-image: url('/img/grade01.png');
  }
  .grade02{
    background-image: url('/img/grade02.png');
  }
  .grade03{
    background-image: url('/img/grade03.png');
  }
  .grade04{
    background-image: url('/img/grade04.png');
  }
  .grade05{
    background-image: url('/img/grade05.png');
  }

  .marker_around:before{
    position: absolute;
    top: -12px;
    left: -7px;
    width: 50px;
    height: 50px;
    content: '';
    border-radius: 50em;
}

.bg_grade01:before{
    background-color: rgba(90, 145, 235, 0.3);
}
.bg_grade02:before{
    background-color: rgba(125, 186, 98, 0.3);
}
.bg_grade03:before{
    background-color: rgba(242, 174, 72, 0.3);
}
.bg_grade04:before{
    background-color: rgba(153, 153, 153, 0.3);
}
.bg_grade05:before{
    background-color: rgba(234, 80, 80, 0.3);
}
  
</style>

<div id="map" style="width: 100%; height: 100%; position: relative; overflow: hidden;"></div>

<!-- Script Push -->
@push('scripts')
  <!-- Naver Api Maps Start -->
  <script type="text/javascript" src="https://openapi.map.naver.com/openapi/v3/maps.js?ncpClientId={{ env('NAVER_MAPS_CLIENT_ID') }}&submodules=geocode"></script>
  <script>
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

    // Create Marker 
    @foreach( $marker as $stationName => $datas )
      addMarker({{ $datas['dmX'] }}, {{ $datas['dmY'] }}, 'grade01');
    @endforeach
    
    // var marker = new naver.maps.Marker({
    //   position: new naver.maps.LatLng(37.572025, 127.005028),
    //   //position: new naver.maps.TransCoord.fromUTMKToTM128(189732.07095, 443575.073582),
    //   map: map
    // });
    
  </script>
  <!-- Naver Api Maps End -->
@endpush

@endsection 