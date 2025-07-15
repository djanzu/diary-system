<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Diary;
use Carbon\Carbon;

class DiarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $today = Carbon::today();
        $oneYearAgo = $today->copy()->subYear();
        
        Diary::create([
            'date' => $today,
            'content' => '今日の日記です。良い一日でした。'
        ]);
        
        Diary::create([
            'date' => $oneYearAgo,
            'content' => '1年前の今日の日記です。懐かしい思い出です。'
        ]);
        
        Diary::create([
            'date' => '2024-01-01',
            'content' => '今年は仕事が忙しくて実家に帰省できなかったな…。'
        ]);
        
        Diary::create([
            'date' => '2025-01-01',
            'content' => '今年は実家で楽しく新年を迎えられた。良いことがありそう！'
        ]);
    }
}
