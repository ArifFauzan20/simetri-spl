<?php

namespace App\Imports;

use App\Models\DetailSpl;
use Maatwebsite\Excel\Concerns\ToModel;

class DetailSplImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new DetailSpl([
            'No' => $row[0],
            'Kode Proyek' => $row[1],
            'NIK' => $row[2],
            'Nama Karyawan' => $row[3],
            'Bagian' => $row[4],
            'Keterangan' => $row[5],
        ]);
    }
}
