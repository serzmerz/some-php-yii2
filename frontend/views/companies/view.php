<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Breadcrumbs;

$this->title = 'Company ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Search Companies', 'url' => ['index']];
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
        ],
    ]) ?>
          </div>
        </div>
      </div>
    </section>
