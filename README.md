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

## File Manager

Support local, s3, hostlink-storage to store files.

### local
```ini
VX_FILE_MANAGER_0=local
VX_FILE_MANAGER_0_PATH=/var/www/html/uploads
```

### s3
```
composer require league/flysystem-aws-s3-v3:^3.0
composer require aws/aws-sdk-php
```

```ini
VX_FILE_MANAGER_0=s3
VX_FILE_MANAGER_0_KEY=your-key
VX_FILE_MANAGER_0_SECRET=your-secret
VX_FILE_MANAGER_0_REGION=your-region
VX_FILE_MANAGER_0_BUCKET=your-bucket
VX_FILE_MANAGER_0_PREFIX=your-prefix
VX_FILE_MANAGER_0_ENDPOINT=your-endpoint
```


### hostlink-storage
```
composer require hostlink/hostlink-storage-adapter
```

```ini
VX_FILE_MANAGER_0=hostlink-storage
VX_FILE_MANAGER_0_TOKEN=your-token
VX_FILE_MANAGER_0_ENDPOINT=your-endpoint
```

### multiple file manager
For multiple file manager, use `VX_FILE_MANAGER_1`, `VX_FILE_MANAGER_2`, etc.

```php
$fs=$vx->getFileSystem(1); // use file manager 1
```


## Debug mode
To enable debug mode, set `VX_DEBUG=1` in `.env` file.
```ini
VX_DEBUG=1
```


## Language
To enable language, set `VX_LANGUAGE_0_NAME` and `VX_LANGUAGE_0_LOCALE` in `.env` file.
```ini

VX_LANGUAGE_0_NAME=English
VX_LANGUAGE_0_LOCALE=en

VX_LANGUAGE_1_NAME=中文
VX_LANGUAGE_1_LOCALE=zh-hk
```