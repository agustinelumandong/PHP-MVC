<?php

namespace Core;

abstract class Model {
    protected static string $table;
    protected array $attributes = [];
    protected static ?\PDO $db = null;

    public function __construct(array $attributes = []) {
        $this->attributes = $attributes;
    }

    public static function getDB(): \PDO {
        if (self::$db === null) {
            $config = require dirname(__DIR__, 2) . '/config/database.php';
            $dsn = "mysql:host={$config['host']};dbname={$config['database']};charset=utf8mb4";
            
            try {
                self::$db = new \PDO($dsn, $config['username'], $config['password'], [
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
                ]);
            } catch (\PDOException $e) {
                throw new \Exception("Connection failed: " . $e->getMessage());
            }
        }
        return self::$db;
    }

    public static function findAll(): array {
        $db = static::getDB();
        $stmt = $db->query("SELECT * FROM " . static::$table);
        return $stmt->fetchAll();
    }

    public static function findById(int $id): ?static {
        $db = static::getDB();
        $stmt = $db->prepare("SELECT * FROM " . static::$table . " WHERE id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch();
        return $result ? new static($result) : null;
    }

    public function save(): bool {
        $db = static::getDB();
        
        if (isset($this->attributes['id'])) {
            // Update
            $fields = [];
            $values = [];
            foreach ($this->attributes as $key => $value) {
                if ($key !== 'id') {
                    $fields[] = "{$key} = ?";
                    $values[] = $value;
                }
            }
            $values[] = $this->attributes['id'];
            
            $sql = "UPDATE " . static::$table . " SET " . implode(', ', $fields) . " WHERE id = ?";
            $stmt = $db->prepare($sql);
            return $stmt->execute($values);
        } else {
            // Insert
            $fields = implode(', ', array_keys($this->attributes));
            $values = array_values($this->attributes);
            $placeholders = implode(', ', array_fill(0, count($values), '?'));
            
            $sql = "INSERT INTO " . static::$table . " ({$fields}) VALUES ({$placeholders})";
            $stmt = $db->prepare($sql);
            return $stmt->execute($values);
        }
    }

    public function delete(): bool {
        if (!isset($this->attributes['id'])) {
            return false;
        }

        $db = static::getDB();
        $stmt = $db->prepare("DELETE FROM " . static::$table . " WHERE id = ?");
        return $stmt->execute([$this->attributes['id']]);
    }

    public function __get(string $name) {
        return $this->attributes[$name] ?? null;
    }

    public function __set(string $name, $value): void {
        $this->attributes[$name] = $value;
    }
}