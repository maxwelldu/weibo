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
use common\models\LoginForm;
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
                Yii::$app->session->setFlash("failure", "该邮箱已被注册");

                return $this->render('signup', [
                    'model' => $model,
                ]);
            }

            $userID = Yii::$app->redis->incr("users:count");
            Yii::$app->redis->hmset("user:{$userID}", "email", $email, "password", md5($password), "username", $username);
            Yii::$app->redis->hset("email.to.id", $email, $userID);

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
        Yii::$app->session->set("userid", 0);

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
                Yii::$app->session->setFlash("failure", "用户或密码错误");

                return $this->render('login', [
                    'model' => $model,
                ]);
            }

            $password = md5($password);
            $userpassword = Yii::$app->redis->hget("user:{$userID}", "password");
            if($password != $userpassword) {
                Yii::$app->session->setFlash("failure", "用户登录失败");
                return $this->render('login', [
                    'model' => $model,
                ]);
            }

            $username = Yii::$app->redis->hget("user:$userID", "username");
            Yii::$app->session->set("userid", $userID);
            Yii::$app->session->set("username", $username);
            $this->goHome();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionIndex()
    {
        $userID = Yii::$app->session->get("userid");
        $posts = array();

        if($userID>0) {
            $postids = Yii::$app->redis->lrange("posts:$userID", 0, Yii::$app->redis->get("posts:count"));

            foreach ($postids as $postID) {
                $post = Yii::$app->redis->hvals("post:$postID");
                $posts[] = $post;
            }
        }

        return $this->render('index', [
            'post' => $posts
        ]);
    }

    public function actionPublis()
    {
        $postID = Yii::$app->redis->incr("posts:count");
        $uid = Yii::$app->session->get("userid");
        $username = Yii::$app->redis->hget("user:$uid", "username");
        $created_at = time();
        $content = "test content";
        Yii::$app->redis->hmset("post:{$postID}", "uid", $uid, "username", $username, "created_at", $created_at, "content", $content);
        Yii::$app->redis->rpush("posts:$uid", $postID);
        echo "微博成功";
    }
}