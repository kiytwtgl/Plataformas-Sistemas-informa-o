<?php

namespace common\models;

use yii\db\ActiveRecord;

class Localizacao extends ActiveRecord
{
    public static function tableName()
    {
        return 'localizacao';
    }

    public function rules()
    {
        return [
            [['id_museu'], 'required'],
            [['id_museu'], 'integer'],
            [['latitude', 'longitude'], 'number'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
        ];
    }
}