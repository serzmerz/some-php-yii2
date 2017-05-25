<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cooperation_tables".
 *
 * @property integer $id
 * @property string $table
 *
 * @property Cooperation[] $cooperations
 */
class CooperationTables extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cooperation_tables';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['table'], 'required'],
            [['table'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'table' => 'Table',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCooperations()
    {
        return $this->hasMany(Cooperation::className(), ['cooperation_table' => 'id']);
    }
}
