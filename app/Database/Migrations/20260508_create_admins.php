<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAdmins extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'password_hash' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'role' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'default' => 'user',
            ],
            'created_at' => [ 'type' => 'DATETIME', 'null' => true ],
            'updated_at' => [ 'type' => 'DATETIME', 'null' => true ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('email');
        $this->forge->createTable('admins', true);

        // Insert default admin if table empty
        $db = \\Config\\Database::connect();
        $builder = $db->table('admins');
        $count = $builder->countAllResults(false);
        if ($count === 0) {
            $hash = password_hash('admin', PASSWORD_DEFAULT);
            $builder->insert([
                'email' => 'admin@example.com',
                'password_hash' => $hash,
                'role' => 'admin',
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }

    public function down()
    {
        $this->forge->dropTable('admins', true);
    }
}
