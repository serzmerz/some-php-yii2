<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use yii\widgets\LinkPager;

$this->title = 'Likes';
$this->params['breadcrumbs'][] = $this->title;
$breadcrumbs = Breadcrumbs::widget([
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
]);
?>
<section id="companies-cooperation">
    <?=$this->render('_formOut', [
        'model' => $model,
    ])?>
</section>
<section id="approved-cooperation">
    <?=$this->render('_formOutApproved', [
        'model' =>$modelApproved
    ])?>
</section>
