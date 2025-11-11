<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Employee;
use Faker\Factory as Facker;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $facker = Facker::create();
        for ($i = 1; $i <= 3; $i++) {
            $employee = new Employee;

            $employee->empid = mt_rand(11111, 99999);
            $employee->fullname = $facker->name;
            $employee->email = $facker->email;
            $employee->address = $facker->address;
            $employee->date = $facker->date;
            $employee->status = 1;
            $employee->save();
        }
    }
}
