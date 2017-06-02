<?php

namespace app\modules\cabinet\controllers;

use Yii;
use common\models\Companies;
use common\models\Search\CompaniesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use common\controllers\AuthController;
use yii\data\Pagination;

use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use yii\imagine\Image;
use Imagine\Gd;
use Imagine\Image\Box;
use Imagine\Image\BoxInterface;

/**
 * CompaniesController implements the CRUD actions for Companies model.
 */
class CompaniesController extends AuthController
{

    public $name_model = 'Companies';

    public function init(){
        parent::init();
        if(isset(\Yii::$app->params['layout']))
            $this->layout = \Yii::$app->params['layout'] ;
    }

    /**
     * Lists all Companies models.
     * @return mixed
     */
    public function actionIndex(){

        $user_id = Yii::$app->user->identity->id;

        $query = Companies::find()
            ->select('c.*, s.stage product_stage')
            ->from(Companies::tableName() . ' c')
            ->leftJoin('company_product_stage s', 'c.product_stage = s.id')
            ->where(['c.user_id' => $user_id, 'c.status' => 1]);
        $clone_query = clone $query;
        $count = $clone_query->count();
        $pages = new Pagination(['totalCount' => $count]);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->orderBy(['c.id' => SORT_DESC])
            ->asArray()
            ->all();
        return $this->render('index', [
            'count' => $count,
            'models' => $models,
            'pages' => $pages,
        ]);
    }

    /**
     * Displays a single Companies model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id){

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Companies model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Companies();

        if(Yii::$app->request->method == 'POST'){
            $user_id = Yii::$app->user->identity->id;
            // $name_model = basename($model::className());
            $name_model = $this->name_model;
            $post = Yii::$app->request->post();
            $post[$name_model]['user_id'] = (string)$user_id;
            $post[$name_model]['img_url'] = '/image/default_s.jpg';

            $model->file = UploadedFile::getInstance($model, 'file');
            if($model->file && $model->validate()){
                $path = 'image/users/' . Yii::$app->user->id . '/' . lcfirst($name_model);
                FileHelper::createDirectory($path);
                $path .= '/' . $model->id . '.' . $model->file->extension;
                $model->file->saveAs($path);
                Image::thumbnail($path, 200, 200)
                    ->resize(new Box(200, 200))
                    ->save($path, ['quality' => 90]);
                $post[$name_model]['img_url'] = '/' . $path;
            }

            $date = new \DateTime('now');
            $date = $date->format('Y-m-d H:i:s');
            $post[$name_model]['created_at'] = $date;

            if($model->load($post) && $model->save())
                return $this->redirect(['view', 'id' => $model->id]);

        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Companies model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id){

        $model = $this->findModel($id);

        if(Yii::$app->request->method == 'POST'){
            $name_model = $this->name_model;
            $post = Yii::$app->request->post();

            $model->file = UploadedFile::getInstance($model, 'file');
            if($model->file && $model->validate()){
                $path = 'image/users/' . Yii::$app->user->id . '/' . lcfirst($name_model);
                FileHelper::createDirectory($path);
                $path .= '/' . $model->id . '.' . $model->file->extension;
                $model->file->saveAs($path);
                Image::thumbnail($path, 200, 200)
                    ->resize(new Box(200, 200))
                    ->save($path, ['quality' => 90]);
                $post[$name_model]['img_url'] = '/' . $path;
            }

            $date = new \DateTime('now');
            $date = $date->format('Y-m-d H:i:s');
            $post[$name_model]['updated_at'] = $date;

            if($model->load($post) && $model->save())
                return $this->redirect(['view', 'id' => $model->id]);

        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Companies model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id){

        $model = $this->findModel($id);
        $model->status = 0;
        $model->save();

        // $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Companies model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Companies the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Companies::findOne($id)) !== null) {

            $user_id = Yii::$app->user->identity->id;

            if($model->user_id == $user_id && $model->status)
                return $model;
            else
                throw new NotFoundHttpException('The requested page does not exist.');
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
