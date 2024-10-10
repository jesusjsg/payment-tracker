<?php

namespace App\Models;

use App\Models\User;
use App\Models\Role;
use PDOException;
use PDO;

class PrivilegedUser extends User
{
    private $roles;

    public function __construct()
    {
        parent::__construct();
    }

    public function getByUsername($username)
    {
        try {
            $query = $this->prepare('select user_id, username, name, created_at from users where username = :username');
            $query->execute([
                ':username' => $username,
            ]);
            $result = $query->fetchAll();

            if(!empty($result)) {
                $privilegedUser = new PrivilegedUser();
                $privilegedUser->id = $result[0]['user_id'];
                $privilegedUser->username = $username;
                $privilegedUser->name = $result[0]['name'];
                $privilegedUser->budget = $result[0]['budget'];
                $privilegedUser->photo = $result[0]['photo'];
                $privilegedUser->createdAt = $result[0]['created_at'];
                $privilegedUser->updatedAt = $result[0]['modified_at'];
            }

        } catch (PDOException $error) {
            print_r('Error to get the username: ' . $error);
            return false;
        }
    }

    protected function initRoles()
    {
        $this->roles = [];
        $role = new Role();
        
        try {
            $query = $this->prepare('
                select user_r.role_id, 
                role.role_name
                from user_role as user_r
                join roles as role on user_r.role_id = role.role_id
                where user_r.user_id = :user_id
            ');
            $query->execute([
                ':user_id' => $this->id,
            ]);

            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                $this->roles[$row['role_name']] = $role->getRolePermissions($row['role_id']);
            }

        } catch (PDOException $error) {
            print_r('Error to set the user roles: ' . $error);
            return false;
        }
    }

    public function hasPrivilege($permission)
    {
        foreach ($this->roles as $role) {
            foreach ($role as $key => $value) {
                if (isset($value[$permission])) {
                    return true;
                }
            }
        }
        return false;
    }

    public function hasRole($roleName)
    {
        return isset($this->roles[$roleName]);
    }

    public function savePermission($roleId, $permissionId)
    {
        try {
            $query = $this->prepare('insert into role_permissions (role_id, permission_id) values (:role_id, :permission_id)');
            $query->execute([
                ':role_id' => $roleId,
                ':permission_id' => $permissionId,
            ]);

        } catch (PDOException $error) {
            print_r('Error to save role permission: ' . $error);
            return false;
        }
    }

    public function deleteAllPermissions()
    {
        try {
            $query = $this->prepare('truncate role_permissions');
            $query->execute();

        } catch (PDOException $error) {
            print_r('Error to delete all role permissions: ' . $error);
            return false;
        }
    }
}
