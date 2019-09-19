<?php


namespace app\common;

class MyDbManager extends \yii\rbac\DbManager
{
    public function getRolesNames()
    {
        return self::convertRolesToRolesNames(
            $this->getRoles()
        );
    }
    public static function convertRolesToRolesNames($roles)
    {
        $rolesNames = [];
        if ( is_array($roles) ) {
            foreach ($roles as $role) {
                $rolesNames[$role->name] = $role->description ?? $role->name;
            }
        }
        return $rolesNames;
    }
}