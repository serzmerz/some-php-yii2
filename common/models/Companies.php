<?php

namespace common\models;

use Yii;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "companies".
 *
 * @property integer $id
 * @property string $name
 * @property string $address
 * @property string $img_url
 * @property string $description
 * @property integer $product_stage
 * @property integer $revenue
 * @property integer $raising
 * @property string $address_1
 * @property string $address_2
 * @property string $tel_1
 * @property string $tel_2
 * @property string $fax
 * @property string $website
 * @property integer $user_id
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @property User $user
 * @property CompanyProductStage $productStage
 * @property CompanyRaising $raising0
 * @property CompanyRevenue $revenue0
 */
class Companies extends \yii\db\ActiveRecord
{

    public $file;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'companies';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['file'], 'file', 'extensions' => 'jpg, png, gif'],
            [['name', 'address', 'product_stage', 'revenue', 'raising', 'tel_1', 'user_id'], 'required'],
            [['description'], 'string'],
            [['product_stage', 'revenue', 'raising', 'user_id', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'address', 'img_url', 'address_1', 'address_2', 'tel_1', 'tel_2', 'fax'], 'string', 'max' => 255],
            [['website'], 'string', 'max' => 50],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['product_stage'], 'exist', 'skipOnError' => true, 'targetClass' => CompanyProductStage::className(), 'targetAttribute' => ['product_stage' => 'id']],
            [['raising'], 'exist', 'skipOnError' => true, 'targetClass' => CompanyRaising::className(), 'targetAttribute' => ['raising' => 'id']],
            [['revenue'], 'exist', 'skipOnError' => true, 'targetClass' => CompanyRevenue::className(), 'targetAttribute' => ['revenue' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'file' => 'Logo',
            'id' => 'ID',
            'name' => 'Company Name',
            'address' => 'Public Address',
            'img_url' => 'Logo',
            'description' => 'Company Description',
            'product_stage' => 'Product Stage',
            'revenue' => 'Revenue',
            'raising' => 'Raising',
            'address_1' => 'Company Address One',
            'address_2' => 'Company Address Two',
            'tel_1' => 'Company Tel One',
            'tel_2' => 'Company Tel Two',
            'fax' => 'Fax',
            'website' => 'Website',
            'user_id' => 'User ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    /*    public function getUser()
        {
            return $this->hasOne(User::className(), ['id' => 'user_id']);
        }*/

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductStageAll()
    {
        $models = CompanyProductStage::find()->asArray()->all();
        return ArrayHelper::map($models, 'id', 'stage');
    }

    public function getProductStage()
    {
        return $this->hasOne(CompanyProductStage::className(), ['id' => 'product_stage']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRaisingAll()
    {
        $models = CompanyRaising::find()->asArray()->all();
        return ArrayHelper::map($models, 'id', 'raising');
    }

    public function getRaising0()
    {
        return $this->hasOne(CompanyRaising::className(), ['id' => 'raising']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRevenueAll()
    {
        $models = CompanyRevenue::find()->asArray()->all();
        return ArrayHelper::map($models, 'id', 'revenue');
    }

    public function getRevenue0()
    {
        return $this->hasOne(CompanyRevenue::className(), ['id' => 'revenue']);
    }

    public function getCooperation()
    {
        return $this->hasOne(Cooperation::className(), ['cooperation_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return CompaniesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CompaniesQuery(get_called_class());
    }

    public static function findCompanies($arrayWhereParams)
    {
        $allCompanies = Companies::find()
            ->select('c.*, s.stage product_stage, st.status cop_status,
             cooperation.id cop_id, inv.id inv_id, inv.name inv_name,
              inv.img_url inv_img, inv.description inv_description')
            ->from(Companies::tableName() . ' c')
            ->leftJoin('company_product_stage s', 'c.product_stage = s.id')
            ->innerJoinWith(['cooperation' => function ($query) {
                $query->onCondition(['cooperation_table' => 1]);
            }])
            ->leftJoin('cooperation_statuses st', 'cooperation.cooperation_status = st.id')
            ->leftJoin('investors inv', 'cooperation.parent_id=inv.id')
            ->where($arrayWhereParams);

        $clone_query = clone $allCompanies;
        $count = $clone_query->count();
        $pages = new Pagination(['totalCount' => $count]);
        $modelCompanies = $allCompanies->offset($pages->offset)
            ->limit($pages->limit)
            ->orderBy(['c.id' => SORT_DESC])
            ->asArray()
            ->all();
        return $array = [
            'count' => $count,
            'model' => $modelCompanies,
            'pages' => $pages,
        ];

    }
}
