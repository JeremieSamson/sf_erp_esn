<?php

use Doctrine\Common\Annotations\AnnotationRegistry;
use Composer\Autoload\ClassLoader;

/**
 * @var ClassLoader $loader
 */
$loader = require __DIR__.'/../vendor/autoload.php';
$loader->add('phpCAS_', __DIR__.'/../vendor/cas/lib');

AnnotationRegistry::registerLoader(array($loader, 'loadClass'));

return $loader;
