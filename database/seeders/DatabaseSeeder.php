<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Company;
use App\Models\Medicine;
use App\Models\MedicineDetails;
use App\Models\Warehouse;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(WarehouseSeeder::class); // creates warehouses
        $this->call(CompanySeeder::class); // creates companies
        $this->call(CategorySeeder::class); // creates categories
        $this->call(MedicineSeeder::class); // creates medicines
        $this->call(MedicineDetailsSeeder::class); // creates medicines doses
        $warehouses = Warehouse::all();
        $medicines = Medicine::all();
        foreach($warehouses as $warehouse) {
            $companies = Company::inRandomOrder()->limit(4)->get();
            $warehouse->companies()->saveMany($companies);
        }
        foreach($medicines as $medicine) {
            $warehouse = Warehouse::inRandomOrder()->limit(1)->first();
            $category = Category::inRandomOrder()->limit(1)->first();
            $doses = MedicineDetails::inRandomOrder()->limit(4)->get();
            $medicine->company()->associate($warehouse->companies[0]);
            $medicine->warehouse()->associate($warehouse);
            $medicine->category()->associate($category);
            $medicine->details()->saveMany($doses);
            $medicine->addMedia("public\download.jpg")->preservingOriginal()->toMediaCollection('medicine');
            // $medicine->addMediaFromUrl('https://loremflickr.com/200/200/medicine')->toMediaCollection('medicine');
            $medicine->save();
        }
        $doses = MedicineDetails::all();
        foreach($doses as $dose) {
            $dose->quantity()->create([
                'sold' => 0,
                'available' => rand(10,1000),
                'warehouse_id' => $dose->medicine->warehouse_id
            ]);
        }
    }
}
