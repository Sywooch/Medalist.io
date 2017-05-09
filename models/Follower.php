<?php

namespace app\models;

use Yii;
use yii\db\Expression;
use amnah\yii2\user\models\User;


/**
 * This is the model class for table "follower".
 *
 * @property integer $follower_id
 * @property integer $user_id
 * @property integer $to_user_id
 * @property string $date_created
 */
class Follower extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'follower';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'to_user_id', 'date_created'], 'required'],
            [['user_id', 'to_user_id'], 'integer'],
            [['date_created'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'follower_id' => 'Follower ID',
            'user_id' => 'User ID',
            'to_user_id' => 'To User ID',
            'date_created' => 'Date Created',
        ];
    }

    /**
     * @inheritdoc
     * @return FollowerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FollowerQuery(get_called_class());
    }




    public static function findAlikeUsers( $userId  ){
        return User::find()->where('id !='.$userId)->orderBy(new Expression('rand()'))->limit(4);
    }

    
}
