<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class BuatPapanBungaTabel extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nama' => ['type' => 'VARCHAR', 'constraint' => '100'],
            'ukuran' => ['type' => 'VARCHAR', 'constraint' => '100', 'null' => true],
            'bahan' => ['type' => 'VARCHAR', 'constraint' => '100', 'null' => true],
            'harga' => ['type' => 'DECIMAL', 'constraint' => '10,2'],
            'stok' => ['type' => 'INT', 'constraint' => 11],
            'gambar' => ['type' => 'VARCHAR', 'constraint' => '255', 'null' => true],
            'status' => ['type' => 'ENUM', 'constraint' => ['tersedia', 'tidak_tersedia'], 'default' => 'tersedia'],
            'dibuat_pada' => ['type' => 'TIMESTAMP', 'null' => true],
            'diupdate_pada' => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('papan_bunga');
    }

    public function down()
    {
        $this->forge->dropTable('papan_bunga');
    }
}