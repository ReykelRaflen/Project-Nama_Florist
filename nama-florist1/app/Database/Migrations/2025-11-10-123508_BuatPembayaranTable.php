<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class BuatPembayaranTabel extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'id_pesanan' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'jumlah' => ['type' => 'DECIMAL', 'constraint' => '10,2'],
            'metode' => ['type' => 'ENUM', 'constraint' => ['transfer_bank', 'tunai']],
            'status' => ['type' => 'ENUM', 'constraint' => ['menunggu', 'lunas', 'gagal', 'dikembalikan'], 'default' => 'menunggu'],
            'tanggal_pembayaran' => ['type' => 'TIMESTAMP', 'null' => true],
            'id_transaksi' => ['type' => 'VARCHAR', 'constraint' => '50', 'null' => true],
            'dibuat_pada' => ['type' => 'TIMESTAMP', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_pesanan', 'pesanan', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('pembayaran');
    }

    public function down()
    {
        $this->forge->dropTable('pembayaran');
    }
}