<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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

        // 追加
        $data = [
            [
                "date" => "2025-10-05 00:00:00",
                "content" => "今日も仕事で生成AIの検証。新しいLLMのプロンプト調整が楽しくて、時間を忘れた。夜は副業のコード書き。気づけば0時。"
            ],
            [
                "date" => "2025-10-06 00:00:00",
                "content" => "昼は社内勉強会でRAGの構成を発表。意外とウケた。夜は友達と居酒屋へ。笑いすぎて腹筋痛い。久しぶりに人と話した気がする。"
            ],
            [
                "date" => "2025-10-07 00:00:00",
                "content" => "会社の帰りにキースイッチを衝動買い。静音タクタイル最高。帰宅後、ビートマニアでストレス解消。夜更かしして後悔。"
            ],
            [
                "date" => "2025-10-08 00:00:00",
                "content" => "今日は副業でAPI連携のバグ修正。原因は単純なタイポ。集中しすぎて夕飯食べ忘れた。AIもいいけど人間の凡ミスは避けられない。"
            ],
            [
                "date" => "2025-10-09 00:00:00",
                "content" => "土曜。昼まで寝て、起きたら夕方。やる気ゼロの日。ベッドの上でYouTube巡回して終わった。でもこういう日も悪くない。"
            ],
            [
                "date" => "2025-10-10 00:00:00",
                "content" => "今日は友達とカフェでおしゃべり。AIの話したら引かれたけど気にしない。帰りにキーボードのキーキャップ眺めて癒された。"
            ],
            [
                "date" => "2025-10-11 00:00:00",
                "content" => "職場でGPTの新モデルを試す。思考過程の透明化が面白い。夜は副業でコード整理。静かな夜にキーボードの音が心地いい。"
            ],
            [
                "date" => "2025-10-12 00:00:00",
                "content" => "会社帰りに同僚とラーメン。技術話ばかりしてたけど楽しかった。家で軽くビートマニアして一日終了。地味に幸せ。"
            ],
            [
                "date" => "2025-10-13 00:00:00",
                "content" => "今日は在宅勤務。猫動画に癒されながら仕事。夜は副業でフロント実装。AIがコード提案してくれて、作業が倍速。"
            ],
            [
                "date" => "2025-10-14 00:00:00",
                "content" => "日曜。洗濯して部屋を片付けたら気分すっきり。午後はAI論文を流し読み。夜はゲームしてリラックス。明日からまた頑張ろう。"
            ],
        ];

        DB::table('diaries')->insert($data);
    }
}
