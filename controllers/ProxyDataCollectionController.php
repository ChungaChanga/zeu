<?php


namespace app\controllers;

use Yii;
use app\common\{
    ProxyFile,
    ProxyFileCSV
};
use app\models\{
    ProxyDataCollection,
    UploadForm
};
use yii\web\{
    Controller,
    UploadedFile
};


class ProxyDataCollectionController extends Controller
{
    /**
     * @return string
     * @throws \Exception
     */
    public function actionUpload()
    {
        $model = new UploadForm();

        if (Yii::$app->request->isPost) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if ($model->upload()) {
                $fullFileName = $model->getUploadedFullFileName();
                $fileHandler = $this->createFileHandler($fullFileName, $model->imageFile->type);
                if ( ! $fileHandler instanceof ProxyFile ) {
                    throw new \Exception('Unknown file format');
                }

                $proxyDataCollection = new ProxyDataCollection();
                $proxyDataCollection->collection = $fileHandler->getProxyDataCollection();

                if ( $proxyDataCollection->validate() && $proxyDataCollection->batchSave() ) {
                    return $this->render('upload-success', [
                        'proxyDataCollection'  => $proxyDataCollection
                    ]);
                } else {
                    return $this->render('upload-failed', [
                        'validationErrors' => $proxyDataCollection->getErrorSummary(true)
                    ]);
                }
            }
        }

        return $this->render('upload', ['model' => $model]);
    }

    /**
     * @param $fullFileName
     * @param $type
     * @return ProxyFileCSV
     * @throws \Exception
     */
    private function createFileHandler($fullFileName, $type) {
        if ( $type === 'text/csv' ) {//TODO add validate by file content
            return new ProxyFileCSV($fullFileName);
        }
    }
}