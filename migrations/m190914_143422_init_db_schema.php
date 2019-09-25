<?php

use yii\db\Schema;
use yii\db\Migration;

/**
 * Class m190914_143422_init_db_schema
 */
class m190914_143422_init_db_schema extends Migration
{

    public function up()
    {
        $this->createProxyTable();
        $this->createProxyTableIndexes();
        $this->createUserTable();
    }

    public function down()
    {
        $this->dropTable('proxy');
        $this->dropTable('user');
    }

    private function createProxyTable()
    {
        return $this->createTable('proxy', [
            'id' => Schema::TYPE_UPK,
            'ip_hash' => $this->integer()->unsigned(),
            'port' => $this->smallInteger()->unsigned(),
        ]);
    }

    private function createUserTable()
    {
        return $this->createTable('user', [
            'id' => Schema::TYPE_UPK,
            'name' => $this->string(50),
            'email' => $this->string(100),
            'password' => $this->string(255),
            'auth_key' => $this->string(32),
        ]);
    }

    private function createProxyTableIndexes()
    {
        $this->createIndex(
            'idx-proxy-ip_hash-port',
            'proxy',
            ['ip_hash', 'port']
        );
        $this->createIndex(
            'idx-proxy-port',
            'proxy',
            'port'
        );
    }
}
