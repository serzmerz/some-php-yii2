<?php

namespace app\modules\cabinet\controllers;

use bubasuma\simplechat\db\Conversation;
use bubasuma\simplechat\models\Message;
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

    public function actionOut()
    {
        $user_id = Yii::$app->user->identity->getId();

        $arrayWhereParams = ['c.status' => 1, 'cooperation.user_id' => $user_id, 'cooperation.status' => 1];

        $arrayModelCompanies = Companies::findCompanies($arrayWhereParams);
        $arrayModelInvestors = Investors::findInvestors($arrayWhereParams);

        if (Yii::$app->request->isPost) {
            if (Yii::$app->getRequest()->post()['q'] === '1') {
                return $this->renderAjax('_formOutCompany', [
                    'arrayModelCompanies' => $arrayModelCompanies,
                ]);
            }
            if (Yii::$app->getRequest()->post()['q'] === '2') {
                return $this->renderAjax('_formOutInvestors', [
                    'arrayModelInvestors' =>$arrayModelInvestors,
                ]);
            }
        } else {
            return $this->render('out', [
                'arrayModelCompanies' => $arrayModelCompanies,
                'arrayModelInvestors' =>$arrayModelInvestors,
            ]);
        }
    }

    public function actionInput()
    {

        $user_id = Yii::$app->user->identity->getId();

        $arrayWhereParams = ['c.status' => 1, 'c.user_id' => $user_id, 'st.id' => 1,'cooperation.status' => 1];

        $arrayModelCompanies = Companies::findCompanies($arrayWhereParams);
        $arrayModelInvestors = Investors::findInvestors($arrayWhereParams);


        if (Yii::$app->request->isPost) {
            if (Yii::$app->getRequest()->post()['q'] === '1') {
                return $this->renderAjax('_formCompany', [
                    'arrayModelCompanies' => $arrayModelCompanies,
                ]);
            }
            if (Yii::$app->getRequest()->post()['q'] === '2') {
                return $this->renderAjax('_formInvestors', [
                    'arrayModelInvestors' =>$arrayModelInvestors,
                ]);
            }
        } else {
            return $this->render('input', [
                'arrayModelCompanies' => $arrayModelCompanies,
                'arrayModelInvestors' =>$arrayModelInvestors,
            ]);
        }
    }

    public function actionApproved()
    {
        $user_id = Yii::$app->user->identity->getId();

        $arrayWhereParamsRequest = ['c.status' => 1, 'c.user_id' => $user_id, 'st.id' => 2, 'cooperation.status' => 1];
        $arrayModelCompaniesRequest = Companies::findCompanies($arrayWhereParamsRequest);
        $arrayModelInvestorsRequest = Investors::findInvestors($arrayWhereParamsRequest);

        $arrayWhereParamsResponse = ['c.status' => 1, 'cooperation.user_id' => $user_id,
            'cooperation.status' => 1, 'cooperation.cooperation_status' => 2];
        $arrayModelCompaniesResponse = Companies::findCompanies($arrayWhereParamsResponse);
        $arrayModelInvestorsResponse = Investors::findInvestors($arrayWhereParamsResponse);

        if (Yii::$app->request->isPost) {
            if (Yii::$app->getRequest()->post()['q'] === '1') {
                return $this->renderAjax('_formApprovedRequest', [
                    'arrayModelCompaniesRequest' => $arrayModelCompaniesRequest,
                    'arrayModelInvestorsRequest' =>$arrayModelInvestorsRequest,
                ]);
            }
            if (Yii::$app->getRequest()->post()['q'] === '2') {
                return $this->renderAjax('_formApprovedResponse', [
                    'arrayModelCompaniesResponse' => $arrayModelCompaniesResponse,
                    'arrayModelInvestorsResponse' =>$arrayModelInvestorsResponse,
                ]);
            }
        } else {
            return $this->render('approved', [
                'arrayModelCompaniesRequest' => $arrayModelCompaniesRequest,
                'arrayModelInvestorsRequest' =>$arrayModelInvestorsRequest,
                'arrayModelCompaniesResponse' => $arrayModelCompaniesResponse,
                'arrayModelInvestorsResponse' =>$arrayModelInvestorsResponse,
            ]);
        }
    }

    public function actionCreateCompany($id)
    {
        if (empty(Yii::$app->getRequest()->post()['parent_id'])) {
            return $this->redirect(['//companies/index']);
        } else {
            $user_id = Yii::$app->user->identity->getId();
            $model = new Cooperation();
            $model->parent_id = Yii::$app->getRequest()->post()['parent_id'];
            $model->cooperation_table = 1;
            $model->cooperation_id = $id;
            $model->user_id = $user_id;
            $date = new \DateTime('now');
            $date = $date->format('Y-m-d H:i:s');
            $model->created_at = $date;

            $model->parent_table = 2;
            if (Cooperation::find()->where(['cooperation_id' => $id, 'cooperation_table' => 1, 'user_id' => $user_id, 'status' => 1])->exists()) {
                return '<p>You early added this company to cooperation`s</p><a data-dismiss="modal" class="btn btn-success">Ok</a>';
            }
            if (Companies::find()->where(['id' => $id, 'user_id' => $user_id])->exists()) {
                return '<p>This is you company</p><a data-dismiss="modal" class="btn btn-success">Ok</a>';
            }
            if ($model->save()) {
                return '<p>Company added to you cooperation</p><a data-dismiss="modal" class="btn btn-success">Ok</a>';
            }
            return '<p>Error! Company not added</p><a data-dismiss="modal" class="btn btn-success">Ok</a>';
        }
    }

    public function actionCreateInvestors($id)
    {
        if (empty(Yii::$app->getRequest()->post()['parent_id'])) {
            return $this->redirect(['//companies/index']);
        } else {
            $user_id = Yii::$app->user->identity->getId();
            $model = new Cooperation();
            $model->cooperation_table = 2;
            $model->cooperation_id = $id;
            $model->user_id = $user_id;
            $model->parent_id = Yii::$app->getRequest()->post()['parent_id'];
            $model->parent_table = 1;

            $date = new \DateTime('now');
            $date = $date->format('Y-m-d H:i:s');

            $model->created_at = $date;
            if (Cooperation::find()->where(['cooperation_id' => $id, 'cooperation_table' => 2, 'user_id' => $user_id, 'status' => 1])->exists()) {
                return '<p>You early added this investor to cooperation`s</p><a data-dismiss="modal" class="btn btn-success">Ok</a>';
            }
            if (Investors::find()->where(['id' => $id, 'user_id' => $user_id])->exists()) {
                return '<p>This is you investor</p><a data-dismiss="modal" class="btn btn-success">Ok</a>';
            }
            if ($model->save()) {
                return '<p>Investor added to you cooperation</p><a data-dismiss="modal" class="btn btn-success">Ok</a>';
            }
            return '<p>Error! Investor not added</p><a data-dismiss="modal" class="btn btn-success">Ok</a>';
        }
    }

    public function actionUpdateStatus($id, $cooperation_status)
    {
        $model = $this->findModel($id);
        $model->cooperation_status = $cooperation_status;

            \bubasuma\simplechat\db\Message::create(1,8,"Init");

        if ($model->save()) {
            return true;
        } else {
            return false;
        }
    }

    public function actionDeleteStatus($id)
    {
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
