<?php

namespace Database\Seeders;

use App\Models\Property;
use App\Models\User;
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
        $user = User::factory(3)->create();
        Property::factory(2)->create([
            'owner_id' => $user[0]->id
        ]);
        Property::factory(2)->create([
            'owner_id' => $user[1]->id
        ]);
        Property::factory(2)->create([
            'owner_id' => $user[2]->id
        ]);
    }
}
