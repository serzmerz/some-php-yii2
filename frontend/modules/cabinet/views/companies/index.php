<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $searchModel common\models\Search\CompaniesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'My Companies';
$this->params['breadcrumbs'][] = $this->title;
$breadcrumbs = Breadcrumbs::widget([
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
]);
?>
      <section style="background: #fafafa;">
        <div class="container">
          <div class="row">
            <div class="col-lg-8 col-lg-offset-2">
              <div class="breadcrumbs">
                <?=$breadcrumbs?>
              </div>
              <h1 class="heading"><?= Html::encode($this->title) ?></h1>
              <p class="lead text-center">Manage and follow your companies.</p>
            </div>
          </div>
        </div>
      </section>
<section>
    <div class="container">
        <h3 class="heading">We have found <span class="accent"><?=$count?></span> startups</h3>
        <div class="row">
            <div class="col-lg-12 text-right margin-bottom--big">
        <?=Html::a('<i class="fa fa-plus"></i>Add new company',
            ['create'],
            ['class'=>'btn btn-primary'])
        ?>
            </div>
        </div>
<?php foreach($models as $model):  ?>
        <div class="job-listing">
            <div class="col-sm-12 col-md-6">
                <div class="row">
                    <div class="col-xs-2"><img src="<?=$model['img_url']?>" class="img-responsive"></div>
                    <div class="col-xs-10">
                        <h4 class="job__title">
                            <?=Html::a($model['name'], ['view?id=' . $model['id']])?>
                        </h4>
                        <p class="job__company"><?=$model['description']?></p>
                    </div>
                </div>
            </div>
            <div class="col-xs-10 col-xs-offset-2 col-sm-4 col-sm-offset-2 col-md-2 col-md-offset-0">
                <i class="fa fa-map-marker job__location"></i><span><?=$model['address']?></span>
            </div>
            <div class="col-xs-10 col-xs-offset-2 col-sm-4 col-sm-offset-0 col-md-3">
                <p><span class="label featured__label label-success"><?=$model['product_stage']?></span></p>
            </div>
            <div class="col-xs-10 col-xs-offset-2 col-sm-2 col-sm-offset-0 col-md-1">
                <?=Html::a('<i class="fa fa-edit"></i>Edit',
                    ['update?id=' . $model['id']],
                    ['class'=>'btn btn-default'])
                ?>
            </div>
        </div>
<?php endforeach; ?>
<?= LinkPager::widget(['pagination' => $pages])?>
    </div>
</section>
