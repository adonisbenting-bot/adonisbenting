@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-6">Add New Task</h1>

<form action="/tasks" method="POST" class="space-y-4">
    @csrf
    <div>
        <label class="block text-sm font-medium mb-1">Task Name *</label>
        <input type="text" name="task_name" required class="w-full border rounded-md p-2">
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Description</label>
        <textarea name="description" rows="3" class="w-full border rounded-md p-2"></textarea>
    </div>

    <div>
        <label class="block text-sm font-medium mb-1">Due Date</label>
        <input type="date" name="due_date" class="w-full border rounded-md p-2">
    </div>

    <div class="flex space-x-2 pt-2">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Save Task</button>
        <a href="/tasks" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400">Cancel</a>
    </div>
</form>
@endsection
