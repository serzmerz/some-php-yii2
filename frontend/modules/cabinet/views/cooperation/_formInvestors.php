<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;

?>
<div class="container">
    <h3 class="heading">
        Incoming proposals for investors: <span class="accent"><?= $arrayModelInvestors['count']?></span></h3>

    <?php foreach($arrayModelInvestors['model'] as $model){ ?>
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
                    <?php Pjax::begin(); ?>
                    <div class="form-group">
                        <a onclick="$.ajax({
                                url: '<?php echo Url::to(['cooperation/update-status', 'id' => $model['cop_id'], 'cooperation_status' => 2])?>',
                                success: function(data){
                                if(data){alert('Successful!');
                                $.ajax({
                                url:'<?php echo Url::to(['cooperation/input'])?>',
                                type: 'post',
                                data:{'q':'2'},
                                response:'text',
                                success:function (html) {
                                $('#investors-cooperation').html(html);
                                }
                                });
                                }
                                else if(!data)alert('Error!');
                                }
                                });" class="btn btn-success">Accept</a>

                        <a onclick="$.ajax({
                                url: '<?php echo Url::to(['cooperation/update-status', 'id' => $model['cop_id'], 'cooperation_status' => 3])?>',
                                success: function(data){
                                if(data){alert('Successful!');
                                $.ajax({
                                url:'<?php echo Url::to(['cooperation/input'])?>',
                                type: 'post',
                                data:{'q':'2'},
                                response:'text',
                                success:function (html) {
                                $('#investors-cooperation').html(html);
                                }
                                });
                                }
                                else if(!data)alert('Error!');
                                }
                                });" class="btn btn-danger">Ignore</a>
                        <?php Pjax::end(); ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-md-3">
                        <h4>From:</h4>
                        <div class="row">
                            <div class="col-xs-2"><img src="<?=$model['com_img']?>" class="img-responsive"></div>
                            <div class="col-xs-10">
                                <h4 class="job__title">
                                    <?=Html::a($model['com_name'], [Url::to(['//companies/view','id'=>$model['com_id']])])?>
                                </h4>
                                <p class="job__company"><?=$model['com_description']?></p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    <?php } ?>
    <?= LinkPager::widget(['pagination' => $arrayModelInvestors['pages']])?>
</div>