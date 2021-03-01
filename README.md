# What service?

`한동대학교 내 URL 단축 웹 서비스`

복잡한 Google Form, YouTube, Zoom, Hiset 게시판 주소를 키워드로 간단하게 줄일 수 있고,
이벤트 홍보도 할 수 있는 서비스입니다.

링크 : http://takeme.kr

## ✈️ TAKE ME 서비스 설명 ✈️

❓ 지금까지 얼마나 많은 링크를 공유해 보셨나요?? 
zoom 링크, youtube 링크, form 링크, ...

❓ 코로나19로 온라인 모임이 활성화되면서 더 많은 링크를 올려야하지 않았나요??

❓ 혹시 공지한 링크가 바뀌어서 또 재공지 해야하는 불상사가 발생하진 않았나요??

👉 복잡한 링크를 간단히 줄이고

👉 공지한 링크가 바뀌는 문제를 해결하세요.

#### ⁉️TAKEME 사용 예시⁉️

https://us02web.zoom.us/j/156852521239 (😡복잡한 URL!!😡)

→→→ http://takeme.kr/@hanst모임-zoom (🤗간단하고 의미있는 URL🤗)


직접 지정한 키워드를 사용하여 링크를 간단하고 의미있게 만들었습니다!

또한 이후에 zoom link가 바뀌어도 링크를 재공지 할 필요가 없어졌습니다!


---

# Guideline for initial setting

1. `git clone git@github.com:HGUfuzzing/TakeMe.git`
2. `cd TakeMe`
3. `composer install` to install dependancies.
4. `mkdir private` to make private directory
5. make 3 files in private directory (client_secret.json, mail_secret.json, config.php)

### client_secret.json

```json
{
    "web":
        {
            "client_id":"",
            "project_id":"php-web-login",
            "auth_uri":"https://accounts.google.com/o/oauth2/auth",
            "token_uri":"https://oauth2.googleapis.com/token",
            "auth_provider_x509_cert_url":"https://www.googleapis.com/oauth2/v1/certs",
            "client_secret":"",
            "redirect_uris":["http://takeme.kr/login/google"]
        }
}
```

(사전에 google api console에서 `프로젝트 생성` 후 `OAuth 2.0 클라이언트 ID 생성` 을 해야합니다.)

### mail_secret.json

```json
{
    "id" : "{id}",
    "pw" : "{password}"
}
```

(사전에 gmail을 만들고 `google 계정관리` 에서 `보안 수준이 낮은 앱의 액세스` 를 허용해야합니다.,)

### config.php

```php
<?php
  
return [
    'database' => [
        'name' => '{db 명}',
        'username' => '{db 아이디}',
        'password' => '{db 비밀번호}',
        'connection' => 'mysql:host={서버주소}',
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]
    ]
];
```
