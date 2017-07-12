Deployee plugin Deploy
======================

## Start writing deployment definitions
This plugin is the base for defining deployments.
A deployment itself is a collection of tasks that you define. You may define a separate deployment for each ticket you work on.

Before you start writing deployments you should get familiar with the shell command deployee:deploy:generate. This command will generate a new deployment definition class for you.

### The deployment definition class
The deployment definition class is the metioned collection of tasks. All deployment definitions will be stored and read from your configured _path_.
The deployment definition itself gets it's functionality by different plugins that are adding usable tasks to the definition.
```php
class DeployDefinition_1499068619_Ticket008 extends \Deployee\Plugins\Deploy\Definitions\AbstractDeploymentDefinition
{
    public function define()
    {
        $this
            ->directory(__DIR__ . '/test/peter/oscar')
            ->create()
            ->recursive();

        $this
            ->file(__DIR__ . '/deploy.txt')
            ->contents("This is an awesome content " . microtime(true));
    }
}
```

### Tasks
The tasks itself are being used for defining the steps. For example you might want to add a file or diretory. So you creating a FileTask or a DirectoryTask wich implements the TaskInterface interface.

### Task dispatcher
To execute a task you need a task dispatcher. As plugins extend Deployees functionality with different tasks they come up with their own task disptcher.

Let's take a look at the task dispatcher for the FileTask class from the DeployFilesystem plugin.
```php
namespace Deployee\Plugins\DeployFilesystem\Dispatcher;

use Deployee\Dispatcher\AbstractTaskDispatcher;
use Deployee\Plugins\DeployFilesystem\Utils\Chmod;
use Deployee\Plugins\DeployFilesystem\Utils\Rm;
use Deployee\Plugins\DeployFilesystem\Utils\RmDir;
use Deployee\Dispatcher\TaskDispatchException;
use Deployee\Tasks\TaskInterface;

class FilesystemTaskDispatcher extends AbstractTaskDispatcher
{
    /**
     * @return array
     */
    protected function getDispatchableClasses()
    {
        return [
            'Deployee\Plugins\DeployFilesystem\Tasks\FileTask'
        ];
    }

    /**
     * @param TaskInterface $task
     * @return int
     */
    public function dispatchFileTask(TaskInterface $task)
    {
        $definition = $task->getDefinition();
        if($definition->offsetGet('remove') === true){
            $rm = new Rm();
            $rm->remove($definition->offsetGet('path'));
            return 0;
        }

        if(strlen($definition->offsetGet('copy')) > 0) {
            if (copy($definition->offsetGet('copy'), $definition->offsetGet('path')) === false) {
                throw new \RuntimeException(
                    "Could not copy file \"{$definition->offsetGet('copy')}\" to \"{$definition->offsetGet('path')}\""
                );
            }
            return 0;
        }

        if(file_put_contents($definition->offsetGet('path'), $definition->offsetGet('contents')) === false){
            throw new \RuntimeException("Could not write to file \"{$definition->offsetGet('path')}\"");
        }

        return 0;
    }
```
As you can see the dispatcher return in FilesystemTaskDispatcher::getDispatchableClasses for what classes it's responsible. The method FilesystemTaskDispatcher::dispatchFileTask contains the logic to execute the defined file task.

## Shell commands
### Generate deployment
```bash
vendor/bin/deployee deployee:deploy:generate Ticket008
```
Generates a new deployment definition in the configured _path_.

### Run the deployment
```bash
vendor/bin/deployee deployee:deploy:run
```
Run alls deployment definitions stored in the configured _path_.

## Plugin configuration
```yaml
plugins:
    - Deployee\Plugins\Deploy\DeployPlugin:
        path: deployments
```
### path
You can configure the directory where to read the deployments from.