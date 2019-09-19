<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
$this->title = 'My Yii Application';
?>
<div class="site-index">
    <div class="body-content">
        <ul>
            <li>
                <?= Html::a('Proxy', ['proxy/index'])?>
            </li>
            <li>
                <?= Html::a('Users', ['user/index'])?>
            </li>
        </ul>
    </div>
</div>
