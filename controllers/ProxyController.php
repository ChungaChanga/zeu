<?php

namespace app\controllers;

use Yii;
use app\models\Proxy;
use app\models\ProxySearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\{
    Json,
    ArrayHelper
};
use kartik\grid\EditableColumnAction;

use app\common\{
    ProxyFile,
    ProxyFileCSV
};
use app\models\{
    ProxyDataCollection,
    UploadProxyFileForm
};
use yii\web\{
    Controller,
    UploadedFile
};


/**
 * ProxyController implements the CRUD actions for Proxy model.
 */
class ProxyController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * @param $action
     * @return bool
     * @throws \yii\web\BadRequestHttpException
     * @throws \yii\web\ForbiddenHttpException
     */
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        if (\Yii::$app->user->can('handleProxy')) {
            return true;
        }

        throw new \yii\web\ForbiddenHttpException('Access denied');
    }

    /**
     * @return array
     */
    public function actions()
    {
        return ArrayHelper::merge(parent::actions(), [
            'editproxy' => [                                       // identifier for your editable column action
                'class' => EditableColumnAction::className(),     // action class name
                'modelClass' => Proxy::className(),                // the model for the record being edited
                'outputValue' => function ($model, $attribute, $key, $index) {
                    return $model->$attribute;      // return any custom output value if desired
                },
                'outputMessage' => function($model, $attribute, $key, $index) {
                    return '';                                  // any custom error to return after model save
                },
                'showModelErrors' => true,                        // show model validation errors after save
                'errorOptions' => ['header' => '']                // error summary HTML options
                // 'postOnly' => true,
                // 'ajaxOnly' => true,
                // 'findModel' => function($id, $action) {},
                // 'checkAccess' => function($action, $model) {}
            ]
        ]);
    }


    /**
     * Lists all Proxy models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProxySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Proxy model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Proxy model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Proxy();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Proxy model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Proxy model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Proxy model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Proxy the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Proxy::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionUploadFile()
    {
        $uploadFormModel = new UploadProxyFileForm();

        if (Yii::$app->request->isPost) {
            $uploadFormModel->imageFile = UploadedFile::getInstance($uploadFormModel, 'imageFile');
            if ( $uploadFormModel->upload() ) {
                $fileHandler = new ProxyFileCSV( $uploadFormModel->getUploadFullFileName() );
                $proxyDataCollection = new ProxyDataCollection();
                $proxyDataCollection->collection = $fileHandler->getAllProxy();

                if ( $proxyDataCollection->validate() && $proxyDataCollection->batchSave() ) {
                    return $this->render('upload-file-success', [
                        'proxyDataCollection'  => $proxyDataCollection
                    ]);
                } else {
                    return $this->render('upload-file-failed', [
                        'validationErrors' => $proxyDataCollection->getErrorSummary(true)
                    ]);
                }
            }
        }

        return $this->render('upload-file', ['model' => $uploadFormModel]);
    }
}
