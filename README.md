Deployee task runner
====================

# Setup
You can require deployee via composer
```bash
composer require phizzl/deployee-cli @dev
```

# Deployments
## Tasks
There are several of tasks you can use to define your deployment. The functionality that makes it possible to define a deployment is stored in the Dpeloyment plugin. For more information see the documentation [here](src/Plugins/Deploy/README.md) 

### Filesystem
See documentation [here](src/Plugins/DeployFilesystem/README.md)

### Shell
See documentation [here](src/Plugins/DeployShell/README.md)

### MySQL database
See documentation [here](src/Plugins/DeployDb/README.md)

### OXID eShop
See documentation [here](src/Plugins/DeployOxid/README.md)