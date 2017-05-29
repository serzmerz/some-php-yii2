<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;

?>
            <div class="container">
              <h3 class="heading">
                We have found <span class="accent"><?=$count?></span> investors</h3>
<?php foreach($models as $model): ?>
          <div class="job-listing">
            <div class="row">
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
                <i class="fa fa-map-marker job__location"></i><span><?=$model['address']?></span></div>
              <div class="col-xs-10 col-xs-offset-2 col-sm-4 col-sm-offset-0 col-md-3">
                <p><span class="label featured__label label-success"><?=$model['net_worth']?></span> </p>
              </div>
              <div class="col-xs-10 col-xs-offset-2 col-sm-2 col-sm-offset-0 col-md-1">
                  <div class="job__star">
                      <?php Pjax::begin(); ?>
                      <a id="job_star<?=$model['id']?>" data-user="" data-company="0" href="<?php if(Yii::$app->user->isGuest) echo Url::to(['user/login']); ?>" data-toggle="modal" data-placement="top"
                         title=""
                         class="job__star__link followbtn <?php if(!empty($model['cooperation_id']))
                             echo "added_link";
                         ?>"
                         data-original-title="Save to my investor" data-target="#modal<?=$model['id']?>">
                          <i class="fa fa-star "></i></a>
                      <?php Pjax::end(); ?>
                      <?php
                      yii\bootstrap\Modal::begin([
                          'headerOptions' => ['id' => 'modalHeader','class'=>'text-center'],
                          'header' => '<h2>Add to cooperation`s</h2>',
                          'id' => 'modal'.$model['id'],
                          //'size' => 'modal-lg',
                          //'clientOptions' => ['backdrop' => 'static', 'keyboard' => FALSE],
                          //'options'=>['style'=>'min-width:300px'],
                      ]);
                      echo $this->context->renderPartial('_formSend', [
                          'id_notice' =>$model['id']
                      ]);
                      yii\bootstrap\Modal::end();
                      ?>
                  </div>
              </div>
            </div>
          </div>
<?php endforeach; ?>
<?= LinkPager::widget(['pagination' => $pages])?>
            </div>