<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "quest".
 *
 * @property integer $quest_id
 * @property integer $active
 * @property integer $deleted
 * @property integer $blocked
 * @property integer $private
 * @property integer $type
 * @property integer $created_by_id
 * @property string $deadline_period
 * @property string $deadline
 * @property integer $category_id
 * @property string $name
 * @property string $short_description
 * @property string $description
 * @property string $picture
 * @property string $place_coords
 * @property string $place_name
 * @property integer $user_limit
 */
class Quest extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quest';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['active', 'deleted', 'blocked', 'private', 'type', 'created_by_id', 'category_id', 'user_limit'], 'integer'],
            [['created_by_id', 'category_id', 'name', 'picture'], 'required'],
            [['deadline'], 'safe'],
            [['short_description', 'description'], 'string'],
            [['deadline_period'], 'string', 'max' => 255],
            [['name', 'picture', 'place_coords', 'place_name'], 'string', 'max' => 512],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'quest_id' => Yii::t('app', 'Quest ID'),
            'active' => Yii::t('app', 'Active'),
            'deleted' => Yii::t('app', 'Deleted'),
            'blocked' => Yii::t('app', 'Blocked'),
            'private' => Yii::t('app', 'Private'),
            'type' => Yii::t('app', 'Type'),
            'created_by_id' => Yii::t('app', 'Created By ID'),
            'deadline_period' => Yii::t('app', 'Deadline Period'),
            'deadline' => Yii::t('app', 'Deadline'),
            'category_id' => Yii::t('app', 'Category ID'),
            'name' => Yii::t('app', 'Name'),
            'short_description' => Yii::t('app', 'Short Description'),
            'description' => Yii::t('app', 'Description'),
            'picture' => Yii::t('app', 'Picture'),
            'place_coords' => Yii::t('app', 'Place Coords'),
            'place_name' => Yii::t('app', 'Place Name'),
            'user_limit' => Yii::t('app', 'User Limit'),
        ];
    }

    /**
     * @inheritdoc
     * @return QuestQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new QuestQuery(get_called_class());
    }


    public function getInterests(){
        return $this->hasMany( Interest::className(), ['interest_id' => 'interest_id'] )->viaTable('quest2interest', ['quest_id' => 'quest_id']);
    }
    public function getRewards(){
        $reward = QuestReward::find()->where('quest_id = '.$this->quest_id);
        return $reward;
    }
    public function getUsersComplete(){
         
        return 0;
    }
    public function getUsersFailed(){
         
        return 0;
    } 
}
