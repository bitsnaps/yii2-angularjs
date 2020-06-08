<?php

namespace app\controllers;

use Yii;
use yii\base\Response;
use yii\filters\ContentNegotiator;
use yii\filters\auth\HttpBearerAuth;
use app\models\ContactForm;
use app\models\LoginForm;
use app\models\SignupForm;


class ApiController extends \yii\rest\Controller {


    public function behaviors() {
        $behaviors = parent::behaviors();
        
        $behaviors['authenticator'] = [
            // HTTP Bearer Auth method we will make some additions to the behaviors() method of our controller
            'class' => HttpBearerAuth::className(),
            // We only have one action (dashboard) that needs authentication
            'only' => ['dashboard'],
        ];
        
        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::className(),
            'formats' => [
                // we will only use JSON 
                'application/json' => Response::FORMAT_JSON,
            ],
        ];
        
        // We wan’t to allow access to the dashboard only for authenticated users.
        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'only' => ['dashboard'],
            'rules' => [
                [
                    'actions' => ['dashboard'],
                    'allow' => true,
                    'roles' => ['@'],
                ],
            ],
        ];
        
        return $behaviors;
        
    }
    
    /**
     * 
     * Login action
     * 
     * @return LoginForm
     */
    public function actionLogin()
    {
        $model = new LoginForm();

        if ($model->load(Yii::$app->getRequest()->getBodyParams(), '') && $model->login()) {
            return ['access_token' => Yii::$app->user->identity->getAuthKey()];
        } else {
            $model->validate();
            return $model;
        }
    }
    
    /**
     * 
     * Login action
     * 
     * @return LoginForm
     */
    public function actionSignup()
    {
        $model = new SignupForm();

//        if ($model->load(Yii::$app->getRequest()->getBodyParams(), '') && $model->login()) {
//            return ['access_token' => Yii::$app->user->identity->getAuthKey()];
//        } else {
//            $model->validate();
            return $model;
//        }
    }
    
    /**
     * 
     * dashboard is protected by AccessControl so we only need to provide 
     * the data for the view in our dashboard action
     * 
     */
    public function actionDashboard()
    {
        $response = [
            'username' => Yii::$app->user->identity->username,
            'access_token' => Yii::$app->user->identity->getAuthKey(),
        ];

        return $response;
    }
    
    /**
     * 
     * Contact action
     * 
     * @return ContactForm
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->getRequest()->getBodyParams(), '') && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                $response = [
                    'flash' => [
                        'class' => 'success',
                        'message' => 'Thank you for contacting us. We will respond to you as soon as possible.',
                    ]
                ];
            } else {
                $response = [
                    'flash' => [
                        'class' => 'error',
                        'message' => 'There was an error sending email.',
                    ]
                ];
            }
            return $response;
        } else {
            $model->validate();
            return $model;
        }
    }
    
}
