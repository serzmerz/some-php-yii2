<?php
namespace frontend\widgets;

use yii\helpers\Html;

class SPNavBar extends \yii\bootstrap\NavBar
{
    /**
     * Renders collapsible toggle button.
     * @return string the rendering toggle button.
     */
    protected function renderToggleButton()
    {
        // $bar = Html::tag('span', '', ['class' => 'icon-bar']);
        $screenReader = $this->screenReaderToggleText;
        $navbar_buttons = Html::button($screenReader, [
            'class' => 'navbar-toggle navbar-btn',
            'data-toggle' => 'collapse',
            'data-target' => "#{$this->containerOptions['id']}",
        ]);

        return '<div class="navbar-buttons">' . $navbar_buttons . '</div>';
    }


}