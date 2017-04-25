<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "likes".
 *
 * @property integer $like_id
 * @property integer $created_by_id
 * @property integer $point
 * @property string $date_created
 * @property string $entity_class
 * @property integer $entity_id
 */
class Like extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'likes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_by_id', 'date_created', 'entity_class', 'entity_id'], 'required'],
            [['created_by_id', 'point', 'entity_id'], 'integer'],
            [['date_created'], 'safe'],
            [['entity_class'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'like_id' => 'Like ID',
            'created_by_id' => 'Created By ID',
            'point' => 'Point',
            'date_created' => 'Date Created',
            'entity_class' => 'Entity Class',
            'entity_id' => 'Entity ID',
        ];
    }

    /**
     * @inheritdoc
     * @return LikesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new LikeQuery(get_called_class());
    }

    //GetLikesOfObject
    public static function getLikesOfObject( $obj ){
        $classname = get_class( $obj );
        $classname = explode("\\",$classname);
        $classname = $classname[count($classname) - 1];
        $idVarName = $classname."_id");
        $id = $obj->{$idVarName};

        return Like::find()->where("entity_class = '".$classname."' and entity_id = ".$id)->all();
    }
    //GetLikesOfObject
    public static function getLikesOfObjectCount( $obj ){
        $classname = get_class( $obj );
        $classname = explode("\\",$classname);
        $classname = $classname[count($classname) - 1];
        $idVarName = $classname."_id");
        $id = $obj->{$idVarName};

        return Like::find()->where("entity_class = '".$classname."' and entity_id = ".$id." where points = 1")->count();
    }
        //GetLikesOfObject
    public static function getDislikesOfObjectCount( $obj ){
        $classname = get_class( $obj );
        $classname = explode("\\",$classname);
        $classname = $classname[count($classname) - 1];
        $idVarName = $classname."_id");
        $id = $obj->{$idVarName};

        return Like::find()->where("entity_class = '".$classname."' and entity_id = ".$id." where points = -1")->count();
    }
}
