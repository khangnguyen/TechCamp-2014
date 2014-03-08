<?php

use \Aws\Sns\SnsClient;

class NotificationController extends Controller {
	/**
	 * @return array action filters
	 */
        public $layout='//layouts/main';
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'topicOnly + delete', // we only allow deletion via TOPIC request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('register','list','publish'),
				'users'=>array('*'),
			),
                        array('allow',
                              'actions'=>array('admin','delete'),
                              'roles'=>array('admin'),
                        ),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

        public function actionPublish() {
            $model=new Notification;
            if (isset($_POST['Notification'])) {
                $model->attributes=$_POST['Notification'];
                if($model->save()) {
                    require Yii::getPathOfAlias('ext.aws.').DIRECTORY_SEPARATOR.'autoloader.php';
                    $snsClient = SnsClient::factory(array(
                        'key'    => Yii::app()->params['aws_access_key'],
                        'secret' => Yii::app()->params['aws_secret_access_key'],
                        'region' => Yii::app()->params['aws_region']
                    ));
                    $result = $snsClient->publish(array(
                        'TopicArn' => Yii::app()->params['topic_arn'],
                        'Message' => $model->message,
                        'Subject' => $model->subject,
                        'MessageStructure' => 'string'));
                }
            }
	    $dataProvider = new CActiveDataProvider('Notification', array(
                'pagination'=>array(
                    'pageSize'=>20,
                ),
            ));
            $this->render('publish',array('model'=>$model, 'dataProvider'=>$dataProvider));
        }

        public function actionList() {
            $model=new Notification();
            $model->unsetAttributes();
            $dataProvider = $model->search();
            $result = array();
            foreach ($dataProvider->getData() as $data) {
                $result[$data->id] = array(
                    'subject' => $data->subject,
                    'message' => $data->message,
                    'sent_at' => $data->created_at
                );
            }
            print json_encode($result);
        }

        public function actionRegister() {
            if (isset($_POST['device_token'])) {
                // SnsClient is provided by AWS SDK
                require Yii::getPathOfAlias('ext.aws.').DIRECTORY_SEPARATOR.'autoloader.php';
                $snsClient = SnsClient::factory(array(
                    'key'    => Yii::app()->params['aws_access_key'],
                    'secret' => Yii::app()->params['aws_secret_access_key'],
                    'region' => Yii::app()->params['aws_region']
                ));

                // Each platform requires a difference Amazon SNS application
                $applicationARN = '';
                if ($_POST['platform'] == 'iOS') {
                    $applicationArn = Yii::app()->params['apns_application_arn'];
                } else if ($_POST['platform'] == 'Android') {
                    $applicationArn = Yii::app()->params['gcm_application_arn'];
                }

                $deviceToken = $_POST['device_token'];
                
		// Add device to EndPoint
                $result = $snsClient->createPlatformEndpoint(array(
                    'PlatformApplicationArn' => $applicationArn,
                    'Token' => $deviceToken));

                $status = array('status'=>'Success');
		
		if (isset($result['EndpointArn'])) {
                    $endpointArn = $result['EndpointArn'];
                    $result = $snsClient->subscribe(array(
                        'TopicArn' => Yii::app()->params['topic_arn'],
                        'Protocol' => 'Application',
                        'Endpoint' => $endpointArn));
                    if (!isset($result['SubscriptionArn'])) {
                        $status['status'] = 'Failure';
                        $status['error'] = 'Failed to subscribe device';
                    }
                } else {
                    $status['status'] = 'Failure';
                    $status['error'] = 'Failed to register device';
                }

                print json_encode($result);
            }
        }

}