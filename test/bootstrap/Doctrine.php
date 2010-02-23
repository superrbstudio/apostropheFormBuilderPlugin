<?php
include(dirname(__FILE__).'/unit.php');
new sfDatabaseManager($configuration);
Doctrine::loadData(dirname(__FILE__).'/../fixtures/project/data/fixtures');