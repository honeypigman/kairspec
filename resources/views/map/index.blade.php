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
  <script src="/js/map.js"></script>
  <script>
    // Create Marker 
    @foreach( $marker as $stationName => $datas )
      addMarker({{ $datas['dmX'] }}, {{ $datas['dmY'] }}, 'grade01');
    @endforeach
  </script>
  <!-- Naver Api Maps End -->
@endpush

@endsection 