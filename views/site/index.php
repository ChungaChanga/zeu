<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\widgets\Menu;
$this->title = 'My Yii Application';
?>
<div class="site-index">
    <div class="body-content">
        <?php
            echo Menu::widget([
                'items' => [
                    ['label' => 'Proxy', 'url' => ['proxy/index']],
                    ['label' => 'Users', 'url' => ['user/index']],
                ],
                'options' => [
                    'style' => 'font-size: 25px;',
                ]
            ]);
        ?>
    </div>
</div>
