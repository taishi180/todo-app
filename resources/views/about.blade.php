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
                <input type="text" name="name" placeholder="洗濯物をたたむ...">
                <button type="submit">追加する</button>
            </div>
        </form>
    </div>