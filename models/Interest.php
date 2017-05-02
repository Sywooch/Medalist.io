<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "interest".
 *
 * @property integer $interest_id
 * @property integer $parent_interest_id
 * @property string $name
 */
class Interest extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'interest';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_interest_id'], 'integer'],
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
            'interest_id' => 'Interest ID',
            'parent_interest_id' => 'Parent Interest ID',
            'name' => 'Name',
        ];
    }

    /**
     * @inheritdoc
     * @return InterestQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new InterestQuery(get_called_class());
    }


 


}
