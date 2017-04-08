<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "quest_challenge".
 *
 * @property integer $quest_challenge_id
 * @property integer $quest_id
 * @property integer $created_by_id
 * @property integer $to_user_id
 * @property string $date_created
 * @property integer $refused
 * @property string $comment
 */
class QuestChallenge extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quest_challenge';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['quest_id', 'created_by_id', 'to_user_id', 'date_created'], 'required'],
            [['quest_id', 'created_by_id', 'to_user_id', 'refused'], 'integer'],
            [['date_created'], 'safe'],
            [['comment'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'quest_challenge_id' => Yii::t('app', 'Quest Challenge ID'),
            'quest_id' => Yii::t('app', 'Quest ID'),
            'created_by_id' => Yii::t('app', 'Created By ID'),
            'to_user_id' => Yii::t('app', 'To User ID'),
            'date_created' => Yii::t('app', 'Date Created'),
            'refused' => Yii::t('app', 'Refused'),
            'comment' => Yii::t('app', 'Comment'),
        ];
    }

    /**
     * @inheritdoc
     * @return QuestChallengeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new QuestChallengeQuery(get_called_class());
    }
}
