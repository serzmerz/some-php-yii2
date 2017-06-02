<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cooperation".
 *
 * @property integer $id
 * @property integer $cooperation_table
 * @property integer $cooperation_id
 * @property integer $cooperation_status
 * @property integer $user_id
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @property CooperationTables $cooperationTable
 * @property CooperationStatuses $cooperationStatus
 * @property User $user
 */
class Cooperation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cooperation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cooperation_table', 'cooperation_id', 'user_id'], 'required'],
            [['cooperation_table', 'cooperation_id', 'cooperation_status', 'user_id', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['cooperation_table'], 'exist', 'skipOnError' => true, 'targetClass' => CooperationTables::className(), 'targetAttribute' => ['cooperation_table' => 'id']],
            [['cooperation_status'], 'exist', 'skipOnError' => true, 'targetClass' => CooperationStatuses::className(), 'targetAttribute' => ['cooperation_status' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cooperation_table' => 'Cooperation Table',
            'cooperation_id' => 'Cooperation ID',
            'cooperation_status' => 'Cooperation Status',
            'user_id' => 'User ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCooperationTable()
    {
        return $this->hasOne(CooperationTables::className(), ['id' => 'cooperation_table']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCooperationStatus()
    {
        return $this->hasOne(CooperationStatuses::className(), ['id' => 'cooperation_status']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    public function getCompanies(){
        return $this->hasMany(Companies::className(), ['id'=> 'cooperation_id']);
    }
    public function getInvestors(){
        return $this->hasMany(Investors::className(), ['id'=> 'cooperation_id']);
    }
}
