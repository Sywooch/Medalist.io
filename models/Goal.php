<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "goal".
 *
 * @property integer $goal_id
 * @property integer $user_id
 * @property string $name
 * @property string $description
 * @property integer $active
 * @property integer $deleted
 * @property integer $blocked
 * @property integer $private
 * @property integer $completed
 * @property string $picture
 * @property integer $status
 * @property integer $category_id
 * @property integer $percent_completed
 * @property integer $difficulty
 * @property string $deadline
 * @property string $date_created
 */
class Goal extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'goal';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'name', 'date_created'], 'required'],
            [['user_id', 'active', 'deleted', 'blocked', 'private', 'completed', 'status', 'category_id', 'percent_completed', 'difficulty'], 'integer'],
            [['description'], 'string'],
            [['deadline', 'date_created'], 'safe'],
            [['name'], 'string', 'max' => 1024],
            [['picture'], 'string', 'max' => 512],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'goal_id' => 'Goal ID',
            'user_id' => 'User ID',
            'name' => 'Name',
            'description' => 'Description',
            'active' => 'Active',
            'deleted' => 'Deleted',
            'blocked' => 'Blocked',
            'private' => 'Private',
            'completed' => 'Completed',
            'picture' => 'Picture',
            'status' => 'Status',
            'category_id' => 'Category ID',
            'percent_completed' => 'Percent Completed',
            'difficulty' => 'Difficulty',
            'deadline' => 'Deadline',
            'date_created' => 'Date Created',
        ];
    }

    /**
     * @inheritdoc
     * @return GoalQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new GoalQuery(get_called_class());
    }


    public  function getLikes(){
        return Likes::find()->where("entity_class = 'Goal' and entity_id = ".$this->goal_id)->all();
    }
    public  function getComments(){
        return Comment::find()->where("entity_class = 'Goal' and entity_id = ".$this->goal_id)->all();
    }

    public  function getPhotos(){
        return Photo::find()->where("entity_class = 'Goal' and entity_id = ".$this->goal_id)->all();
    }
    public  function getSubtasks(){
        return $this->hasMany(GoalSubtask::classname(), ['goal_id' => 'goal_id'])->all();

    }

    public static function getUserGoalsById( $user_id ){
        return Goal::find()->where(" user_id = ".$user_id)->all();
    }

    public static function getSubtasksById( $goal_id ){
        return GoalSubtask::find()->where(" goal_id = ".$goal_id." and goal_subtask_parent_id = 0")->all();
    }
}
