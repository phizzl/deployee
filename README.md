Deployee task runner
====================

# Setup
You can require deployee via composer
```bash
composer require phizzl/deployee-cli @dev
```

# Deployments
## Tasks
There are several of tasks you can use to define your deployment.

### Filesystem
#### Create directory
```php
$this
    ->directory(__DIR__ . '/my/awesome/directory')
    ->create()
    ->recursive();
```

#### Remove directory
```php
$this
    ->directory(__DIR__ . '/my/awesome/directory')
    ->remove()
    ->recursive();
```

#### Create file or change file contents
```php
$this
    ->file(__DIR__ . '/deploy.txt')
    ->contents("This is an awesome content " . microtime(true));
```

#### Copy file
```php
$this
    ->file(__DIR__ . '/my_awesome_target_file.txt')
    ->copy(__DIR__ . '/my_awesome_source_file.txt');
```

#### Remove file
```php
$this
    ->file(__DIR__ . '/my_not_so_awesome_file.txt')
    ->remove();
```

#### Set owner, group or permissions
```php
$this
    ->permission(__DIR__ . '/deploy.txt')
    ->owner('root')
    ->group('www-data')
    ->permissions(0775)
    ->recursive();
```

### Shell
#### Execute shell command
```php
$this
    ->shell("php")
    ->arguments("-v");
```

### MySQL database
#### Create dump
```php
$this
    ->mysqldump("/path/to/dump.sql")
    ->force()
    ->noData();
```

#### Import MySQL file
```php
$this
    ->mysqlfile("/path/to/dump.sql")
    ->force();
```

### OXID eShop
#### Activate module
```php
$this
    ->module("invoicepdf")
    ->activate()
    ->shopId(2)
    ->shopId(4);
```

#### Deactivate module
```php
$this
    ->module("invoicepdf")
    ->activate()
    ->shopId(3);
```

#### Clear temp directory module
```php
$this
    ->shop()
    ->clearTmp();
```

#### Generate database views
```php
$this
    ->shop()
    ->generateViews();
```