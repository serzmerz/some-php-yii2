<?php
/* @var $this yii\web\View */
use yii\widgets\Breadcrumbs;

$this->title = 'Home';
$this->params['breadcrumbs'][] = $this->title;
$breadcrumbs = Breadcrumbs::widget([
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
]);
?>
<section class="job-form-section job-form-section--compressed">
            <div class="container">
              <h4 class="heading">Search</h4>
              <div class="row">
                <div class="col-sm-5 col-sm-offset-1 col-lg-4 col-lg-offset-2">
                  <p class="text-center">
                    <a href="/companies" class="btn btn-primary">Companies</a>
                  </p>
                </div>
                <div class="col-sm-5 col-lg-4">
                  <p class="text-center">
                    <a href="/investors" class="btn btn-primary">Investors</a>
                  </p>
                </div>
              </div>
            </div>
          </section>
          <section>
            <div class="container">
              <div class="row">
<?php foreach($models as $model):  ?>
                <div class="col-sm-2 col-md-2 col-xs-2">
                  <a title="<?=$model['name']?>" href="/companies/view?id=<?=$model['id']?>">
                    <img src="<?=$model['img_url']?>" class="img-responsive">
                  </a>
                </div>
<?php endforeach; ?>
              </div>
            </div>
          </section>
