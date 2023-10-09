<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeederTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::create([
            "name"       => "Company Name",
            "owner_name" => "Owner Name",
            "phone"      => "017#########",
            "address"    => "Company Address"
        ]);
    }
}
