<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Diary;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

class DiaryApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // テスト用データを作成
        Diary::create([
            'date' => Carbon::parse('2024-01-01')->format('Y-m-d'),
            'content' => 'テスト用日記1'
        ]);
        
        Diary::create([
            'date' => Carbon::parse('2024-01-02')->format('Y-m-d'),
            'content' => 'テスト用日記2'
        ]);
        
        Diary::create([
            'date' => Carbon::parse('2025-01-01')->format('Y-m-d'),
            'content' => 'テスト用日記3'
        ]);
    }

    /**
     * 日記取得API - 正常系
     */
    public function test_get_diary_api_success()
    {
        $response = $this->getJson('/api/diary?year=2024');
        
        $response->assertStatus(200)
                 ->assertJson([
                     'count' => 2,
                     'items' => [
                         [
                             'date' => '2024-01-01',
                             'content' => 'テスト用日記1'
                         ],
                         [
                             'date' => '2024-01-02',
                             'content' => 'テスト用日記2'
                         ]
                     ]
                 ]);
    }

    /**
     * 日記取得API - yearパラメータなし
     */
    public function test_get_diary_api_without_year()
    {
        $response = $this->getJson('/api/diary');
        
        $response->assertStatus(400)
                 ->assertJson([
                     'error' => 'year parameter is required'
                 ]);
    }

    /**
     * 日記取得API - 該当データなし
     */
    public function test_get_diary_api_no_data()
    {
        $response = $this->getJson('/api/diary?year=2023');
        
        $response->assertStatus(200)
                 ->assertJson([
                     'count' => 0,
                     'items' => []
                 ]);
    }

    /**
     * 日記投稿API - 正常系（新規作成）
     */
    public function test_post_diary_api_create_success()
    {
        $data = [
            'date' => '2024-12-25',
            'content' => 'クリスマスの日記'
        ];
        
        $response = $this->postJson('/api/diary', $data);
        
        $response->assertStatus(200)
                 ->assertJson(['status' => 'OK']);
        
        // データベースに保存されているか確認
        $this->assertDatabaseHas('diaries', [
            'date' => '2024-12-25 00:00:00',
            'content' => 'クリスマスの日記'
        ]);
    }



    /**
     * 日記投稿API - contentなし（null許可）
     */
    public function test_post_diary_api_without_content()
    {
        $data = [
            'date' => '2024-12-31'
        ];
        
        $response = $this->postJson('/api/diary', $data);
        
        $response->assertStatus(200)
                 ->assertJson(['status' => 'OK']);
        
        $this->assertDatabaseHas('diaries', [
            'date' => '2024-12-31 00:00:00',
            'content' => null
        ]);
    }

    /**
     * 日記投稿API - dateパラメータなし（バリデーションエラー）
     */
    public function test_post_diary_api_without_date()
    {
        $data = [
            'content' => '日付なしの日記'
        ];
        
        $response = $this->postJson('/api/diary', $data);
        
        $response->assertStatus(403)
                 ->assertJson(['status' => 'NG']);
    }

    /**
     * 日記投稿API - 不正な日付形式
     */
    public function test_post_diary_api_invalid_date()
    {
        $data = [
            'date' => 'invalid-date',
            'content' => '不正な日付の日記'
        ];
        
        $response = $this->postJson('/api/diary', $data);
        
        $response->assertStatus(403)
                 ->assertJson(['status' => 'NG']);
    }

    /**
     * 日記投稿API - contentが1000文字を超える
     */
    public function test_post_diary_api_content_too_long()
    {
        $data = [
            'date' => '2024-12-25',
            'content' => str_repeat('あ', 1001) // 1001文字
        ];
        
        $response = $this->postJson('/api/diary', $data);
        
        $response->assertStatus(403)
                 ->assertJson(['status' => 'NG']);
    }

    /**
     * 日記投稿API - contentが1000文字ちょうど（正常系）
     */
    public function test_post_diary_api_content_max_length()
    {
        $data = [
            'date' => '2024-12-25',
            'content' => str_repeat('あ', 1000) // 1000文字
        ];
        
        $response = $this->postJson('/api/diary', $data);
        
        $response->assertStatus(200)
                 ->assertJson(['status' => 'OK']);
    }
}