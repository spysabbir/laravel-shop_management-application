<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExpenseCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('expense_categories')->insert([
            // Staff Salary
            [
                'expense_category_name' => 'Staff Salary',
                'created_by' => 1,
                'created_at' => Carbon::now(),
            ],
            // Staff Bonus
            [
                'expense_category_name' => 'Staff Bonus',
                'created_by' => 1,
                'created_at' => Carbon::now(),
            ]
        ]);
    }
}
