<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function () {
    $tasks = session('tasks', []);
    $editIndex = null;

    return view('welcome', compact('tasks', 'editIndex'));
});

Route::post('/add', function (Request $request) {
    $request->validate([
        'task' => 'required|string|max:255'
    ]);

    $tasks = session('tasks', []);

    $tasks[] = [
        'name' => $request->task,
        'completed' => false
    ];

    session(['tasks' => $tasks]);

    return redirect('/');
});

Route::post('/complete/{index}', function ($index) {
    $tasks = session('tasks', []);

    if (array_key_exists($index, $tasks)) {
        $tasks[$index]['completed'] = true;
        session(['tasks' => $tasks]);
    }

    return redirect('/');
});

Route::get('/edit/{index}', function ($index) {
    $tasks = session('tasks', []);

    if (!array_key_exists($index, $tasks)) {
        return redirect('/');
    }

    $editIndex = (int) $index;

    return view('welcome', compact('tasks', 'editIndex'));
});

Route::post('/edit/{index}', function (Request $request, $index) {
    $request->validate([
        'task' => 'required|string|max:255'
    ]);

    $tasks = session('tasks', []);

    if (array_key_exists($index, $tasks)) {
        $tasks[$index]['name'] = $request->task;
        session(['tasks' => $tasks]);
    }

    return redirect('/');
});

Route::post('/delete/{index}', function ($index) {
    $tasks = session('tasks', []);

    if (array_key_exists($index, $tasks)) {
        unset($tasks[$index]);
        $tasks = array_values($tasks);

        session(['tasks' => $tasks]);
    }

    return redirect('/');
});