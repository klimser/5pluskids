<?php
namespace backend\components;

use backend\models\User;
use yii;
use yii\rbac\Rule;

/**
 * Checks if user role matches
 */
class UserRoleRule extends Rule
{
    public $name = 'userRole';

    public function execute($user, $item, $params)
    {
        if (!Yii::$app->user->isGuest) {
            $role = Yii::$app->user->identity->role;

            if ($item->name === 'admin') {
                return $role == User::ROLE_ROOT;
            } elseif ($item->name === 'content') {
                return $role == User::ROLE_CONTENT || $role == User::ROLE_ROOT;
            }
        }
        return false;
    }
}