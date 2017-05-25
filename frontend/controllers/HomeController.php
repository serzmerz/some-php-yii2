<?php
namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use common\models\Companies;
use common\models\Investors;
use yii\data\Pagination;

class HomeController extends \yii\web\Controller
{
    public function init(){
        parent::init();
        if(isset(\Yii::$app->params['layout']))
            $this->layout = \Yii::$app->params['layout'] ;
    }

    /**
    * @inheritdoc
    */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
                'view' => '@app/views/common/error.php'
            ]
        ];
    }

    public function actionIndex(){
        $models = Companies::find()
            ->select('id, name, img_url')
            ->from(Companies::tableName())
            ->where(['status' => 1])
            ->limit(6)
            ->asArray()
            ->all();

        return $this->render('index', [
            'models' => $models,
        ]);
    }

}
