<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Search\InvestorsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="investors-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'address') ?>

    <?= $form->field($model, 'net_worth') ?>

    <?= $form->field($model, 'img_url') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'address_1') ?>

    <?php // echo $form->field($model, 'address_2') ?>

    <?php // echo $form->field($model, 'tel_1') ?>

    <?php // echo $form->field($model, 'tel_2') ?>

    <?php // echo $form->field($model, 'fax') ?>

    <?php // echo $form->field($model, 'user_id') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
