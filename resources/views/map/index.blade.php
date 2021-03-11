<!--
    Title : Api Layout 
    Date : 2021.03.09
//-->
@extends('layout/header')
@section('content')
<div id="map" class="map" style="width: 100%; height: 100%; position: relative;">
  <div style="display:inline-block; position: relative; width:230px; z-index: 1; margin-top:60px; bottom:0px; right:10px; float:right;">
    <div id="markerDetail" class="alert alert-success d-none" role="alert" >
      <h4 class="alert-heading" id="stationName">[측정소명]</h4>
        <div class="text-center">
          <h5>
            <span class="badge bg-light text-dark w-100 mb-2" id="msg">[메세지]</span>
            <!-- <button type="button" class="btn btn-outline-light w-100" id="msg">[메세지]</button> -->
          </h5>
        </div>
        <div class="row">
          <div class="col-9">
            <div class='text-start'>미세먼지 : <span id="pm10">[미세먼지]</span> ㎍/m³</div>
            <div class='text-start'>초미세먼지 : <span id="pm25">[초미세먼지]</span> ㎍/m³</div>
          </div>
          <div class="col-3" style="margin-top:-8px; margin-left:-20px;">
            <img id="emoticonDetail" src='/img/grade0.png'>
          </div>
        </div>
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
      //var content = "<div class='text-start'>미세먼지 : {{ $datas['mesure_pm10'] }} ㎍/m³</div><div class='text-start'>초미세먼지 : {{ $datas['mesure_pm25']}} ㎍/m³</div>";
      // 마커 생성
      // param[1] : 아이콘
      // param[2] : X좌표
      // param[3] : Y좌표
      // param[4] : 미세먼지 농도
      // param[5] : 초미세먼지 농도
      // param[6] : 측정소명칭
      // param[7] : 측정소정보 뷰
      addMarker({{ $datas['grade'] }}, '{{ $datas['msg'] }}', '{{ $datas['mesure_date'] }}', {{ $datas['dmX'] }}, {{ $datas['dmY'] }}, '{{ $datas['mesure_pm10'] }}', '{{ $datas['mesure_pm25'] }}', '{{ "[".$datas['city']."] ".$stationName }}');

    @endforeach
  </script>
  <!-- Naver Api Maps End -->
@endpush

@endsection 