Deployee plugin for MySQL tasks
==============================
# Dependencies
## Deployee plugin DeployShell
The Deployee shell plugins is being used to execute the mysql commands.
The mysqldump and mysql binaries can also be modified via the DeployShell alias configuration. See the plugins [manual](../DeployShell/README.md) for more information.

# New tasks
## Mysqldump task
### Creating a new mysqldump task
```php
$this
    ->mysqldump("/path/to/dumpfile.sql");
```
You can create a new mysqldump task as seen.

### Set force flag to mysqldump
```php
$this
    ->mysqldump("/path/to/dumpfile.sql")
    ->force();
```
Sets the --force flag to the command line command.

### Configure dump without create statements
```php
$this
    ->mysqldump("/path/to/dumpfile.sql")
    ->noCreateInfo();
```
Sets the --no-create-info flag to the command line command.

### Configure structure dump
```php
$this
    ->mysqldump("/path/to/dumpfile.sql")
    ->noData();
```
Sets the --no-data flag to the command line command and creates only a structure dump.

### Including only specified tables to dump
```php
$this
    ->mysqldump("/path/to/dumpfile.sql")
    ->includeTable("payments")
    ->includeTable("user")
    ->includeTable("phs_*");
```
This command will only include configured tables or views to the dump. You may also include tables by using wildcards like in the example above.
 It cannot be used with excludeTable.
 
### Excluding specified tables to dump
```php
$this
    ->mysqldump("/path/to/dumpfile.sql")
    ->excludeTable("cache_*")
    ->excludeTable("statistics");
```
This command will exclude configured tables or views from the dump. You may also exclude tables by using wildcards like in the example above.
It cannot be used with includeTable.
 
## MySQL file import
### Import MySQL file
```php
$this
    ->mysqlfile("/path/to/dumpfile.sql");
```
Import MySQL a file.

### Set force flag
```php
$this
    ->mysqlfile("/path/to/dumpfile.sql")
    ->force();
```
Sets the --force flag while importing dump.
 
# Plugin configuration
```yaml
plugins:
    - Deployee\Plugins\DeployDb\DeployDbPlugin:
        host: "localhost"
        port: 3306
        user: "root"
        password: ~
        name: "localdb"
```
The access db connection data are set in the config.