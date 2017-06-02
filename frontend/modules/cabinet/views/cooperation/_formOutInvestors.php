<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;

?>
<div class="container">
        <h3 class="heading">
You likes <span class="accent"><?=$arrayModelInvestors['count']?></span> investors</h3>

<?php foreach($arrayModelInvestors['model'] as $model){ ?>
    <div class="job-listing">
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <h4>To Investor:</h4>
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
            <div class="col-sm-12 col-md-5">
                <h4>From Company:</h4>
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
                            data:{'q':'2'},
                            response:'text',
                            success:function (html) {
                            $('#investors-cooperation').html(html);
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

            <div class="row">
            </div>

        </div>
    </div>
<?php } ?>
<?= LinkPager::widget(['pagination' => $arrayModelInvestors['pages']])?>
</div>