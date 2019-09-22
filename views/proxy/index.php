<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\grid\{
    GridView,
    EditableColumn
};
use kartik\editable\Editable;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProxySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Proxy');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="proxy-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Proxy'), ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app', 'Upload Proxy File'), ['proxy/upload-file'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'resizableColumns'=>true,
        'resizeStorageKey'=>Yii::$app->user->id . '-' . date("m"),
        'columns' => [
            [
                'class' => 'kartik\grid\SerialColumn',
                'width'=>'30px',
            ],
            [
                'class'=>'kartik\grid\EditableColumn',
                'attribute'=>'ip',
                'editableOptions'=>[
                    'formOptions'=>['action' => ['/proxy/editproxy']],
                ],
                'hAlign'=>'right',
                'vAlign'=>'middle',
                'width'=>'100px',
            ],
            [
                'class'=>'kartik\grid\EditableColumn',
                'attribute'=>'port',
                'editableOptions'=>[
                    'formOptions'=>['action' => ['/proxy/editproxy']],
                ],
                'hAlign'=>'right',
                'vAlign'=>'middle',
                'width'=>'30%',
            ],
            [
                'class' => 'kartik\grid\ActionColumn',
                'width'=>'70px',
            ],
        ],
    ]); ?>
    <div class="cept-test-block">the proxy index page is work</div>
</div>
