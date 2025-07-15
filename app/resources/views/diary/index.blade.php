<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>日記システム - Diary System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }
        .diary-section {
            margin-bottom: 40px;
        }
        .diary-section h2 {
            color: #666;
            margin-bottom: 10px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }
        input[type="date"] {
            width: 200px;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }
        textarea {
            width: 100%;
            min-height: 120px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            resize: vertical;
            box-sizing: border-box;
        }
        .readonly {
            background-color: #f9f9f9;
            color: #666;
        }
        .buttons {
            text-align: center;
            margin-top: 20px;
        }
        .btn {
            padding: 10px 20px;
            margin: 0 5px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
            display: inline-block;
        }
        .btn-primary {
            background-color: #007bff;
            color: white;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }
        .btn-secondary:hover {
            background-color: #545b62;
        }
        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .navigation {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .current-date {
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>日記システム - Diary System</h1>
        
        @if(session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif
        
        <div class="navigation">
            <a href="{{ route('diary.index', ['date' => $currentDate->copy()->subDay()->toDateString()]) }}" class="btn btn-secondary">前日へ</a>
            <div class="current-date">{{ $currentDate->format('Y年m月d日') }}</div>
            <a href="{{ route('diary.index', ['date' => $currentDate->copy()->addDay()->toDateString()]) }}" class="btn btn-secondary">翌日へ</a>
        </div>
        
        <form id="diaryForm" action="{{ route('diary.store') }}" method="POST">
            @csrf
            <div class="diary-section">
                <h2>今日の日記</h2>
                <div class="form-group">
                    <label for="date">日付:</label>
                    <input type="date" id="date" name="date" value="{{ $currentDate->toDateString() }}" required>
                </div>
                <div class="form-group">
                    <label for="content">内容:</label>
                    <textarea id="content" name="content" placeholder="日記の内容を入力してください（最大1000文字）" maxlength="1000">{{ $diary ? $diary->content : '' }}</textarea>
                </div>
            </div>
            
            <div class="diary-section">
                <h2>1年前の同日</h2>
                <div class="form-group">
                    <label>日付:</label>
                    <input type="date" value="{{ $currentDate->copy()->subYear()->toDateString() }}" readonly class="readonly">
                </div>
                <div class="form-group">
                    <label>内容:</label>
                    <textarea readonly class="readonly">{{ $lastYearDiary ? $lastYearDiary->content : '日記が見つかりません' }}</textarea>
                </div>
            </div>
            
            <div class="buttons">
                <button type="submit" class="btn btn-primary">保存</button>
            </div>
        </form>
    </div>
    
    <script>
        let originalContent = document.getElementById('content').value;
        let hasChanged = false;
        
        document.getElementById('content').addEventListener('input', function() {
            hasChanged = (this.value !== originalContent);
        });
        
        window.addEventListener('beforeunload', function(e) {
            if (hasChanged) {
                e.preventDefault();
                e.returnValue = '日記を変更しましたが、保存されていません。ページを離れますか？';
            }
        });
        
        document.getElementById('diaryForm').addEventListener('submit', function() {
            hasChanged = false;
        });
        
        document.querySelectorAll('a').forEach(function(link) {
            link.addEventListener('click', function(e) {
                if (hasChanged) {
                    if (!confirm('日記を変更しましたが、保存されていません。ページを離れますか？')) {
                        e.preventDefault();
                    }
                }
            });
        });
    </script>
</body>
</html>