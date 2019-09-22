<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\log\Logger;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\models\User;


AppAsset::register($this);

$cookies = Yii::$app->request->cookies;
$prevAuthKey = $cookies->get('prev_auth_key');
if ($prevAuthKey !== null) {
    Yii::getLogger()->log($prevAuthKey, Logger::LEVEL_WARNING);
    $prevUser = User::findByAuthKey($prevAuthKey);
}
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
            'background-color' => 'orange'
        ],
    ]);
    $navBarItems = [];
    if ( isset($prevUser) && ! Yii::$app->user->isGuest) {
        $navBarItems[] = [
            'label' => 'Relogin as ' . $prevUser->name ?? 'previous user',
            'url' => ['/site/login-as-another-user', 'id' => $prevUser->getId()]
        ];
    }
    $navBarItems[] =
        Yii::$app->user->isGuest ? (
        ['label' => 'Login', 'url' => ['/site/login']]
        ) : (
            '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->name . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>'
        );


    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $navBarItems
    ]);
    NavBar::end();
    ?>
    <div class="container">
        <?= Alert::widget() ?>
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
