@extends('layouts.app')

@section('title', 'タスクの編集')

@section('content')
    <h1 class="page-title">タスクを編集する</h1>

    <div class="card">
        <form action="{{ route('tasks.update', $task->id) }}" method="post">
            @csrf
            @method('PUT')

            <input type="text" name="name" value="{{ old('name', $task->name) }}">
            @error('name')
                <p class="error">{{ $message }}</p>
            @enderror

            <div class="form-actions">
                <button type="submit" class="btn-accent">更新する</button>
                <a href="{{ route('tasks.index') }}" class="btn-link">一覧に戻る</a>
            </div>
        </form>

        {{-- 日時表示エリアを追加 --}}
        <div class="dates-info" style="margin-top: 1.5rem; font-size: 0.9rem; color: #666;">
            <p>登録日時: {{ $task->created_at->format('Y/m/d H:i') }}</p>
            <p>最終更新日時: {{ $task->updated_at->format('Y/m/d H:i') }}</p>
        </div>
    </div>

    {{-- 完了にする --}}
        <div style="margin-top: 1rem;">
            <form action="{{ route('tasks.complete', $task->id) }}" method="post">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn-success">完了にする</button>
            </form>
        </div>

    
@endsection