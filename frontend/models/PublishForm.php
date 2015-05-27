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
            ['content', 'required', 'message' => '微博内容不能为空'],
            ['content', 'string', 'min' => 2, 'max' => 255], //规则为字符串, 则程序会在入库出库的时候做处理, 不会乱码
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'content' => '',
        ];
    }
}
