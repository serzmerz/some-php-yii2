<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "company_product_stage".
 *
 * @property integer $id
 * @property string $stage
 *
 * @property Companies[] $companies
 */
class CompanyProductStage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'company_product_stage';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['stage'], 'required'],
            [['stage'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'stage' => 'Stage',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanies()
    {
        return $this->hasMany(Companies::className(), ['product_stage' => 'id']);
    }

    /**
     * @inheritdoc
     * @return CompanyProductStageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CompanyProductStageQuery(get_called_class());
    }
}
