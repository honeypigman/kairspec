<!--
    Title : Api Layout 
    Date : 2021.03.09
//-->
<!--
    Title : Header Layout 
    Date : 2020.12.30
//-->
<!doctype html>
<html lang="ko">
  <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>{{ env('APP_NAME') }}</title>
    <script src="/js/jquery.min.js"></script>
    <link href="{{ mix('/css/common.css') }}" rel="stylesheet">
    <link href="{{ mix('/css/map.css') }}" rel="stylesheet">
</header>
<body class="text-center">

  <div class="alert alert-warning notice" role="alert">
    <div>데이터출처 : 한국환경공단에서 제공하는 대기오염정보 입니다.</div>
  </div>

  <div class="option-bar">  
    <!-- 현재위치 -->
    <div id="find-me"></div>
  </div>

  <div id="map" class="map">
    <div class="markerDetail"></div>
  </div>

  <div class="serach-bar">
    <input type="text" class="form-control" id="address" placeholder='장소를 입력해주세요'>
    <span class="input-group-text" id="submit">검색</span>
  </div>

  <script src="/js/script.js"></script>
  <script src="/js/jquery.ui.min.js"></script>
  <script src="/js/bootstrap.min.js"></script>
  <script src="/js/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script>
  <!-- Naver Api Maps Start -->
  <script type="text/javascript" src="https://openapi.map.naver.com/openapi/v3/maps.js?ncpClientId={{ env('NAVER_MAPS_CLIENT_ID') }}&submodules=geocoder"></script>
  <script src="{{ mix('/js/map.js') }}"></script>
  <!-- <script src="/js/MAP.js"></script> -->
  <script>
    // Create Marker 
    @foreach( $marker as $stationName => $datas )
      //var content = "<div class='text-start'>미세먼지 : {{ $datas['mesure_pm10'] }} ㎍/m³</div><div class='text-start'>초미세먼지 : {{ $datas['mesure_pm25']}} ㎍/m³</div>";
      // 마커 생성
      // param[1] : 등급
      // param[2] : 메세지
      // param[3] : 측정일
      // param[4] : 경도
      // param[5] : 위도
      // param[6] : 미세먼지 농도
      // param[7] : 초미세먼지 농도
      // param[8] : 시도명
      // param[9] : 측정소명
      addMarker({{ $datas['grade'] }}, '{{ $datas['msg'] }}', '{{ $datas['mesure_date'] }}', {{ $datas['dmX'] }}, {{ $datas['dmY'] }}, '{{ $datas['mesure_pm10'] }}', '{{ $datas['mesure_pm25'] }}', '{{ $datas['city'] }}', '{{ $stationName }}');
    @endforeach
  </script>
  <!-- Naver Api Maps End -->
</body>
</html>