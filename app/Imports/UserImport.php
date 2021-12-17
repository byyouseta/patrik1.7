<?php

namespace App\Imports;

use App\User;
use App\Pegawai;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UserImport implements OnEachRow, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function onRow(Row $row)
    {
        $rowIndex = $row->getIndex();
        $row      = $row->toArray();

        $user = User::firstOrCreate([
            'name' => $row['name'],
            'unit_id' => $row['unit_id'],
            'email' => $row['email'],
            'username' => $row['username'],
            'level' => $row['level'],
            'password' => Hash::make($row['username']),
        ]);

        $user->pegawai()->create([
            'alamat' => $row['alamat'],
            'no_hp' => $row['nohp'],
        ]);

        // foreach ($rows as $row) {
        //     User::create([
        //         'name' => $row[1],
        //         'unit_id' => $row[2],
        //         'email' => $row[3],
        //         'username' => $row[4],
        //         'level' => $row[5],
        //         'password' => Hash::make($row[4]),
        //     ]);

        //     $data = User::where('username', '=', $row[4])->first();
        //     $user_id = (int)$data->id;

        //     // dd($user_id);

        //     Pegawai::create([
        //         'user_id' => $user_id,
        //         'alamat' => $row[6],
        //         'no_hp' => $row[7],
        //     ]);
        // }
    }
}
