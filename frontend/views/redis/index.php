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

$this->title = '我关注的微博';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-8">
            <?php
                foreach($posts as $post) {
            ?>
                <span>作者: <?php echo $post[1]; ?></span>
                <span>发布时间: <?php echo date('y-m-d H:i:s', $post[2]); ?></span>
                <span>微博内容: <?php echo $post[3]; ?></span>
            <hr />
            <?php
                }
            ?>
        </div>
        <div class="col-lg-4">
            <h3>所有用户</h3>
            <?php
            foreach($users as $user) {
                ?>
                    <span>用户名: <?php echo $user[5]; ?></span>
                <?= Html::a('关注', '?r=redis/follow',  ['class' => 'btn btn-primary']) ?>
                <hr />
            <?php
            }
            ?>
        </div>

    </div>
</div>
