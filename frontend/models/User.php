<?php
/**
 * Created by PhpStorm.
 * User: michaeldu
 * Date: 5/25/15
 * Time: 1:43 PM
 */

namespace frontend\models;

use yii;

class User extends  \yii\redis\ActiveRecord
{
    /**
     * @return array the list of attributes for this record
     */
    public function attributes()
    {
        return ['id', 'name', 'address', 'registration_date'];
    }

    /**
     * @return ActiveQuery defines a relation to the Order record (can be in other database, e.g. elasticsearch or sql)
     */
    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['customer_id' => 'id']);
    }

    /**
     * Defines a scope that modifies the `$query` to return only active(status = 1) customers
     */
    public static function active($query)
    {
        
        $query->andWhere(['status' => 1]);
    }
}