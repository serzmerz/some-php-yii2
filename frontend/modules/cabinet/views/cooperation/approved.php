<?php
/* @var $this yii\web\View */
use yii\widgets\Breadcrumbs;


$this->title = 'Likes';
$this->params['breadcrumbs'][] = $this->title;
$breadcrumbs = Breadcrumbs::widget([
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
]);
?>
<section id="request-cooperation">

    <?=$this->render('_formApprovedRequest', [
        'count' => $count,
        'modelCompanies' => $modelCompanies,
        'pages' => $pages,
        'count2' => $count2,
        'modelInvestors' => $modelInvestors,
        'pages2' => $pages2,
    ])?>

</section>

<section id="response-cooperation">

    <?=$this->render('_formApprovedResponse', [
        'count' => $countResponse,
        'modelCompanies' => $modelCompaniesResponse,
        'pages' => $pagesResponse,
        'count2' => $count2Response,
        'modelInvestors' => $modelInvestorsResponse,
        'pages2' => $pages2Response,
    ])?>

</section>