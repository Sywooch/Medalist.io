<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "category".
 *
 * @property integer $category_id
 * @property integer $parent_category_id
 * @property string $name
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_category_id'], 'integer'],
            [['name'], 'required'],
            [['name'], 'string', 'max' => 512],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'category_id' => 'Category ID',
            'parent_category_id' => 'Parent Category ID',
            'name' => 'Name',
        ];
    }

    /**
     * @inheritdoc
     * @return CategoryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CategoryQuery(get_called_class());
    }




    public function getInterests(){
        return $this->hasMany( Interest::className(), ['interest_id' => 'interest_id'] )->viaTable('category2interest', ['category_id' => 'category_id']);
    }


    //Получает категорию по переданным ID интересов

    public static function getByInterestIDs( $interestIDs ){
        if( !empty($interestIDs ) ){

            //Quering all
     

            $query = new \Yii\db\Query;
            $query->select('*')
                    ->from('category2interest')
                    ->andWhere(['interest_id' => $interestIDs]);
                
            $command = $query->createCommand();
            $rows = $command->queryAll();   


            //Setting matrix of category weights
            $categoryMatrix = array();
            foreach ($rows as $row) {
                if( empty($categoryMatrix[ $row['category_id'] ] ) ) {
                    $categoryMatrix[ $row['category_id'] ] = 0;
                }

                $categoryMatrix[ $row['category_id'] ] += (float)$row['weight'];

            }

            //Sorting category 
            arsort ($categoryMatrix );
            reset ($categoryMatrix);
            $category_id = key( $categoryMatrix );

            return $category_id;



        }else{
            return false;
        }
    }


    //Получает категорию по переданным ID тегов

    public static function getByTagIDs( $tagIDs ){
        $tags = Tag::find()->where(['tag_id' => $tagIDs ])->all();

        $interestIDs = array();
        foreach ($tags as $tag) {
            $interests = $tag->getInterests();

            foreach( $interests as $interest ){
                $interestIDs[] = $interest->interest_id;
            }
        }

        return self::getByInterestIDs( $interestIDs );
    }
}
