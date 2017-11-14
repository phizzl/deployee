Deployee task runner
====================

## Setup
You can require deployee via composer
```bash
composer require phizzl/deployee v0.2@dev
```

## Configuration
Create a file called deployee.yml. You might copy it fom vendor/phizzl/deployee/deployee.dist.yml.

### Load specified configuration by an OS environment var
If you want to use another configuration you can change it by setting the environment variable DEPLOYEE_CONFIG with the absolute path to the configuration to use.
```bash
export DEPLOYEE_CONFIG=/var/www/custom.deployee.yml; vendor/bin/deployee deployee:deploy:run
```

### Load config by --env option
You also are able to load a configuration by defining the --env option
```bash
vendor/bin/deployee deployee:deploy:run --env=dev
```
In the example above Deployee will try to read the configuration from a file called delpoyee.dev.yml in you current CWD.

## Deployments
### Tasks
There are several of tasks you can use to define your deployment. The functionality that makes it possible to define a deployment is stored in the Dpeloyment plugin. For more information see the documentation [here](_trash/Plugins/Deploy/README.md) 

#### Filesystem
See documentation [here](_trash/Plugins/DeployFilesystem/README.md)

#### Shell
See documentation [here](_trash/Plugins/DeployShell/README.md)

#### MySQL database
See documentation [here](_trash/Plugins/DeployDb/README.md)

#### OXID eShop
See documentation [here](_trash/Plugins/DeployOxid/README.md)

### Annotation controlled deployments
You can manipulate the behaviour of when a deplyoment is executed by setting annotations to the deployment definition. If you want to know more about how to force a deployment to run always or only when a specified environment is given take a look at the plugin docs [here](_trash/Plugins/DeployAnnotation/README.md)

## Plugins
The system itself is designed to be event and plugin based. So the functionality to define a deployment is a plugin itself that adds events and commands to the system. 

### Create a new plugin
If you want to add functionality to Deployee you are able to create your own plugin. For this you need a Plugin class that extends the AbstractPlugin class.
```php
use Deployee\Container;
use Deployee\Plugins\AbstractPlugin;

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
    - Deployee\Plugins\MyPlugin\MyPluginPlugin
```

### Plugin configuration parameter
You can also define your plugin configuration in the config YAML file. This parameters will be available in the plugins initialize method.
```yaml
plugins:
    - Deployee\Plugins\MyPlugin\MyPluginPlugin:
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
