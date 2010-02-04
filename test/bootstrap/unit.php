<?php

$app = 'frontend';
require_once dirname(__FILE__).'/../../../../config/ProjectConfiguration.class.php';
$configuration = ProjectConfiguration::getApplicationConfiguration($app, 'test', isset($debug) ? $debug : true);
sfContext::createInstance($configuration);
include($configuration->getSymfonyLibDir().'/vendor/lime/lime.php');