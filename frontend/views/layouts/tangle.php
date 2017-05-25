<?php
use yii\helpers\Html;
use frontend\assets\TangleAsset;
use common\widgets\Alert;

TangleAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= \Yii::$app->name . ' - ' . Html::encode($this->title) ?></title>
    <link rel="shortcut icon" href="favicon.ico">
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<?=$this->render("//common/header")?>

<?= Alert::widget() ?>
<?= $content ?>

<?=$this->render("//common/footer")?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>