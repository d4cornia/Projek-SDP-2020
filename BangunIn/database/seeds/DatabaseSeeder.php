<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('kontraktors')->insert([
            [
                'kode_kontraktor' => '100001', 'nama_kontraktor' => 'David',
                'no_hp_kontraktor' => '086754733120', 'username_kontraktor' => 'david',
                'email_kontraktor' => 'david@gmail.com', 'password_kontraktor' => 'david',
                'nama_perusahaan' => 'PT. Kecap Manis',
                'logo_perusahaan' => 'abc.jpg',
                'nomer_perusahaan' => '0818116628',
                'alamat_perusahaan' => 'Gang Buntu no 39'
            ]
        ]);
        DB::table('mandors')->insert([
            ['kode_mandor' => '100001', 'status_delete_mandor' => 0, 'gaji_mandor' => 200000, 'kode_kontraktor' => '100001', 'nama_mandor' => 'monica', 'no_hp_mandor' => '082853714156', 'username_mandor' => 'monica', 'email_mandor' => 'monica@gmail.com', 'password_mandor' => 'monica']
        ]);
        DB::table('administrators')->insert([
            ['kode_admin' => '100001', 'status_delete_admin' => '0', 'gaji_admin' => 1000000, 'kode_kontraktor' => '100001', 'nama_admin' => 'denny', 'no_hp_admin' => '087123784556', 'username_admin' => 'denny', 'email_admin' => 'denny@gmail.com', 'password_admin' => 'denny']
        ]);
        DB::table('jenis_tukangs')->insert([
            ['kode_jenis' => '100001', 'status_delete_jt' => 0, 'kode_mandor' => '100001', 'nama_jenis' => 'Tukang Kayu', 'gaji_pokok' => 180000],
            ['kode_jenis' => '100002', 'status_delete_jt' => 0, 'kode_mandor' => '100001', 'nama_jenis' => 'Tukang Listrik', 'gaji_pokok' => 0],
            ['kode_jenis' => '100003', 'status_delete_jt' => 0, 'kode_mandor' => '100001', 'nama_jenis' => 'Tukang poles', 'gaji_pokok' => 0]
        ]);
        DB::table('tukangs')->insert([
            ['kode_tukang' => '100001', 'status_delete_tukang' => 0, 'gaji_pokok_tukang' => 180000, 'kode_jenis' => '100001', 'kode_mandor' => '100001', 'nama_tukang' => 'joe', 'no_hp_tukang' => '087526789502', 'username_tukang' => 'joe', 'email_tukang' => 'joe@gmail.com', 'password_tukang' => 'joe']
        ]);
        DB::table('tukangs')->insert([
            ['kode_tukang' => '100002', 'status_delete_tukang' => 0, 'gaji_pokok_tukang' => 180000, 'kode_jenis' => '100001', 'kode_mandor' => '100001', 'nama_tukang' => 'robby', 'no_hp_tukang' => '087526789502', 'username_tukang' => 'robby', 'email_tukang' => 'robby@gmail.com', 'password_tukang' => 'r']
        ]);
    }
}
