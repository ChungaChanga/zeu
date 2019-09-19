<?php


namespace app\models;

use Yii;
use yii\base\Model;
use yii\log\Logger;

class ProxyDataCollection extends Model
{
    public $collection;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['collection', function($collection) {
                if ( empty($this->$collection) ) {
                    return;
                }

                $proxyTemplate = new Proxy();

                foreach ($this->$collection as $proxyData) {
                    $proxyTemplate->attributes = $proxyData;
                    if ( $proxyTemplate->validate() ) {
                        continue;
                    } else {
                        $this->addError('data',
                            array_merge( $proxyTemplate->attributes  , $proxyTemplate->getErrorSummary(true) )
                        );
                    }
                }
            }]
        ];
    }

    /**
     * @return bool
     * @throws \yii\db\Exception
     */
    public function batchSave()
    {
        $orderColumn = ['ip_hash', 'port'];
        $hashedProxyData = $this->convertDataToDbFormat($this->collection, $orderColumn);

        $rowCount = Yii::$app->db->createCommand()
            ->batchInsert( Proxy::tableName(), $orderColumn, $hashedProxyData)
            ->execute();
        if ($rowCount) {
            return true;
        }
    }

    /**
     * @param array $collection
     * @param array $orderColumn
     * @return array
     */
    private function convertDataToDbFormat(array $collection, array $orderColumn): array
    {
        $orderColumnByNames = array_flip($orderColumn);
        $convertedProxyData = array_map(function ($proxyData) use($orderColumnByNames) {
            $convertedProxyData[ $orderColumnByNames['ip_hash'] ] = Proxy::ip4ToHash( $proxyData['ip'] );
            $convertedProxyData[ $orderColumnByNames['port'] ] = $proxyData['port'];
            return $convertedProxyData;
        }, $collection);
        return $convertedProxyData;
    }
}