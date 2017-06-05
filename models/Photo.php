<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "photo".
 *
 * @property integer $photo
 * @property string $filename
 * @property string $date_created
 * @property string $entity_class
 * @property integer $entity_id
 */
class Photo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'photo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['filename', 'entity_class', 'entity_id'], 'required'],
            [['date_created'], 'safe'],
            [['entity_id'], 'integer'],
            [['filename'], 'string', 'max' => 1024],
            [['entity_class'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'photo' => 'Photo',
            'filename' => 'Filename',
            'date_created' => 'Date Created',
            'entity_class' => 'Entity Class',
            'entity_id' => 'Entity ID',
        ];
    }

    /**
     * @inheritdoc
     * @return PhotoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PhotoQuery(get_called_class());
    }


    public function deleteFile(){
        if( file_exists( Yii::getAlias('@webroot').'/uploads'.$this->filename )){
            unlink(Yii::getAlias('@webroot').'/uploads'.$this->filename);
        }
        
    }
}
