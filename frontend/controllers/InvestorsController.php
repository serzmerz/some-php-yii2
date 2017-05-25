<?php
namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use common\models\Investors;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;

class InvestorsController extends \yii\web\Controller
{
    public function init(){
        parent::init();
        if(isset(\Yii::$app->params['layout']))
            $this->layout = \Yii::$app->params['layout'] ;
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['view'],
                'rules' => [
                    [
                        'actions' => ['view'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex(){
        if(Yii::$app->request->method == 'POST'){
            $post = Yii::$app->request->post();
        }

        /*your query
         * $query = Investors::find()
            ->select('*')
            ->from(Investors::tableName())
            ->where(['status' => 1]);*/
        $user_id = null;
        if(!Yii::$app->user->isGuest) $user_id = Yii::$app->user->identity->getId();
        $query = Investors::find()
            ->select('c.*, cooperation.cooperation_id')
            ->from(Investors::tableName() .' c')
            ->joinWith(['cooperation' => function($query) use($user_id) {
                $query->onCondition(['cooperation_table' => 2,'cooperation.user_id' => $user_id, 'cooperation.status'=>1]);
            }])
            ->where(['c.status' => 1]);

        if(isset($post)  || !empty(Yii::$app->request->get('q'))){
            $p_q = !empty(Yii::$app->request->get('q'))? explode('|', Yii::$app->request->get('q')): false;
            $p_name = isset($post['name'])? $post['name']: $p_q[0]?: false;
            $p_city = isset($post['address'])? $post['address']: $p_q[1]?: false;

            if($p_name) $query->andWhere(['like', 'name', $p_name]);
            if($p_city) $query->andWhere(['like', 'address', $p_city]);
        }

        $clone_query = clone $query;
        $count = $clone_query->count();
        $pages = new Pagination(['totalCount' => $count, 'pageSize' => 7]);
        $pages->pageSizeParam = false;
        if(isset($post))
            $pages->params = ['name' => $post['name']];
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->orderBy(['id' => SORT_DESC])
            ->asArray()
            ->all();

        if(isset($post)){
            return $this->renderAjax('_investors_search', [
              'count' => $count,
              'models' => $models,
              'pages' => $pages
            ]);
        } else {
            return $this->render('index', [
                'count' => $count,
                'models' => $models,
                'pages' => $pages,
            ]);
        }
    }

    public function actionView($id){

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    protected function findModel($id){
        if (($model = Investors::findOne($id)) !== null) {
            if($model->status)
                return $model;
            else
                throw new NotFoundHttpException('The requested page does not exist.');
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
