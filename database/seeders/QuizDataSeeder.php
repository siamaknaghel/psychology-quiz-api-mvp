<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class QuizDataSeeder extends Seeder
{
    public function run(): void
    {
        // مسیر فایل JSON
        $json = File::get(database_path('seeders/data/questions.json'));

        // دیکد JSON
        $data = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->command->error('خطا در خواندن JSON: ' . json_last_error_msg());
            return;
        }

        DB::transaction(function () use ($data) {
            foreach ($data['questions'] as $questionData) {
                // ایجاد سوال
                $question = DB::table('questions')->insertGetId([
                    'text' => $questionData['text'],
                    'sort_order' => $questionData['sort_order'] ?? 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // ایجاد گزینه‌ها
                foreach ($questionData['options'] as $option) {
                    DB::table('options')->insert([
                        'question_id' => $question,
                        'text' => $option['text'],
                        'value' => $option['value'],
                        'trait' => $option['trait'],
                        'weight' => $option['weight'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        });

        $this->command->info('✅ داده‌های کوئیز با موفقیت وارد شدند!');
    }
}
