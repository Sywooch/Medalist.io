<?php

namespace app\models;

use Yii;
use amnah\yii2\user\models\User;

/**
 * This is the model class for table "achievement".
 *
 * @property integer $achievement_id
 * @property integer $active
 * @property integer $deleted
 * @property integer $blocked
 * @property integer $difficult
 * @property string $date_created
 * @property string $date_achieved
 * @property integer $difficulty
 * @property integer $quest_id
 * @property integer $goal_id
 * @property string $place_coords
 * @property string $place_name
 * @property integer $category_id
 * @property integer $status
 * @property string $name
 * @property string $description
 */
class Achievement extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'achievement';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['active', 'deleted', 'blocked', 'difficult', 'difficulty', 'quest_id', 'goal_id', 'category_id', 'status'], 'integer'],
            [['date_created', 'date_achieved', 'name'], 'required'],
            [['date_created', 'date_achieved'], 'safe'],
            [['description'], 'string'],
            [['place_coords', 'place_name', 'name'], 'string', 'max' => 512],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'achievement_id' => 'Achievement ID',
            'active' => 'Active',
            'deleted' => 'Deleted',
            'blocked' => 'Blocked',
            'difficult' => 'Difficult',
            'date_created' => 'Date Created',
            'date_achieved' => 'Date Achieved',
            'difficulty' => 'Difficulty',
            'quest_id' => 'Quest ID',
            'goal_id' => 'Goal ID',
            'place_coords' => 'Place Coords',
            'place_name' => 'Place Name',
            'category_id' => 'Category ID',
            'status' => 'Status',
            'name' => 'Name',
            'description' => 'Description',
        ];
    }

    /**
     * @inheritdoc
     * @return AchievementQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AchievementQuery(get_called_class());
    }


    public  function getLikes(){
        return Like::find()->where("entity_class = 'Achievement' and entity_id = ".$this->achievement_id)->all();
    }
    public  function getComments(){
        return Comment::find()->where("entity_class = 'Achievement' and entity_id = ".$this->achievement_id)->all();
    }

    public  function getPhotos(){
        return Photo::find()->where("entity_class = 'Achievement' and entity_id = ".$this->achievement_id)->all();
    }
    public  function getTags(){
        $tags = Tag::find();
        $tags->multiple = true;
        $tags->innerJoin('tag2entity', 'tag.tag_id = tag2entity.tag_id');
        $tags->where('tag2entity.entity_id = '.$this->achievement_id ." AND tag2entity.entity_class = 'Achievement'");
        return $tags->all();
    }

    public  function getInterests(){
        $interests = Interest::find();
        $interests->multiple = true;
        $interests->innerJoin('interest2entity', 'interest.interest_id = interest2entity.interest_id');
        $interests->where('interest2entity.entity_id = '.$this->achievement_id ." AND interest2entity.entity_class = 'Achievement'");
        return $interests->all();
    }
    public  function getUser(){
        $user = User::findOne($this->user_id);
      
        return $user;
    }


    public  function getCategory(){
        
        return $this->hasOne(Category::className(), ['category_id' => 'category_id'])->one();
    }

    /**
    * Привязывает интересы к достижению 
    */
    public function attachInterests( $interestTextArray ){

    }

    /** 
    * Анализирует себя и интересы и привязывает награды
    */
    public function analyzeAndSetRewards(){

    }


    /**
    *   На основании интересов получает категории
    */
    public function getSuitableCategoryId () {

    }

}
