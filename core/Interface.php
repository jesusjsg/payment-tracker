<?php

namespace App\Core;

interface CRUDInterface {
    public function save(): bool;
    public function all(): array;
    public function one(int $id): Object;
    public function delete(int $id): bool;
    public function update(int $id): bool;
    //public function from(array $array): void;
}