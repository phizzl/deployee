Deployee plugin for shell commands
==============================
## Dependencies
### Deployee plugin Deploy
This plugin makes use of events triggered when booting the deploy plugin. It extends the functionality to use in a deployment definition class.

## New tasks
### Shell task
```php
$this
    ->shell("php")
    ->arguments("-v");
```
This example will execute php with the argument -v.

## Plugin configuration
```yaml
plugins:
    - Deployee\Plugins\DeployShell\DeployShellPlugin:
        aliase:
            php: /usr/bin/php5
            mysqldump: /usr/local/mysql5/bin/mysqldump
```
You can configure command aliases in your plugin configuration. So you may use $this->shell("php")->arguments("-v") in your deployment definition and it will be resolved to /usr/bin/php5 -v.