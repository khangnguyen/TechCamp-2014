<?php

# http://www.yiiframework.com/doc/cookbook/52/
$dbConfig = json_decode(file_get_contents(dirname(__FILE__).'/db.json'), true);
$pre_config = require(dirname(__FILE__).'/local.php');


# Location where user images are stored
#Yii::setPathOfAlias('uploadPath', realpath(dirname(__FILE__). '/../../images/uploads'));
#Yii::setPathOfAlias('uploadURL', '/images/uploads/');
#Yii::setPathOfAlias('application.views.process.emails', realpath(dirname(__FILE__).'/../views/process-email'));

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return CMap::mergeArray($pre_config, array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Lewis Iselin',

    # preloading 'log' component
    'preload'=>array('log'),

    # autoloading model and component classes
    'import'=>array(
        'application.models.*',
        'application.components.*',
        'application.behaviors.*',
        'application.vendors.*',
        'application.helpers.*',
    ),
    # application components
    'components'=>array(
        'db'=>array(
            'class'=>'system.db.CDbConnection',
            'connectionString'=>"pgsql:dbname={$dbConfig['database']};host={$dbConfig['host']}",
            'username'=>$dbConfig['user'],
            'password'=>$dbConfig['password'],
            'charset'=>'utf8',
            'persistent'=>true,
            'enableParamLogging'=>true,
            'schemaCachingDuration'=>30
        ),
        'log'=>array(
            'class'=>'CLogRouter',
            'routes'=>array(
                array(
                    'class'=>'CFileLogRoute',
                    'levels'=>'error, warning, info, debug',
                    'logFile'=>'console.log',
                ),
            ),
        ),
        'authManager'=>array(
            'class'=>'CDbAuthManager',
            #'defaultRoles'=>array('end_user'),
            'connectionID'=>'db',
        ),
       'image'=>array(
            'class'=>'application.extensions.image.CImageComponent',
            # GD or ImageMagick
            'driver'=>'GD',
            # ImageMagick setup path
            #'params'=>array('directory'=>'/opt/local/bin'),
        ),
    ),
    # application-level parameters that can be accessed
    # using Yii::app()->params['paramName']
    'params'=>array(
        #'home_url' => 'http://www.cogini.com', # Where top level link goes to
        'app_email_name' => 'lewisiselin',
        'app_email' => 'support@cogini.com',
        'reply_to_email' => 'support@cogini.com',
    ),
));
