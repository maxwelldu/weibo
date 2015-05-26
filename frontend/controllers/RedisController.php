<?php
/**
 * Created by PhpStorm.
 * User: michaeldu
 * Date: 5/26/15
 * Time: 8:07 AM
 */

namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use frontend\models\SignupForm;
use yii\filters\AccessControl;


class RedisController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'signup', 'logout', 'login', 'index'
                ],
            ],
        ];
    }

    public function actionSignup()
    {
        $model = new SignupForm();
        if (Yii::$app->request->isPost) {
            $SignupForm = Yii::$app->request->post("SignupForm");
            $email = $SignupForm['email'];
            $password = $SignupForm['password'];
            $username = $SignupForm['username'];

            //检查邮箱是否唯一
            if ( Yii::$app->redis->hexists("email.to.id", $email) ) {
                echo "该邮箱已被注册";
            }

            $userID = Yii::$app->redis->incr("users:count");
            Yii::$app->redis->hmset("user:{$userID}", "email", $email, "password", $password, "username", $username);
            Yii::$app->redis->hset("email.to.id", $email, $userID);

            echo "注册成功";
            Yii::$app->session->set("userid", $userID);
            Yii::$app->session->set("username", $username);
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->getSession()->destroy();

        return $this->goHome();
    }


    public function actionLogin()
    {
        if (Yii::$app->session->get("userid")>0) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if (Yii::$app->request->isPost) {
            //登录, 获取邮箱, 去查id
            $LoginForm = Yii::$app->request->post("LoginForm");
            $email = $LoginForm['email'];
            $password = $LoginForm['password'];
            $userID = Yii::$app->redis->hget("email.to.id", $email);
            if(!$userID) {
                echo '用户名或密码错误!';
            }

            $password = md5($password);
            $userpassword = Yii::$app->redis->hget("user:{$userID}", "password");
            if($password != $userpassword) {
                echo "用户登录失败";
            }
            echo "用户登录成功";
            $this->goHome();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionIndex()
    {
        return $this->render('index');
    }
}