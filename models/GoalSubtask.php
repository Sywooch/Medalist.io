<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "goal_subtask".
 *
 * @property integer $goal_subtask_id
 * @property integer $goal_subtask_parent_id
 * @property integer $goal_id
 * @property string $deadline
 * @property string $date_created
 * @property integer $active
 * @property integer $deleted
 * @property integer $blocked
 * @property integer $completed
 * @property integer $sort
 */
class GoalSubtask extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'goal_subtask';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goal_subtask_parent_id', 'goal_subtask_id','goal_id', 'active', 'deleted', 'blocked', 'completed', 'sort'], 'integer'],
            [['goal_id', 'date_created', 'name'], 'required'],
            [['deadline', 'date_created', 'description'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'goal_subtask_id' => 'Goal Subtask ID',
            'goal_subtask_parent_id' => 'Goal Subtask Parent ID',
            'goal_id' => 'Goal ID',
            'name' => 'Name',
            'description' => 'description',
            'deadline' => 'Deadline',
            'date_created' => 'Date Created',
            'active' => 'Active',
            'deleted' => 'Deleted',
            'blocked' => 'Blocked',
            'completed' => 'Completed',
            'sort' => 'Sort',
        ];
    }

    /**
     * @inheritdoc
     * @return GoalSubtaskQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new GoalSubtaskQuery(get_called_class());
    }

    public  function getSubtasks(){
        return GoalSubtask::find()->where("goal_subtask_parent_id = ".$this->goal_subtask_id)->all();
    }



    public function getProgressPercent(){

        $subtasks = $this->getSubtasks();

        if( !empty($subtasks) ){
            $count = 0;
            $percent = 0;
            foreach ($subtasks as $st) {
                $count++;
                $percent += $st->getProgressPercent();
            }
            return ($percent/$count);
        }else{
            return ($this->completed)?100:0;
        }

    }


    public function getGoal(){
        return $this->hasOne( Goal::className(), ['goal_id' => 'goal_id']);
    }


    public function setSubtasksCompleted( $state = 1 ){
        $subtasks = $this->getSubtasks();

        if( !empty($subtasks) ){
            foreach ($subtasks as $key => $subtask) {
                $subtask->completed = $state;
                $subtask->save();
            }
        }
    }



}
