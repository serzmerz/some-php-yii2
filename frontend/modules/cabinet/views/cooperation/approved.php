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
        'arrayModelCompaniesRequest' => $arrayModelCompaniesRequest,
        'arrayModelInvestorsRequest' =>$arrayModelInvestorsRequest,
    ])?>

</section>

<section id="response-cooperation">

    <?=$this->render('_formApprovedResponse', [
        'arrayModelCompaniesResponse' => $arrayModelCompaniesResponse,
        'arrayModelInvestorsResponse' =>$arrayModelInvestorsResponse,
    ])?>

</section>