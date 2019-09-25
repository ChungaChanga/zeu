<?php


namespace app\commands;


namespace app\commands;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        $handleProxy = $auth->createPermission('handleProxy');
        $handleProxy->description = 'Handle a proxy';
        $auth->add($handleProxy);

        $handleUser = $auth->createPermission('handleUser');
        $handleUser->description = 'Handle a users';
        $auth->add($handleUser);


        $proxyEditor = $auth->createRole('proxyEditor');
        $auth->add($proxyEditor);
        $auth->addChild($proxyEditor, $handleProxy);

        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $handleUser);
        $auth->addChild($admin, $proxyEditor);

    }
}