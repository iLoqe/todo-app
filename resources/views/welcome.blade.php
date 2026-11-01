<!DOCTYPE html>
<html>
<head>
    <title>To-Do List</title>

    <style>
        * { box-sizing: border-box; }

        body {
            font-family: Arial, sans-serif;
            background: #F1EBDD;
            background-image: radial-gradient(#C9BFA9 1px, transparent 1px);
            background-size: 20px 20px;
            color: #263F35;
            margin: 0;
            padding: 30px 0;
        }

        .container {
            width: 520px;
            max-width: calc(100% - 40px);
            margin: 35px auto;
            padding: 28px;
            background: #FFFDF5;
            border: 2px solid #263F35;
            border-radius: 12px;
            box-shadow: 8px 8px 0 #263F35;
        }

        h1 {
            font-size: 36px;
            margin: 0 0 25px;
            letter-spacing: -1.5px;
        }

        .add-form, .edit-form, .task-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 7px;
        }

        input {
            flex: 1;
            min-width: 0;
            padding: 12px;
            border: 2px solid #263F35;
            border-radius: 6px;
            background: #F8F5EB;
            font-size: 14px;
        }

        button {
            padding: 10px 13px;
            border: 2px solid #263F35;
            border-radius: 6px;
            color: #263F35;
            font-size: 13px;
            cursor: pointer;
        }

        button:hover { filter: brightness(.95); }

        .add { background: #E47B42; color: white; }
        .complete { background: #DCE9D7; }
        .edit { background: #F2D99B; }
        .delete { background: #E8BDB2; }

        .task-list {
            padding-left: 30px;
            margin: 20px 0 0;
        }

        .task-item {
            padding: 10px 0 14px;
            border-bottom: 1px dashed #C9BFA9;
            overflow-wrap: anywhere;
        }

        .task-item::marker {
            color: #E47B42;
            font-weight: bold;
        }

        .completed {
            text-decoration: line-through;
            color: #99978D;
        }

        .task-actions { margin-top: 12px; }

        .task-actions form { display: inline; }

        .error {
            color: #AD3E32;
            font-size: 13px;
        }

        @media (max-width: 480px) {
            .container { padding: 20px; }
            h1 { font-size: 30px; }
        }
    </style>
</head>

<body>
    <div class="container">

        <h1>To-do List</h1>

        @if ($errors->any())
            <p class="error">{{ $errors->first() }}</p>
        @endif

        <form class="add-form" action="/add" method="POST">
            @csrf
            <input type="text" name="task"
                   placeholder="What's on your mind?"
                   value="{{ old('task') }}" required>
            <button class="add" type="submit">ADD +</button>
        </form>

        <ol class="task-list">
            @foreach ($tasks as $index => $task)
                <li class="task-item">

                    @if ($editIndex !== null && $editIndex == $index)

                        <form class="edit-form"
                              action="/edit/{{ $index }}" method="POST">
                            @csrf
                            <input type="text" name="task"
                                   value="{{ $task['name'] }}" required>
                            <button class="edit" type="submit">SAVE</button>
                        </form>

                    @else

                        <span class="{{ $task['completed'] ? 'completed' : '' }}">
                            {{ $task['name'] }}
                        </span>

                        <div class="task-actions">

                            @if (!$task['completed'])
                                <form action="/complete/{{ $index }}" method="POST">
                                    @csrf
                                    <button class="complete" type="submit">DONE ✓</button>
                                </form>
                            @endif

                            <a href="/edit/{{ $index }}">
                                <button class="edit" type="button">EDIT</button>
                            </a>

                            <form action="/delete/{{ $index }}" method="POST">
                                @csrf
                                <button class="delete" type="submit">DELETE</button>
                            </form>

                        </div>
                    @endif

                </li>
            @endforeach
        </ol>

    </div>
</body>
</html>