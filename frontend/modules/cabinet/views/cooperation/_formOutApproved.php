<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;
?>
<div class="container">
    <h3 class="heading">
        Approved request <span class="accent"><?=$model['count']?></span></h3>
    <?php foreach($model['model'] as $item){ ?>
        <div class="job-listing">
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <h4>To <?php echo ($item['cop_table'] === '1') ? 'company' : 'investor'; ?>:</h4>
                    <div class="row">
                        <div class="col-xs-2"><img src="<?=$item['img']?>" class="img-responsive"></div>
                        <div class="col-xs-10">
                            <h4 class="job__title">
                                <?=Html::a($item['name'], [Url::to(['//companies/view','id'=>$item['id']])])?>
                            </h4>
                            <p class="job__company"><?=$item['description']?></p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-5">
                    <h4>From <?php echo ($item['cop_table'] === '2') ? 'company' : 'investor'; ?>:</h4>
                    <div class="row">
                        <div class="col-xs-2"><img src="<?=$item['inv_img']?>" class="img-responsive"></div>
                        <div class="col-xs-10">
                            <h4 class="job__title">
                                <?=Html::a($item['inv_name'], [Url::to(['//investors/view','id'=>$item['inv_id']])])?>
                            </h4>
                            <p class="job__company"><?=$item['inv_description']?></p>
                        </div>
                    </div>
                </div>
                <div class="col-xs-10 col-xs-offset-2 col-sm-2 col-sm-offset-0 col-md-1">
                    <div class="job__star">
                        <p><?=$item['cop_status']?></p>
                        <?php Pjax::begin(); ?>
                        <a onclick="$.ajax({
                            url: '<?php echo Url::to(['cooperation/delete-status', 'id' => $item['cop_id']])?>',
                            success: function(data){
                            if(data){alert('Successful!');
                            $.ajax({
                            url:'<?php echo Url::to(['cooperation/out'])?>',
                            type: 'post',
                            data:{'q':'2'},
                            response:'text',
                            success:function (html) {
                            $('#approved-cooperation').html(html);
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
    <?= LinkPager::widget(['pagination' => $model['pages']])?>
</div>