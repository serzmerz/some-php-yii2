<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model common\models\Companies */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'My Companies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'img_url',
                'value' => $model->img_url,
                'format' => ['image', ['width'=>'100', 'height'=>'100']],
            ],
            'name',
            'address',
            'description:ntext',
            'productStage.stage',
            'revenue0.revenue',
            'raising0.raising',
            'address_1',
            'address_2',
            'tel_1',
            'tel_2',
            'fax',
            'website'
        ],
    ]) ?>
          </div>
        </div>
      </div>
    </section>
