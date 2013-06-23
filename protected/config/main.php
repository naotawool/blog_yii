<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
        'language'=>'ja',
        'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
        'name'=>'オプログ',
        'defaultController'=>'post',

        // preloading 'log' component
        'preload'=>array('log'),

        // autoloading model and component classes
        'import'=>array(
                'application.models.*',
                'application.components.*',
        ),

        'modules'=>array(
                // uncomment the following to enable the Gii tool
                'gii'=>array(
                        'class'=>'system.gii.GiiModule',
                        'password'=>'opsttest',
                        // If removed, Gii defaults to localhost only. Edit carefully to taste.
                        // 'ipFilters'=>array('127.0.0.1','::1'),
                ),
        ),

        // application components
        'components'=>array(
                'user'=>array(
                        // enable cookie-based authentication
                        'allowAutoLogin'=>true,
                ),
                'cache'=>array(
                        'class'=>'CDbCache',
                ),
                // uncomment the following to enable URLs in path-format
                'urlManager'=>array(
                        'showScriptName' => true,
                        'urlFormat'=>'path',
                        'rules'=>array(
                                'post/<id:\d+>/<title:.*?>'=>'post/view',
                                'posts/<tag:.*?>'=>'post/index',
                                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
                                /*
                                 '<controller:\w+>/<id:\d+>'=>'<controller>/view',
'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
*/
                        ),
                ),
                /*
                 'db'=>array(
                         'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/blog.db',
                         'tablePrefix'=>'tbl_',
                 ),
// uncomment the following to use a MySQL database
*/
                'db'=>array(
                        'class' => 'system.db.CDbConnection',
                        'connectionString' => 'mysql:host=localhost;dbname=blog',
                        'enableParamLogging' => true,
                        'emulatePrepare' => true,
                        'username' => 'blog',
                        'password' => 'blog',
                        'charset' => 'utf8',
                        'tablePrefix'=>'tbl_',
                        'enableProfiling' => true,
                        'schemaCachingDuration'=>3600,  // 読み取った DB のスキーマデータを 3600 秒間キャッシュする
                ),
                'errorHandler'=>array(
                        // use 'site/error' action to display errors
                        'errorAction'=>'site/error',
                ),
                'log'=>array(
                        'class'=>'CLogRouter',
                        'routes'=>array(
                                array(
                                        'class'=>'CFileLogRoute',
                                        'levels'=>'error, warning, info',
                                ),
                                array(
                                        'class' => 'CWebLogRoute',
                                        'levels'=>'error, warning',
                                ),
                                array(
                                        'class' => 'CProfileLogRoute',
                                        'report' => 'summary'
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
        'params'=>array(
                // this is used in contact page
                'adminEmail'=>'webmaster@example.com',
        ),
);
