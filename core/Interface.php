<?php

namespace App\Core;

interface CRUDInterface {
    public function save();
    public function all();
    public function one(int $id): Object;
    public function delete(int $id): bool;
    public function update();
    public function from(array $array): void;
}