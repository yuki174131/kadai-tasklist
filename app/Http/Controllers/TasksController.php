<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Task;

class TasksController extends Controller
{
    //getでtasks/にアクセスされた場合の「一覧表示処理」
    public function index()
    {
        $tasks = Task::where('user_id', \Auth::id())->get();
        
        if (\Auth::check()) {
            return view('tasks.index', [
                'tasks' => $tasks,
            ]);
          } else {
            return view('welcome');
        }
    }

    //getでtasks/createにアクセスされた場合の「新規登録画面表示処理」
    public function create()
    {   
        $task = new Task;
        
        return view('tasks.create',[
            'task' => $task,
        ]);
    }

   //postでtasks/にアクセスされた場合の「新規登録処理」
    public function store(Request $request)
    {   
        $this->validate($request,[
            'status' => 'required|max:10',
            'content' => 'required|max:191',
        ]);
        
        $task = new Task;
        $task->user_id = \Auth::id();
        $task->status = $request->status;
        $task->content = $request->content;
        $task->save();
        
        return redirect('/');
    }

    //getでtasks/idにアクセスされた場合の「取得表示処��」
    public function show($id)
    {   
        $task = Task::find($id);
        
        if ($task->user_id === \Auth::id()) {
        
        return view('tasks.show', [
            'task' => $task,
        ]);
        } else {
            return redirect('/');
        }
    }

    //getでtasks/id/editにアクセスされた場合の「更新画面表示処理」
    public function edit($id)
    {  
        $task = Task::find($id);
        
        if ($task->user_id === \Auth::id()) {
        
        return view('tasks.edit', [
            'task' => $task,
        ]);
        } else {
            return redirect('/');
        }
    }

    //putまたはpatchでtasks/idにアクセスされた場合の「更新処理」
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'status' => 'required|max:10',
            'content' => 'required|max:191',
        ]);
        
        $task = Task::find($id);
        $task->user_id = \Auth::id();
        $task->status = $request->status;
        $task->content = $request->content;
        $task->save();
        
        return redirect('/');
    }

    //deleteでtasks/idにアクセスされた場合の「削除処理」
    public function destroy($id)
    {   
        $task = Task::find($id);
        
        if ($task->user_id === \Auth::id()) {
        
            $task->delete();
            return redirect('/');
            
        } else {
            return redirect('/');
        }
    }
}
