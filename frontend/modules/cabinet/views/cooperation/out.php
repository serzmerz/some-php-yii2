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
    <?=$this->render('_formOutCompany', [
        'count' => $count,
        'modelCompanies' => $modelCompanies,
        'pages' => $pages
    ])?>
</section>
<section id="investors-cooperation">
    <?=$this->render('_formOutInvestors', [
        'count2' => $count2,
        'modelInvestors' => $modelInvestors,
        'pages2' => $pages2
    ])?>
</section>