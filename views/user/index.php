<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create User'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'email:email',
//            'password',
//            'auth_key',
//            'roles',
            'rolesNamesString',
            [
                'class' => '\kartik\grid\ActionColumn',
                'deleteOptions' => ['label' => '<i class="glyphicon glyphicon-remove"></i>'],
                'buttons' => [
                    'login-as-another-user' => function ($url, $model, $key) {
                        if ( Yii::$app->user->getId() === $key) {
                            return;
                        }
                        return  Html::a(
                              '<i class="glyphicon glyphicon-sunglasses"></i>',
                              ['site/login-as-another-user', 'id' => $key],
                              ['title' => 'Login as this user']
                        );
                    },
                ],
                'template' => '{view} {update} {delete} {login-as-another-user}',
                'width' => '100px',
                'hAlign' => GridView::ALIGN_LEFT,
            ]
        ],
    ]); ?>

    <?php Pjax::end();
    ?>
    <div class="cept-test-block">the user index page is work</div>

</div>
