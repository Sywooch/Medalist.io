<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tag".
 *
 * @property integer $tag_id
 * @property string $name
 * @property string $locale
 * @property integer $canonical_tag_id
 * @property integer $active
 */
class Tag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['canonical_tag_id', 'active'], 'integer'],
            [['name'], 'string', 'max' => 512],
            [['locale'], 'string', 'max' => 10],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tag_id' => 'Tag ID',
            'name' => 'Name',
            'locale' => 'Locale',
            'canonical_tag_id' => 'Canonical Tag ID',
            'active' => 'Active',
        ];
    }

    /**
     * @inheritdoc
     * @return TagQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TagQuery(get_called_class());
    }

    protected static  function mb_ucwords($string) {
        return mb_convert_case($string, MB_CASE_TITLE, "UTF-8");
    } 
    protected static function prepareTagStr( $s ){
        $s = self::mb_ucwords($s);
        return preg_replace("#\s#", "", $s);
    }

    public static function attachTagsToObject( $obj, $tagsArray ){
        $tagsArray = array_unique($tagsArray);


        $classname = get_class( $obj );
        $classname = explode("\\",$classname);
        $classname = $classname[count($classname) - 1];
        $idVarName = strtolower($classname."_id");
        $id = $obj->{$idVarName};



        foreach ($tagsArray as $text) {

            if( empty($text) ) { continue; }

            $text = self::prepareTagStr($text);
            if( !$tag = self::findTagByText( $text ) ){
                $tag = new Tag;
                $tag->name=$text;
                $tag->save();
                
                //Adding interests to tags 
                if( !Yii::$app->user->isGuest ){
                    $tag->addUserInterests( Yii::$app->user->identity->id );
                }

            }

            $user_id = (!Yii::$app->user->isGuest)?Yii::$app->user->identity->id:null;
            Yii::$app->db->createCommand("INSERT INTO tag2entity (tag_id, entity_id, entity_class, user_id) VALUES (
                ".$tag->tag_id.",
                ".$id.",
                '".$classname."',
                ".$user_id."
                )")->execute();




        }
    }




    /**
    * TODO
    */

    public function addUserInterests( $user_id ){
        //Find user interests and add them to Tag
    }

    public static function findTagByText($text){
        return self::find()->where("name = '".$text."'")->one();
    }
}
