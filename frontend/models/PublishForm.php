<?php
namespace frontend\models;

use yii\base\Model;
use Yii;

/**
 * Publish form
 */
class PublishForm extends Model
{
    public $content;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['content', 'filter', 'filter' => 'trim'],
            ['content', 'required'],
        ];
    }

}
