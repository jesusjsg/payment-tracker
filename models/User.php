<?php

namespace App\Models;

use App\Core\CRUDInterface;
use App\Core\Model;
use PDO;
use PDOException;

class User extends Model implements CRUDInterface
{
    private $id;
    private $username;
    private $name;
    private $role;
    private $password;
    private $budget;
    private $photo;
    private $createdAt;
    private $updatedAt;

    public function __construct()
    {
        parent::__construct();

        $this->username = '';
        $this->password = '';
        $this->role = '';
        $this->budget = 0.0;
        $this->name = '';
        $this->photo = '';
        $this->createdAt = null;
        $this->updatedAt = null;
    }

    public function save()
    {
        try {
            $query = $this->prepare('insert into users(username, password, role, budget, photo, name) values(:username, :password, :role, :budget, :photo, :name)');
            $query->execute([
                'username'  =>  $this->username,
                'password'  =>  $this->password,
                'role'      =>  $this->role,
                'budget'    =>  $this->budget,
                'photo'     =>  $this->photo,
                'name'      =>  $this->name,
            ]);
            return true;

        } catch (PDOException $error) {
            print_r('Error to save in user model: ' . $error);
            return false;
        }
    }

    public function all()
    {
        $data = [];
        try {
            $query = $this->query('select * from users');

            while ($pointer = $query->fetch(PDO::FETCH_ASSOC)) {
                $item = new User();
                $item->setId($pointer['id']);
                $item->setBudget($pointer['budget']);
                $item->setName($pointer['name']);
                $item->setUsername($pointer['username']);
                $item->setRole($pointer['role']);
                $item->setPhoto($pointer['photo']);
                $item->setPassword($pointer['password']);
                $item->setCreatedAt($pointer['createdAt']);
                $item->setUpdateAt($pointer['updatedAt']);
                array_push($data, $item);
            }
            return $data;

        } catch (PDOException $error) {
            print_r('Error to show all users: ' . $error);
        }
    }

    public function one($id)
    {
        try {
            $query = $this->prepare('select * from users where id = :id');
            $query->execute([
                'id' => $id,
            ]);
            $userData = $query->fetch(PDO::FETCH_ASSOC);
            if ($userData) {
                $user = new User();
                $user->setId($userData['id']);
                $user->setBudget($userData['budget']);
                $user->setName($userData['name']);
                $user->setUsername($userData['username']);
                $user->setRole($userData['role']);
                $user->setPhoto($userData['photo']);
                $user->setPassword($userData['password']);
                $user->setCreatedAt($userData['createdAt']);
                $user->setUpdateAt($userData['updatedAt']);
                return $user;
            }

        } catch (PDOException $error) {
            print_r('Error to get the user id: ' . $error);
        }
    }

    public function delete($id)
    {
        try {
            $query = $this->prepare('delete from users where id = :id');
            $query->execute([
                'id' => $id,
            ]);

            return true;

        } catch (PDOException $error) {
            print_r('Error to delete the user: ' . $error);
            return false;
        }
    }

    public function update()
    {
        try {
            $query = $this->prepare('update users set username = :username, password = :password, photo = :photo, budget = :budget, name = :name, role = :role where id = :id');
            $query->execute([
                'id'       => $this->id,
                'username' => $this->username,
                'password' => $this->password,
                'photo'    => $this->photo,
                'budget'   => $this->budget,
                'name'     => $this->name,
                'role'     => $this->role,
            ]);

            return true;

        } catch (PDOException $error) {
            print_r('Error to update the user: ' . $error);
            return false;
        }
    }

    public function from($array)
    {
        $this->id       = $array['id'];
        $this->username = $array['username'];
        $this->password = $array['password'];
        $this->photo    = $array['photo'];
        $this->role     = $array['role'];
        $this->budget   = $array['budget'];
        $this->name     = $array['name'];
    }

    public function exists($username)
    {
        try {
            $query = $this->prepare('select username from users where username = :username');
            $query->execute([
                'username' => $username,
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

    public function comparePass($password, $userId) {
        try {
            $user = $this->one($userId);
            return password_verify($password, $user->getPassword());
            
        } catch (PDOException $error) {
            print_r('Error while compare the passwords: ' . $error);
            return false;
        }
    }


    //implementation of setters
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setRole($role)
    {
        $this->role = $role;
    }

    public function setBudget($budget)
    {
        $this->budget = $budget;
    }

    public function setPhoto($photo)
    {
        $this->photo = $photo;
    }

    public function setPassword($password)
    {
        $this->password = $this->getHashedPass($password);
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    public function setUpdateAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    //Implementation of getters
    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getPhoto()
    {
        return $this->photo;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function getBudget()
    {
        return $this->budget;
    }

    public function getName()
    {
        return $this->name;
    }

    private function getHashedPass($password)
    {
        return password_hash($password, PASSWORD_BCRYPT, ['cost' => 10]);
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}