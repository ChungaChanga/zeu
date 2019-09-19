<?php


namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\log\Logger;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return 'user';
    }

    public function rules()
    {
        return [
            [['name'], 'string'],
            [['email'], 'email'],
            [['password', 'rolesNames'], 'safe'],
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     * @throws \yii\base\Exception
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->auth_key = \Yii::$app->security->generateRandomString();
            }
            return true;
        }
        return false;
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
    }

    /**
     * Finds an identity by the given ID.
     *
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface|null the identity object that matches the given ID.
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }


    /**
     * @return int|string current user ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string current user auth key
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }


    /**
     * @param string $authKey
     * @return bool if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * @param $name
     * @return User|null
     */
    public static function findByUserName($name)
    {
        return static::findOne([
            'name' => $name
        ]);
    }

    public static function findByAuthKey($authKey)
    {
        return static::findOne([
            'auth_key' => $authKey
        ]);
    }

    public function validatePassword($password)
    {
        return true;
        $hash = self::generatePasswordHash($password);

        if (Yii::$app->getSecurity()->validatePassword($password, $hash)) {
            // всё хорошо, пользователь может войти
        } else {
            // неправильный пароль
        }
    }

    public static function generatePasswordHash($password) {
        return Yii::$app->getSecurity()->generatePasswordHash($password);
    }

    public function getRoles()
    {
        return Yii::$app->authManager->getRolesByUser($this->id);
    }
    public function getRolesNames()
    {
        $rolesNames = Yii::$app->authManager::convertRolesToRolesNames(
            Yii::$app->authManager->getRolesByUser($this->id)
        );
        Yii::getLogger()->log($rolesNames, Logger::LEVEL_INFO);
        return $rolesNames;
    }
    public function getRolesNamesString()
    {
        $rolesNamesString = '';
        $rolesNames = $this->getRolesNames();
        if ( is_array($rolesNames) && ! empty($rolesNames) ) {
            $rolesNamesString = implode(', ', $rolesNames);
        }
        return $rolesNamesString;
    }

    public function setRolesNames($newUserRolesNames)
    {
        if ( ! is_array($newUserRolesNames) ) {
            $newUserRolesNames = [];
        }
        $toAddRolesNames = [];
        $toRevokeRolesNames = [];
        $preventUserRolesNames = $this->getRolesNames();
        $allRolesNames = Yii::$app->authManager->getRolesNames();

//        $newUserRolesNames = [];
//        //foreach ($rolesIds as $roleId) {
//            $newUserRolesNames[] = $allRolesNames[$roleId];
//       // }

        if ( $newUserRolesNames == $preventUserRolesNames) {
            return;
        }

        $toAddRolesNames = array_diff($newUserRolesNames, $preventUserRolesNames);
        $toRevokeRolesNames = array_diff($preventUserRolesNames, $newUserRolesNames);

        foreach ($toAddRolesNames as $toAddRoleName) {
            $role = Yii::$app->authManager->getRole($toAddRoleName);
            Yii::$app->authManager->assign($role, $this->id);
        }

        foreach ($toRevokeRolesNames as $toRevokeRoleName) {
            $role = Yii::$app->authManager->getRole($toRevokeRoleName);
            Yii::$app->authManager->revoke($role, $this->id);
        }

    }

    public function setPassword($password)
    {
        $this->password = self::generatePasswordHash($password);
    }
}