<?php
namespace frontend\controllers;

use Yii;
use frontend\models\SignupForm;
use common\models\User;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * User controller
 */
class UserController extends Controller {
    
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create', 'index'],
                'rules' => [
                    [
                        'actions' => ['create', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ]
        ];
    }
    
    public function actions() {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
    
    public function actionIndex($parent_id=null) {
        $parent_id = (int) $parent_id;
        if (!$parent_id) {
            $parentId = Yii::$app->user->id;
        } else {
            $parentId = $parent_id;
        }
        $depth = 10;
        $connection = Yii::$app->db;
        $command = $connection->createCommand('call get_branch(:parent_id, :depth)')
        ->bindParam(':parent_id', $parentId)
        ->bindParam(':depth', $depth);
        $result = $command->queryAll();
        $nodes = array();
        foreach ($result as $item) {
            if ($item['id'] == $parentId) {
                $nodes[] [] = $item;
                continue;
            }
            $item['parent_id'] = (int) $item['parent_id'];
            if (!isset($nodes[$item['parent_id']])) {
                $nodes[$item['parent_id']] = [];
            }
            $nodes[$item['parent_id']] [] = $item;
        }
        /*echo '<pre>';
        print_r($nodes);
        exit;*/
        
        return $this->render('index', [
            'nodes' => $nodes,
        ]);
    }
    
    public function actionCreate($parent_id=null) {
        $parentId = (int) Yii::$app->request->queryParams['parent_id'];
        $parent = User::findOne($parentId);
        if ($parent instanceof User !==true) {
            throw new InvalidParamException('Invalid supplied parent-id');
        }
        
        $model = new SignupForm();
        $model->parentId = $parentId;
        if (!Yii::$app->request->isPost) {
            return $this->render('create', [
            'model' => $model,
            'parent' => $parent,
            ]);
        }
        
        if ($model->load(Yii::$app->request->post())) {
            $uname = 'user' . mt_rand(1000, 9999);
            $model->username = $uname;
            $model->password = $uname;
            $model->email = $uname . '@yopmail.com';
            if ($user = $model->signup()) {
                return $this->redirect(array('index'));
            }
        }

        return $this->render('create', [
            'model' => $model,
            'parent' => $parent,
        ]); 
    }
    
    public function actionTree() {
        return $this->render('tree2');
    }
}