<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "scale".
 *
 * @property integer $scale_id
 * @property string $name
 */
class Scale extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'scale';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 256],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'scale_id' => 'Scale ID',
            'name' => 'Name',
        ];
    }

    /**
     * @inheritdoc
     * @return ScaleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ScaleQuery(get_called_class());
    }
}
