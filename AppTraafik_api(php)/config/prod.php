<?php

return CMap::mergeArray(
	require(dirname(__FILE__).'/main.php'),
	array(
	'preload'=>array('log'),
	'components'=>array(
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
						 	array(
								'class' => 'CFileLogRoute',
								'levels' => 'error, warning',
							),
/* 						   array(
								'class' => 'CWebLogRoute',
								'levels' => 'trace',
							), 
							array(
								'class' => 'CProfileLogRoute',
								'report' => 'summary',
								'levels' => 'profile',
							),*/
		
						),					
				),

		),
	)
);
