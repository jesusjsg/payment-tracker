<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use PDO;
use PDOException;

// implements RoleInterface

class Role extends Model
{
    public function __construct(
        public array $permissions = [], 
    ) {}

    public function getRolePermissions(int $role_id): Role
    {
        try {
            $role = new Role();
            $query = $this->prepare(
                'SELECT p.permission_name 
                FROM role_permissions AS rp
                INNER JOIN permissions AS p
                ON rp.permission_id = p.permission_id
                WHERE rp.role_id = :role_id'
            );

            $query->execute([
                ':role_id' => $role_id,
            ]);

            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                $role->permissions[$row['permission_name']] = true;
            }
            return $role;

        } catch (PDOException $error) {
            error_log('Role -> getRolePermissions -> Error to get the role permissions: ' . $error);
            return false;
        }

    }

    private function exists(string $role_name): bool
    {
        try {
            $query = $this->prepare('SELECT COUNT(role_id) AS role_count, role_id FROM roles WHERE role_name = :role_name');
            $query->execute([
                ':role_name' => $role_name,
            ]);

            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                if ($row['role_count'] > 0) {
                    return true;
                }
            }
            return false;

        } catch (PDOException $error) {
            error_log('Role -> exists -> Error to check if the role exists: ' . $error);
            return false;
        }
    }

    public function saveRole(): bool
    {
        
    }
}