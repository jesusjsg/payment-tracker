<?php

namespace App\Models;

use App\Core\Model;
use PDO;
use PDOException;

class Permission extends Model
{
    private $name;

    public function savePermission($permissionName)
    {
        if ($this->hasPermission($this->name)) {
            print_r('Error the permission already exist');
            return false;
        }

        try {
            $query = $this->prepare('inser into permissions (permission_name) values (:permission_name)');
            $query->execute([
                ':permission_name' => $permissionName,
            ]);
            return true;

        } catch (PDOException $error) {
            print_r('Error to save the permission: ' . $error);
            return false;
        }
    }

    private function hasPermission($permissionName)
    {
        try {
            $query = $this->prepare('
                select count(permission_id) as permission_count, permission_id from permissions where permission_name = :permission_name
            ');
            $query->execute([
                ':permission_name' => $permissionName,
            ]);

            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                if ($row['permission_count'] > 0) {
                    return true;
                } 
            }
            return false;

        } catch (PDOException $error) {
            print_r('Error to validate if the permission exist: ' . $error);
            return false;
        }
    }

    public function deletePermissions($permissions)
    {
        try {
            $query = $this->prepare('delete permission from permissions as permission where permission.permission_id = :permission_id');
            $query->bindParam(':permission_id', $permId, PDO::PARAM_INT);

            foreach ($permissions as $permId) {
                $query->execute();
            }
            return true;

        } catch (PDOException $error) {
            print_r('Error to delete the permission: ' . $error);
            return false;
        }
    }
}