<?php

namespace App\Core;

interface CRUDInterface {
    public function save();
    public function all();
    public function one($id);
    public function delete($id);
    public function update($id);
    public function from($array);
}