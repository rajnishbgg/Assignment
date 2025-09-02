<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTeachers extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'user_id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
                'unique' => true
            ],
            'university_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'gender' => [
                'type' => "ENUM('male','female','other')",
                'default' => 'other',
            ],
            'year_joined' => [
                'type' => 'INT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'default' => 'CURRENT_TIMESTAMP'
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id','auth_user','id','CASCADE','CASCADE');
        $this->forge->createTable('teachers');
    }

    public function down()
    {
        $this->forge->dropTable('teachers');
    }
}
