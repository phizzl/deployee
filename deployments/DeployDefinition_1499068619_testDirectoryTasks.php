<?php

/**
 * @mixin ideHelperDeploymentDefinition
 * @runalways
 */
class DeployDefinition_1499068619_testDirectoryTasks extends \Deployee\Plugins\Deploy\Definitions\AbstractDeploymentDefinition
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

        $this
            ->directory(__DIR__ . '/test/peter/oscar')
            ->remove();

        $this
            ->directory(__DIR__ . '/test')
            ->remove()
            ->recursive();

        $this
            ->file(__DIR__ . '/deploy.txt')
            ->remove();

        $this
            ->file(__DIR__ . '/.gittest')
            ->copy(__DIR__ . '/.gitkeep');

        $this
            ->file(__DIR__ . '/.gittest')
            ->remove();

        $this
            ->shell("php")
            ->arguments("-v");
    }
}