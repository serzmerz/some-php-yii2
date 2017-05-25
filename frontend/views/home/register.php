<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<section class="home elearning-home dark-image-bg gradient-overlay editBG" id="elearning-home" src="home/images/logo.png" style="background-image: linear-gradient(rgba(0, 0, 0, 0.74902), rgba(0, 0, 0, 0.74902)), url(&quot;http://builder.estero.a2hosted.com/elements/images/app-home-bg.jpg&quot;); background-color: rgb(61, 133, 198); outline-offset: -3px;">
  <div class="container">
    <div class="row">
      <div class="col-md-12 text-center">

        <h1 class="heading-text">Connect with local founders and investors</h1>
        <p class="sub-heading mb60">Tangle is in private beta. Sign up below for early access.</p>

      </div>
    </div>  <!-- /.row -->

    <div class="row">
      <div class="col-lg-8 col-md-10 col-lg-offset-2 col-md-offset-1 mt60">
        <?php $form = ActiveForm::begin([
            'id' => 'register-form',
            'options' => ['class' => 'elearning-request form-bar two-field'],
            'fieldConfig' => [
                'template' => "{label}{input}{error}",
                'labelOptions' => ['class' => 'form-inline-label'],
            ],
            'enableAjaxValidation' => true,
        ]); ?>

        <?php if ($requireEmail): ?>
            <?= $form->field($user, 'email')->textInput(array('placeholder' => 'Email', 'class'=>'form-inline-input')) ?>
        <?php endif; ?>

        <?php if ($requireUsername): ?>
            <?= $form->field($user, 'username')->textInput(array('placeholder' => 'Username', 'class'=>'form-inline-input')) ?>
        <?php endif; ?>

        <?= $form->field($user, 'newPassword')->passwordInput(array('placeholder' => 'Password', 'class'=>'form-inline-input')) ?>

        <?php /* uncomment if you want to add profile fields here
        <?= $form->field($profile, 'full_name') ?>
        */ ?>

        <div class="form-group form-group-btn">
            <?= Html::submitButton(Yii::t('user', 'Sign Up'), ['class' => 'btn btn-base btn-rectangle btn-md']) ?>
        </div>

        <?php ActiveForm::end(); ?>
            <div class="col-lg-12">
                <?= Html::a(Yii::t('user', 'Login'), ["/user/login"]) ?>
            </div>

        <?php if (Yii::$app->get("authClientCollection", false)): ?>
            <div class="col-lg-12">
                <?= yii\authclient\widgets\AuthChoice::widget([
                    'baseAuthUrl' => ['/user/auth/login']
                ]) ?>
            </div>
        <?php endif; ?>

      </div>
    </div>  <!-- /.row -->
  </div>
</section><!-- start page -->
<div class="submit-form-popup" style="display: none;">
  <div class="form-inner success">
    <i class="icon svg-check"><!--?xml version="1.0" encoding="utf-8"?-->  <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="32" height="32" viewBox="0 0 32 32"> <path d="M16 2.688c-7.375 0-13.313 5.938-13.313 13.313s5.938 13.313 13.313 13.313c7.375 0 13.313-5.938 13.313-13.313s-5.938-13.313-13.313-13.313zM16 28.25c-6.75 0-12.25-5.5-12.25-12.25s5.5-12.25 12.25-12.25c6.75 0 12.25 5.5 12.25 12.25s-5.5 12.25-12.25 12.25zM22.688 11.25l-8.563 8.313-3-3c-0.313-0.313-0.813-0.313-1.125 0s-0.313 0.813 0 1.125l3.563 3.563c0.125 0.125 0.313 0.188 0.563 0.188 0.188 0 0.375-0.063 0.5-0.188l9.125-8.875c0.375-0.313 0.375-0.813 0.063-1.125s-0.813-0.313-1.125 0z"></path> </svg> </i>
    <p>Request submitted</p>
  </div>


</div>
