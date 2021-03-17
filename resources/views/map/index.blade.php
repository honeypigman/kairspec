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
    <!-- <link href="{{ mix('/css/map.css') }}" rel="stylesheet"> -->
    <style>
      .map{
        width: 100%; 
        height: 100%; 
        position: relative;
      }
      .marker {
        display: inline-block;
        position: relative;
        width: 27px;
        height: 27px;
        margin-top: 12px;
        padding: 3px;
        line-height: 0;
        border-radius: 100em;
        background-color: rgba(90, 145, 235);
        z-index: 999;
      }

      .marker:hover .marker-bg{
        display:block;
        width:45px;
        height:45px;
        margin-top: -5px;
        margin-left: -4px;
      }

      .marker:hover .emoticon{
        width:32px;
        height:32px;
        margin-top: -7px;
        margin-left: -6px;
        display: inline-block;
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

      .grade0 .emoticon{
        background-image: url('/img/grade0.png');
      }
      .grade1 .emoticon{
        background-image: url('/img/grade1.png');
      }
      .grade2 .emoticon{
        background-image: url('/img/grade2.png');
      }
      .grade3 .emoticon{
        background-image: url('/img/grade3.png');
      }
      .grade4 .emoticon{
        background-image: url('/img/grade4.png');
      }
      .grade5 .emoticon{
        background-image: url('/img/grade5.png');
      }
      .marker.grade0{
        background-color: rgba(153, 153, 153);
      }
      .marker.grade1{
        background-color: rgba(90, 145, 235);
      }
      .marker.grade2{
        background-color: rgba(125, 186, 98);
      }
      .marker.grade3{
        background-color: rgba(242, 174, 72);
      }
      .marker.grade4{
        background-color: rgba(234, 80, 80);
      }
      .marker.grade5{
        background-color: rgba(153, 153, 153);
      }
      .bg_grade0{
        background-color: rgba(153, 153, 153, 0.9);
      }
      .bg_grade1{
        background-color: rgba(90, 145, 235, 0.9);
      }
      .bg_grade2{
        background-color: rgba(125, 186, 98, 0.9);
      }
      .bg_grade3{
        background-color: rgba(242, 174, 72, 0.9);    
      }
      .bg_grade4{
        background-color: rgba(234, 80, 80, 0.9);
      }
      .bg_grade5{
        background-color: rgba(153, 153, 153, 0.9);
      }

      .marker-bg {
        position: absolute;
        width: 38px;
        height: 38px;
        top: -5px;
        left: -6px;
        z-index: -2;
        border-radius: 50%;
        opacity: 0.8;
        display:none;
      }

      .option-bar{
        display:flex;
        float:left;
        margin-left:5px;
      }

      .serach-bar{
        position: absolute;
        display: flex;
        float: right;
        right: 5px;
        bottom: 25px;
      }

      #find-me{
        position:absolute; 
        width:32px; 
        height:32px; 
        background-color:#ffffff;
        z-index: 2; 
        margin-top: 40px;
        border-radius: 0.3em;
        cursor:pointer;
        background-image: url(/img/point.png);
        background-repeat: no-repeat;
        background-position: center center;
      }

      .img-center{
        display: flex;
        justify-content: center;
        margin:8px;
      }

      .notice{
        display:flex;
        justify-content:center;
        position: absolute;
        width: 100%;
        margin-bottom:10px;
        padding: 4px;
        font-size:0.8rem;
        z-index: 10;
      }

      .markerDetail{
        display:inline-block; 
        position: relative; 
        width:230px; 
        z-index: 1; 
        margin-top:40px; 
        bottom:0px; 
        right:5px; 
        float:right;
      }
    </style>
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
    <div class="markerDetail">
      <div id="markerDetail" class="alert alert-success d-none" role="alert" >
          <h4>[<span id="city">[시도명]</span>]<span id="stationName">[측정소명]</span></h4>
          <div class="text-center">
            <h5>
              <span class="badge bg-light text-dark w-100 mb-2" id="msg">[메세지]</span>
            </h5>
          </div>
          <div class="row">
            <div class="col-9">
              <div class='text-start'>미세먼지 <span id="pm10">[미세먼지]</span> ㎍/m³</div>
              <div class='text-start'>초미세먼지 <span id="pm25">[초미세먼지]</span> ㎍/m³</div>
             </div>
            <div class="col-3" style="margin-top:-8px; margin-left:-20px;">
              <img id="emoticonDetail" src='/img/grade0.png'>
            </div>
          </div>
          <div class="markerReport">
              <canvas class="my-4 w-100 chartjs-render-monitor" id="myChart" height="290" style="display: block;"></canvas>
          </div>
      </div>
    </div>
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
  <!-- <script src="{{ mix('/js/map.js') }}"></script> -->
  <script src="/js/MAP.js"></script>
  <script>

    var infoWindow = new naver.maps.InfoWindow({
      anchorSkew: true
    });

    map.setCursor('pointer');
      function searchAddressToCoordinate(address) {

        console.log('>>>'+address)
        naver.maps.Service.geocode({
          query: address
        }, function(status, response) {

          console.log(status);
          console.log(response);

          if (status === naver.maps.Service.Status.ERROR) {
            if (!address) {
              return alert('Geocode Error, Please check address');
            }
            return alert('Geocode Error, address:' + address);
          }

          if (response.v2.meta.totalCount === 0) {
            return alert('No result.');
          }

          var htmlAddresses = [],
            item = response.v2.addresses[0],
            point = new naver.maps.Point(item.x, item.y);

          if (item.roadAddress) {
            htmlAddresses.push('[도로명 주소] ' + item.roadAddress);
          }

          if (item.jibunAddress) {
            htmlAddresses.push('[지번 주소] ' + item.jibunAddress);
          }

          if (item.englishAddress) {
            htmlAddresses.push('[영문명 주소] ' + item.englishAddress);
          }

          infoWindow.setContent([
            '<div style="padding:10px;min-width:200px;line-height:150%;">',
            '<h4 style="margin-top:5px;">검색 주소 : '+ address +'</h4><br />',
            htmlAddresses.join('<br />'),
            '</div>'
          ].join('\n'));

          map.setCenter(point);
          infoWindow.open(map, point);
        });
      }

      function initGeocoder() {
        if (!map.isStyleMapReady) {
          return;
        }

        $('#address').on('keydown', function(e) {
          var keyCode = e.which;

          if (keyCode === 13) { // Enter Key
            searchAddressToCoordinate($('#address').val());
          }
        });

        $('#submit').on('click', function(e) {
          e.preventDefault();
          searchAddressToCoordinate($('#address').val());
        });
      }

      naver.maps.onJSContentLoaded = initGeocoder;
      naver.maps.Event.once(map, 'init_stylemap', initGeocoder);

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