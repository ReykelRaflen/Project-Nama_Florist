<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class BuatPenggunaTabel extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'unique'     => true,
            ],
            'kata_sandi' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'telepon' => [
                'type'       => 'VARCHAR',
                'constraint' => '18',
                'null'       => true,
            ],
            'alamat' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'peran' => [
                'type'       => 'ENUM',
                'constraint' => ['penyewa', 'admin'],
                'default'    => 'penyewa',
            ],
            'dibuat_pada' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'diupdate_pada' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('pengguna');
    }

    public function down()
    {
        $this->forge->dropTable('pengguna');
    }
}