<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;
?>

<div class="container">
    <h3 class="heading">
        Your request approved: <span class="accent"><?=$count+$count2?></span></h3>
    <h4>Companies:</h4>
    <?php foreach($modelCompanies as $model){ ?>
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
                        <p><?=$model['cop_status']?></p>
                        <?php Pjax::begin(); ?>
                        <a onclick="$.ajax({
                            url: '<?php echo Url::to(['cooperation/delete-status', 'id' => $model['cop_id']])?>',
                            success: function(data){
                            if(data){alert('Successful!');
                            $.ajax({
                            url:'<?php echo Url::to(['cooperation/out'])?>',
                            type: 'post',
                            data:{'q':'1'},
                            response:'text',
                            success:function (html) {
                            $('#companies-cooperation').html(html);
                            }
                            });
                            }
                            else alert('Not removed!');
                            }
                            });">
                            <i class="fa fa-remove"></i>
                        </a>
                        <?php Pjax::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <?= LinkPager::widget(['pagination' => $pages])?>

    <h4>Investors:</h4>
    <?php foreach($modelInvestors as $model){ ?>
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
                    <p><?=$model['cop_status']?></p>
                    <?php Pjax::begin(); ?>
                    <a onclick="$.ajax({
                        url: '<?php echo Url::to(['cooperation/delete-status', 'id' => $model['cop_id']])?>',
                        success: function(data){
                        if(data){alert('Successful!');
                        $.ajax({
                        url:'<?php echo Url::to(['cooperation/out'])?>',
                        type: 'post',
                        data:{'q':'1'},
                        response:'text',
                        success:function (html) {
                        $('#companies-cooperation').html(html);
                        }
                        });
                        }
                        else alert('Not removed!');
                        }
                        });">
                        <i class="fa fa-remove"></i>
                    </a>
                    <?php Pjax::end(); ?>
                </div>
            </div>
        </div>
    <?php } ?>
    <?= LinkPager::widget(['pagination' => $pages2])?>
</div>