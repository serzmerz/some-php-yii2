<?php
use frontend\widgets\SPNavBar;
use yii\bootstrap\Nav;
use yii\helpers\Html;

$checkController = function($route){
  return $route === $this->context->getUniqueId();
};
?>
<header class="header" id="head">
    <?php
    SPNavBar::begin([
        'brandLabel' => '<img src="/img/logo.png" alt="logo" class="hidden-xs hidden-sm"><img src="/img/logo-small.png" alt="logo" class="visible-xs visible-sm"><span class="sr-only">Go to homepage</span>',
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

    $menuItems = [
        // ['label' => 'Search', 'url' => ['/search'], 'active' => $checkController('search')],
        /*[
            'label' => '<i class="fa fa-star "></i>',
            'url' => ['/cabinet/cooperation'],
            'active' => $checkController('cabinet/cooperation')
        ],*/
        [
            'label' => '<i class="fa fa-star "></i>',
            'items' => [
                ['label' => 'input', 'url' => '/cabinet/cooperation/input'],
                ['label' => 'out', 'url' => '/cabinet/cooperation/out'],
                ['label' => 'approved', 'url' => '/cabinet/cooperation/approved'],
            ],
        ],
        [
            'label' => 'My Companies',
            'url' => ['/cabinet/companies'],
            'active' => $checkController('cabinet/companies')
        ],
        [
            'label' => 'My Investors',
            'url' => ['/cabinet/investors'],
            'active' => $checkController('cabinet/investors')
        ],
    ];
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
    } else {
        $menuItems[] = [
            'label' => 'Log out (' . Yii::$app->user->displayName . ')',
            'url' => ['/user/logout'],
            'linkOptions' => [
                'data-method' => 'post',
                'style' => 'font-weight: 700;',
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