<?php
namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use common\models\Companies;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;

// use common\models\Search\CompaniesSearch;

class CompaniesController extends \yii\web\Controller
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
        $user_id = null;
        if(!Yii::$app->user->isGuest) $user_id = Yii::$app->user->identity->getId();

        if(Yii::$app->request->method == 'POST'){
            $post = Yii::$app->request->post();
        }

        $model = new Companies();
        $name = lcfirst(basename($model::className()));

        // $search = $model::find()
        //     ->select(['name as value', 'name as  label', 'id as id'])
        //     ->asArray()
        //     ->all();

        // ?name=t&address=l

        /*your query
         * $query = $model::find()
            ->select('c.*, s.stage product_stage')
            ->from($model::tableName() . ' c')
            ->leftJoin('company_product_stage s', 'c.product_stage = s.id')
            ->where(['c.status' => 1]);*/

        $query = $model::find()
            ->select('c.*, s.stage product_stage, cooperation.cooperation_id')
            ->from($model::tableName() . ' c')
            ->leftJoin('company_product_stage s', 'c.product_stage = s.id')
            ->joinWith(['cooperation' => function($query) use ($user_id) {
                $query->onCondition(['cooperation_table' => 1,'cooperation.user_id' => $user_id, 'cooperation.status'=> 1]);
            }])
            ->where(['c.status' => 1]);

        if(isset($post)  || !empty(Yii::$app->request->get('q'))){
            $p_q = !empty(Yii::$app->request->get('q'))? explode('|', Yii::$app->request->get('q')): false;
            $p_name = isset($post['name'])? $post['name']: $p_q[0]?: false;
            $p_city = isset($post['address'])? $post['address']: $p_q[1]?: false;

            if($p_name) $query->andWhere(['like', 'c.name', $p_name]);
            if($p_city) $query->andWhere(['like', 'c.address', $p_city]);
        }

        $clone_query = clone $query;
        $count = $clone_query->count();
        $pages = new Pagination(['totalCount' => $count, 'pageSize' => 7]);
        $pages->pageSizeParam = false;
        if(isset($post))
            $pages->params = ['name' => $post['name']];
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->orderBy(['c.id' => SORT_DESC])
            ->asArray()
            ->all();

        if(isset($post)){
            return $this->renderAjax('_companies_search', [
              'count' => $count,
              'models' => $models,
              'pages' => $pages
            ]);
        } else {
            return $this->render('index', [
                // 'name' => $name,
                // 'search' => $search,
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
        if (($model = Companies::findOne($id)) !== null) {
            if($model->status)
                return $model;
            else
                throw new NotFoundHttpException('The requested page does not exist.');
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
