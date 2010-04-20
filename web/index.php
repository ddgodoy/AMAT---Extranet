<?php
	ini_set('magic_quotes_gpc','off');
  
  require_once(dirname(__FILE__).'/../config/ProjectConfiguration.class.php');

	$configuration = ProjectConfiguration::getApplicationConfiguration('frontend', 'prod', true);
  //$configuration = ProjectConfiguration::getApplicationConfiguration('frontend', 'prod', true);

	sfContext::createInstance($configuration)->dispatch();