<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;

class IndexController extends \amnah\yii2\user\controllers\DefaultController
{
	public function init(){
		parent::init();
		if(isset(\Yii::$app->params['layout']))
			$this->layout = '//' . \Yii::$app->params['layout'] ;
	}

    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return $this->actionLogin();
        } else {
            return $this->redirect(['/search']);
        }
    }

    /**
     * Display login page
     */
    public function actionLogin(){
        $this->layout = '//home';
        $model = $this->module->model("LoginForm");
		  parent::actionLogin();
        return $this->render('//home/login', compact("model"));
    }


    public function actionRegister(){
    	$this->layout = '//home';
    	parent::actionRegister();
    	$user = $this->module->model("User", ["scenario" => "register"]);
      $profile = $this->module->model("Profile");
      $requireEmail = $this->module->requireEmail;
		$requireUsername = $this->module->requireUsername;
    	return $this->render("//home/register", compact("user", "profile", 'requireEmail', 'requireUsername'));
    }

    // public function actionLogout(){}
    // public function actionProfile(){}
}