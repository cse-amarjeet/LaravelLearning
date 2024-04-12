<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Models\Task;
use \App\Http\Requests\TaskRequest;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function ()  {
    return redirect()->route('tasks.index');
});

Route::get('/tasks', function () {
    return view('index',
    ['tasks'=>Task::latest()-> paginate(10)]);
})->name("tasks.index");

Route::view('/tasks/create','create')->name('tasks.create');


Route::get('/tasks/{task}/edit',function(Task $task)  {
    return view('edit',['task'=> $task]);
})->name('task.edit');

Route::get('/tasks/{task}',function(Task $task)  {
    return view('show',['task'=> $task]);
})->name('task.show');

Route::post('/tasks', function (TaskRequest $request) {

    $task = Task::create($request->validated());

    return redirect()->route('task.show',['task'=>$task->id])->with('success','Task Created successfully!!');

})->name('tasks.store');

Route::put('/tasks/{task}', function (Task $task,TaskRequest $request) {
    $task->update($request->validated());

    return redirect()->route('task.show',['task'=>$task->id])->with('success','Task updated successfully!!');

})->name('tasks.update');

Route::delete('/tasks/{task}', function (Task $task) {
    $task->delete();
    return redirect()->route('tasks.index',['task'=> $task->id])->with('success','Tasks was deleted successfully!!');
})->name('tasks.destroy');

Route::put('/tasks/{task}/toggle-complete',function(Task $task, Request $request){
    $task->toggleComplete();
    
    return redirect()->back()->with('success','Task updated successfully!');
})->name('tasks.toggle-complete');

// this is fall back route that execute when no route match
Route::fallback(function(){
    return "return something";
});
