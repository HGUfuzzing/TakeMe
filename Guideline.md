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