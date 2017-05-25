<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\widgets\LinkPager;

$this->title = 'Search Companies';
$this->params['breadcrumbs'][] = $this->title;
$breadcrumbs = Breadcrumbs::widget([
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
]);
?>
<section class="job-form-section job-form-section--compressed">
            <div class="container">
              <div class="row">
                <div class="col-lg-8 col-lg-offset-2">
                  <div class="breadcrumbs">
                    <?=$breadcrumbs?>
                  </div>
                  <h1 class="heading"><?= Html::encode($this->title) ?></h1>
                </div>
              </div>
            </div>
          </section>

          <section>
            <div class="container">
              <h3 class="heading">
                We have found <span class="accent"><?=$count?></span> startups</h3>
<? foreach($models as $model): ?>
          <div class="job-listing">
            <div class="row">
              <div class="col-sm-12 col-md-6">
                <div class="row">
                  <div class="col-xs-2"><img src="<?=$model['img_url']?>" class="img-responsive"></div>
                  <div class="col-xs-10">
                    <h4 class="job__title">
                      <?=Html::a($model['name'], ['company?id=' . $model['id']])?>
                    </h4>
                    <p class="job__company"><?=$model['description']?></p>
                  </div>
                </div>
              </div>
              <div class="col-xs-10 col-xs-offset-2 col-sm-4 col-sm-offset-2 col-md-2 col-md-offset-0">
                <i class="fa fa-map-marker job__location"></i><span><?=$model['address']?></span></div>
              <div class="col-xs-10 col-xs-offset-2 col-sm-4 col-sm-offset-0 col-md-3">
                <p><span class="label featured__label label-success"><?=$model['product_stage']?></span> </p>
              </div>
              <div class="col-xs-10 col-xs-offset-2 col-sm-2 col-sm-offset-0 col-md-1">
                <div class="job__star">
                  <a data-user="" data-company="0" href="#" data-toggle="tooltip" data-placement="top" title="" class="job__star__link followbtn" data-original-title="Save to my companies"><i class="fa fa-star "></i></a></div>
              </div>
            </div>
          </div>
<? endforeach; ?>
<?= LinkPager::widget(['pagination' => $pages])?>
            </div>
          </section>