<?php

// uncomment the following to define a path alias
Yii::setPathOfAlias('bootstrap',dirname(__FILE__).'/../ext-prod/bootstrap');
Yii::setPathOfAlias('ext-dev',dirname(__FILE__).'/../ext-dev');
Yii::setPathOfAlias('ext-prod',dirname(__FILE__).'/../ext-prod');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
		'basePath'=>dirname(__FILE__).'/../protected',
		'runtimePath'=>dirname(__FILE__).'/../wdir/runtime',
		'name'=>'Traafik!',
		'theme'=>'united',
		'defaultController'=> 'user',

		'preload'=>array('session','urlManager','user','bootstrap'),

		// autoloading model and component classes
		'import'=>array(
				'application.models.*',
				'application.components.*',
				'application.controllers.*',
		),

		'modules'=>array(
				'api',
		),
		
		
		//---JASON ERROR LOG - for APIs----
	/*	'log' => array(
				'class' => 'CLogRouter',
				'routes' => array(
						array(
								'logFile'=>'trace.log',
								'class' => 'CFileLogRoute',
								'levels' => 'error,info, warning',
						),
						// uncomment the following to show log messages on web pages
						
						 array(
						 		'class'=>'CWebLogRoute',
						 ),
						
				),*/
				
				
				

		// application components
		'components'=>array(
			'bootstrap' => array(
				'class' => 'ext-prod.bootstrap.components.Bootstrap',
				'responsiveCss' => true,
			),
				
				'mail' => array (
						'class' => 'ext-prod.yii-mail.YiiMail',
						'transportType' => 'smtp',
						'transportOptions' => array (
								'host' => 'mail.tuffgeekers.com',
								'username' => 'praveen.shivhare@tuffgeekers.com',
								'password' => 'praveen@tuff@99',
								'port' => '25' 
						),
						// 'encryption'=>'tls',
						
						/*'transportOptions' => array (
								'host' => 'email-smtp.us-east-1.amazonaws.com',
								'username' => 'AKIAIF4LPBNFMAGRXDVA',
								'password' => 'AmrZhr5Qoqbwqye4tBcwVh46NZkDAaxNvmSbs56NsE60',
								'port' => '25' ,
								'encryption'=>'tls',
						),*/
						
						
						'viewPath' => 'application.views.mail',
						'logging' => true,
						'dryRun' => false 
				),
				/*
				'sms' => array(
						'class'=>'ext.ClickatellSms.ClickatellSms',
						'clickatell_username'=>'tuffgeekers',
						'clickatell_password'=>'GUUKEWdTSDCeOW',
						'clickatell_apikey'=>'3424484',
						'debug' => true, 'https' => false,
				),
				*/
			'ePdf' => array(
				'class'     => 'ext-prod.yii-pdf.EYiiPdf',
				'params'    => array(
				'mpdf'     	=> array(
						'librarySourcePath' => 'ext-prod.vendors.mpdf.*',
						'constants'    => array(
							'_MPDF_TEMP_PATH' => Yii::getPathOfAlias('application.wdir.runtime'),
							)
					)
				)
			),
		'cache'=> array(
		'class'=>'system.caching.CDbCache',
		),

		'user'=>array(
		'class'=>'application.components.WebUser',
		'allowAutoLogin'=>true,
		'loginUrl' => array('/user/login'),

		),

		// uncomment the following to enable URLs in path-format
		'urlManager'=>array(
		'urlFormat'=>'path',
		'showScriptName'=>false,
		'rules'=>array(
		'home'=>'site',
		'<controller:\w+>/<id:\d+>'=>'<controller>/view',
		'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
		'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
		),
		),

		'db'=> require(DB_CONFIG_FILE_PATH),

		'errorHandler'=>array(
		'errorAction'=>'site/error',
		),
		),

		// application-level parameters that can be accessed
		// using Yii::app()->params['paramName']
		'params'=>require(dirname(__FILE__).'/params.php'),

);
