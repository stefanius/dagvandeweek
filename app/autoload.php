<?php

use Doctrine\Common\Annotations\AnnotationRegistry;
use Composer\Autoload\ClassLoader;

/**
 * @var ClassLoader $loader
 */
$loader = require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/bootstrap.php.cache';

AnnotationRegistry::registerLoader(array($loader, 'loadClass'));

return $loader;
