<?php
/**
 * Created by PhpStorm.
 * User: michaeldu
 * Date: 5/26/15
 * Time: 8:11 AM
 */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

$this->title = '我的页面';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row well">
        用户信息
        <?php
        echo "用户名";
        echo $userinfo[2]; //用户名
        echo "关注数";
        echo $userinfo[3]; //关注数
        echo "粉丝数";
        echo $userinfo[4]; //粉丝数
        echo "微博数";
        echo $userinfo[5]; //微博数
        ?>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <?php
            foreach($posts as $post) {
                ?>
                <div class="well">
                    <span><?php echo $post[1]; ?></span>
                    <br />
                    <span><?php echo $post[3]; ?></span>
                    <br />
                    <span style="color: darkgray"><?php echo date('y-m-d H:i:s', $post[2]); ?></span>
                </div>
            <?php
            }
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <h3>关注的人</h3>
            <ul class="list-group">
                <?php
                $i = 1;
                foreach($followingusers as $user) {
                    ?>
                    <li class="list-group-item list-group-item-info">
                        <span class="glyphicon glyphicon-user"> <?php echo $user[2]; ?></span>
                        <?php
                        if(Yii::$app->session->get('userid')>0) :
                            ?>
                            <?= Html::a('取消关注', '?r=redis/delfollow&userid='.$i++,  ['class' => 'btn btn-primary']) ?>
                        <?php
                        endif;
                        ?>
                    </li>
                <?php
                }
                ?>
            </ul>
        </div>
        <div class="col-lg-6">
            <h3>我的粉丝</h3>
            <ul class="list-group">
                <?php
                $i = 1;
                foreach($followersusers as $user) {
                    ?>
                    <li class="list-group-item list-group-item-info">
                        <span class="glyphicon glyphicon-user"> <?php echo $user[2]; ?></span>
                        <?php
                        if(Yii::$app->session->get('userid')>0) :
                            ?>
                            <?= Html::a('关注', '?r=redis/follow&userid='.$i++,  ['class' => 'btn btn-primary']) ?>
                        <?php
                        endif;
                        ?>
                    </li>
                <?php
                }
                ?>
            </ul>
        </div>
    </div>
</div>
