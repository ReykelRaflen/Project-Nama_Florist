<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class BuatDetailPesananTabel extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_pesanan' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'id_papan_bunga' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'jumlah' => ['type' => 'INT', 'constraint' => 11],
            'harga' => ['type' => 'DECIMAL', 'constraint' => '10,2'],
            'subtotal' => ['type' => 'DECIMAL', 'constraint' => '10,2'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_pesanan', 'pesanan', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_papan_bunga', 'papan_bunga', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('detail_pesanan');
    }

    public function down()
    {
        $this->forge->dropTable('detail_pesanan');
    }
}