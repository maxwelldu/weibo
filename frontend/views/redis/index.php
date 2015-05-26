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

$this->title = '微博';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-8">
            <?php
                foreach($posts as $post) {
            ?>
                    <div class="well">
                <span>作者: <?php echo $post[1]; ?></span>
                <span>发布时间: <?php echo date('y-m-d H:i:s', $post[2]); ?></span>
                <span>微博内容: <?php echo $post[3]; ?></span>
                    </div>
            <?php
                }
            ?>
        </div>
        <div class="col-lg-4">
            <h3>所有用户</h3>
            <ul class="list-group">
            <?php
            $i = 1;
            foreach($users as $user) {
            ?>
                <li class="list-group-item list-group-item-info">
                    <span>用户名: <?php echo $user[5]; ?></span>
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
