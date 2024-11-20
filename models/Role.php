<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\CRUDInterface;
use App\Core\Model;
use PDO;
use PDOException;

// implements RoleInterface

class Role extends Model implements CRUDInterface
{
    public function __construct(
        public int $role_id = 0,
        public int $user_id = 0,
        public string $role_name = '',
        public array $permissions = [],
    ) {}

    public function save(): bool
    {
        try {
            $query = $this->prepare('INSERT INTO roles (role_name) VALUES (:role_name)');
            $query->execute([
                ':role_name' => $this->role_name,
            ]);
            return true;

        } catch (PDOException $error) {
            error_log('Role -> save -> The role could not be saved: ' . $error->getMessage());
            return false;
        }
    }

    public function update(int $id): bool
    {
        return true;
    }

    public function one(int $id): object
    {
        try {
            $role = new Role();
            $query = $this->prepare(
                'SELECT p.permission_name
                FROM role_permissions AS rp
                JOIN permissions AS p ON rp.permission_id = p.permission_id
                WHERE rp.role_id = :role_id'
            );
            $query->execute([
                ':role_id' => $id,
            ]);

            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                $role->permissions[$row['permission_name']] = true;
            }
            return $role;


        } catch (PDOException $error) {
            error_log('Role -> one -> The role could not be found: ' . $error->getMessage());
            return false;
        }
    }
    
    public function delete(int $id): bool
    {
        return true;
    }

    public function all(): array
    {
        return [];
    }
    

}