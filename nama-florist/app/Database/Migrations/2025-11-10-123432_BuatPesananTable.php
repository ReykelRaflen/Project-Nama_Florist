<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class BuatPesananTabel extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_penyewa' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'tanggal_pesan' => ['type' => 'DATE'],
            'tanggal_sewa' => ['type' => 'DATE'],
            'total_harga' => ['type' => 'DECIMAL', 'constraint' => '10,2'],
            'teks_pesan' => ['type' => 'TEXT', 'null' => true],
            'status' => ['type' => 'ENUM', 'constraint' => ['menunggu', 'dikonfirmasi', 'dalam_penyewaan', 'selesai', 'dibatalkan'], 'default' => 'menunggu'],
            'dibuat_pada' => ['type' => 'TIMESTAMP', 'null' => true],
            'diupdate_pada' => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_penyewa', 'pengguna', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('pesanan');
    }

    public function down()
    {
        $this->forge->dropTable('pesanan');
    }
}