<?php

namespace App\Models;

use App\Core\CRUDInterface;
use App\Core\Model;
use PDO;
use PDOException;

class Role extends Model
{
    private $id;
    private $name;
    public $permissions;

    public function __construct()
    {
        parent::__construct();

        $this->name = '';
        $this->permissions = [];
    }

    public function saveRole()
    {
        try {
            if ($this->hasRole($this->name)) {
                print_r('Error the role name already exist');
                return false;
            }
    
            $query = $this->prepare('insert into roles (role_name) values (:role_name)');
            $query->execute([
                ':role_name' => $this->name,
            ]);
            return true;

        } catch (PDOException $error) {
            print_r('Error to save the role: ' . $error);
            return false;
        }
    }

    public function saveRolePermissions($roleId, $permissionIds)
    {
        $items = [];
        foreach ($permissionIds as $permId) {
            $value = "(" . $roleId . "," . $permId . ")";
            array_push($items, $value);
        }
        $itemsImplode = implode(",", $items);

        try {
            $query = $this->prepare('insert into role_permissions (role_id, permission_id) values ' . $itemsImplode);
            $query->execute();
            return $query->rowCount();

        } catch (PDOException $error) {
            print_r('Error to save the role permissions: ' . $error);
            return false;
        }
    }

    public function saveUserRoles($userId, $roles)
    {
        $items = [];
        foreach ($roles as $roleId) {
            $value = "(" . $userId . "," . $roleId . ")";
            array_push($items, $value);
        }
        $itemsImplode = implode(",", $items);

        try {
            $query = $this->prepare('insert into user_role (user_id, role_id) values ' . $itemsImplode);
            $query->execute();
            return $query->rowCount();

        } catch (PDOException $error) {
            print_r('Error to save the user role: ' . $error);
            return false;
        }
    }

    public function deleteRoles($roles)
    {
        try {
            $query = $this->prepare('
                delete role, user_role, role_perm
                from roles as role
                join user_role as user_role on role.role_id = user_role.role_id
                join role_permissions as role_perm on role.role_id = role_perm.role_id
                where role.role_id = :role_id
            ');
            
            foreach ($roles as $roleId) {
                $query->bindParam(':role_id', $roleId, PDO::PARAM_INT);
                $query->execute();
            }
            return true;

        } catch (PDOException $error) {
            print_r('Error to delete the roles: ' . $error);
            return false;
        }
    }

    public function deleteUserRoles($userId)
    {
        try {
            $query = $this->prepare('delete from user_roles where user_id = :user_id');
            $query->execute([
                ':user_id' => $userId,
            ]);

        } catch (PDOException $error) {
            print_r('Errot to delete the user roles: ' . $error);
            return false;
        }
    }

    public function getRolePermissions($roleId)
    {
        try {

            $role = new Role();
            $query = $this->prepare('
                select perm.permission_name
                from role_permissions as role_perm
                join permissions as perm 
                on role_perm.permission_id = perm.perm_id
                where role_perm.role_id = :role_id
            ');
            $query->execute([
                ':role_id' => $roleId,
            ]);

            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                $role->permissions[$row['permission_name']] = true;
            }
            return $role;

        } catch (PDOException $error) {
            print_r('Error to get the permissions role: ' . $error);
            return false;
        }
    }

    public function hasPermission($permission)
    {
        return isset($this->permissions[$permission]);
    }

    public function hasRole($roleName)
    {
        try {
            $query = $this->prepare('select count(role_id) as role_count, role_id from roles where role_name = :role_name');
            $query->execute([
                ':role_name' => $roleName,
            ]);

            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                if ($row['role_count'] > 0) {
                    return true;
                }
            }
            return false;

        } catch (PDOException $error) {
            print_r('Error to validate if the role exist: ' . $error);
            return false;
        }
    }
}