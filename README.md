# puxt-vx

## setup
index.php
```php
require_once __DIR__ . "/vendor/autoload.php";
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

