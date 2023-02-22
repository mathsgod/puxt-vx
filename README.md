# puxt-vx

## setup
index.php
```php
require_once __DIR__ . "/vendor/autoload.php";

//
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, PATCH, HEAD, DELETE");
header("Access-Control-Expose-Headers: location, Content-Location");


$app = new PUXT\App();
$app->pipe(VX::class);
$app->run();
```

.env
```
JWT_SECRET=123456

DATABASE_HOSTNAME=
DATABASE_DATABASE=
DATABASE_USERNAME=
DATABASE_PASSWORD=
DATABASE_PORT=3306
DATABASE_CHARSET=utf8mb4
```

.htaccess
```
RewriteEngine on
RewriteRule .* - [env=HTTP_AUTHORIZATION:%{HTTP:Authorization}]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . index.php [L]
```

