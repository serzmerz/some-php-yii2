<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

use yii\jui\AutoComplete;
use yii\web\JsExpression;

use yii\widgets\PjaxAsset;
PjaxAsset::register($this);

/* @var $this yii\web\View */
/* @var $model common\models\Search\CompaniesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<?php
    $this->registerJs(
        '$("document").ready(function(){
            $("#new_note").on("pjax:end", function() {
            $.pjax.reload({container:"#notes"});  //Reload GridView
        });
    });'
    );
?>

<div class="companies-search">
<?php Pjax::begin(['id' => 'new_note']); ?>
    <?php $form = ActiveForm::begin([
        // 'id' => 'companies-search',
        'action' => Url::current(),
        // 'enableAjaxValidation' => true,
        // 'enableClientValidation' => true,
        'method' => 'get',
        // 'options' => ['data-pjax' => true ],
        //'ajaxParam' => 'ajax',
    ]); ?>

    <?= $form->field($model, 'name')->widget(
        AutoComplete::className(), [
            'clientOptions' => [
                'source' => $search,
                'minLength'=>'2',
                'autoFill' => true,
                'select' => new JsExpression("function(event, ui){
                    var href = '/{$name}/view?id=' + ui.item.id;
                    // console.log(href);
                    window.location.href = href;
                    return false;
                }")
            ]
        ]);
    ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
<?php Pjax::end(); ?>
</div>
