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


    $query = \common\models\MenuItem::find()->where(['menu'=>3])->all();
    $menuArray = [];
    foreach ($query as $item) {
        $menuArray[] = [
            'label' => $item['title'],
            'url' => $item['href'],
            'active' => $checkController(strtolower($item['title']))
        ];
    }
    debug($menuArray);

    $query = \common\models\MenuItem::find()->where([''])->all();
    $menuItems = [
        // ['label' => 'Search', 'url' => ['/search'], 'active' => $checkController('search')],
        /*[
            'label' => '<i class="fa fa-star "></i>',
            'url' => ['/cabinet/cooperation'],
            'active' => $checkController('cabinet/cooperation')
        ],*/
        [
            'label' => 'Search',
            'items' => $menuArray
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
            'label' => Yii::$app->user->displayName,
            //'url' => ['/user/logout'],
            /*'linkOptions' => [
                'data-method' => 'post',
                'style' => 'font-weight: 700;',
            ]*/
            'items' => [
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
                [
                    'label' => 'Cooperation`s',
                    'url' => ['/cabinet/cooperation'],
                    'active' => $checkController('cabinet/cooperation')
                ],
                [
                    'label' => 'Log out',
                    'url' => ['/user/logout'],
                    'linkOptions' => [
                        'data-method' => 'post',
                        'style' => 'font-weight: 700;',
                    ]
                ],
            ],

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