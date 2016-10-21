<?php
//defined('YII_ENV') or define('YII_ENV','prod');

require (dirname(__FILE__).'/common.php');

require_once($yii);
Yii::createWebApplication($config)->run();
