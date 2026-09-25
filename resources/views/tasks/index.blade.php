<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        body { font-family: sans-serif; background: #f4f6f9; margin: 0; padding: 20px; }
        .container { display: flex; gap: 20px; max-width: 1000px; margin: auto; }
        .card { background: white; padding: 20px; border-radius: 8px; flex: 1; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 12px; }
        label { display: block; font-weight: bold; margin-bottom: 4px; }
        input, textarea, select { width: 100%; padding: 8px; box-sizing: border-box; }
        button { background: #007bff; color: white; border: none; padding: 10px 15px; border-radius: 4px; cursor: pointer; }
        .task-item { border-bottom: 1px solid #eee; padding: 10px 0; display: flex; justify-content: space-between; align-items: center; }
        .badge { padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold; text-decoration: none; display: inline-block; }
        .badge-pending { background: #ffc107; color: #000; }
        .badge-completed { background: #28a745; color: #fff; }
        .actions { display: flex; gap: 8px; align-items: center; }
        .btn-danger { background: #dc3545; }
    </style>
</head>
<body>

<div class="container">
    <!-- ADD TASK FORM -->
    <div class="card">
        <h1>Task Manager</h1>
        <h2>Add a Task</h2>
        <form action="{{ route('tasks.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Task Name</label>
                <input type="text" name="task_name" required>
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label>Due Date</label>
                <input type="date" name="due_date">
            </div>
            <div class="form-group">
                <label>Status</label>
                <select name="status">
                    <option value="Pending">Pending</option>
                    <option value="Completed">Completed</option>
                </select>
            </div>
            <button type="submit">Add Task</button>
        </form>
    </div>

    <!-- VIEW TASKS LIST -->
    <div class="card">
        <h2>Your Tasks</h2>
        @if($tasks->isEmpty())
            <p>No tasks yet.</p>
        @else
            @foreach($tasks as $task)
                <div class="task-item">
                    <div>
                        <strong>{{ $task->task_name }}</strong>
                        <p style="margin: 4px 0; color: #666;">{{ $task->description }}</p>
                        <small>Due: {{ $task->due_date ?? 'N/A' }}</small>
                    </div>
                    <div class="actions">
                        <!-- UPDATE STATUS TOGGLE -->
                        <form action="{{ route('tasks.updateStatus', $task) }}" method="POST" style="margin:0;">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="badge {{ strtolower($task->status) === 'completed' ? 'badge-completed' : 'badge-pending' }}">
                                {{ ucfirst($task->status) }}
                            </button>
                        </form>

                        <!-- EDIT TASK -->
                        <a href="{{ route('tasks.edit', $task) }}" style="text-decoration: none; color: #007bff;">Edit</a>

                        <!-- DELETE TASK -->
                        <form action="{{ route('tasks.destroy', $task) }}" method="POST" style="margin:0;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-danger" onclick="return confirm('Delete this task?')">Delete</button>
                        </form>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>

</body>
</html>