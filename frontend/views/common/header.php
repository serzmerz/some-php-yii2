<?php
use frontend\widgets\SPNavBar;
use yii\bootstrap\Nav;
use yii\helpers\Html;

?>
<header class="header" id="head">
    <?php
        SPNavBar::begin([
        'brandLabel' => '<img src="/image/logo.png" alt="logo" class="hidden-xs hidden-sm"><img src="/img/logo-small.png" alt="logo" class="visible-xs visible-sm"><span class="sr-only">Go to homepage</span>',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'tag' => 'div',
            'class' => 'navbar navbar-default',
            'id' => false
        ],
        'renderInnerContainer' => true,
        'innerContainerOptions' => [
            'class' => 'container'
        ],
        'screenReaderToggleText' => 'Menu<i class="fa fa-align-justify"></i>',
    ]);

    $menuItems = \common\models\MenuItem::getMenuItems($this->context->getUniqueId());

    // ['label' => 'Search', 'url' => ['/search'], 'active' => $checkController('search')],
    /*[
        'label' => '<i class="fa fa-star "></i>',
        'url' => ['/cabinet/cooperation'],
        'active' => $checkController('cabinet/cooperation')
    ],*/

    if (Yii::$app->user->isGuest) {
        $menuItems[] = [
            'label' => '<i class="fa fa-sign-in"></i> Log in',
            'url' => ['/user/login'],
            'visible' => Yii::$app->user->isGuest,
            'linkOptions' => [
                'style' => 'font-weight: 700;',
                // 'data-target' => '#loginModal',
                // 'data-toggle' => 'modal'
            ]
        ];
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'encodeLabels' => false,
        // 'activateParents' => true,
        'items' => $menuItems,
    ]);
    SPNavBar::end();
    ?>
</header>