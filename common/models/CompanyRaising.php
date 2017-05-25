<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "company_raising".
 *
 * @property integer $id
 * @property string $raising
 *
 * @property Companies[] $companies
 */
class CompanyRaising extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'company_raising';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['raising'], 'required'],
            [['raising'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'raising' => 'Raising',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanies()
    {
        return $this->hasMany(Companies::className(), ['raising' => 'id']);
    }

    /**
     * @inheritdoc
     * @return CompanyRaisingQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CompanyRaisingQuery(get_called_class());
    }
}
