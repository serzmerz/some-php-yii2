<?php

namespace common\models;

use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "menu_item".
 *
 * @property integer $id
 * @property integer $parent
 * @property integer $menu
 * @property string $title
 * @property string $href
 * @property integer $sort
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Menu $menu0
 */
class MenuItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent', 'menu', 'sort', 'status'], 'integer'],
            [['menu', 'title', 'href'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'href'], 'string', 'max' => 150],
            [['menu'], 'exist', 'skipOnError' => true, 'targetClass' => Menu::className(), 'targetAttribute' => ['menu' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent' => 'Parent',
            'menu' => 'Menu',
            'title' => 'Title',
            'href' => 'Href',
            'sort' => 'Sort',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenu0()
    {
        return $this->hasOne(Menu::className(), ['id' => 'menu']);
    }

    public static function getMenuItems($param)
    {
        $checkController = function ($route) use ($param) {
            return $route === $param;
        };
        $query = MenuItem::find()->where(['menu' => 3, 'status'=>1])->all();
        $query2 = MenuItem::find()->where(['menu' => 1,'status'=>1])->all();

        $menuArray = [];
        foreach ($query as $item) {

            $menuArray[] = [
                'label' => $item['title'],
                'url' => $item['href'],
                'active' => $checkController(strtolower($item['title']))
            ];
        }

        $menuCabinet = [];
        foreach ($query2 as $item) {
            $menuCabinet[] = [
                'label' => $item['title'],
                'url' => '/' . $item['href'],
                'active' => $checkController(strtolower($item['href']))
            ];
        }
        $menuCabinet[] = [
            'label' => 'Log out',
            'url' => ['/user/logout'],
            'linkOptions' => [
                'data-method' => 'post',
                'style' => 'font-weight: 700;',
            ]
        ];
        if ($checkController('cabinet/cooperation')) {
            $menuCooperation = [];
            $query3 = MenuItem::find()->where(['menu' => 4,'status'=>1])->all();
            foreach ($query3 as $item) {
                $menuCooperation[] = [
                    'label' => $item['title'],
                    'url' => '/' . $item['href'],
                    'active' => $checkController(strtolower($item['title']))
                ];
            }
            $menuItems[] =
                [
                    'label' => 'Cooperation`s',
                    'items' => $menuCooperation,
                ];
        }
        /*if ($checkController('message')) {
            $menuMessage = [];
            //$query3 = MenuItem::find()->where(['menu' => 4])->all();
            $users = [];
            $companies = Companies::find()->where(['user_id'=>Yii::$app->getUser()->getId()])->all();
            $investors = Investors::find()->where(['user_id'=>Yii::$app->getUser()->getId()])->all();

            foreach ($companies as $userItem) {
                $users[] = [
                    'label' => $userItem->name,
                    'url' => Url::to(['login-as', 'userId' => $userItem->id, 'table' => 1]),
                    'options' => ['class' => in_array($userItem->id, $except) ? 'disabled' : ''],
                    'linkOptions' => ['data-method' => 'post'],
                ];
            }
            foreach ($investors as $userItem) {
                $users[] = [
                    'label' => $userItem->name,
                    'url' => Url::to(['login-as', 'userId' => $userItem->id, 'table' => 2]),
                    'options' => ['class' => in_array($userItem->id, $except) ? 'disabled' : ''],
                    'linkOptions' => ['data-method' => 'post'],
                ];
            }
            /*foreach ($query3 as $item) {
                $menuMessage[] = [
                    'label' => $item['title'],
                    'url' => '/' . $item['href'],
                    'active' => $checkController(strtolower($item['title']))
                ];
            }*/
           /* $menuItems[] =
                [
                    'label' => 'Messages',
                    'items' => $menuMessage,
                ];
        }
*/
        $menuItems[] =
                [
                    'label' => 'Search',
                    'items' => $menuArray,
                ];
        $menuItems[] =
                [
                    'label' => Yii::$app->user->displayName,
                    'items' => $menuCabinet,
                    'visible' => !Yii::$app->user->isGuest,
                ];


        return $menuItems;
    }
}
