<?php
namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
    protected $table      = 'admins';
    protected $primaryKey = 'id';
    protected $allowedFields = ['email', 'password_hash', 'role'];
    protected $useTimestamps = true;

    public function findByEmail(string $email)
    {
        return $this->where('email', $email)->first();
    }
}
