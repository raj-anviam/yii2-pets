<?php

namespace app\models;

use yii\base\Model;
use yii\db\ActiveRecord;
use app\models\User;

class Pet extends ActiveRecord
{
    // public $name;

    public static function tableName() {
        return 'pets';
    }

    public function behaviors()
    {
        return [
            \cornernote\linkall\LinkAllBehavior::className(),
        ];
    }


    // public function users() {
    //     return $this->hasMany(User::className(), ['user_id' => 'id']);
    // }

    public function getUsers() {
        return $this->hasMany(User::className(), ['id' => 'user_id'])
          ->viaTable('pet_user', ['pet_id' => 'id']);
    }

}