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
See documentation [here](src/Plugins/DeployFilesystem/README.md)

### Shell
See documentation [here](src/Plugins/DeployShell/README.md)

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
See documentation [here](src/Plugins/DeployOxid/README.md)