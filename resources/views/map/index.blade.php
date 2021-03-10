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

  .grade01 .emoticon{
    background-image: url('/img/grade01.png');
  }
  .grade02 .emoticon{
    background-image: url('/img/grade02.png');
  }
  .grade03 .emoticon{
    background-image: url('/img/grade03.png');
  }
  .grade04 .emoticon{
    background-image: url('/img/grade04.png');
  }
  .grade05 .emoticon{
    background-image: url('/img/grade05.png');
  }

  .marker {
    display: inline-block;
    width: 27px;
    height: 27px;
    margin-top: 12px;
    padding: 3px;
    line-height: 0;
    border-radius: 100em;
    background-color: rgba(90, 145, 235);
    z-index: 999;
  }

  .marker:after {
    /* position: absolute;
    z-index: -1;
    bottom: -2px;
    left: 50%;
    width: 0;
    height: 0;
    margin-left: -4px;
    border-top: 8px solid #3083E8;
    border-right: 4px solid transparent;
    border-left: 4px solid transparent;
    content: ''; */
  }

  .marker_pop {
    position: absolute;
    overflow: visible; 
    box-sizing: content-box !important; 
    display: inline-block;
    width: 150px;
    height: 50px;
    margin-top: -20px;
    margin-left: -95px;
    padding: 5px;
    line-height: 0;
    border-radius: 0.5em;
    z-index: 10;
    background-color: red;
  }

  .marker_pop:after {
    display:none;
    position: absolute;
    z-index: -1;
    bottom: -1px;
    left: 50%;
    top: 60px;
    width: 0;
    height: 0;
    margin-left: -4px;
    border-top: 8px solid #3083E8;
    border-right: 4px solid transparent;
    border-left: 4px solid transparent;
    content: '';
  }

  .marker_pop.emoticon:after {
    width:50px;
    height:50px;
  }

  .emoticon{
    width:23px;
    height:23px;
    margin-top: -1px;
    margin-left: -1px;
    display: inline-block;
    background: no-repeat 50% 50%;
    background-size: contain;
    cursor:pointer;
    z-index:-1;
  }
  

  .marker_around:before{
    position: absolute;
    display: inline-block;
    top: 5px;
    left: -6px;
    width: 40px;
    height: 40px;
    content: '';
    border-radius: 100em;
    z-index:-1;

    /*Long Ractangle
    position: absolute;
    display: inline-block;
    top: 9px;
    left: -7px;
    width: 55px;
    height: 32px;
    content: '';
    border-radius: 50em;
    z-index:999; */
  }

  .marker.grade01{
    background-color: rgba(90, 145, 235);
  }
  .marker.grade02{
    background-color: rgba(125, 186, 98);
  }
  .marker.grade03{
    background-color: rgba(234, 80, 80);
  }
  .marker.grade04{
    background-color: rgba(242, 174, 72);
  }
  .marker.grade05{
    background-color: rgba(153, 153, 153);
  }
  
  .bg_grade01{
    background-color: rgba(90, 145, 235, 0.6);
  }
  .bg_grade02{
    background-color: rgba(125, 186, 98, 0.6);
  }
  .bg_grade03{
    background-color: rgba(234, 80, 80, 0.6);
  }
  .bg_grade04{
    background-color: rgba(242, 174, 72, 0.6);    
  }
  .bg_grade05{
    background-color: rgba(153, 153, 153, 0.6);
  }
  
  .bg_grade:before{
    background-color: rgba(255, 255, 255, 0.3);
  }
  .bg_grade01:before{
    background-color: rgba(90, 145, 235, 0.3);
  }
  .bg_grade02:before{
    background-color: rgba(125, 186, 98, 0.3);
  }
  .bg_grade03:before{
    background-color: rgba(234, 80, 80, 0.3);
  }
  .bg_grade04:before{
    background-color: rgba(242, 174, 72, 0.3);    
  }
  .bg_grade05:before{
    background-color: rgba(153, 153, 153, 0.3);
  }

  .max_zindex{
    z-index:999;
    display:inline-block;
  }

  .marker_back{
    position: absolute;
    display:none;
    font-size: 0.68rem;
    margin-top: -12px;
    margin-left: -16px;
    color:#ffffff;
  }

</style>
<div id="map" class="map" style="width: 100%; height: 100%; position: relative;">
  <div style="display:inline-block; position: relative; width:20%; z-index: 1; margin-top:60px; bottom:0px; right:10px; float:right;">
    <div id="markerDetail" class="alert alert-success d-none" role="alert" >
      <h4 class="alert-heading">Well done!</h4>
      <p>Aww yeah, you successfully read this important alert message.</p>
    </div>
  </div>
</div>

<!-- Script Push -->
@push('scripts')
  <!-- Naver Api Maps Start -->
  <script type="text/javascript" src="https://openapi.map.naver.com/openapi/v3/maps.js?ncpClientId={{ env('NAVER_MAPS_CLIENT_ID') }}&submodules=geocode"></script>
  <script src="{{ mix('/js/map.js') }}"></script>
  <!-- <script src="/js/MAP.js"></script> -->
  <script>
    // Create Marker 
    @foreach( $marker as $stationName => $datas )
      @if( $datas['mesure_pm10'] == '-')
      {{ $datas['mesure_pm10'] = 0 }}
      @endif 
      @if( $datas['mesure_pm25'] == '-')
        {{ $datas['mesure_pm25'] = 0 }}
      @endif
      addMarker({{ $datas['dmX'] }}, {{ $datas['dmY'] }}, 'grade02', {{ $datas['mesure_pm10'] ?? 0 }}, {{ $datas['mesure_pm25'] ?? 0 }});
    @endforeach
  </script>
  <!-- Naver Api Maps End -->
@endpush

@endsection 