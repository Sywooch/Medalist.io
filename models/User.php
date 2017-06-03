<?php

namespace app\models;

class User extends \yii\base\Object implements \yii\web\IdentityInterface
{
    public $id;
    public $username;
    public $password;
    public $authKey;
    public $accessToken;

    private static $users = [
        '100' => [
            'id' => '100',
            'username' => 'admin',
            'password' => 'admin',
            'authKey' => 'test100key',
            'accessToken' => '100-token',
        ],
        '101' => [
            'id' => '101',
            'username' => 'demo',
            'password' => 'demo',
            'authKey' => 'test101key',
            'accessToken' => '101-token',
        ],
    ];


    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        foreach (self::$users as $user) {
            if (strcasecmp($user['username'], $username) === 0) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }



    public function getInterests(){
        return $this->hasMany( Interest::className(), ['interest_id' => 'interest_id'] )->viaTable('user2interest', ['id' => 'user_id']);
    }    


    public static function findUsers($string){

		$query1 = (new \yii\db\Query())
		    ->select("user_id")
		    ->from('profile')
		    ->where('LOWER(full_name) like LOWER("%'.$string.'%")')
		    ->limit(10);

		$query2 = (new \yii\db\Query())
		    ->select('user_id')
		    ->from('user2interest')
		    ->limit(10);
		$query2->innerJoin('interest', 'interest.interest_id = user2interest.interest_id')
				->where('LOWER(name) like LOWER("%'.$string.'%")');

		$query1->union($query2);


        $rows = $query1->all();
        $user_ids =[];
        foreach ($rows as $row ) {
          
            $user_ids[] = $row['user_id'];
        }
 

        return User::find()->where(['id' => $user_ids])->all();

    }    

}
