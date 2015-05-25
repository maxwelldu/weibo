<?php
namespace frontend\controllers;

use Yii;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\models\User;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * test memcache
     * @return mixed|string
     */
	public function actionTestMemcache()
    {
        $key = "username";
        //Yii::$app->cache->delete($key);
        $value = Yii::$app->cache->get($key);
        if ($value === false) {
            $value = "maxwelldu ";
            Yii::$app->cache->set($key, $value, 30);
        }
        return $value;
    }

    public function actionTestRedis()
    {
        // 批量注册10个用户
        for($i=0; $i<10; $i++) {
            $userID = Yii::$app->redis->incr("users:count");
            $email = "dcj3sjt@126.com";
            Yii::$app->redis->hmset("user:{$userID}", "email", $email.$userID, "password", md5("adminadmin"), "nickname", "maxwelldu".$userID);
            Yii::$app->redis->hset("email.to.id", $email, $userID);

            echo "注册成功";
        }

        //检测邮箱是否已经注册
        if ( Yii::$app->redis->hexists('email.to.id', "dcj3sjt@126.com") ) {
            echo '该邮箱已经注册过了';
            exit;
        }


        //登录, 获取邮箱, 去查id
        $email = "dcj3sjt@126.com1";
        $userID = Yii::$app->redis->hget("email.to.id", $email);
        if(!$userID) {
            echo '用户名或密码错误!';
            exit;
        }

        $password = md5("adminadmin");
        $userpassword = Yii::$app->redis->hget("user:{$userID}", "password");
        if($password != $userpassword) {
            echo "用户登录失败";
            exit;
        }
        echo "用户登录成功";



        //Yii::$app->redis->executeCommand('HMSET', ['user:1', 'name', 'joe', 'solary', 2000]);
//        Yii::$app->redis->set("site1", "www.baidu.com");
//        Yii::$app->redis->set("site2", "www.google.com");

//        echo Yii::$app->redis->get("site1");
//        echo Yii::$app->redis->get("site2");

//        删除 redis中的所有数据
//        Yii::$app->redis->flushall();

//        $customer = new User();
//        $customer->attributes = ['name' => 'test'];
//        $customer->save();
//        echo $customer->id; // id will automatically be incremented if not set explicitly

        /*
        $customer = User::find()->where(['name' => 'test'])->one(); // find by query
        var_dump($customer);
        $customers = User::find()->active()->all(); // find all by query
        foreach($customers as $c) {
            var_dump($c);
        }
        */
    }
}
