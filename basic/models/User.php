<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;


/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $fio
 * @property string $username
 * @property string $email
 * @property string $phone
 * @property string $password
 * @property int $role
 *
 * @property Request[] $requests
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{

    public $password2;
    public $check;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fio', 'username', 'email', 'phone', 'password','password2','check'], 'required'],
            [['role'], 'integer'],
            [['email'], 'email'],
            ['username', 'unique'],
            [['password2'], 'compare','compareAttribute'=> 'password'],
            [['check'], 'compare','compareValue'=> 1, 'message'=>'Обязательно'],
            [['password'], 'string', 'min'=> 6],
            ['fio', 'match', 'pattern'=> '/^[А-яЁe -]*$/u', 'message'=> 'Только кирилица'],
            ['username', 'match', 'pattern'=> '/^[A-z]\w*$/i', 'message'=> 'Только латиница'],
            [['fio', 'username', 'phone'], 'string', 'max' => 30],
            [['email'], 'string', 'max' => 50],
            [['password'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fio' => 'Фио',
            'username' => 'Имя пользователя',
            'email' => 'Email',
            'phone' => 'Номер телефона',
            'password' => 'Пароль',
            'password2' => 'Подтверждение пароля',
            'check' => 'Согласие на обработку данных',
        ];
    }

    /**
     * Gets query for [[Requests]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRequests()
    {
        return $this->hasMany(Request::class, ['id_user' => 'id']);
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Finds an identity by the given token.
     *
     * @param string $token the token to be looked for
     * @return IdentityInterface|null the identity object that matches the given token.
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    /**
     * @return int|string current user ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string|null current user auth key
     */
    public function getAuthKey()
    {
        return null;
    }

    /**
     * @param string $authKey
     * @return bool|null if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
        return false;
    }

    public static function findByUsername($username)
    {
        
        return User::findOne(['username' => $username]);;
    }


    public function validatePassword($password)
    {
        return $this->password === md5($password);
    }

    public function beforeSave($insert)
    {
       $this->password = md5($this->password);
        return parent::beforeSave($insert);
    }

    public function isAdmin()
    {
        return $this-> role == 1;
    }

}
