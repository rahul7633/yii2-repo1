<?php
namespace common\web;

use Yii;
use yii\web\User As BaseUser;
use common\models\User as UserModel;

class User extends BaseUser {
 
 public function can($permissionName, $params = [], $allowCaching = true) {
  $user = $this->getIdentity();
  $role = isset($user->role) ? $user->role : 'guest';
  switch ($permissionName) {
   case 'administrator':
    return $role==UserModel::ROLE_ADMINISTRATOR;
     break;
   case 'moderator':
    return $role==UserModel::ROLE_MODERATOR;
    break;
   case 'company':
    return $role==UserModel::ROLE_COMPANY;
    break;
   case 'operator':
    return $role==UserModel::ROLE_OPERATOR;
    break;
   case 'standard':
    return $role==UserModel::ROLE_USER;
    break;
  }
  return false;
 }
 
}