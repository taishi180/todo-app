@extends('layouts.app')

@section('title', 'タスク一覧')

@section('content')
    <h1 class="page-title">今日は何をする？</h1>

    <p>登録件数：{{ $tasks->count() }} 件</p>

    <form method="POST" action="/tasks">
        @csrf

        <input type="text" name="name" placeholder="タスクを入力してください">

        <button type="submit">追加</button>
    </form>
    
    <table>
        <thead>
            <tr>
                <th>タスク</th>
                <th>登録日時</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tasks as $task)
                <tr>
                    <td>{{ $task->name }}</td>
                    <td class="muted">{{ $task->created_at->format('Y/m/d H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
```