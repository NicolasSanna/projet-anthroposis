<?php

namespace App\Model;

use App\Framework\AbstractModel;

class UserModel extends AbstractModel
{
    private const ROLE_AUTHOR_STRING = "['ROLE_AUTHOR']";
    private const ROLE_ADMINISTRATOR_STRING = "['ROLE_ADMINISTRATOR']";
    private const ROLE_NEW_USER_STRING = "['ROLE_NEW_USER']";

    private const ROLE_AUTHOR_ID = 2;
    private const ROLE_ADMINISTRATOR_ID = 1;
    private const ROLE_NEW_USER_ID = 3;
  
    public function __construct()
    {
        parent::__construct();
    }

    public function insert(string $firstname, string $lastname, string $pseudo, string $email, string $password): mixed
    {
        $sql = 'CALL SP_UserInsert(:firstname, :lastname, :pseudo, :email, :password, :newUserRoleString, :newUserRoleId)';

        $result = $this->database->getOneResult($sql, [
            'firstname' => $firstname,
            'lastname' => $lastname,
            'pseudo' => $pseudo,
            'email' => $email,
            'password' => $password,
            'newUserRoleString' => self::ROLE_NEW_USER_STRING,
            'newUserRoleId' => self::ROLE_NEW_USER_ID
        ]);

        return $result;
    }

    public function getOneByEmail (string $email): mixed
    {
        $sql = 'CALL SP_UserSelect(:email)';

        $result = $this->database->getOneResult($sql, [
            'email' => $email
        ]);

        return $result;
    }

    public function checkCredentials(string $email, string $password): mixed
    {
        $user = $this->getOneByEmail($email);

        if(!$user)
        {
            return false;
        }

        if(!password_verify($password, $user->password))
        {
            return false;
        }

        return $user;
    }
}