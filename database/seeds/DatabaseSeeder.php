<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
//         factory(App\Models\User::class)->create();
//         factory(App\Models\User::class)->create(['email' => 'user@user.com']);
//         factory(App\Models\Wedding::class, 20)->create();
//         factory(App\Models\Vendor::class, 20)->create();
//         factory(App\Models\Event::class, 20)->create();
//         factory(App\Models\Guest::class, 20)->create();
//         factory(App\Models\Profession::class, 5)->create();
         factory(App\Models\Product::class, 50)->create();
    }
}
