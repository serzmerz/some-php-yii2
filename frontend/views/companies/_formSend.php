<?php
use common\models\Investors;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;


?>

<?php Pjax::begin(); ?>
<?php
if(!Yii::$app->user->isGuest)
    $user_id = Yii::$app->user->identity->getId();
else $user_id = null;
if(Investors::find()->where(['user_id'=>$user_id])->exists()){
$investors = Investors::find()->where(['user_id'=>Yii::$app->user->identity->getId()])->all();
$items = ArrayHelper::map($investors,'id','name');
$params = [
    'style' => 'width:300px',
    'id' => 'name'
];
?>
<div class="request-form">
    <?php $form = ActiveForm::begin(['action' =>Url::to(['cabinet/cooperation/create-company','id'=>$id_notice]), 'method' => 'post','options' => ['data' => ['pjax' => true]]]); ?>


    <?=Html::label('Select your investor:','parent_id')?>
    <?=Html::dropDownList('parent_id', 'null', $items,$params);?>

<div class="form-group">
    <?= Html::submitButton('Add', ['class' => 'btn btn-success', 'onclick'=>'$(\'#job_star'.$id_notice.'\').addClass(\'added_link\');']) ?>
</div>
<?php ActiveForm::end(); ?>
</div>
<?php }
else echo "<p>You don`t hava any investors</p>";
?>
<?php Pjax::end(); ?>



