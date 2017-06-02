<?php
/**
 * @link https://github.com/bubasuma/yii2-simplechat
 * @copyright Copyright (c) 2015 bubasuma
 * @license http://opensource.org/licenses/BSD-3-Clause
 */

namespace frontend\models;

use bubasuma\simplechat\DataProvider;
use common\models\Companies;
use common\models\Investors;
use yii\db\ActiveQuery;
use yii\helpers\StringHelper;
use yii\helpers\Url;

/**
 * Class Conversation
 * @package bubasuma\simplechat\models
 *
 *
 * @author Buba Suma <bubasuma@gmail.com>
 * @since 2.0
 */
class Conversation extends \bubasuma\simplechat\db\Conversation
{
    public static $table_received;
    /**
     * @return DataProvider
     */

    public static function get($userId,$table,$limit = true, $history = true, $key = null)
    {
        self::$table_received = $table;
        $query = static::baseQuery($userId);
        if (null !== $key) {
            $query->andHaving([$history ? '<' : '>', 'last_message_id', $key]);
        }
        return new DataProvider([
            'query' => $query,
            'key' => 'last_message_id',
            'pagination' => [
                'pageSize' => $limit
            ]
        ]);
    }

    /*public function getContact()
    {
        return $this->hasOne(User::className(), ['id' => 'contact_id']);
    }*/

    public function getInvestor() {
        return $this->hasOne(Investors::className(), ['id' => 'contact_id']);
    }
    public function getCompany() {
        return $this->hasOne(Companies::className(), ['id'=> 'contact_id']);
    }
    public function getOrganization() {
        $table = self::$table_received;
        return $table === 1? $this->hasOne(Companies::className(), ['id'=> 'contact_id']) :
            $this->hasOne(Investors::className(), ['id' => 'contact_id']);
    }

    /**
     * @inheritDoc
     */
    public function fields()
    {
        return [
            'lastMessage' => function ($model) {
                return [
                    'text' => StringHelper::truncate($model['lastMessage']['text'], 20),
                    'date' => static::formatDate($model['lastMessage']['created_at']),
                    'senderId' => $model['lastMessage']['sender_id']
                ];
            },
            'newMessages' => function ($model) {
                return [
                    'count' => count($model['newMessages'])
                ];
            },
            'contact' => function ($model) {
                return $model['organization'];
            },
            'loadUrl',
            'sendUrl',
            'deleteUrl',
            'readUrl',
            'unreadUrl',
        ];
    }

    /**
     * @inheritDoc
     */
    protected static function baseQuery($userId)
    {
        return parent::baseQuery($userId) ->with(['newMessages', 'organization']);
    }

    public static function formatDate($value)
    {
        $today = date_create()->setTime(0, 0, 0);
        $date = date_create($value)->setTime(0, 0, 0);
        if ($today == $date) {
            $formatted = \Yii::$app->formatter->asTime($value, 'short');
        } elseif ($today->getTimestamp() - $date->getTimestamp() == 24 * 60 * 60) {
            $formatted = 'Yesterday';
        } elseif ($today->format('W') == $date->format('W') && $today->format('Y') == $date->format('Y')) {
            $formatted = \Yii::$app->formatter->asDate($value, 'php:l');
        } elseif ($today->format('Y') == $date->format('Y')) {
            $formatted = \Yii::$app->formatter->asDate($value, 'php:d F');
        } else {
            $formatted = \Yii::$app->formatter->asDate($value, 'medium');
        }
        return $formatted;
    }

    public function getLoadUrl()
    {
        return Url::to(['messages','contactId' => $this->contact_id]);
    }

    public function getSendUrl()
    {
        return Url::to(['create-message','contactId' => $this->contact_id]);
    }

    public function getDeleteUrl()
    {
        return Url::to(['delete-conversation','contactId' => $this->contact_id]);
    }

    public function getReadUrl()
    {
        return Url::to(['mark-conversation-as-read','contactId' => $this->contact_id]);
    }

    public function getUnreadUrl()
    {
        return Url::to(['mark-conversation-as-unread','contactId' => $this->contact_id]);
    }
    public static function tableName()
    {
        return Message::tableName();
    }
    public function getLastMessage()
    {
        return $this->hasOne(Message::className(), ['id' => 'last_message_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNewMessages()
    {
        return $this->hasMany(Message::className(), ['sender_id' => 'contact_id', 'receiver_id' => 'user_id'])
            ->andOnCondition(['is_new' => true]);
    }
}
