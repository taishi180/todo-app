@extends('layouts.app')

@section('title', '自己紹介')

@section('content')
    <h1 class="page-title">こんにちは</h1>

    <div class="card">
        <p>紙本泰志</p>
        <p>Laravel を勉強中です。</p>
    </div>
@endsection

    {{-- 追加フォーム --}}
    <div class="card">
        <form action="{{ route('tasks.store') }}" method="post">
            @csrf
            <div class="form-row">
                <input type="text" name="name" value="{{ old('name') }}" placeholder="洗濯物をたたむ...">
                <button type="submit">追加する</button>
            </div>
            @error('name')
                <p class="error">{{ $message }}</p>
            @enderror
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>タスク</th>
                <th>登録日時</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tasks as $task)
                <tr>
                    <td>{{ $task->name }}</td>
                    <td class="muted">{{ $task->created_at->format('Y/m/d H:i') }}</td>
                    <td class="actions">
                        <form action="{{ route('tasks.complete', $task->id) }}" method="post">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn-success btn-sm">完了</button>
                        </form>

                        <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-accent btn-sm">編集</a>

                         <form action="{{ route('tasks.destroy', $task->id) }}" method="post" onsubmit="return confirm('「{{ addslashes($task->name) }}」を削除します。よろしいですか？')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-danger btn-sm">削除</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

{{-- 未完了タスク一覧 --}}
@if ($tasks->isEmpty())
        <p class="empty">未完了のタスクはありません。</p>
    @else
    <table>
        <thead>
            <tr>
                <th>タスク</th>
                <th>登録日時</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tasks as $task)
                <tr>
                    <td>{{ $task->name }}</td>
                    <td class="muted">{{ $task->created_at->format('Y/m/d H:i') }}</td>
                    <td class="actions">
                        <form action="{{ route('tasks.complete', $task->id) }}" method="post">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn-success btn-sm">完了</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @endif

   {{-- 完了済みタスク一覧セクション --}}
    <h2 style="margin-top: 2rem;">完了済みタスク</h2>
    <table>
        <thead>
            <tr>
                <th>タスク</th>
                <th>完了日時</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($completedTasks as $task)
                <tr>
                    <td style="text-decoration: line-through; color: #888;">{{ $task->name }}</td>
                    <td>{{ $task->updated_at->format('Y/m/d H:i') }}</td>
                    <td>
                        {{-- 未完了に戻すボタン --}}
                        <form action="{{ route('tasks.undo', $task->id) }}" method="post" style="display:inline;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn-secondary btn-sm">未完了に戻す</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @if (session('message'))
    {{-- session('type') があればそれを使い、なければデフォルトで success にする --}}
    <div class="alert alert-{{ session('type', 'success') }}">
        {{ session('message') }}
    </div>
@endif

<form action="{{ route('tasks.undo', $task->id) }}" method="post">
    @csrf
    @method('PATCH')
    <button type="submit" class="btn-secondary btn-sm">未完了に戻す</button>
</form>