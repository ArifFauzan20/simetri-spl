<?php

namespace Database\Seeders;

use App\Models\Bagian;
use App\Models\DetailSpl;
use App\Models\HariKerja;
use App\Models\HariLibur;
use App\Models\Karyawan;
use App\Models\Pengajuan;
use App\Models\Role;
use App\Models\Spl;
use App\Models\UangMakan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        Bagian::factory()->create([
            'nama_bagian' => 'IT',
            'update_by' => 'Super Admin',
        ]);


        Role::factory()->create([
            'role_user' => '1',
            'update_by' => 'Super Admin',
        ]);

        Role::factory()->create([
            'role_user' => '2',
            'update_by' => 'Super Admin',
        ]);

        Role::factory()->create([
            'role_user' => '3',
            'update_by' => 'Super Admin',
        ]);

        Role::factory()->create([
            'role_user' => '4',
            'update_by' => 'Super Admin',
        ]);

        Role::factory()->create([
            'role_user' => '5',
            'update_by' => 'Super Admin',
        ]);

        Role::factory()->create([
            'role_user' => '6',
            'update_by' => 'Super Admin',
        ]);

        Role::factory()->create([
            'role_user' => '7',
            'update_by' => 'Super Admin',
        ]);

        Karyawan::factory()->create([
            'nik_karyawan' => '03.01.0033',
            'bagian_id' => '1',
            'nama_karyawan' => "HADI NURHIDAYAT",
            'tarif_lembur' => 10000,
            'status_kontrak' => 'kontrak',
            'update_by' => 'Super Admin',
        ]);

        User::factory()->create([
            'karyawan_id' => '1',
            'nik_karyawan' => '03.01.0033',
            'status_user' => '1',
            'password' => bcrypt('password'),
            'role_id' => 5,
            'last_login' => Carbon::now(),
            'update_by' => 'Super Admin',
        ]);

        HariKerja::factory()->create([
            'jam_lembur' => '1',
            'point' => '1.5',
            'updated_by' => 'Super Admin'
        ]);

        HariKerja::factory()->create([
            'jam_lembur' => '1.5',
            'point' => '2.5',
            'updated_by' => 'Super Admin'
        ]);

        HariKerja::factory()->create([
            'jam_lembur' => '2',
            'point' => '3.5',
            'updated_by' => 'Super Admin'
        ]);

        HariKerja::factory()->create([
            'jam_lembur' => '2.5',
            'point' => '4.5',
            'updated_by' => 'Super Admin'
        ]);

        HariKerja::factory()->create([
            'jam_lembur' => '3',
            'point' => '5.5',
            'updated_by' => 'Super Admin'
        ]);

        HariKerja::factory()->create([
            'jam_lembur' => '3.5',
            'point' => '6.5',
            'updated_by' => 'Super Admin'
        ]);

        HariKerja::factory()->create([
            'jam_lembur' => '4',
            'point' => '7.5',
            'updated_by' => 'Super Admin'
        ]);

        HariKerja::factory()->create([
            'jam_lembur' => '4.5',
            'point' => '8.5',
            'updated_by' => 'Super Admin'
        ]);

        HariKerja::factory()->create([
            'jam_lembur' => '5',
            'point' => '9.5',
            'updated_by' => 'Super Admin'
        ]);

        HariKerja::factory()->create([
            'jam_lembur' => '5.5',
            'point' => '10.5',
            'updated_by' => 'Super Admin'
        ]);

        HariKerja::factory()->create([
            'jam_lembur' => '6',
            'point' => '11.5',
            'updated_by' => 'Super Admin'
        ]);

        HariKerja::factory()->create([
            'jam_lembur' => '6.5',
            'point' => '12.5',
            'updated_by' => 'Super Admin'
        ]);

        HariKerja::factory()->create([
            'jam_lembur' => '7',
            'point' => '13.5',
            'updated_by' => 'Super Admin'
        ]);

        HariKerja::factory()->create([
            'jam_lembur' => '7.5',
            'point' => '14.5',
            'updated_by' => 'Super Admin'
        ]);

        HariKerja::factory()->create([
            'jam_lembur' => '8',
            'point' => '15.5',
            'updated_by' => 'Super Admin'
        ]);

        HariKerja::factory()->create([
            'jam_lembur' => '8.5',
            'point' => '16.5',
            'updated_by' => 'Super Admin'
        ]);

        HariKerja::factory()->create([
            'jam_lembur' => '9',
            'point' => '17.5',
            'updated_by' => 'Super Admin'
        ]);

        HariKerja::factory()->create([
            'jam_lembur' => '9.5',
            'point' => '18.5',
            'updated_by' => 'Super Admin'
        ]);

        HariKerja::factory()->create([
            'jam_lembur' => '10',
            'point' => '19.5',
            'updated_by' => 'Super Admin'
        ]);

        HariKerja::factory()->create([
            'jam_lembur' => '10.5',
            'point' => '20.5',
            'updated_by' => 'Super Admin'
        ]);

        HariKerja::factory()->create([
            'jam_lembur' => '11',
            'point' => '21.5',
            'updated_by' => 'Super Admin'
        ]);

        HariKerja::factory()->create([
            'jam_lembur' => '11.5',
            'point' => '22.5',
            'updated_by' => 'Super Admin'
        ]);

        HariKerja::factory()->create([
            'jam_lembur' => '12',
            'point' => '23.5',
            'updated_by' => 'Super Admin'
        ]);

        HariKerja::factory()->create([
            'jam_lembur' => '12.5',
            'point' => '24.5',
            'updated_by' => 'Super Admin'
        ]);

        HariKerja::factory()->create([
            'jam_lembur' => '13',
            'point' => '25.5',
            'updated_by' => 'Super Admin'
        ]);

        HariKerja::factory()->create([
            'jam_lembur' => '13.5',
            'point' => '26.5',
            'updated_by' => 'Super Admin'
        ]);

        HariKerja::factory()->create([
            'jam_lembur' => '14',
            'point' => '27.5',
            'updated_by' => 'Super Admin'
        ]);

        HariKerja::factory()->create([
            'jam_lembur' => '14.5',
            'point' => '28.5',
            'updated_by' => 'Super Admin'
        ]);

        HariKerja::factory()->create([
            'jam_lembur' => '15',
            'point' => '29.5',
            'updated_by' => 'Super Admin'
        ]);

        HariKerja::factory()->create([
            'jam_lembur' => '15.5',
            'point' => '30.5',
            'updated_by' => 'Super Admin'
        ]);

        HariKerja::factory()->create([
            'jam_lembur' => '16',
            'point' => '31.5',
            'updated_by' => 'Super Admin'
        ]);

        HariKerja::factory()->create([
            'jam_lembur' => '16.5',
            'point' => '32.5',
            'updated_by' => 'Super Admin'
        ]);

        HariKerja::factory()->create([
            'jam_lembur' => '17',
            'point' => '33.5',
            'updated_by' => 'Super Admin'
        ]);

        HariKerja::factory()->create([
            'jam_lembur' => '17.5',
            'point' => '34.5',
            'updated_by' => 'Super Admin'
        ]);

        HariKerja::factory()->create([
            'jam_lembur' => '18',
            'point' => '35.5',
            'updated_by' => 'Super Admin'
        ]);

        HariKerja::factory()->create([
            'jam_lembur' => '18.5',
            'point' => '36.5',
            'updated_by' => 'Super Admin'
        ]);

        HariKerja::factory()->create([
            'jam_lembur' => '19',
            'point' => '37.5',
            'updated_by' => 'Super Admin'
        ]);

        HariKerja::factory()->create([
            'jam_lembur' => '19.5',
            'point' => '38.5',
            'updated_by' => 'Super Admin'
        ]);

        HariKerja::factory()->create([
            'jam_lembur' => '20',
            'point' => '39.5',
            'updated_by' => 'Super Admin'
        ]);

        HariKerja::factory()->create([
            'jam_lembur' => '20.5',
            'point' => '40.5',
            'updated_by' => 'Super Admin'
        ]);

        HariKerja::factory()->create([
            'jam_lembur' => '21',
            'point' => '41.5',
            'updated_by' => 'Super Admin'
        ]);

        HariKerja::factory()->create([
            'jam_lembur' => '21.5',
            'point' => '42.5',
            'updated_by' => 'Super Admin'
        ]);

        HariKerja::factory()->create([
            'jam_lembur' => '22',
            'point' => '43.5',
            'updated_by' => 'Super Admin'
        ]);

        HariKerja::factory()->create([
            'jam_lembur' => '22.5',
            'point' => '44.5',
            'updated_by' => 'Super Admin'
        ]);

        HariKerja::factory()->create([
            'jam_lembur' => '23',
            'point' => '45.5',
            'updated_by' => 'Super Admin'
        ]);

        HariKerja::factory()->create([
            'jam_lembur' => '23.5',
            'point' => '46.5',
            'updated_by' => 'Super Admin'
        ]);

        HariKerja::factory()->create([
            'jam_lembur' => '24',
            'point' => '47.5',
            'updated_by' => 'Super Admin'
        ]);

        HariLibur::factory()->create([
            'jam_lembur' => '1',
            'point' => '2',
            'updated_by' => 'Super Admin'
        ]);

        HariLibur::factory()->create([
            'jam_lembur' => '1.5',
            'point' => '3',
            'updated_by' => 'Super Admin'
        ]);

        HariLibur::factory()->create([
            'jam_lembur' => '2',
            'point' => '4',
            'updated_by' => 'Super Admin'
        ]);

        HariLibur::factory()->create([
            'jam_lembur' => '2.5',
            'point' => '5',
            'updated_by' => 'Super Admin'
        ]);

        HariLibur::factory()->create([
            'jam_lembur' => '3',
            'point' => '6',
            'updated_by' => 'Super Admin'
        ]);

        HariLibur::factory()->create([
            'jam_lembur' => '3.5',
            'point' => '7',
            'updated_by' => 'Super Admin'
        ]);

        HariLibur::factory()->create([
            'jam_lembur' => '4',
            'point' => '8',
            'updated_by' => 'Super Admin'
        ]);

        HariLibur::factory()->create([
            'jam_lembur' => '4.5',
            'point' => '9',
            'updated_by' => 'Super Admin'
        ]);

        HariLibur::factory()->create([
            'jam_lembur' => '5',
            'point' => '10',
            'updated_by' => 'Super Admin'
        ]);

        HariLibur::factory()->create([
            'jam_lembur' => '5.5',
            'point' => '11',
            'updated_by' => 'Super Admin'
        ]);

        HariLibur::factory()->create([
            'jam_lembur' => '6',
            'point' => '12',
            'updated_by' => 'Super Admin'
        ]);

        HariLibur::factory()->create([
            'jam_lembur' => '6.5',
            'point' => '13',
            'updated_by' => 'Super Admin'
        ]);

        HariLibur::factory()->create([
            'jam_lembur' => '7',
            'point' => '14',
            'updated_by' => 'Super Admin'
        ]);

        HariLibur::factory()->create([
            'jam_lembur' => '7.5',
            'point' => '15',
            'updated_by' => 'Super Admin'
        ]);

        HariLibur::factory()->create([
            'jam_lembur' => '8',
            'point' => '16',
            'updated_by' => 'Super Admin'
        ]);

        HariLibur::factory()->create([
            'jam_lembur' => '8.5',
            'point' => '17.5',
            'updated_by' => 'Super Admin'
        ]);

        HariLibur::factory()->create([
            'jam_lembur' => '9',
            'point' => '19',
            'updated_by' => 'Super Admin'
        ]);

        HariLibur::factory()->create([
            'jam_lembur' => '9.5',
            'point' => '21',
            'updated_by' => 'Super Admin'
        ]);

        HariLibur::factory()->create([
            'jam_lembur' => '10',
            'point' => '23',
            'updated_by' => 'Super Admin'
        ]);

        HariLibur::factory()->create([
            'jam_lembur' => '10.5',
            'point' => '25',
            'updated_by' => 'Super Admin'
        ]);

        HariLibur::factory()->create([
            'jam_lembur' => '11',
            'point' => '27',
            'updated_by' => 'Super Admin'
        ]);

        HariLibur::factory()->create([
            'jam_lembur' => '11.5',
            'point' => '29',
            'updated_by' => 'Super Admin'
        ]);

        HariLibur::factory()->create([
            'jam_lembur' => '12',
            'point' => '31',
            'updated_by' => 'Super Admin'
        ]);

        HariLibur::factory()->create([
            'jam_lembur' => '12.5',
            'point' => '33',
            'updated_by' => 'Super Admin'
        ]);

        HariLibur::factory()->create([
            'jam_lembur' => '13',
            'point' => '35',
            'updated_by' => 'Super Admin'
        ]);

        HariLibur::factory()->create([
            'jam_lembur' => '13.5',
            'point' => '37',
            'updated_by' => 'Super Admin'
        ]);

        HariLibur::factory()->create([
            'jam_lembur' => '14',
            'point' => '39',
            'updated_by' => 'Super Admin'
        ]);

        HariLibur::factory()->create([
            'jam_lembur' => '14.5',
            'point' => '41',
            'updated_by' => 'Super Admin'
        ]);

        HariLibur::factory()->create([
            'jam_lembur' => '15',
            'point' => '43',
            'updated_by' => 'Super Admin'
        ]);

        HariLibur::factory()->create([
            'jam_lembur' => '15.5',
            'point' => '45',
            'updated_by' => 'Super Admin'
        ]);

        HariLibur::factory()->create([
            'jam_lembur' => '16',
            'point' => '47',
            'updated_by' => 'Super Admin'
        ]);

        HariLibur::factory()->create([
            'jam_lembur' => '16.5',
            'point' => '49',
            'updated_by' => 'Super Admin'
        ]);

        HariLibur::factory()->create([
            'jam_lembur' => '17',
            'point' => '51',
            'updated_by' => 'Super Admin'
        ]);

        HariLibur::factory()->create([
            'jam_lembur' => '17.5',
            'point' => '53',
            'updated_by' => 'Super Admin'
        ]);

        HariLibur::factory()->create([
            'jam_lembur' => '18',
            'point' => '55',
            'updated_by' => 'Super Admin'
        ]);

        HariLibur::factory()->create([
            'jam_lembur' => '18.5',
            'point' => '57',
            'updated_by' => 'Super Admin'
        ]);

        HariLibur::factory()->create([
            'jam_lembur' => '19',
            'point' => '59',
            'updated_by' => 'Super Admin'
        ]);

        HariLibur::factory()->create([
            'jam_lembur' => '19.5',
            'point' => '61',
            'updated_by' => 'Super Admin'
        ]);

        HariLibur::factory()->create([
            'jam_lembur' => '20',
            'point' => '63',
            'updated_by' => 'Super Admin'
        ]);

        HariLibur::factory()->create([
            'jam_lembur' => '20.5',
            'point' => '65',
            'updated_by' => 'Super Admin'
        ]);

        HariLibur::factory()->create([
            'jam_lembur' => '21',
            'point' => '67',
            'updated_by' => 'Super Admin'
        ]);

        HariLibur::factory()->create([
            'jam_lembur' => '21.5',
            'point' => '69',
            'updated_by' => 'Super Admin'
        ]);

        HariLibur::factory()->create([
            'jam_lembur' => '22',
            'point' => '71',
            'updated_by' => 'Super Admin'
        ]);

        HariLibur::factory()->create([
            'jam_lembur' => '22.5',
            'point' => '73',
            'updated_by' => 'Super Admin'
        ]);

        HariLibur::factory()->create([
            'jam_lembur' => '23',
            'point' => '75',
            'updated_by' => 'Super Admin'
        ]);

        HariLibur::factory()->create([
            'jam_lembur' => '23.5',
            'point' => '77',
            'updated_by' => 'Super Admin'
        ]);

        HariLibur::factory()->create([
            'jam_lembur' => '24',
            'point' => '79',
            'updated_by' => 'Super Admin'
        ]);

        UangMakan::factory()->create([
            'status' => '1',
            'uang_makan' => '25000',
            'updated_by' => 'Super Admin'
        ]);
        UangMakan::factory()->create([
            'status' => '2',
            'uang_makan' => '15000',
            'updated_by' => 'Super Admin'
        ]);
        UangMakan::factory()->create([
            'status' => '3',
            'uang_makan' => '10000',
            'updated_by' => 'Super Admin'
        ]);
    }
}
