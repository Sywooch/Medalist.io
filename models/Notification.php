<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "notification".
 *
 * @property integer $notification_id
 * @property integer $notification_type_id
 * @property integer $user_id
 * @property integer $to_user_id
 * @property string $date_created
 * @property string $text
 * @property string $entity_class
 * @property integer $entity_id
 */
class Notification extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notification';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['notification_type_id', 'user_id', 'to_user_id', 'entity_id'], 'integer'],
            [['user_id', 'date_created'], 'required'],
            [['date_created', 'text'], 'safe'],
            [['text'], 'string'],
            [['entity_class'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'notification_id' => 'Notification ID',
            'notification_type_id' => 'Notification Type ID',
            'user_id' => 'User ID',
            'to_user_id' => 'To User ID',
            'date_created' => 'Date Created',
            'text' => 'Text',
            'entity_class' => 'Entity Class',
            'entity_id' => 'Entity ID',
        ];
    }

    /**
     * @inheritdoc
     * @return NotificationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NotificationQuery(get_called_class());
    }

    public function getNotificationType(){
        return $this->hasOne(NotificationType::$className, ['notification_type_id' => 'notification_type_id'])->one();
    }



    public static function getUserFeed( $for_user_id, $notification_type_id = false, $limit = 20, $offset = 0  ){

        //GetFriends IDs

        
        if( empty($notification_type_id) ){
            $notifications = Notification::find()->where(['for_user_id' => $for_user_id])->orWhere([ 'user_id' => $user_ids]);    
        }else{
             $notifications = Notification::find()->where(['for_user_id' => $for_user_id, 'notification_type_id' => $notification_type_id])->orWhere([ 'user_id' => $user_ids]);    
        }

        $notifications = $notifications->offset( $offset )->limit( $limit );
      

        return $notifications;
        
    }


    /*
    * Добавить новость 
    */
    public static function addNotification($user_id, $notification_type_id, $obj = false, $to_user_id = false, $text = '' ){

        $notification = new Notification;
        $notification->user_id;
        $notification->notification_type_id = $notification_type_id;
        $notification->date_created = date("Y-m-d H:i:s");

        if( !empty($obj) ){
            $classname = get_class( $obj );
            $classname = explode("\\",$classname);
            $classname = $classname[count($classname) - 1];
            $idVarName = strtolower($classname."_id");
            $id = $obj->{$idVarName};

            $notification->entity_class = $classname;
            $notification->entity_id = $id;
        }

        if( !empty($to_user_id) ){
            $notification->to_user_id = $to_user_id;
        }

        if( !empty($text) ){
            $notification->text = $text;
        }

        if ( $notification->save() ){
            return $notification->notification_id;
        }else{
            return false;
        }

    }


}
