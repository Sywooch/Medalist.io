<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comment".
 *
 * @property integer $comment_id
 * @property integer $active
 * @property integer $deleted
 * @property integer $created_by_id
 * @property string $text
 * @property string $entity_class
 * @property integer $entity_id
 * @property integer $parent_comment_id
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['active', 'deleted', 'created_by_id', 'entity_id', 'parent_comment_id'], 'integer'],
            [['created_by_id', 'text', 'entity_class', 'entity_id'], 'required'],
            [['text'], 'string'],
            [['entity_class'], 'string', 'max' => 256],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'comment_id' => 'Comment ID',
            'active' => 'Active',
            'deleted' => 'Deleted',
            'created_by_id' => 'Created By ID',
            'text' => 'Text',
            'entity_class' => 'Entity Class',
            'entity_id' => 'Entity ID',
            'parent_comment_id' => 'Parent Comment ID',
        ];
    }

    /**
     * @inheritdoc
     * @return CommentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CommentQuery(get_called_class());
    }
}
