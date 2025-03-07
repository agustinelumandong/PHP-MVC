<?php

namespace App\Models;

use Core\Model;

class User extends Model {
    protected static string $table = 'users';

    public static function findByEmail(string $email): ?self {
        $db = static::getDB();
        $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $result = $stmt->fetch();
        return $result ? new static($result) : null;
    }

    public function setPassword(string $password): void {
        $this->attributes['password'] = password_hash($password, PASSWORD_DEFAULT);
    }

    public function verifyPassword(string $password): bool {
        return password_verify($password, $this->attributes['password']);
    }

    public static function create(array $data): ?self {
        $user = new static();
        $user->attributes = [
            'name' => $data['name'],
            'email' => $data['email'],
            'created_at' => date('Y-m-d H:i:s')
        ];
        $user->setPassword($data['password']);

        return $user->save() ? $user : null;
    }

    public function update(array $data): bool {
        if (isset($data['password'])) {
            $this->setPassword($data['password']);
            unset($data['password']);
        }
        
        $this->attributes = array_merge($this->attributes, $data);
        $this->attributes['updated_at'] = date('Y-m-d H:i:s');
        
        return $this->save();
    }
}