<?php
/* @var $this yii\web\View */
use common\models\CooperationStatuses;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Breadcrumbs;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;

$this->title = 'Likes';
$this->params['breadcrumbs'][] = $this->title;
$breadcrumbs = Breadcrumbs::widget([
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
]);
?>
<section id="companies-cooperation">
    <?=$this->render('_formInput', [
        'model' => $model,
    ])?>
</section>
<section id="approved-cooperation">
    <?=$this->render('_formInputApproved', [
        'model' =>$modelApproved
    ])?>
</section>