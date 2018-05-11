<?php
require __DIR__.'/vendor/autoload.php';

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Dotenv\Dotenv;

$container = new ContainerBuilder();

$dotenv = new Dotenv();
try {
    $dotenv->load(__DIR__.'/.env');
} catch (\Symfony\Component\Dotenv\Exception\PathException $exception) {

}

$loader = new YamlFileLoader($container, new FileLocator([__DIR__.'/config']));
$loader->load('services.yaml');

$container->addCompilerPass(new \Symfony\Component\Console\DependencyInjection\AddConsoleCommandPass());
$container->compile(true);

return $container;
