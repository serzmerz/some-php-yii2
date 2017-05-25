<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;

?>
            <div class="container">
              <h3 class="heading">
                We have found <span class="accent"><?=$count?></span> startups</h3>
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
                <p><span class="label featured__label label-success"><?=$model['product_stage']?></span> </p>
              </div>
              <div class="col-xs-10 col-xs-offset-2 col-sm-2 col-sm-offset-0 col-md-1">
                  <div class="job__star">
                      <?php Pjax::begin(); ?>
                      <a onclick="<?php if(!Yii::$app->user->isGuest) echo "$.ajax({
                        url: '". Url::to(['cabinet/cooperation/create-company', 'id' => $model['id']])."',
                            success: function(data){
                            switch(data){
                            case '0':alert('You early added this company to cooperation\'s');break;
                            case '1':alert('You added this company to cooperation');break;
                            case '2':alert('Error! Company not added');break;
                            case '3':alert('This is you company');break;
                            default: alert('Error!');
                            }
                        }});";?>"
                         data-user="" data-company="0" href="<?php if(Yii::$app->user->isGuest) echo Url::to(['user/login']); ?>" data-toggle="tooltip" data-placement="top"
                         title=""
                         class="job__star__link followbtn <?php if(!empty($model['cooperation_id']))
                             echo "added_link";
                         ?>"
                         data-original-title="Save to my companies">
                          <i class="fa fa-star "></i></a>
                      <?php Pjax::end(); ?>
                  </div>
              </div>
            </div>
          </div>
<?php endforeach; ?>
<?= LinkPager::widget(['pagination' => $pages])?>
            </div>