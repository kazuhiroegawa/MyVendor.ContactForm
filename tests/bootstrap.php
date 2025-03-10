<?php
use BEAR\Package\Bootstrap;
use Doctrine\Common\Annotations\AnnotationRegistry;
use MyVendor\ContactForm;

error_reporting(E_ALL);

$loader = require dirname(__DIR__) . '/vendor/autoload.php';
AnnotationRegistry::registerLoader([$loader, 'loadClass']);

// set the application path into the globals so we can access it in the tests.
$_ENV['TEST_DIR'] = __DIR__;
$_ENV['TMP_DIR'] = __DIR__ . '/tmp';

// set the resource client
$app = (new Bootstrap)->getApp('MyVendor\ContactForm', 'html-app');
$GLOBALS['RESOURCE'] = $app->resource;
