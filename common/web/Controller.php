<?php
namespace common\web;

use Yii;
use yii\web\Controller As ParentController;

class Controller extends ParentController {
 
 public function getRedirectUrl($default='') {
  if ( isset($_GET['redirect_url']) ) {
   $redirectUrl = trim( Yii::$app->request->get('redirect_url') );
  } else if ( isset($_POST['redirect_url']) ) {
   $redirectUrl = trim( Yii::$app->request->post('redirect_url') );
  } else {
   $redirectUrl = null;
  }
 
  switch($redirectUrl) {
   case 'referer':
    if (isset($_SERVER['HTTP_REFERER']) && strval($_SERVER['HTTP_REFERER'])!='') {
     $redirectUrl=$_SERVER['HTTP_REFERER'];
    }
    break;
  }
 
  if ( empty($redirectUrl) ) return $default;
  else return $redirectUrl;
 }
}