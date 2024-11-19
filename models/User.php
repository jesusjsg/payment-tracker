<?php

namespace App\Models;

use App\Core\CRUDInterface;
use App\Core\Model;
use PDO;
use PDOException;

class User extends Model implements CRUDInterface
{
    public function __construct( // properties promotion
        private int $id = 0,
        private string $username = '',
        private string $firstName = '',
        private string $lastName = '',
        private string $password = '',
        private string $email = '',
        private string $photo = '',
        private string $createdAt = '',
        private string $updatedAt = '',
    ) {  
        parent::__construct();
    }

    public function save(): bool
    {
        try {
            $query = $this->prepare('INSERT INTO users (username, password, first_name, last_name, email, photo) VALUES (:username, :first_name, :last_name, :password,  :email, :photo)');
            $query->execute([
                ':username'    => $this->username,
                ':password'    => $this->password,
                ':first_name'  => $this->firstName,
                ':last_name'   => $this->lastName,
                ':email'       => $this->email,
                ':photo'       => $this->photo,
            ]);
            return true;

        } catch (PDOException $error) {
            print_r('Error to save in user model: ' . $error);
            return false;
        }
    }

    public function all(): array
    {
        $data = [];
        try {
            $query = $this->query('SELECT * FROM users');

            while ($pointer = $query->fetch(PDO::FETCH_ASSOC)) {
                $item = new User();
                $item->setId($pointer['id']);
                $item->setUsername($pointer['username']);
                $item->setFirstName($pointer['first_name']);
                $item->setLastName($pointer['last_name']);
                $item->setEmail($pointer['email']);
                $item->setCreatedAt($pointer['createdAt']);
                $item->setUpdateAt($pointer['updatedAt']);
                array_push($data, $item);
            }
            return $data;

        } catch (PDOException $error) {
            print_r('Error to show all users: ' . $error);
        }
    }

    public function one(int $id): User
    {
        try {
            $query = $this->prepare('SELECT * FROM users WHERE id = :id');
            $query->execute([
                ':id' => $id,
            ]);
            $userData = $query->fetch(PDO::FETCH_ASSOC);
            if ($userData) {
                $user = new User();
                $user->setId($userData['id']);
                $user->setUsername($userData['username']);
                $user->setFirstName($userData['first_name']);
                $user->setLastName($userData['last_name']);
                $user->setLastName($userData['email']);
                $user->setPhoto($userData['photo']);
                return $user;
            }

        } catch (PDOException $error) {
            print_r('Error to get the user id: ' . $error);
            return false;
        }
    }

    public function delete(int $id): bool
    {
        try {
            $query = $this->prepare('DELETE FROM users WHERE id = :id');
            $query->execute([
                ':id' => $id,
            ]);
            return true;

        } catch (PDOException $error) {
            print_r('Error to delete the user: ' . $error);
            return false;
        }
    }

    public function update(int $id): bool
    {
        try {
            $query = $this->prepare('UPDATE users SET username = :username, password = :password, first_name = :first_name, last_name = :last_name, email = :email, photo = :photo WHERE id = :id');
            $query->execute([
                ':id'           => $this->id,
                ':username'     => $this->username,
                ':password'     => $this->password,
                ':first_name'   => $this->firstName,
                ':last_name'    => $this->lastName,
                ':email'        => $this->email,
                ':photo'        => $this->photo,
            ]);
            return true;

        } catch (PDOException $error) {
            print_r('Error to update the user: ' . $error);
            return false;
        }
    }

    public function exists(string $username)
    {
        try {
            $query = $this->prepare('SELECT username FROM users WHERE username = :username');
            $query->execute([
                ':username' => $username,
            ]);
            
            if ($query->rowCount() > 0) {
                return true;
            } else {
                return false;
            }

        } catch (PDOException $error) {
            print_r('Error to validate username: ' . $error);
            return false;
        }
    }

    public function comparePass(string $password, int $userId) {
        try {
            $user = $this->one($userId);
            return password_verify($password, $user->getPassword());
            
        } catch (PDOException $error) {
            print_r('Error while compare the passwords: ' . $error);
            return false;
        }
    }


    //implementation of setters
    public function setId(int $id)                      {$this->id = $id;}
    public function setUsername(string $username)       {$this->username = $username;}
    public function setFirstName(string $firstName)     {$this->firstName = $firstName;}
    public function setLastName(string $lastName)       {$this->lastName = $lastName;}
    public function setPassword(string $password)       {$this->password = $this->getHashedPass($password);}
    public function setEmail(string $email)             {$this->email = $email;}
    public function setPhoto(string $photo)             {$this->photo = $photo;}
    public function setCreatedAt(string $createdAt)     {$this->createdAt = $createdAt;}
    public function setUpdateAt(string $updatedAt)      {$this->updatedAt = $updatedAt;}

    //Implementation of getters
    public function getId()                             {return $this->id;}
    public function getUsername()                       {return $this->username;}
    public function getFirstName()                      {return $this->firstName;}
    public function getLastName()                       {return $this->lastName;}
    public function getPassword()                       {return $this->password;}
    public function getEmail()                          {return $this->email;}
    public function getPhoto()                          {return $this->photo;}
    private function getHashedPass(string $password)    {return password_hash($password, PASSWORD_BCRYPT, ['cost' => 10]);}
    public function getCreatedAt()                      {return $this->createdAt;}
    public function getUpdatedAt()                      {return $this->updatedAt;}
}