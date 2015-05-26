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

    <div class="row">
        <div class="col-lg-12">
            <?php
            foreach($posts as $post) {
                ?>
                <div class="row">
                    <span>作者: <?php echo $post[1]; ?></span>
                    <span>发布时间: <?php echo date('y-m-d H:i:s', $post[2]); ?></span>
                    <span>微博内容: <?php echo $post[3]; ?></span>
                </div>
            <?php
            }
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <h3>关注的人</h3>
            <?php
            foreach($followingusers as $user) {
                ?>
                <span>用户名: <?php echo $user[2]; ?></span>
                <hr />
            <?php
            }
            ?>
        </div>
        <div class="col-lg-6">
            <h3>我的粉丝</h3>
            <?php
            foreach($followersusers as $user) {
                ?>
                <span>用户名: <?php echo $user[2]; ?></span>
                <hr />
            <?php
            }
            ?>
        </div>
    </div>
</div>
