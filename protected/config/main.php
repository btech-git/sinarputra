<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'PT. Sinar Putra Metalindo',
    'timezone' => 'Asia/Jakarta',
    // preloading 'log' component
    'preload' => array('log'),
    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.models.base.*',
        'application.models.custom.*',
        'application.components.*',
        'application.components.validators.*',
    ),
    'modules' => array(
        // uncomment the following to enable the Gii tool
        'admin',
        'transaction',
        'report',
        'manufacture',
        'accounting',
        
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => 'sinarputra',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters' => array('127.0.0.1', '::1'),
            'generatorPaths' => array(
                'application.generators',
            ),
        ),
    ),
    // application components
    'components' => array(
        'clientScript' => array(
            'packages' => array(
                'jquery' => array(
                    'baseUrl' => 'http://ajax.googleapis.com/ajax/libs/jquery/',
                    'js' => array('1.7.2/jquery.min.js'),
                )
            ),
        ),
        'user' => array(
            // enable cookie-based authentication
            'allowAutoLogin' => true,
        ),
        'authManager' => array(
            'class' => 'CDbAuthManager',
        ),
        'cache'=>array( 
            'class'=>'system.caching.CDbCache'
        ),
        // uncomment the following to enable URLs in path-format
//		'urlManager'=>arrt
//		'db'=>array(
//			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
//		),
        // uncomment the following to use a MySQL database
        /*
        'db' => array(
            'connectionString' => 'mysql:host=192.168.0.150;dbname=sinarputra',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => 'Strike*Force',
            'charset' => 'utf8',
        ),
        */
        'db'=>array(
            'connectionString' => 'mysql:host=localhost;dbname=sinarputra',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => 'Strike*Force1',
            'charset' => 'utf8',
        ),
        
        'errorHandler' => array(
            // use 'site/error' action to display errors
            'errorAction' => 'site/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
            // uncomment the following to show log messages on web pages
            /*
              array(
              'class'=>'CWebLogRoute',
              ),
             */
            ),
        ),
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => array(
        // this is used in contact page
        'adminEmail' => 'webmaster@example.com',
    ),
);
