<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My To-Do List</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .header {
            text-align: center;
            color: white;
            margin-bottom: 30px;
        }
        .header h1 { font-size: 2.5rem; font-weight: 700; }
        .header p { font-size: 1rem; opacity: 0.85; margin-top: 5px; }
        .header .meta {
            font-size: 0.9rem;
            opacity: 0.75;
            margin-top: 5px;
        }
        .logout-btn {
            position: absolute;
            top: 20px;
            right: 30px;
            background: rgba(255,255,255,0.2);
            color: white;
            border: 1px solid rgba(255,255,255,0.4);
            padding: 8px 16px;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            font-size: 0.85rem;
        }
        .logout-btn:hover { background: rgba(255,255,255,0.35); }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            gap: 25px;
            align-items: flex-start;
        }
        /* LEFT PANEL */
        .left-panel {
            background: white;
            border-radius: 16px;
            padding: 25px;
            width: 300px;
            min-width: 300px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
        }
        .left-panel h2 {
            font-size: 1.2rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f0f0f0;
        }
        .form-group { margin-bottom: 16px; }
        .form-group label {
            display: block;
            font-size: 0.82rem;
            font-weight: 600;
            color: #555;
            margin-bottom: 6px;
        }
        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 10px 12px;
            border: 1.5px solid #e0e0e0;
            border-radius: 8px;
            font-size: 0.88rem;
            color: #333;
            outline: none;
            transition: border 0.2s;
        }
        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            border-color: #667eea;
        }
        .form-group textarea { resize: vertical; height: 80px; }
        .add-btn {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            margin-top: 5px;
        }
        .add-btn:hover { opacity: 0.9; }
        /* RIGHT PANEL */
        .right-panel {
            flex: 1;
            background: white;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
        }
        .right-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .right-header h2 {
            font-size: 1.2rem;
            font-weight: 700;
            color: #333;
        }
        .search-filter {
            display: flex;
            gap: 10px;
            align-items: center;
        }
        .search-filter input {
            padding: 8px 14px;
            border: 1.5px solid #e0e0e0;
            border-radius: 8px;
            font-size: 0.85rem;
            outline: none;
            width: 180px;
        }
        .search-filter input:focus { border-color: #667eea; }
        .search-filter select {
            padding: 8px 12px;
            border: 1.5px solid #e0e0e0;
            border-radius: 8px;
            font-size: 0.85rem;
            outline: none;
        }
        /* TABLE */
        table { width: 100%; border-collapse: collapse; }
        thead th {
            background: #f8f9ff;
            padding: 12px 14px;
            text-align: left;
            font-size: 0.82rem;
            font-weight: 700;
            color: #666;
            border-bottom: 2px solid #eee;
        }
        tbody tr { border-bottom: 1px solid #f0f0f0; transition: background 0.2s; }
        tbody tr:hover { background: #fafbff; }
        tbody td { padding: 13px 14px; font-size: 0.88rem; color: #333; vertical-align: middle; }
        .task-title { font-weight: 600; color: #222; }
        .task-desc { font-size: 0.78rem; color: #888; margin-top: 2px; }
        /* BADGES */
        .badge {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-block;
        }
        .badge-high { background: #ffe0e0; color: #e53e3e; }
        .badge-medium { background: #fff3cd; color: #d69e2e; }
        .badge-low { background: #e0f4e8; color: #38a169; }
        .badge-pending { background: #fff3cd; color: #d69e2e; }
        .badge-completed { background: #e0f4e8; color: #38a169; }
        /* ACTION BUTTONS */
        .action-btns { display: flex; gap: 6px; }
        .btn-edit {
            background: #4299e1;
            color: white;
            border: none;
            padding: 6px 10px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.8rem;
        }
        .btn-complete {
            background: #48bb78;
            color: white;
            border: none;
            padding: 6px 10px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.8rem;
        }
        .btn-delete {
            background: #fc8181;
            color: white;
            border: none;
            padding: 6px 10px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.8rem;
        }
        .btn-edit:hover { background: #3182ce; }
        .btn-complete:hover { background: #38a169; }
        .btn-delete:hover { background: #e53e3e; }
        .empty-msg {
            text-align: center;
            padding: 40px;
            color: #aaa;
            font-size: 0.95rem;
        }
        /* ALERT */
        .alert {
            padding: 10px 16px;
            border-radius: 8px;
            margin-bottom: 16px;
            font-size: 0.88rem;
            background: #e0f4e8;
            color: #38a169;
            border: 1px solid #c6f6d5;
        }
        /* MODAL */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 999;
            justify-content: center;
            align-items: center;
        }
        .navbar {
    background: linear-gradient(135deg, #667eea, #764ba2);
    padding: 15px 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}
.brand { color: white; font-size: 1.3rem; font-weight: 700; text-decoration: none; }
.navbar-links { display: flex; gap: 10px; align-items: center; }
.nav-link { color: rgba(255,255,255,0.85); text-decoration: none; padding: 7px 14px; border-radius: 8px; font-size: 0.88rem; }
.nav-link:hover, .nav-link.active { background: rgba(255,255,255,0.2); color: white; }
.nav-user { color: white; font-size: 0.85rem; }
.logout-btn { background: rgba(255,255,255,0.15); color: white; border: 1px solid rgba(255,255,255,0.3); padding: 7px 14px; border-radius: 8px; cursor: pointer; font-size: 0.85rem; }
        .modal-overlay.active { display: flex; }
        .modal {
            background: white;
            border-radius: 16px;
            padding: 30px;
            width: 420px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        .modal h3 {
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 20px;
            color: #333;
        }
        .modal-btns {
            display: flex;
            gap: 10px;
            margin-top: 20px;
            justify-content: flex-end;
        }
        .btn-cancel {
            padding: 10px 20px;
            background: #eee;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 0.9rem;
        }
        .btn-save {
            padding: 10px 20px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 0.9rem;
            font-weight: 600;
        }
    </style>
</head>
<body>

{{-- Logout --}}
<form method="POST" action="{{ route('logout') }}" style="display:inline">
    @csrf
   <nav class="navbar">
    <a href="{{ route('dashboard') }}" class="brand">📝 TodoApp</a>
    <div class="navbar-links">
        <a href="{{ route('dashboard') }}" class="nav-link">📊 Dashboard</a>
        <a href="{{ route('todos.index') }}" class="nav-link active">✅ My Tasks</a>
        <span class="nav-user">👤 {{ auth()->user()->name }}</span>
        <form method="POST" action="{{ route('logout') }}" style="display:inline">
            @csrf
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>
</nav>
</form>

{{-- Header --}}
<div class="header">
    <h1>📝 My To-Do List</h1>
    <p>Stay organized and get things done.</p>
    <div class="meta">
        {{ now()->format('l, d M Y') }}
    </div>
</div>

<div class="container">
    {{-- LEFT PANEL --}}
    <div class="left-panel">
        <h2>➕ Add New Task</h2>

        @if(session('success'))
            <div class="alert">✅ {{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('todos.store') }}">
            @csrf
            <div class="form-group">
                <label>Task Title</label>
                <input type="text" name="title" placeholder="Enter task title" required />
            </div>
            <div class="form-group">
                <label>Task Description</label>
                <textarea name="description" placeholder="Enter task description"></textarea>
            </div>
            <div class="form-group">
                <label>Due Date</label>
                <input type="date" name="due_date" />
            </div>
            <div class="form-group">
                <label>Priority</label>
                <select name="priority">
                    <option value="Medium">Medium</option>
                    <option value="High">High</option>
                    <option value="Low">Low</option>
                </select>
            </div>
            <button type="submit" class="add-btn">Add Task</button>
        </form>
    </div>

    {{-- RIGHT PANEL --}}
    <div class="right-panel">
        <div class="right-header">
            <h2>📋 All Tasks</h2>
            <form method="GET" action="{{ route('todos.index') }}" class="search-filter">
                <input type="text" name="search" placeholder="🔍 Search tasks..."
                    value="{{ request('search') }}" />
                <select name="status" onchange="this.form.submit()">
                    <option value="All" {{ request('status') == 'All' ? 'selected' : '' }}>All</option>
                    <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                </select>
                <button type="submit" class="btn-edit">Go</button>
            </form>
        </div>

        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Due Date</th>
                    <th>Priority</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($todos as $index => $todo)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <div class="task-title {{ $todo->completed ? 'text-decoration: line-through' : '' }}">
                            {{ $todo->title }}
                        </div>
                        @if($todo->description)
                            <div class="task-desc">{{ $todo->description }}</div>
                        @endif
                    </td>
                    <td>{{ $todo->due_date ? $todo->due_date->format('d M Y') : '—' }}</td>
                    <td>
                        <span class="badge badge-{{ strtolower($todo->priority) }}">
                            {{ $todo->priority }}
                        </span>
                    </td>
                    <td>
                        <span class="badge {{ $todo->completed ? 'badge-completed' : 'badge-pending' }}">
                            {{ $todo->completed ? 'Completed' : 'Pending' }}
                        </span>
                    </td>
                    <td>
                        <div class="action-btns">
                            {{-- Edit --}}
                            <button class="btn-edit"
                                onclick="openEdit({{ $todo->id }}, '{{ addslashes($todo->title) }}', '{{ addslashes($todo->description) }}', '{{ $todo->due_date?->format('Y-m-d') }}', '{{ $todo->priority }}')">
                                ✏️
                            </button>
                            {{-- Toggle Complete --}}
                            <form method="POST" action="{{ route('todos.toggle', $todo) }}">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn-complete">
                                    {{ $todo->completed ? '↩️' : '✅' }}
                                </button>
                            </form>
                            {{-- Delete --}}
                            <form method="POST" action="{{ route('todos.destroy', $todo) }}"
                                onsubmit="return confirm('Delete this task?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-delete">🗑️</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="empty-msg">No tasks yet. Add one! 👆</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- EDIT MODAL --}}
<div class="modal-overlay" id="editModal">
    <div class="modal">
        <h3>✏️ Edit Task</h3>
        <form method="POST" id="editForm">
            @csrf @method('PATCH')
            <div class="form-group">
                <label>Task Title</label>
                <input type="text" name="title" id="editTitle" required />
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" id="editDesc"></textarea>
            </div>
            <div class="form-group">
                <label>Due Date</label>
                <input type="date" name="due_date" id="editDate" />
            </div>
            <div class="form-group">
                <label>Priority</label>
                <select name="priority" id="editPriority">
                    <option value="High">High</option>
                    <option value="Medium">Medium</option>
                    <option value="Low">Low</option>
                </select>
            </div>
            <div class="modal-btns">
                <button type="button" class="btn-cancel" onclick="closeEdit()">Cancel</button>
                <button type="submit" class="btn-save">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEdit(id, title, desc, date, priority) {
        document.getElementById('editForm').action = '/todos/' + id;
        document.getElementById('editTitle').value = title;
        document.getElementById('editDesc').value = desc;
        document.getElementById('editDate').value = date;
        document.getElementById('editPriority').value = priority;
        document.getElementById('editModal').classList.add('active');
    }
    function closeEdit() {
        document.getElementById('editModal').classList.remove('active');
    }
    // Close modal on outside click
    document.getElementById('editModal').addEventListener('click', function(e) {
        if (e.target === this) closeEdit();
    });
</script>

</body>
</html>