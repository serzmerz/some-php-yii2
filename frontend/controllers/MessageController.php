<?php
namespace frontend\controllers;

//...
use bubasuma\simplechat\controllers\DefaultController;
use bubasuma\simplechat\models\Conversation;
use bubasuma\simplechat\models\Message;
use bubasuma\simplechat\models\User;
use bubasuma\simplechat\Module;
use common\models\Companies;
use common\models\Investors;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;


//...

class MessageController extends DefaultController
{

    protected $_table;

    public function actionIndex($contactId = null)
    {
        $this->setUser(5,1);

        $user = $this->user;
        //debug($user);
        //$user = Yii::$app->getUser();
        if ($contactId == $user['id']) {
            throw new ForbiddenHttpException('You cannot open this conversation');
        }
        if (isset($contactId)) {
            $current = new Conversation(['user_id' => $user['id'],'table_sender'=>$this->_table, 'contact_id' => $contactId, 'table_contact' => 2]);
        }
        /** @var $conversationClass Conversation */
        $conversationClass = $this->conversationClass;
        $conversationDataProvider = $conversationClass::get($user['id'], $this->_table, 8);
        debug($conversationDataProvider);
        //debug($conversationDataProvider);
        if (!isset($current)) {
            if (0 == $conversationDataProvider->getTotalCount()) {
                throw new NotFoundHttpException('You have no active conversations');
            }
            $current = current($conversationDataProvider->getModels());
        }
        debug($current);
        $contact = $current['contact'];
        debug($contact);
        if (empty($contact)) {
            throw new NotFoundHttpException();
        }
        $this->view->title = $contact['name'];
        /** @var $messageClass Message */
        $messageClass = $this->messageClass;
        $messageDataProvider = $messageClass::get($user['id'], $contact['id'], 10);
        $users = $this->getUsers([$user['id'], $contact['id']]);
        return $this->render(
            'index.twig',
            compact('conversationDataProvider', 'messageDataProvider', 'users', 'user', 'contact', 'current')
        );
    }
    /**
     * @return Companies|Investors|MessageController
     */
    public function getUser()
    {
        if (null === $this->_user) {

            if(\Yii::$app->session->get($this->module->id . '_table', 1) === 1){
                $this->_user = Companies::findOne(\Yii::$app->session->get($this->module->id . '_user', 1));
                $this->_table = 1;
            }
               if(\Yii::$app->session->get($this->module->id . '_table', 1) === 2){
                   $this->_user = Investors::findOne(\Yii::$app->session->get($this->module->id . '_user', 1));
               $this->_table = 2;
            }
               //$this->_user = User::findIdentity(Yii::$app->getUser()->getId());
        }
        return $this->_user;
    }

    /**
     * @param $userId
     * @param $table
     * override
     */
    public function setUser($userId, $table)
    {
        \Yii::$app->session->set($this->module->id . '_user', $userId);
        \Yii::$app->session->set($this->module->id . '_table', $table);

    }
    public function actionLoginAs($userId, $table)
    {
        $this->setUser($userId, $table);
        return $this->redirect(['index']);
    }

    public function getUsers(array $except = [])
    {
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

        return $users;
    }

}