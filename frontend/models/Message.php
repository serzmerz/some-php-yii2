<?php
/**
 * @link https://github.com/bubasuma/yii2-simplechat
 * @copyright Copyright (c) 2015 bubasuma
 * @license http://opensource.org/licenses/BSD-3-Clause
 */

namespace frontend\models;

use bubasuma\simplechat\DataProvider;
use yii\db\Expression;
use yii\helpers\Html;

/**
 * Class Message
 * @package bubasuma\simplechat\models
 *
 * @author Buba Suma <bubasuma@gmail.com>
 * @since 1.0
 */
class Message extends \bubasuma\simplechat\db\Message
{
    public static function tableName()
    {
        return 'simplechat_message';
    }
    /**
     * @inheritDoc
     */
    public function fields()
    {
        return [
            'senderId' => 'sender_id',
            'text',
            'date' => function ($model) {
                return static::formatDate($model['created_at'])[1];
            },
            'when' => function ($model) {
                return static::formatDate($model['created_at'])[0];
            },
        ];
    }

    public static function formatDate($value)
    {
        $today = date_create()->setTime(0, 0, 0);
        $date = date_create($value)->setTime(0, 0, 0);
        if ($today == $date) {
            $label = 'Today';
        } elseif ($today->getTimestamp() - $date->getTimestamp() == 24 * 60 * 60) {
            $label = 'Yesterday';
        } elseif ($today->format('W') == $date->format('W') && $today->format('Y') == $date->format('Y')) {
            $label = \Yii::$app->formatter->asDate($value, 'php:l');
        } elseif ($today->format('Y') == $date->format('Y')) {
            $label = \Yii::$app->formatter->asDate($value, 'php:d F');
        } else {
            $label = \Yii::$app->formatter->asDate($value, 'medium');
        }
        $formatted = \Yii::$app->formatter->asTime($value, 'short');
        return [$label, $formatted];
    }

    public static function get($userId,$tableUser, $contactId, $tableContact = null, $limit = null, $history = true, $key = null)
    {
        $query = static::baseQuery($userId, $contactId, $tableUser, $tableContact);
        if (null !== $key) {
            $query->andWhere([$history ? '<' : '>', 'id', $key]);
        }
        return new DataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $limit
            ]
        ]);
    }

    protected static function baseQuery($userId, $contactId, $tableUser = null, $tableContact = null)
    {
        return static::find()
            ->between($userId, $contactId)
            ->andWhere(['or',
                ['sender_table' => $tableUser, 'received_table' => $tableContact, 'is_deleted_by_receiver' => false],
                ['sender_table' => $tableContact, 'received_table' => $tableUser, 'is_deleted_by_sender' => false],
            ])
            ->orderBy(['id' => SORT_DESC]);
    }
    public static function create($userId,$userTable,$contactId,$receivedTable = null, $text = null)
    {
        $instance = new static(['scenario' => 'create']);
        $instance->created_at = new Expression('UTC_TIMESTAMP()');
        $instance->sender_id = $userId;
        $instance->sender_table = $userTable;
        $instance->received_table = $receivedTable;
        $instance->receiver_id = $contactId;
        $instance->text = Html::encode($text);
        $instance->save();
        return $instance->errors;
    }

}
