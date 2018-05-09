<?php
require __DIR__.'/../vendor/autoload.php';

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

$container = new ContainerBuilder();

$loader = new YamlFileLoader($container, new FileLocator([__DIR__.'/config']));
$loader->load('services.yaml');

$container->addCompilerPass(new \Symfony\Component\Console\DependencyInjection\AddConsoleCommandPass());
$container->compile();

return $container;
