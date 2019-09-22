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
                    $this->addError('collection', 'Proxy collection is empty');
                }

                $proxyTemplate = new Proxy();

                foreach ($this->$collection as $proxyData) {
                    $proxyTemplate->attributes = $proxyData;
                    if ( $proxyTemplate->validate() ) {
                        continue;
                    } else {
                        $errorData = array_merge(
                            $proxyTemplate->attributes,
                            $proxyTemplate->getErrorSummary(true)
                        );
                        $this->addError('collection', $errorData);
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
        $collectionWithIpHashes = $this->addIpHashes($this->collection);
        $orderedProxyCollection = $this->orderCollection($collectionWithIpHashes, $orderColumn);

        $rowCount = Yii::$app->db->createCommand()
            ->batchInsert( Proxy::tableName(), $orderColumn, $orderedProxyCollection)
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
    private function orderCollection(array $collection, array $orderColumn): array
    {
        $orderedProxyCollection = array_map(function ($proxyData) use($orderColumn) {
            $orderedProxyData = [];
            foreach ($orderColumn as $columnPosition => $columnName) {
                $orderedProxyData[$columnPosition] = $proxyData[$columnName];
            }
            return $orderedProxyData;
        }, $collection);
        return $orderedProxyCollection;
    }

    private function addIpHashes(array $collection): array
    {
        $collectionWithIpHashes = array_map(function ($proxyData) {
            $proxyData['ip_hash'] = Proxy::ip4ToHash($proxyData['ip']);
            return $proxyData;
        }, $collection);
        return $collectionWithIpHashes;
    }
}