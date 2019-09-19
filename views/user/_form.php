<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;


/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

    <?=
//    $form->field($model, 'rolesNames')
//        ->dropDownList(
//            Yii::$app->authManager->getRolesNames(),
//            ['multiple'=> true]
//        );
    $form->field($model, 'rolesNames')->widget(Select2::classname(), [
        'data' => Yii::$app->authManager->getRolesNames(),
        'options' => [
            'multiple' => true
        ],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);

//     Select2::widget([
//        'model' => $model,
//        'attribute' => 'rolesNames',
//        'data' => Yii::$app->authManager->getRolesNames(),
//        'options' => [
//           // 'placeholder' => 'Select provinces ...',
//            'multiple' => true,
//        ],
//    ]);

    ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
