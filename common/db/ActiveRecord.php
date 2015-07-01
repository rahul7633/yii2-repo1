<?php
namespace common\db;

use Yii;
use yii\db\ActiveRecord as BaseActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

class ActiveRecord extends BaseActiveRecord {
 
 public function behaviors() {
  $ret = parent::behaviors();
  $ret[] = [
            'class' => TimestampBehavior::className(),
            'value' => new Expression('NOW()'),
          ];
  return $ret;
 }
 
 public function formatDateTime($mysqlDate, $timeZone='') {
  if ( empty($mysqlDate) || date('Y-m-d H:i:s', strtotime($mysqlDate))!=$mysqlDate ) {
   return $mysqlDate;
  }
  $d1 = new \DateTime($mysqlDate);
  if ( strval($timeZone)!='' ) {
   $d1->setTimezone(new DateTimeZone($timeZone));
  }
  return $d1->format('d M Y h:i A');
 }
 
 public function formatDate($mysqlDate, $timeZone='') {
  if ( empty($mysqlDate) || date('Y-m-d', strtotime($mysqlDate))!=$mysqlDate ) {
   return $mysqlDate;
  }
  $d1 = new \DateTime($mysqlDate);
  if ( strval($timeZone)!='' ) {
   $d1->setTimezone(new DateTimeZone($timeZone));
  }
  return $d1->format('d M Y');
 }
 
}