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
        <?= Html::a(Yii::t('app', 'Upload Proxy File'), ['proxy-data-collection/upload'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'resizableColumns'=>true,
        'resizeStorageKey'=>Yii::$app->user->id . '-' . date("m"),
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'ip',
            [
                'class'=>'kartik\grid\EditableColumn',
                'attribute'=>'ip',
                'editableOptions'=>[
//                    'header'=>'Buy Amount',
//                    'inputType'=> Editable::INPUT_SPIN,
//                    'options'=>['pluginOptions'=>['min'=>0, 'max'=>5000]]
                    'formOptions'=>['action' => ['/proxy/editproxy']],
                ],
                'hAlign'=>'right',
                'vAlign'=>'middle',
                'width'=>'100px',
//                'format'=>['decimal', 2],
//                'pageSummary'=>true
            ],
//            'port',
            [
                'class'=>'kartik\grid\EditableColumn',
                'attribute'=>'port',
                'editableOptions'=>[
//                    'header'=>'Buy Amount',
//                    'inputType'=> Editable::INPUT_SPIN,
//                    'options'=>['pluginOptions'=>['min'=>0, 'max'=>5000]]
                    'formOptions'=>['action' => ['/proxy/editproxy']],
                ],
                'hAlign'=>'right',
                'vAlign'=>'middle',
                'width'=>'100px',
//                'format'=>['decimal', 2],
//                'pageSummary'=>true
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>

</div>
