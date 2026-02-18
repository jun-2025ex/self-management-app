<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Record;
use Carbon\Carbon;

class RecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = ['food', 'sleep', 'exercise', 'study'];

        for ($i = 0; $i < 50; $i++) {
            $category = $categories[array_rand($categories)];

            $value = match($category) {
                'food' => rand(0, 1500),
                'sleep' => rand(0, 24),
                'exercise' => rand(0, 24),
                'study' => rand(0, 24),
            };

            Record::create([
                'category' => $category,
                'date' => Carbon::today()->subDays(rand(0, 60))->format('Y-m-d'),
                'content' => 'テストデータ '.$i,
                'value' => $value,
            ]);
        }
    }
}
