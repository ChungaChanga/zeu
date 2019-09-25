<?php

use yii\db\Migration;
use app\models\User;

/**
 * Class m190914_150952_load_test_data
 */
class m190914_150952_load_test_data extends Migration
{
    public function up()
    {
        $this->fillProxyTable();
        $this->fillUserTable();
    }
    public function down()
    {
        $this->truncateTable('proxy');
    }

    private function fillProxyTable()
    {
        $proxyTestData = $this->genProxyTestData();
        $this->batchInsert(
            'proxy',
            ['id', 'ip_hash', 'port'],
            $proxyTestData
        );
    }

    private function fillUserTable()
    {
        $userTestData = $this->genUserTestData();
        $this->batchInsert(
            'user',
            ['id', 'name', 'email', 'password',  'auth_key'],
            $userTestData
        );
    }

    private function genProxyTestData(int $proxyCount = 100): array
    {
        $proxyTestData = [];

        $proxyTestData[] = [
            null,
            ip2long('0.0.0.0'),
            0
        ];
        $proxyTestData[] = [
            null,
            ip2long('255.255.255.255'),
            65535
        ];

        for ($i = 0; $i < $proxyCount; $i++) {
            $proxyTestData[] = [
                null,
                ip2long( $this->genRandIP() ),
                $this->genRandPort(),
            ];
        }



        return $proxyTestData;
    }
    private function genRandIP(): string
    {
        $randArr = [
            rand(0, 255),
            rand(0, 255),
            rand(0, 255),
            rand(0, 255),
        ];
        return implode('.', $randArr);
    }
    private function genRandPort(): int
    {
        return rand(1, 64000);
    }

    private function genUserTestData(): array
    {
        return [
            [
                null,
                'Admin',
                'admin@mail.zz',
                User::generatePasswordHash('qwerty'),
                \Yii::$app->security->generateRandomString()
            ],
            [
                null,
                'FirstEditor',
                'fedit@mail.zz',
                User::generatePasswordHash('qwerty'),
                \Yii::$app->security->generateRandomString()
            ],
        ];
    }
}
