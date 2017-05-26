<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "investors".
 *
 * @property integer $id
 * @property string $name
 * @property string $address
 * @property string $net_worth
 * @property string $img_url
 * @property string $description
 * @property string $address_1
 * @property string $address_2
 * @property string $tel_1
 * @property string $tel_2
 * @property string $fax
 * @property integer $user_id
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @property User $user
 */
class Investors extends \yii\db\ActiveRecord
{

    public $file;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'investors';
    }

    public static function dropdown()
    {
        static $dropdown;
        if ($dropdown === null) {
            $models = static::find()->all();
            foreach ($models as $model) {
                $dropdown[$model->id] = $model->name;
            }
        }
        return $dropdown;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['file'], 'file', 'extensions' => 'jpg, png, gif'],
            [['name', 'address', 'net_worth', 'tel_1', 'user_id'], 'required'],
            [['description'], 'string'],
            [['user_id', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'address', 'net_worth', 'img_url', 'address_1', 'address_2'], 'string', 'max' => 255],
            [['tel_1', 'tel_2', 'fax'], 'string', 'max' => 50],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'name' => 'Investor Name',
            'address' => 'Public Address',
            'net_worth' => 'Net Worth',
            'img_url' => 'Logo',
            'description' => 'Investor Description',
            'address_1' => 'Investor Address One',
            'address_2' => 'Investor Address Two',
            'tel_1' => 'Investor Tel One',
            'tel_2' => 'Investor Tel Two',
            'fax' => 'Fax',
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
     * @inheritdoc
     * @return InvestorsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new InvestorsQuery(get_called_class());
    }
    public function getCooperation()
    {
        return $this->hasOne(Cooperation::className(), ['cooperation_id' => 'id']);
    }
}
