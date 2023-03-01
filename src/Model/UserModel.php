<?php

namespace App\Model;

use App\Framework\AbstractModel;

class UserModel extends AbstractModel
{
    private const ROLE_ADMINISTRATOR_STRING = "['ROLE_ADMINISTRATOR']";
    private const ROLE_AUTHOR_STRING = "['ROLE_AUTHOR']";
    private const ROLE_NEW_USER_STRING = "['ROLE_NEW_USER']";

    private const ROLE_ADMINISTRATOR_ID = 1;
    private const ROLE_AUTHOR_ID = 2;
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

    public function findOneByEmail (string $email): mixed
    {
        $sql = 'CALL SP_UserByEmailSelect(:email)';

        $result = $this->database->getOneResult($sql, [
            'email' => $email
        ]);

        return $result;
    }

    public function checkCredentials(string $email, string $password): mixed
    {
        $user = $this->findOneByEmail($email);

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

    public function findAll(): array
    {
        $sql = 'CALL SP_UserManageSelect()';

        $results = $this->database->getAllResults($sql);

        return $results;
    }

    public function manageToAuthor(int $userId): void
    {
        $sql = 'CALL SP_UserManageUpdate(:userId, :roleId, :roleLabel)';

        $this->database->executeQuery($sql, [
            'userId' => $userId,
            'roleId' => self::ROLE_AUTHOR_ID,
            'roleLabel' => self::ROLE_AUTHOR_STRING
        ]);
    }

    public function manageToNewUser(int $userId): void
    {
        $sql = 'CALL SP_UserManageUpdate(:userId, :roleId, :roleLabel)';

        $this->database->executeQuery($sql, [
            'userId' => $userId,
            'roleId' => self::ROLE_NEW_USER_ID,
            'roleLabel' => self::ROLE_NEW_USER_STRING
        ]);
    }

    public function getOneById(int $userId)
    {
        $sql = 'CALL SP_UserByIdSelect(:userId)';

        $result = $this->database->getOneResult($sql, [
            'userId' => $userId
        ]);

        return $result;
    }

    public function updatePersonalInfos(int $userId, string $lastname, string $firstname, string $pseudo, string $email): mixed
    {
        $sql = 'CALL SP_UserUpdate(:userId, :lastname, :firstname, :pseudo, :email)';

        $result = $this->database->getOneResult($sql, [
            'userId' => $userId,
            'lastname' => $lastname,
            'firstname' => $firstname,
            'pseudo' => $pseudo,
            'email' => $email
        ]);

        return $result;
    }
}