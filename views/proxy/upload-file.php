<?php
    use yii\widgets\ActiveForm;

    $this->title = Yii::t('app', 'Upload proxy file');
    $this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Proxy'), 'url' => ['proxy/index']];
    $this->params['breadcrumbs'][] = $this->title;
?>


<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <?= $form->field($model, 'imageFile')->fileInput() ?>

    <button>Submit</button>

<?php ActiveForm::end() ?>