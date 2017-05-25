<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "company_revenue".
 *
 * @property integer $id
 * @property string $revenue
 *
 * @property Companies[] $companies
 */
class CompanyRevenue extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'company_revenue';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['revenue'], 'required'],
            [['revenue'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'revenue' => 'Revenue',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanies()
    {
        return $this->hasMany(Companies::className(), ['revenue' => 'id']);
    }

    /**
     * @inheritdoc
     * @return CompanyRevenueQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CompanyRevenueQuery(get_called_class());
    }
}
