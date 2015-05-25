<?php
/**
 * Created by PhpStorm.
 * User: michaeldu
 * Date: 5/25/15
 * Time: 1:43 PM
 */

namespace frontend\models;

use yii;

class UserModel extends  \yii\redis\ActiveRecord{
    public function attributes()
    {
        return ['id', 'username', 'password', 'created_at'];
    }


}