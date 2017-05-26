<?php

namespace app\modules\cabinet\controllers;

use common\models\Cooperation;
use common\models\CooperationStatuses;
use common\models\Investors;
use Yii;
use common\models\Companies;

use common\controllers\AuthController;
use yii\data\Pagination;
use yii\db\Query;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\web\Request;


/**
 * CompaniesController implements the CRUD actions for Companies model.
 */
class CooperationController extends AuthController
{

    public function init()
    {
        parent::init();
        if (isset(\Yii::$app->params['layout']))
            $this->layout = \Yii::$app->params['layout'];
    }

    /**
     * Lists all Companies models.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->redirect('cooperation/out');

    }
    public function actionOut(){
        $user_id = Yii::$app->user->identity->getId();

        /*$query = Cooperation::find()->where(['user_id' => $user_id])->all();
        $arrayIdNotice = [];
        foreach ($query as $item){
            $arrayIdNotice[$item['cooperation_id']] = $item['cooperation_id'];
        }*/
        //$modelCompanies = Companies::findAll($arrayIdNotice);
        /*$allCompanies = Companies::find()
            ->select('c.*, s.stage product_stage, st.status cop_status')
            ->from(Companies::tableName() . ' c')
            ->joinWith(['cooperation' => function($query) {
                $query->onCondition(['cooperation_table' => 1]);
            }])
            ->leftJoin('cooperation_statuses st','cooperation.cooperation_status = st.id')
            ->leftJoin('company_product_stage s', 'c.product_stage = s.id')
            ->where(['c.status' => 1, 'c.id'=>$arrayIdNotice]);*/
        $allCompanies = Companies::find()
            ->select('c.*, s.stage product_stage, st.status cop_status, cooperation.id cop_id')
            ->from(Companies::tableName() . ' c')
            ->leftJoin('company_product_stage s', 'c.product_stage = s.id')
            ->innerJoinWith(['cooperation' => function($query) {
                $query->onCondition(['cooperation_table' => 1]);
            }])
            ->leftJoin('cooperation_statuses st','cooperation.cooperation_status = st.id')
            ->where(['c.status' => 1, 'cooperation.user_id'=>$user_id, 'cooperation.status' => 1]);

        $clone_query = clone $allCompanies;
        $count = $clone_query->count();
        $pages = new Pagination(['totalCount' => $count]);
        $modelCompanies = $allCompanies->offset($pages->offset)
            ->limit($pages->limit)
            ->orderBy(['c.id' => SORT_DESC])
            ->asArray()
            ->all();

        $allInvestors =  Investors::find()
            ->select('c.*, st.status cop_status, cooperation.id cop_id')
            ->from(Investors::tableName() .' c')
            ->innerJoinWith(['cooperation' => function($query) {
                $query->onCondition(['cooperation_table' => 2]);
            }])
            ->leftJoin('cooperation_statuses st','cooperation.cooperation_status = st.id')
            ->where(['c.status' => 1, 'cooperation.user_id'=>$user_id,'cooperation.status' => 1]);

        $clone_query2 = clone $allInvestors;
        $count2 = $clone_query2->count();
        $pages2 = new Pagination(['totalCount' => $count2]);
        $modelsInvestor = $allInvestors->offset($pages2->offset)
            ->limit($pages2->limit)
            ->orderBy(['c.id' => SORT_DESC])
            ->asArray()
            ->all();

        /*$modelNotice = [];
        foreach ($query as $model) {
            if ($model['identifier'] === 0) {
                $modelNotice[] = Companies::findOne($model['id_notice']);
            } else {
                $modelNotice[] = Investors::findOne($model['id_notice']);
            }
        }*/
        if(Yii::$app->request->isPost) {
            if(Yii::$app->getRequest()->post()['q'] === '1'){
                return $this->renderAjax('_formOutCompany', [
                    'count' => $count,
                    'modelCompanies' => $modelCompanies,
                    'pages' => $pages,
                ]);
            }
            if(Yii::$app->getRequest()->post()['q'] === '2') {
                return $this->renderAjax('_formOutInvestors', [
                    'count2' => $count2,
                    'modelInvestors' => $modelsInvestor,
                    'pages2' => $pages2,
                ]);
            }
        } else {
            return $this->render('out', [
                'count' => $count,
                'modelCompanies' => $modelCompanies,
                'pages' => $pages,
                'count2' => $count2,
                'modelInvestors' => $modelsInvestor,
                'pages2' => $pages2,

            ]);
        }
    }

    public function actionInput(){

            $user_id = Yii::$app->user->identity->getId();

        $allCompanies = Companies::find()
            ->select('c.*, s.stage product_stage, st.status cop_status, cooperation.id cop_id')
            ->from(Companies::tableName() . ' c')
            ->leftJoin('company_product_stage s', 'c.product_stage = s.id')
            ->innerJoinWith(['cooperation' => function($query) {
                $query->onCondition(['cooperation_table' => 1]);
            }])
            ->leftJoin('cooperation_statuses st','cooperation.cooperation_status = st.id')
            ->where(['c.status' => 1, 'c.user_id'=>$user_id, 'st.id' => 1, 'cooperation.status'=>1]);

        $clone_query = clone $allCompanies;
        $count = $clone_query->count();
        $pages = new Pagination(['totalCount' => $count]);
        $modelCompanies = $allCompanies->offset($pages->offset)
            ->limit($pages->limit)
            ->orderBy(['c.id' => SORT_DESC])
            ->asArray()
            ->all();

        $allInvestors =  Investors::find()
            ->select('c.*, st.status cop_status, cooperation.id cop_id')
            ->from(Investors::tableName() .' c')
            ->innerJoinWith(['cooperation' => function($query) {
                $query->onCondition(['cooperation_table' => 2]);
            }])
            ->leftJoin('cooperation_statuses st','cooperation.cooperation_status = st.id')
            ->where(['c.status' => 1, 'c.user_id'=>$user_id, 'st.id' => 1,'cooperation.status'=>1]);

        $clone_query2 = clone $allInvestors;
        $count2 = $clone_query2->count();
        $pages2 = new Pagination(['totalCount' => $count2]);
        $modelsInvestor = $allInvestors->offset($pages2->offset)
            ->limit($pages2->limit)
            ->orderBy(['c.id' => SORT_DESC])
            ->asArray()
            ->all();

        //$modelStatuses = new Cooperation();
        /*if ($modelStatuses->load(Yii::$app->request->post()) && $modelStatuses->save()) {
            //return $this->redirect(['view', 'id' => $model->id]);
        }*/
        if(Yii::$app->request->isPost) {
            if(Yii::$app->getRequest()->post()['q'] === '1'){
                return $this->renderAjax('_formCompany', [
                    'count' => $count,
                    'modelCompanies' => $modelCompanies,
                    'pages' => $pages,
                ]);
            }
            if(Yii::$app->getRequest()->post()['q'] === '2') {
                return $this->renderAjax('_formInvestors', [
                    'count2' => $count2,
                    'modelInvestors' => $modelsInvestor,
                    'pages2' => $pages2,
                ]);
            }
        } else {
            return $this->render('input', [
                'count' => $count,
                'modelCompanies' => $modelCompanies,
                'pages' => $pages,
                'count2' => $count2,
                'modelInvestors' => $modelsInvestor,
                'pages2' => $pages2,
            ]);
        }
    }

    public function actionApproved(){
        $user_id = Yii::$app->user->identity->getId();

        $allCompanies = Companies::find()
            ->select('c.*, s.stage product_stage, st.status cop_status, cooperation.id cop_id')
            ->from(Companies::tableName() . ' c')
            ->leftJoin('company_product_stage s', 'c.product_stage = s.id')
            ->innerJoinWith(['cooperation' => function($query) {
                $query->onCondition(['cooperation_table' => 1]);
            }])
            ->leftJoin('cooperation_statuses st','cooperation.cooperation_status = st.id')
            ->where(['c.status' => 1, 'c.user_id'=>$user_id, 'st.id' => 2, 'cooperation.status'=> 1]);

        $clone_query = clone $allCompanies;
        $count = $clone_query->count();
        $pages = new Pagination(['totalCount' => $count]);
        $modelCompanies = $allCompanies->offset($pages->offset)
            ->limit($pages->limit)
            ->orderBy(['c.id' => SORT_DESC])
            ->asArray()
            ->all();


        $allInvestors =  Investors::find()
            ->select('c.*, st.status cop_status, cooperation.id cop_id')
            ->from(Investors::tableName() .' c')
            ->innerJoinWith(['cooperation' => function($query) {
                $query->onCondition(['cooperation_table' => 2]);
            }])
            ->leftJoin('cooperation_statuses st','cooperation.cooperation_status = st.id')
            ->where(['c.status' => 1, 'c.user_id'=>$user_id, 'st.id' => 2,'cooperation.status'=>1]);

        $clone_query2 = clone $allInvestors;
        $count2 = $clone_query2->count();
        $pages2 = new Pagination(['totalCount' => $count2]);
        $modelsInvestor = $allInvestors->offset($pages2->offset)
            ->limit($pages2->limit)
            ->orderBy(['c.id' => SORT_DESC])
            ->asArray()
            ->all();



        /*Response*/
        $allCompaniesResponse = Companies::find()
            ->select('c.*, s.stage product_stage, st.status cop_status, cooperation.id cop_id')
            ->from(Companies::tableName() . ' c')
            ->leftJoin('company_product_stage s', 'c.product_stage = s.id')
            ->innerJoinWith(['cooperation' => function($query) {
                $query->onCondition(['cooperation_table' => 1]);
            }])
            ->leftJoin('cooperation_statuses st','cooperation.cooperation_status = st.id')
            ->where(['c.status' => 1, 'cooperation.user_id'=>$user_id, 'cooperation.status' => 1, 'cooperation.cooperation_status' =>2]);

        $clone_queryResponse = clone $allCompaniesResponse;
        $countResponse = $clone_queryResponse->count();
        $pagesResponse = new Pagination(['totalCount' => $countResponse]);
        $modelCompaniesResponse = $allCompaniesResponse->offset($pagesResponse->offset)
            ->limit($pagesResponse->limit)
            ->orderBy(['c.id' => SORT_DESC])
            ->asArray()
            ->all();

        $allInvestorsResponse =  Investors::find()
            ->select('c.*, st.status cop_status, cooperation.id cop_id')
            ->from(Investors::tableName() .' c')
            ->innerJoinWith(['cooperation' => function($query) {
                $query->onCondition(['cooperation_table' => 2]);
            }])
            ->leftJoin('cooperation_statuses st','cooperation.cooperation_status = st.id')
            ->where(['c.status' => 1, 'cooperation.user_id'=>$user_id,'cooperation.status' => 1,'cooperation.cooperation_status' =>2]);

        $clone_query2Response = clone $allInvestorsResponse;
        $count2Response = $clone_query2Response->count();
        $pages2Response = new Pagination(['totalCount' => $count2Response]);
        $modelsInvestorResponse = $allInvestorsResponse->offset($pages2Response->offset)
            ->limit($pages2Response->limit)
            ->orderBy(['c.id' => SORT_DESC])
            ->asArray()
            ->all();


        return $this->render('approved', [
            'count' => $count,
            'modelCompanies' => $modelCompanies,
            'pages' => $pages,
            'count2' => $count2,
            'modelInvestors' => $modelsInvestor,
            'pages2' => $pages2,
            'countResponse' => $countResponse,
            'modelCompaniesResponse' => $modelCompaniesResponse,
            'pagesResponse' => $pagesResponse,
            'count2Response' => $count2Response,
            'modelInvestorsResponse' => $modelsInvestorResponse,
            'pages2Response' => $pages2Response,
        ]);
    }

    public function actionCreateCompany($id){
        $user_id = Yii::$app->user->identity->getId();
        $model = new Cooperation();
        if(!empty(Yii::$app->getRequest()->post()['parent_id']))
            $model->parent_id = Yii::$app->getRequest()->post()['parent_id'];
        else $this->redirect(['//companies/index']);
        $model->cooperation_table = 1;
        $model->cooperation_id = $id;
        $model->user_id = $user_id;
         $date = new \DateTime('now');
        $date = $date->format('Y-m-d H:i:s');
        $model->created_at = $date;

        $model->parent_table = 2;
        if(Cooperation::find()->where(['cooperation_id' => $id, 'cooperation_table'=> 1,'user_id' =>$user_id, 'status'=>1])->exists()){
            return '<p>You early added this company to cooperation`s</p><a data-dismiss="modal" class="btn btn-success">Ok</a>';
        }
        if(Companies::find()->where(['id'=>$id, 'user_id'=>$user_id])->exists()){
            return '<p>This is you company</p><a data-dismiss="modal" class="btn btn-success">Ok</a>';
        }
        if($model->save()){
            return '<p>Company added to you cooperation</p><a data-dismiss="modal" class="btn btn-success">Ok</a>';
        }
        return '<p>Error! Company not added</p><a data-dismiss="modal" class="btn btn-success">Ok</a>';

    }

    public function actionCreateInvestors($id){
        $user_id = Yii::$app->user->identity->getId();
        $model = new Cooperation();
        $model->cooperation_table = 2;
        $model->cooperation_id = $id;
        $model->user_id = $user_id;

        $date = new \DateTime('now');
        $date = $date->format('Y-m-d H:i:s');

        $model->created_at = $date;
        if(Cooperation::find()->where(['cooperation_id' => $id, 'cooperation_table'=> 2, 'user_id' =>$user_id,'status'=>1])->exists()){
            return 0;
        }
        if(Investors::find()->where(['id'=>$id, 'user_id'=>$user_id])->exists()){
            return 3;
        }
        if($model->save()){
            return 1;
        }
        return 2;

    }
    public function actionUpdateStatus($id, $cooperation_status){
        $model = $this->findModel($id);
        $model->cooperation_status = $cooperation_status;
        if ($model->save()) {
            return true;
        } else {
            return false;
        }
    }

    public function actionDeleteStatus($id){
        $model = $this->findModel($id);
        $model->status = 0;
        if ($model->save()) {
            return true;
        } else {
            return false;
        }
    }

    protected function findModel($id)
    {
        if (($model = Cooperation::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }




}
