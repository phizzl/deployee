Deployee plugin Annotation
======================

The plgin adds the functionality to manipulate the deployment execution for only run defined deployment on specified environments and marking single deployment to run always.

## Running a deployment only for specified environments
```php
/**
 * @mixin ideHelperDeploymentDefinition
 * @env stage
 */
class DeployDefinition_1499068619_testDirectoryTasks extends \Deployee\Plugins\Deploy\Definitions\AbstractDeploymentDefinition {
    // Awesome stuff
}
```

The example above shows how to mark a deployment to run only when a special --env parameter is matching to @env.

The deployment will be executed when running a deployment like this
```bash
vendor/bin/deployee deployee:deploy:run --env=stage
```

The deployment won'te be executed when running the command without the --env param or with another value than _stage_.  

You also might define multiple environments to run.
```php
/**
 * @mixin ideHelperDeploymentDefinition
 * @env stage
 * @env build
 */
class DeployDefinition_1499068619_testDirectoryTasks extends \Deployee\Plugins\Deploy\Definitions\AbstractDeploymentDefinition {
    // Awesome stuff
}
```

## Running a deployment always
```php
/**
 * @mixin ideHelperDeploymentDefinition
 * @runalways
 */
class DeployDefinition_1499068619_testDirectoryTasks extends \Deployee\Plugins\Deploy\Definitions\AbstractDeploymentDefinition {
    // Awesome stuff
}
```
The example above shows how easy you might prevent a deployment from being added to the history by using the @runalways tag. Of course you might combine it with @env.