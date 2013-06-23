<?php

class PostController extends Controller
{
	private $_model;

	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
				'accessControl', // perform access control for CRUD operations
				'postOnly + delete', // we only allow deletion via POST request
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
				array('allow',  // 全てのユーザに 'index' と 'view' のアクションを許可
						'actions'=>array('index','view'),
						'users'=>array('*'),
				),
				array('allow', // 認証されたユーザにすべてのアクションを許可
						// 'actions'=>array('create','update'),
						'users'=>array('@'),
				),
				/*
				 array('allow', // allow admin user to perform 'admin' and 'delete' actions
				 		'actions'=>array('admin','delete'),
				 		'users'=>array('admin'),
				 ),
		*/
				array('deny',  // 全てのユーザのアクセスを拒否
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
		$post = $this->loadModel($id);
		$comment = $this->newComment($post);
		$this->render('view',array(
				'model' => $post,
				'comment' => $comment,
		));
	}

	protected function newComment($post)
	{
		$comment=new Comment;

		$this->performAjaxValidation($post);

		if(isset($_POST['Comment']))
		{
			$comment->attributes=$_POST['Comment'];
			if($post->addComment($comment))
			{
				if($comment->status==Comment::STATUS_PENDING)
					Yii::app()->user->setFlash('commentSubmitted','コメント、有難うございます。コメントは承認後に投稿されます。');
				$this->refresh();
			}
		}
		return $comment;
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Post;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Post']))
		{
			$model->attributes=$_POST['Post'];
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
		$this->performAjaxValidation($model);

		if(isset($_POST['Post']))
		{
			$model->attributes=$_POST['Post'];
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
		if(Yii::app()->request->isPostRequest) {
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		} else {
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
		}
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex($tag = '')
	{
		$criteria = new CDbCriteria(array(
				'condition'=>'status='.Post::STATUS_PUBLISHED,
				'order'=>'update_time DESC',
				'with'=>'commentCount',
		));
		if ($tag !== null) {
			$criteria->addSearchCondition('tags', $tag);
		}

		$dataProvider = new CActiveDataProvider('Post', array(
				'pagination'=>array(
						'pageSize'=>5,
				),
				'criteria'=>$criteria,
		));
		$this->render('index',array(
				'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Post('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Post']))
			$model->attributes=$_GET['Post'];

		$this->render('admin',array(
				'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Post the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		if ($this->_model === null) {
			if ($id !== null) {
				if (Yii::app()->user->isGuest) {
					$condition = 'status='.Post::STATUS_PUBLISHED.' OR status='.Post::STATUS_ARCHIVED;
				} else {
					$condition = '';
				}
				$this->_model=Post::model()->findByPk($id, $condition);
			}

			if ($this->_model === null) {
				throw new CHttpException(404,'リクエストされたページは存在しません。');
			}
		}

		return $this->_model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Post $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='post-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
