<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class MessageForm extends Model
{
    public $text;
    public $time;
    public $username;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['text', 'trim'],
            [['text', 'time', 'username'], 'required'],
        ];
    }

}
