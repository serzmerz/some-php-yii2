<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model common\models\Companies */
/* @var $form yii\widgets\ActiveForm */
?>
    <?php $form = ActiveForm::begin([
            'options'=>['enctype'=>'multipart/form-data'],
            'fieldConfig' => [
                'options' => [
                    'class' => 'col-md-12 form-group',
                ],
                'errorOptions' => [
                    'class' => 'help-block text-small',
                    'tag' => 'p',
                ],
            ],
        ]); ?>
          <div class="row">
            <div class="col-md-12">
              <h4>Public Information</h4>
              <p class="text-muted text-small">
                  This information will be displayed on our site publicly.
               </p>
              <hr>
            </div>
          </div>
          <div class="row">
<?= $form->field($model, 'name', ['options' => ['class' => 'col-md-6 form-group']])->textInput(['maxlength' => true]) ?>
          </div>
          <div class="row">
<?= $form->field($model, 'description')->textarea(['rows' => 5, 'placeholder' => 'The place to buy anything']) ?>
          </div>
          <div class="row">
<?= $form->field($model, 'address', ['options' => ['class' => 'col-md-6 form-group']])->textInput(['maxlength' => true, 'placeholder' => 'e.g. Rio de Janeiro']) ?>
<?= $form->field($model, 'net_worth', ['options' => ['class' => 'col-md-6 form-group']])->textInput(['maxlength' => true]) ?>
          </div>
          <div class="row">
<?=$form->field($model, 'file', ['options' => ['class' => 'col-md-6 form-group']])->widget(FileInput::classname(), [
    'pluginOptions' => [
      'overwriteInitial' => true,
      'maxFileSize' => 2050,
      'showUpload' => false,
      'showClose' => false,
      'showCaption' => false,
      'fileActionSettings' => ['showZoom' => false],
      'browseLabel' => '',
      'removeLabel' => '',
      'defaultPreviewContent' => '<img src="' . ($model->img_url?:'/image/default_i.jpg') . '" alt="Your Logo">',
      'elErrorContainer' => '#errors-image',
      'layoutTemplates' => ['main2' => '{preview}{remove}{browse}<p id="errors-image"></p>'],
      'allowedFileExtensions' => ['jpg', 'png', 'gif']
    ],
])?>
          </div>
          <div class="row">
            <div class="col-md-12">
              <hr class="margin-bottom--big">
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <h4>Private Investor Details</h4>
              <p class="text-muted text-small">
                    These details will only be shared with founders you approve.
                 </p>
              <hr>
            </div>
          </div>
          <div class="row">
<?= $form->field($model, 'address_1', ['options' => ['class' => 'col-md-6 form-group']])->textInput(['maxlength' => true]) ?>
          </div>
          <div class="row">
<?= $form->field($model, 'address_2', ['options' => ['class' => 'col-md-6 form-group']])->textInput(['maxlength' => true]) ?>
          </div>
          <div class="row">
<?= $form->field($model, 'tel_1', ['options' => ['class' => 'col-md-4 form-group']])->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'tel_2', ['options' => ['class' => 'col-md-4 form-group']])->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'fax', ['options' => ['class' => 'col-md-4 form-group']])->textInput(['maxlength' => true]) ?>
          </div>
          <div class="row">
            <div class="col-md-12 form-group"><hr>
                <div class="checkbox text-center">
<?= Html::submitButton('<i class="fa fa-magic"></i>Save', ['class' => 'btn btn-primary save']) ?>
                </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 text-center">
              <hr>
            </div>
          </div>
    <?php ActiveForm::end(); ?>
