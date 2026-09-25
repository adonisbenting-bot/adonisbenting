<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        body { padding: 20px; }
        .container { max-width: 760px; }
        .card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 12px; }
        label { display: block; font-weight: bold; margin-bottom: 4px; }
        input, textarea, select { width: 100%; padding: 8px; box-sizing: border-box; }
        button, .cancel-link { background: #007bff; color: white; border: none; padding: 10px 15px; border-radius: 4px; cursor: pointer; text-decoration: none; display: inline-block; }
        .cancel-link { background: #6c757d; }
    </style>
</head>
<body>
<div class="container">
<div class="card">
<h1>Edit Task</h1>

<form action="{{ route('tasks.update', $task) }}" method="POST">
    @csrf
    @method('PUT')

        <div class="form-group">
            <label for="task_name">Task Name</label>
            <input id="task_name" type="text" name="task_name" value="{{ old('task_name', $task->task_name) }}" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="3">{{ old('description', $task->description) }}</textarea>
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <select id="status" name="status">
                <option value="Pending" {{ old('status', ucfirst($task->status)) === 'Pending' ? 'selected' : '' }}>Pending</option>
                <option value="Completed" {{ old('status', ucfirst($task->status)) === 'Completed' ? 'selected' : '' }}>Completed</option>
            </select>
        </div>

        <div class="form-group">
            <label for="due_date">Due Date</label>
            <input id="due_date" type="date" name="due_date" value="{{ old('due_date', optional($task->due_date)->format('Y-m-d')) }}">
        </div>

    <div>
        <button type="submit">Update Task</button>
        <a class="cancel-link" href="{{ route('tasks.index') }}">Cancel</a>
    </div>
</form>
</div>
</div>
</body>
</html>
