<?php
namespace PresenceEngine\Models;

use PresenceEngine\Core\Model;

class User extends Model
{
    protected string $table = 'users';

    public function findByUsername(string $username): ?array
    {
        return $this->fetch(
            "SELECT * FROM users WHERE username = ? AND is_active = 1",
            [$username]
        );
    }

    public function findById(int $id): ?array
    {
        return $this->fetch("SELECT * FROM users WHERE id = ?", [$id]);
    }

    public function all(): array
    {
        return $this->fetchAll(
            "SELECT id, username, email, section, role, is_active, created_at 
             FROM users ORDER BY created_at DESC"
        );
    }

    public function create(array $data): int
    {
        return $this->insert(
            "INSERT INTO users (username, email, password_hash, section, role) 
             VALUES (?, ?, ?, ?, ?)",
            [
                $data['username'],
                $data['email'],
                password_hash($data['password'], PASSWORD_DEFAULT),
                $data['section'] ?? null,
                $data['role'] ?? 'user',
            ]
        );
    }

    public function toggleActive(int $id): void
    {
        $this->query(
            "UPDATE users SET is_active = NOT is_active WHERE id = ?",
            [$id]
        );
    }

    public function usernameExists(string $username): bool
    {
        return (int) $this->query(
            "SELECT COUNT(*) FROM users WHERE username = ?",
            [$username]
        )->fetchColumn() > 0;
    }

    public function emailExists(string $email): bool
    {
        return (int) $this->query(
            "SELECT COUNT(*) FROM users WHERE email = ?",
            [$email]
        )->fetchColumn() > 0;
    }

    public function count(): int
    {
        return (int) $this->query("SELECT COUNT(*) FROM users")->fetchColumn();
    }

    public function countByRole(string $role): int
    {
        return (int) $this->query(
            "SELECT COUNT(*) FROM users WHERE role = ?",
            [$role]
        )->fetchColumn();
    }
}