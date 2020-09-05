<?php

class StatusRepository extends DBRepository
{
    public function insert(int $userId, string $body)
    {
        $now = new DateTime();

        $sql = "
            INSERT INTO status(user_id, body, created_at)
            VALUE(:user_id, :body, :created_at)
        ";

        $stmt = $this->execute($sql, [
            ':user_id'    => $userId,
            ':body'       => $body,
            ':created_at' => $now->format('Y-m-d H:i:s'),
        ]);
    }

    public function fetchAllPersonalArchivesByUserId(?int $userId)
    {
        $sql = "
            SELECT a.*, u.user_name
                FROM status a
                    LEFT JOIN user u ON a.user_id = u.id
                WHERE u.id = :user_id
                ORDER BY a.created_at DESC 
        ";

        return $this->fetchAll($sql, [':user_id' => $userId]);
    }

    public function fetchAllByUserId(int $userId)
    {
        $sql = "
            SELECT * a.*, u.user_name
                FROM status a
                    LEFT JOIN user u ON a.user_id = u.id
                WHERE u.id = :user_id
                ORDER BY a.created_at DESC
        ";

        return $this->fetchAll($sql, [':user_id' => $userId]);
    }

    public function fetchByIdAndUserName(int $id, string $userName)
    {
        $sql = "
            SELECT a.*, u.user_name
            FROM status a
                LEFT JOIN user u ON u.id = a.user_id
            WHERE a.id = :id
                AND u.user_name = :user_name 
        ";

        return $this->fetch($sql, [
            ':id'        => $id,
            ':user_name' => $userName
        ]);
    }
}