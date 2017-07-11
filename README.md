Deployee task runner
====================

## Setup
You can require deployee via composer
```bash
composer require phizzl/deployee-cli @dev
```

## Configuration
Create a file called deployee.yml. You might copy it fom vendor/phizzl/deployee-cli/deployee.dist.yml.
If you want to use another configuration you can change it by setting the environment variable DEPLOYEE_CONFIG with the absolute path to the configuration to use.
```bash
export DEPLOYEE_CONFIG=/var/www/custom.deployee.yml; vendor/bin/deployee deployee:deploy:run
```

## Deployments
### Tasks
There are several of tasks you can use to define your deployment. The functionality that makes it possible to define a deployment is stored in the Dpeloyment plugin. For more information see the documentation [here](src/Plugins/Deploy/README.md) 

#### Filesystem
See documentation [here](src/Plugins/DeployFilesystem/README.md)

#### Shell
See documentation [here](src/Plugins/DeployShell/README.md)

#### MySQL database
See documentation [here](src/Plugins/DeployDb/README.md)

#### OXID eShop
See documentation [here](src/Plugins/DeployOxid/README.md)

## Plugins
The system itself is designed to be event and plugin based. So the functionality to define a deployment is a plugin itself that adds events and commands to the system. 

### Create a new plugin
If you want to add functionality to Deployee you are able to create your own plugin. For this you need a Plugin class that extends the AbstractPlugin class.
```php
use Phizzl\Deployee\Container;
use Phizzl\Deployee\Plugins\AbstractPlugin;

class MyPluginPlugin extends AbstractPlugin
{
    const PLUGIN_ID = "deploy.myUniquePluginId";

    /**
     * @return string
     */
    public function getPluginId()
    {
        return self::PLUGIN_ID;
    }

    /**
     * @param Container $container
     */
    public function initialize(Container $container)
    {
        // start subscribing to events
    }
}
```
After you defined your plugin you just have to add your class to your Deployee config YAML file under the _plugin_ section.
```yaml
plugins:
    - Phizzl\Deployee\Plugins\MyPlugin\MyPluginPlugin
```

### Plugin configuration parameter
You can also define your plugin configuration in the config YAML file. This parameters will be available in the plugins initialize method.
```yaml
plugins:
    - Phizzl\Deployee\Plugins\MyPlugin\MyPluginPlugin:
        myvar1: val1
        myvar2: ["apple", "orange"]
```

Than you can access the config vars as in the following example
```php
public function initialize(Container $container)
{
    $myvar1 = $this->config['myvar1'];
    if(!isset($this->config['myvar2']) || !is_array($this->config['myvar2'])){
        throw new \RuntimeException("You need to configure myvar2");
    }
}
```