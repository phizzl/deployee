Deployee plugin for filesystem tasks
====================================
# Dependencies
## Deployee plugin Deploy
This plugin makes use of events triggered when booting the deploy plugin. It extends the functionality to use in a deployment definition class.

# New tasks
## Directory tasks
This task can be used for creating and removing directories

### Creating new directory task
```php
$this
    ->directory(__DIR__ . '/my/awesome/directory');
```
The example above will create a new directory task. Now you can start defining what should happen.

### Creating a new directory
```php
$this
    ->directory(__DIR__ . '/my/awesome/directory')
    ->create();
```
Creates a given directory. This will fail if the parent directories doesn't exist.

### Creating a new directory recursively
```php
$this
    ->directory(__DIR__ . '/my/awesome/directory')
    ->create()
    ->recursive();
```
Creates a given directory. In case the parent directories do not exist they will be created.

### Removing a directory
```php
$this
    ->directory(__DIR__ . '/my/awesome/directory')
    ->remove();
```
Removes a directory.

### Removing a directory recursively
```php
$this
    ->directory(__DIR__ . '/my/awesome/directory')
    ->remove()
    ->recursive();
```
Removes a directory and all it's contents.

## File tasks
### Creating new file task
```php
$this
    ->file(__DIR__ . '/my/awesome/file.txt');
```
The example above will create a new file task.

### Creating a new file
```php
$this
    ->file(__DIR__ . '/my/awesome/file.txt')
    ->contents('my content')
    ->create();
```
Creates a new file with the given content.

### Copy a file
```php
$this
    ->file(__DIR__ . '/my/awesome/target/file.txt')
    ->copy(__DIR__ . '/my/awesome/source/file.txt);
```
Perform a file copy.

### Remove a file
```php
$this
    ->file(__DIR__ . '/my/awesome/file.txt')
    ->remove();
```
Perform a file copy.

## Permission tasks
### Create a new permission task
```php
$this
    ->permission(__DIR__ . '/my/awesome/file.txt');
```
You can create permission tasks for files and directories.

### Set permissions
```php
$this
    ->permission(__DIR__ . '/my/awesome/file.txt')
    ->permissions(0775);
```
You can set permissions to a file or directory

### Set owner
```php
$this
    ->permission(__DIR__ . '/my/awesome/directory')
    ->owner("www-data");
```
Set the ownership of a file or directory

### Set group
```php
$this
    ->permission(__DIR__ . '/my/awesome/file.txt')
    ->group("web-grp");
```
Set the group of a file or directory

### Apply permissions recursively
```php
$this
    ->permission(__DIR__ . '/my/awesome/directory')
    ->group("web-grp")
    ->owner("www-data")
    ->permissions(0775)
    ->recursive();
```
You can apply all operations recursively on nested directories.