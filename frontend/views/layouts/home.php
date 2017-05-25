<?php
use yii\helpers\Html;
use frontend\assets\HomeAsset;
use common\widgets\Alert;

HomeAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= \Yii::$app->name ?></title>
    <link rel="shortcut icon" href="favicon.ico">
    <?php $this->head() ?>
</head>
<body class="body-container">
<div id="page" class="page">
<?php $this->beginBody() ?>

<?= $content ?>

</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>