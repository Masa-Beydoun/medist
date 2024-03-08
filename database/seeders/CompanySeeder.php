<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companies = Company::factory(10)->hasAddress(1)->create();
        foreach ($companies as $company) {
            $company->addMedia("public\download.jpg")->preservingOriginal()->toMediaCollection('companies');
        }
    }
}
