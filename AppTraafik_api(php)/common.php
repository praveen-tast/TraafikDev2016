<?php
date_default_timezone_set('Asia/Calcutta');

//defined('YII_ENV') or define('YII_ENV','prod');
defined('YII_ENV') or define('YII_ENV','dev');

//db config path setting
defined('UPLOAD_PATH') or define('UPLOAD_PATH','/wdir/uploads/');

// create directories if required
if ( !file_exists(dirname(__FILE__). UPLOAD_PATH)) mkdir( dirname(__FILE__). UPLOAD_PATH, 0777, true);
if ( !file_exists(dirname(__FILE__). '/assets')) mkdir( dirname(__FILE__). '/assets', 0777, true);
if ( !file_exists(dirname(__FILE__). '/wdir/runtime')) mkdir( dirname(__FILE__). '/wdir/runtime', 0777, true);

defined('DB_CONFIG_PATH') or define('DB_CONFIG_PATH',dirname(__FILE__).'/config/');
defined('DB_CONFIG_FILE_PATH') or define('DB_CONFIG_FILE_PATH', DB_CONFIG_PATH.YII_ENV.'-db.php');

// change the following paths if necessary
$yii = dirname(__FILE__).'/../yii/framework/yii.php';
$config = dirname(__FILE__).'/config/'. YII_ENV .'.php';


if ( YII_ENV == 'dev')
{
	error_reporting(E_ALL);
	ini_set("display_errors", 1);

	// remove the following lines when in production mode
	defined('YII_DEBUG') or define('YII_DEBUG',true);
	// specify how many levels of call stack should be shown in each log message
	defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
}
else if ( YII_ENV == 'test')
{
	error_reporting(E_ALL);
	ini_set("display_errors", 1);

	// remove the following line when in production mode
	defined('YII_DEBUG') or define('YII_DEBUG',true);
}
else
{
	$yii = dirname(__FILE__).'/../yii-1.1.14.f0fee9/framework/yii.php';
}