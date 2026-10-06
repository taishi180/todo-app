<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
public function run()
    {
        $names = [
            'おきる',
            'ごはんたべる',
            '勉強する',
            'ねる',
        ];

        foreach ($names as $name) {
            Task::create([
                'name'   => $name,
                'status' => false,
            ]);
        }

        Task::create([
            'name'   => 'あそぶ（完了済みの例）',
            'status' => true,
        ]);
    }    

}
