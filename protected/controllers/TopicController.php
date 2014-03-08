<?php

class TopicController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
        public $layout='//layouts/main';
	public $og_title = 'Techcamp Saigon 2014';
	public $og_description = "TechcampSaigon is a new evolution in the BarcampSaigon family. It's an event that focuses solely on technology and bringing in high quality in-depth speakers that can talk about topics that are relevant to computer scientists, engineers, outsourcing companies, tech companies, startups, and more. Topics will revolve around key themes like: mobile, web development, programming languages, servers, hardware, new frontiers of technology, and more.";
	public $og_type = 'article';
	public $og_image = 'http://techcamp.vn/techcamp_blog/wp-content/themes/mesocolumn/images/facebook-default.jpg';


	/**
	 * @return array action filters
	 */
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
				'actions'=>array('index','view','create','update', 'vote','api'),
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

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}


        public function renderTopic($model,$row) {
            return $this->renderPartial('_topic', array('model'=>$model));
        }

        public function renderSpeaker($model,$row) {
            return $this->renderPartial('_speaker', array('model'=>$model));
        }

        public function renderVote($model,$row) {
            return $this->renderPartial('_vote', array('model'=>$model));
        }


        public function actionAPI() {
          $model=new Topic();
          $model->unsetAttributes();
          $deviceId = $_REQUEST['device_id'];
	  //$updatedAt = $_REQUEST['updated_at'];

          $dataProvider = $model->search($deviceId);
          $result = array();

          foreach ($dataProvider->getData() as $data) {
            $result[$data->id] = array(
              'title'=>$data->title,
              'description'=>$data->description,
              'slide_url'=>$data->slide_url,
	      'duration'=>$data->duration,
              'speaker_name'=>$data->speaker_name,
              'speaker_description'=>$data->speaker_description,
              'speaker_url'=>$data->speaker_url,
              'created_at'=>$data->created_at,
              'updated_at'=>$data->updated_at,
              'vote_count'=>$data->vote_count,
              'voted'=>$data->vote_id ? true : false
            );
          }

          print json_encode($result);
        }

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
                $this->layout = '//layouts/minimal';
		$model=new Topic;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Topic']))
		{
			$model->attributes=$_POST['Topic'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Topic']))
		{
			$model->attributes=$_POST['Topic'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
                $this->layout = '//layouts/minimal';
                $model=new Topic('search');
                $model->unsetAttributes();  // clear any default values
                if(isset($_GET['Topic'])) {
                    $model->attributes=$_GET['Topic'];
                }
		$this->render('index',array(
                        'model'=>$model
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Topic('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Topic']))
			$model->attributes=$_GET['Topic'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

        public function actionVote() {
            if (isset($_POST['topic_id'])) {
              $vote = new Vote;
              $vote->id = $_POST['id'];
              $vote->topic_id = $_POST['topic_id'];

              $result = array('status'=>'Success');
              if (!$vote->save()) {
                $result['status'] = 'Failure';
                $result['errors'] = $vote->getErrors();
              }
              print json_encode($result);
            }
        }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Topic the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Topic::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Topic $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='topic-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
