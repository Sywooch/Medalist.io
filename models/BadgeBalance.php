<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "badge_balance".
 *
 * @property integer $badge_balance_id
 * @property integer $user_id
 * @property integer $badge_id
 * @property string $date_created
 * @property string $description
 */
class BadgeBalance extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'badge_balance';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'badge_id', 'date_created'], 'required'],
            [['user_id', 'badge_id'], 'integer'],
            [['date_created', 'description'], 'safe'],
            [['description'], 'string', 'max' => 1024],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'badge_balance_id' => 'Badge Balance ID',
            'user_id' => 'User ID',
            'badge_id' => 'Badge ID',
            'date_created' => 'Date Created',
            'description' => 'Description',
        ];
    }

    public function getScalePoints(){
        return ScalePointsBalance::find()->where(['user_id' => $this->user_id, 'attached_entity_class' => 'Badge', 'attached_entity_id' => $this->badge_id])->one();
    }
    public function getBadge(){
        return Badge::findOne($this->badge_id);
    }

    /**
     * @inheritdoc
     * @return BadgeBalanceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BadgeBalanceQuery(get_called_class());
    }


/* Andrey */
    public static function addBalance($user_id, $badge_id){
        $badgeBalance = BadgeBalance::find()->where(['user_id' => $user_id, 'badge_id' => $badge_id])->one();
		if(empty($badgeBalance)){
			$badgeBalance = new BadgeBalance;
		}
		$badgeBalance->user_id = $user_id;
		$badgeBalance->badge_id = $badge_id;
	    $badgeBalance->date_created = date("Y-m-d H:i:s");
		$badgeBalance->save();
    }
/* Andrey */


}
