<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model common\models\Investors */

$this->title = 'Edit Investor - ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'My Investors', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Edit';
$breadcrumbs = Breadcrumbs::widget([
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
]);
?>
	<section style="background: #fafafa;">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 col-lg-offset-2">
            <div class="breadcrumbs">
              <?=$breadcrumbs?>
            </div>
            <h1 class="heading"><?= Html::encode($this->title) ?></h1>
          </div>
        </div>
      </div>
    </section>
	<section>
	  <div class="container">
	    <div class="row">
	      <div class="col-lg-10 col-lg-offset-1">
<?= $this->render('_form', ['model' => $model,]) ?>
	      </div>
	    </div>
	  </div>
	</section>
