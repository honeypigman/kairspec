## About Project
- REST API 를 통한 데이터 연동 및 활용.
- 데이터출처 [공공데이터포털::한국환경공단_대기오염정보](https://www.data.go.kr/data/15000581/openapi.do).
- 라라벨 프레임워크 routes/api 를 통한 통신연동 진행하며 아래의 기본사항을 준수하고자 합니다.
> 1) URI을 통한 정보에 대한 자원을 정확하게 표현
> 2) HTTP Method(GET, POST, PUT, DELETE) 를 통한 CRUD 수행
## Todo
- [X] Api 화면구성
- [X] Api 레이아웃 작성
- [X] 전문확정 - 측정소정보::getNearbyMsrstnList, getMsrstnList
- [X] 전문확정 - 대기오염정보::getMsrstnAcctoRltmMesureDnsty
- [X] Xml To Json - Simplexml_load_string
- [X] MongoDB설치 및 설정
- [X] 카테고리 - 전문별 요청/응답 화면구현
- [ ] 카테고리 - 전문별 데이터 적재내역
- [ ] 카테고리 - 지도 마킹
- [ ] 카테고리 - 매트릭스 8단계 구현 ( 한국기준 / WHO기준 )
- [ ] 기능 - Operatio에 따른 전문송수신 공통화
- [ ] 기능 - RestAPI 형태의 공통인터페이스 작성1
- [ ] 기능 - 스케쥴러로 데이터 적재
- [ ] 기능 - 측정소별 통계
- [ ] 기능 - 측정소의 가장 최신 데이터 (1시간 단위)만 사용

## How to Use
> 1) 프로젝트 경로로 이동
> 2) git clone
> ```git
> git clone https://github.com/honeypigman/kairspec.git ./
> ```
> 3) .env 파일 생성 
> ```env
> APP_ENV=D
> APP_VER=1.0
> APP_NAME=[Proejct Name]
> APP_KEY=[GenerateKey]
> APP_DEBUG=true
> APP_URL=[Domain URL]
> ADMIN_EMAIL=[Admin Email Address]
> 
> LOG_CHANNEL=stack
> 
> API_TITLE=데이터출처_공공데이터::한국환경공단_대기오염정보
> API_LINK=https://www.data.go.kr/data/15000581/openapi.do
> API_KEY=[서비스ID]
> 
> MONGO_DB_HOST=[IP]
> MONGO_DB_PORT=27017
> MONGO_DB_DATABASE=[데이터베이스명]
> MONGO_DB_USERNAME=[DB 유저]
> MONGO_DB_PASSWORD=[DB 비밀번호]
>```
> 4) storage 디렉토리내  json 파일사용을 위한 링크 설정.[Laravel-Filesystem](https://laravel.com/docs/7.x/filesystem).
> ```php 
> artisan storage:link
> ```
> 5) 라라벨 키 재생성
> ```php
> php artisan key:generate
> ```
>6) Docker MongoDB 설치
> ```docker
> docker run -d --name mongo-db -v [로컬경로]:/data/db -p 27017:27017 mongo
> docker run -e MONGODB_USER=[유저명] -e MONGODB_PASSWORD=[패스워드] -d --name mongo-db -v [로컬경로]:/data/db -p 27017:27017 mongo
> ```
> 7) Laravel config/database.php > Connections 추가
> ```php
> 'mongodb' => [
>           'driver'   => 'mongodb',
>           'host'     => env('MONGO_DB_HOST', '127.0.0.1'),
>           'port'     => env('MONGO_DB_PORT', 27017),
>           'database' => env('MONGO_DB_DATABASE'),
>           //'username' => env('MONGO_DB_USERNAME'),
>           //'password' => env('MONGO_DB_PASSWORD'),
>           'options'  => [
>                'database' => env('DB_AUTHENTICATION_DATABASE', 'admin'), // required with Mongo 3+
>            ]
>         ],
>```
> 8) Composer MongoDB
> ```
> $ composer require jenssegers/mongodb:"^3.7"
>````
>
> * pecl 문제로 소스설치 진행으로 설치.
> php [mongodb extension](https://www.php.net/manual/en/mongodb.installation.manual.php).
> ```sh
> $ git clone https://github.com/mongodb/mongo-php-driver.git
> $ cd mongo-php-driver
> $ git submodule update --init
> $ phpize
> $ ./configure
> $ make all
> $ sudo make install
> ```
> /etc/php.d/20-mongodb.ini
> ```sh
> ; Enable mongodb extension module
> extension=mongodb.so
> ```
## Based on following plugins or services
- RestAPI
- PHP v7
- PHP [Simplexml_load_string](https://www.php.net/manual/en/book.simplexml.php).
- Apache v2.3
- Laravel v7.3
- Bootstrap v5
- NoSQL - MongoDB
- Laravel - MongoDB [laravel-mongodb#query-builder](https://github.com/jenssegers/laravel-mongodb#query-builder).

## License
The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Contact Me
- 오늘 역시 조금씩 꾸준하게 하자.
- 소스리뷰 및 조언 언제나 환영합니다. 
- honeypigman@gmail.com