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

$this->title = 'Index';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-lg-5">
            <?php
            echo Yii::$app->session->get('userid');
            echo Yii::$app->session->get("username");
            ?>
        </div>
    </div>
</div>
