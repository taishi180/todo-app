<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;


class TaskController extends Controller
{
    private array $rules = [
        'name' => 'required|max:100',
    ];

    private array $messages = [
        'name.required' => 'タスク名を入力してください。',
        'name.max'      => 'タスク名は100文字以内で入力してください。',
    ];

    public function index()
    {
    
        $tasks = Task::where('status', false)
            ->orderBy('created_at', 'desc')
            ->get();

        $doneTasks = Task::where('status', true)
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('tasks.index', compact('tasks', 'doneTasks'));
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|min:3|max:100|unique:tasks,name',
        ], [
            'name.required' => 'タスク名を入力してください。',
            'name.min'      => 'タスク名は3文字以上で入力してください。',
            'name.max'      => 'タスク名は100文字以内で入力してください。',
            'name.unique'   => 'すでに同じ名前のタスクが存在します。',
        ]);

        Task::create([
            'name'   => $validated['name'],
            'status' => false,
        ]);

        return redirect()
        ->route('tasks.index')
        ->with('message', 'タスクを追加しました。');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = Task::findOrFail($id);

        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|max:100',
        ], [
            'name.required' => 'タスク名を入力してください。',
            'name.max'      => 'タスク名は100文字以内で入力してください。',
        ]);

        $task = Task::findOrFail($id);
        $task->name = $validated['name'];
        $task->save();

        return redirect()
        ->route('tasks.index')
        ->with('message', 'タスクを更新しました。');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        return redirect()
        ->route('tasks.index')
        ->with('message', 'タスクを削除しました。')
        ->with('type', 'danger');
    }
    public function complete($id)
    {
        $task = Task::find($id);
        $task->status = true;
        $task->save();

        return redirect()
        ->route('tasks.index')
        ->with('message', 'タスクを完了にしました。')
        ->with('type', 'success');
    }

    /**
     * PATCH /tasks/{id}/undo  未完了に戻す
     */
    public function undo($id)
    {
        $task = Task::findOrFail($id);
        $task->status = false; // status を false（未完了）に戻す
        $task->save();

        return redirect()->route('tasks.index')
            ->with('message', 'タスクを未完了に戻しました。')
            ->with('type', 'success');
    }
    
}


