<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cooperation_statuses".
 *
 * @property integer $id
 * @property string $status
 *
 * @property Cooperation[] $cooperations
 */
class CooperationStatuses extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cooperation_statuses';
    }

    public static function dropdown()
    {

    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'required'],
            [['status'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCooperations()
    {
        return $this->hasMany(Cooperation::className(), ['cooperation_status' => 'id']);
    }
}
