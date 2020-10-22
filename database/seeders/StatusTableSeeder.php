<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status1 = Status::create([
            'name' => 'confirmed'
        ]);

        $status1->save();

        $status2 = Status::create([
            'name' => 'upper'
        ]);

        $status2->save();

        $status3 = Status::create([
            'name' => 'bottom'
        ]);

        $status3->save();

        $status4 = Status::create([
            'name' => 'finished'
        ]);

        $status4->save();

        $status5 = Status::create([
            'name' => 'dispatched'
        ]);

        $status5->save();

        $status6 = Status::create([
            'name' => 'returned'
        ]);

        $status6->save();

    }
}
