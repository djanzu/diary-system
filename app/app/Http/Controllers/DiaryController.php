<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Diary;
use Carbon\Carbon;

class DiaryController extends Controller
{
    private function washDate($date)
    {
        // とりあえず、すまん。
        return "{$date} 00:00:00";
    }

    public function index(Request $request)
    {
        $date = $request->get('date', Carbon::today()->toDateString());
        $currentDate = Carbon::parse($date);
        
        $diary = Diary::where('date', $currentDate)->first();
        $lastYearDiary = Diary::where('date', $currentDate->copy()->subYear())->first();
        
        return view('diary.index', compact('diary', 'lastYearDiary', 'currentDate'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'content' => 'nullable|string|max:1000'
        ]);
        
        // postで渡される日付をそのまま使うと…
        Diary::updateOrCreate(
            ['date' => $this->washDate($request->date)],
            ['content' => $request->content]
        );
        
        return redirect()->route('diary.index', ['date' => $request->date])
                         ->with('success', '日記を保存しました。');
    }
    
    public function api(Request $request)
    {
        $year = $request->get('year');
        
        if (!$year) {
            return response()->json([
                'error' => 'year parameter is required'
            ], 400);
        }
        
        $diaries = Diary::whereYear('date', $year)
                        ->orderBy('date', 'asc')
                        ->get(['date', 'content']);
        
        return response()->json([
            'count' => $diaries->count(),
            'items' => $diaries->map(function ($diary) {
                return [
                    'date' => $diary->date->toDateString(),
                    'content' => $diary->content
                ];
            })
        ]);
    }
    
    public function apiStore(Request $request)
    {
        try {
            $request->validate([
                'date' => 'required|date',
                'content' => 'nullable|string|max:1000'
            ]);
            
            Diary::updateOrCreate(
                ['date' => Carbon::parse($request->date)->format('Y-m-d')],
                ['content' => $request->content]
            );
            
            return response()->json(['status' => 'OK'], 200);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['status' => 'NG'], 403);
        } catch (\Exception $e) {
            return response()->json(['status' => 'NG'], 403);
        }
    }
}
