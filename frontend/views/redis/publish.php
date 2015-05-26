<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = '发布微博';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php
    if(Yii::$app->session->getFlash('failure')) {
        echo "<div class='alert alert-error'>".Yii::$app->session->getFlash('failure')."</div>";
    }
    ?>
    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'publish-form']); ?>
            <?= $form->field($model, 'content')->textarea(['width' => 300, 'height' => 300]) ?>
            <div class="form-group">
                <?= Html::submitButton('发布', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>


