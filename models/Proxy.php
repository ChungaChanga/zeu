<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "proxy".
 *
 * @property int $id
 * @property int $ip_hash
 * @property int $port
 */
class Proxy extends \yii\db\ActiveRecord
{
   // public $ip;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'proxy';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ip', 'port'], 'required'],
            [['port'], 'integer', 'min' => 0, 'max' => 65535],
            ['ip', 'ip', 'ipv6' => false]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ip' => 'IP',
            'port' => 'Port',
        ];
    }


    /**
     * @return array|false
     */
    public function fields()
    {
        return ['ip', 'port'];
    }

    /**
     * {@inheritdoc}
     * @return ProxyQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProxyQuery(get_called_class());
    }

    /**
     * @return string
     */
    public function getIp()
    {
        return self::hashToIp4($this->ip_hash);
    }

    /**
     * @param $ip
     */
    public function setIp($ip)
    {
        $this->ip = $ip;//for validate, fixme
        $this->ip_hash = self::ip4ToHash($ip);
    }

    /**
     * @param $hash
     * @return string
     */
    public static function hashToIp4($hash)
    {
        return long2ip($hash);
    }

    /**
     * @param $ip
     * @return int
     */
    public static function ip4ToHash($ip)
    {
        return ip2long($ip);
    }
}
