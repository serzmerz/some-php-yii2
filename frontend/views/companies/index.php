<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

$this->registerJs(<<<JS
$(document).on('input', '#companies-search-name, #companies-search-city', function(e){
    var t = $(this);
    var form = t.closest('#filter-form');
    var name = form.find('#companies-search-name').val();
    var city = form.find('#companies-search-city').val();
    var value = name + '|' + city;

    window.history.pushState(null, null, '?q=' + value);

    $.post(form.attr('action'), form.serialize(), function(html){
      $('#companies-search').html(html);
    });
});
JS
, yii\web\View::POS_END);

$this->title = 'Search Companies';
$this->params['breadcrumbs'][] = $this->title;
$breadcrumbs = Breadcrumbs::widget([
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
]);
?>
<section class="job-form-section job-form-section--compressed">
            <div class="container">
              <div class="row">
                <div class="col-lg-8 col-lg-offset-2">
                  <div class="breadcrumbs">
                    <?=$breadcrumbs?>
                  </div>
                  <h1 class="heading"><?= Html::encode($this->title) ?></h1>
                </div>
<?=Html::beginForm(Url::current(), 'GET', ['id'=>'filter-form', 'class' => 'job-main-form']);?>
    <div class="col-sm-5 col-sm-offset-1 col-lg-4 col-lg-offset-2">
      <div class="form-group">
        <label for="location">Search Company Name</label>
<?=Html::textInput('name', '', ['id'=> 'companies-search-name', 'class' => 'form-control', 'placeholder' => 'Enter company name you are looking for'])?>
      </div>
    </div>
    <div class="col-sm-5 col-lg-4">
      <div class="form-group">
        <label for="location">Search Company City</label>
<?=Html::textInput('address', '', ['id'=> 'companies-search-city', 'class' => 'form-control', 'placeholder' => 'Enter company city you are looking for'])?>
      </div>
    </div>
<?=Html::endForm(); ?>
              </div>
            </div>
          </section>

          <section id="companies-search">
  <?=$this->render('_companies_search', [
      'count' => $count,
      'models' => $models,
      'pages' => $pages
    ])?>
          </section>