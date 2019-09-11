<?php

namespace app\models;

use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class CreatedirForm extends Model
{
    public $name;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['name'], 'required'],
        ];
    }
}
