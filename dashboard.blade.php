<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Todo. — Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=DM+Serif+Display&display=swap" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.js"></script>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --peach: #F2A58E; --peach-lt: #FAD9CE; --peach-bg: #FDF0EB;
            --teal: #4ECBA5; --yellow: #F5C842; --blue: #6B9EE2; --pink: #E87B8C;
            --text: #1C1C2E; --muted: #9B9BAE; --white: #FFFFFF; --bg: #F7F3EF;
            --sidebar-w: 195px; --r: 18px;
        }
        body { font-family: 'DM Sans', sans-serif; background: var(--bg); color: var(--text); display: flex; min-height: 100vh; }
        .sidebar { width: var(--sidebar-w); background: var(--white); min-height: 100vh; position: fixed; top: 0; left: 0; display: flex; flex-direction: column; padding: 26px 14px; gap: 22px; border-right: 1px solid #F0EDE8; z-index: 100; }
        .logo { display: flex; align-items: center; gap: 9px; font-family: 'DM Serif Display', serif; font-size: 20px; color: var(--text); padding-left: 4px; }
        .logo-box { width: 30px; height: 30px; background: var(--peach); border-radius: 8px; display: flex; align-items: center; justify-content: center; }
        .logo-box svg { width: 16px; height: 16px; fill: none; stroke: white; stroke-width: 2.2; }
        .create-btn { background: linear-gradient(135deg, var(--peach), #E0664E); color: white; border: none; border-radius: 12px; padding: 11px; font-size: 13px; font-weight: 500; cursor: pointer; width: 100%; transition: opacity .15s; }
        .create-btn:hover { opacity: .9; }
        .nav-section { display: flex; flex-direction: column; gap: 2px; }
        .nav-label { font-size: 10px; color: var(--muted); text-transform: uppercase; letter-spacing: .09em; padding: 0 8px; margin-bottom: 5px; }
        .nav-item { display: flex; align-items: center; gap: 9px; padding: 8px 10px; border-radius: 10px; font-size: 13px; color: #666; cursor: pointer; text-decoration: none; transition: background .15s, color .15s; }
        .nav-item svg { width: 16px; height: 16px; flex-shrink: 0; stroke: currentColor; fill: none; stroke-width: 1.8; }
        .nav-item:hover, .nav-item.active { background: var(--peach-bg); color: var(--peach); }
        .nav-arrow { margin-left: auto; opacity: .35; font-size: 13px; }
        .main { margin-left: var(--sidebar-w); flex: 1; padding: 26px 26px 48px; }
        .topbar { display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; }
        .topbar h2 { font-family: 'DM Serif Display', serif; font-size: 21px; }
        .topbar p { font-size: 12px; color: var(--muted); margin-top: 2px; }
        .topbar-right { display: flex; align-items: center; gap: 10px; }
        .icon-btn { width: 36px; height: 36px; background: var(--white); border: 1px solid #EEE; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; }
        .icon-btn svg { width: 16px; height: 16px; stroke: var(--muted); fill: none; stroke-width: 1.8; }
        .avatar { width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(135deg, var(--peach), var(--pink)); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 13px; }
        .hero-row { display: grid; grid-template-columns: 1fr 1.8fr 0.95fr; gap: 15px; margin-bottom: 16px; }
        .welcome-card { background: linear-gradient(145deg, #FAD9CE, #F5C3B0); border-radius: var(--r); padding: 26px 22px 22px; position: relative; overflow: hidden; min-height: 168px; display: flex; flex-direction: column; justify-content: flex-end; }
        .welcome-card::before { content: ''; position: absolute; top: -28px; right: -28px; width: 120px; height: 120px; background: rgba(242,165,142,.3); border-radius: 50%; }
        .welcome-card::after { content: ''; position: absolute; top: 16px; right: 58px; width: 65px; height: 65px; background: rgba(245,200,66,.22); border-radius: 50%; }
        .welcome-card h3 { font-size: 12px; color: #9E6350; font-weight: 400; }
        .welcome-card h2 { font-family: 'DM Serif Display', serif; font-size: 25px; color: #3D1F10; margin-top: 3px; }
        .wc-tag { display: inline-block; margin-top: 12px; background: rgba(255,255,255,.5); color: #8B5040; font-size: 11px; padding: 4px 14px; border-radius: 20px; }
        .wc-emoji { position: absolute; top: 18px; right: 18px; font-size: 48px; opacity: .2; }
        .inbox-card { background: var(--white); border-radius: var(--r); padding: 24px 22px; min-height: 168px; display: flex; flex-direction: column; justify-content: space-between; }
        .ic-label { font-size: 12px; color: var(--muted); }
        .ic-num { font-family: 'DM Serif Display', serif; font-size: 50px; color: var(--text); line-height: 1; margin-top: 4px; }
        .ic-sub { font-size: 11px; color: var(--muted); margin-top: 3px; }
        .prog-bar { height: 5px; background: #F0EDE8; border-radius: 10px; overflow: hidden; }
        .prog-fill { height: 100%; background: linear-gradient(90deg, var(--peach), #E0664E); border-radius: 10px; }
        .mini-stats { display: flex; flex-direction: column; gap: 11px; }
        .mini-stat { background: var(--white); border-radius: 14px; padding: 13px 15px; display: flex; align-items: center; justify-content: space-between; }
        .ms-label { font-size: 10px; color: var(--muted); margin-bottom: 2px; }
        .ms-val { font-size: 20px; font-weight: 600; }
        .ms-sub { font-size: 10px; color: var(--muted); }
        .mini-ring { width: 46px; height: 46px; }
        .stat-cards { display: grid; grid-template-columns: repeat(4,1fr); gap: 14px; margin-bottom: 16px; }
        .stat-card { border-radius: 16px; padding: 20px 18px; color: white; position: relative; overflow: hidden; }
        .sc-peach  { background: linear-gradient(135deg,#F2A58E,#E0664E); }
        .sc-teal   { background: linear-gradient(135deg,#4ECBA5,#2AA880); }
        .sc-blue   { background: linear-gradient(135deg,#6B9EE2,#4278C0); }
        .sc-yellow { background: linear-gradient(135deg,#F5C842,#E0A000); }
        .sc-emoji { font-size: 26px; margin-bottom: 10px; display: block; }
        .sc-val { font-size: 32px; font-weight: 600; line-height: 1; }
        .sc-lbl { font-size: 12px; margin-top: 4px; opacity: .85; }
        .sc-bg { position: absolute; right: -12px; bottom: -12px; font-size: 66px; opacity: .12; }
        .charts-row { display: grid; grid-template-columns: 1.1fr 1.1fr 1fr; gap: 15px; margin-bottom: 16px; }
        .chart-card { background: var(--white); border-radius: var(--r); padding: 20px; }
        .chart-card h4 { font-size: 14px; font-weight: 500; margin-bottom: 14px; }
        .chart-wrap { position: relative; width: 100%; height: 188px; }
        .chart-legend { display: flex; flex-wrap: wrap; gap: 12px; margin-top: 10px; font-size: 11px; color: var(--muted); }
        .leg { display: flex; align-items: center; gap: 5px; }
        .leg-dot { width: 9px; height: 9px; border-radius: 2px; flex-shrink: 0; }
        .tasks-section { background: var(--white); border-radius: var(--r); padding: 22px; }
        .tasks-hd { display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; }
        .tasks-hd h4 { font-size: 15px; font-weight: 500; }
        .tasks-hd p { font-size: 11px; color: var(--muted); margin-top: 2px; }
        .filter-tabs { display: flex; gap: 6px; }
        .ftab { padding: 6px 14px; border-radius: 20px; font-size: 12px; border: 1px solid #EEE; cursor: pointer; background: transparent; color: var(--muted); font-family: 'DM Sans', sans-serif; transition: all .15s; }
        .ftab.active, .ftab:hover { background: var(--peach); color: white; border-color: var(--peach); }
        table { width: 100%; border-collapse: collapse; }
        thead th { text-align: left; font-size: 11px; color: var(--muted); font-weight: 500; text-transform: uppercase; letter-spacing: .06em; padding: 0 14px 12px; border-bottom: 1px solid #F0EDE8; }
        tbody tr { border-bottom: 1px solid #F8F5F2; transition: background .12s; }
        tbody tr:hover { background: var(--peach-bg); }
        tbody tr:last-child { border-bottom: none; }
        tbody td { padding: 12px 14px; font-size: 13px; vertical-align: middle; }
        .task-name { font-weight: 500; }
        .task-desc { font-size: 11px; color: var(--muted); margin-top: 2px; }
        .badge { display: inline-block; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 500; }
        .b-done    { background: #D4F4E8; color: #0D6E45; }
        .b-pending { background: #FFF0E0; color: #9B5A00; }
        .p-dot { width: 8px; height: 8px; border-radius: 50%; display: inline-block; margin-right: 5px; }
        .p-high   { background: #E87B8C; }
        .p-medium { background: #F5C842; }
        .p-low    { background: #4ECBA5; }
        .btn-edit { padding: 5px 12px; background: var(--peach-bg); color: var(--peach); border-radius: 8px; font-size: 12px; text-decoration: none; font-weight: 500; display: inline-block; }
        .btn-del { padding: 5px 12px; background: #FEE8E8; color: #C0392B; border: none; border-radius: 8px; font-size: 12px; cursor: pointer; font-weight: 500; font-family: 'DM Sans', sans-serif; }
        .empty-state { text-align: center; padding: 40px 20px; color: var(--muted); }
        .empty-state .es-emoji { font-size: 42px; margin-bottom: 10px; }
        @keyframes fadeUp { from { opacity:0; transform:translateY(12px); } to { opacity:1; transform:translateY(0); } }
        .hero-row      { animation: fadeUp .4s ease both; }
        .stat-cards    { animation: fadeUp .4s .08s ease both; }
        .charts-row    { animation: fadeUp .4s .16s ease both; }
        .tasks-section { animation: fadeUp .4s .24s ease both; }
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-thumb { background: #DDD; border-radius: 10px; }
    </style>
</head>
<body>

<aside class="sidebar">
    <div class="logo">
        <div class="logo-box">
            <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
        </div>
        Todo.
    </div>
    <button class="create-btn" onclick="window.location='{{ route('todos.index') }}'">+ Create New Task</button>
    <nav class="nav-section">
        <div class="nav-label">Main</div>
        <a href="{{ route('dashboard') }}" class="nav-item active">
            <svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
            Dashboard <span class="nav-arrow">›</span>
        </a>
        <a href="{{ route('todos.index') }}" class="nav-item">
            <svg viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            All Tasks <span class="nav-arrow">›</span>
        </a>
        <a href="{{ route('todos.index') }}?filter=pending" class="nav-item">
            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            Pending <span class="nav-arrow">›</span>
        </a>
        <a href="{{ route('todos.index') }}?filter=completed" class="nav-item">
            <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
            Completed <span class="nav-arrow">›</span>
        </a>
    </nav>
    <nav class="nav-section">
        <div class="nav-label">Account</div>
        <a href="{{ route('profile.edit') }}" class="nav-item">
            <svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
            Profile <span class="nav-arrow">›</span>
        </a>
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('lf').submit();" class="nav-item">
            <svg viewBox="0 0 24 24"><path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h6a2 2 0 012 2v1"/></svg>
            Logout <span class="nav-arrow">›</span>
        </a>
        <form id="lf" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>
    </nav>
</aside>

<main class="main">

    <div class="topbar">
        <div>
            <h2>{{ now()->hour < 12 ? 'Good Morning' : (now()->hour < 17 ? 'Good Afternoon' : 'Good Evening') }}, {{ Auth::user()->name }} 👋</h2>
            <p>{{ now()->format('l, d F Y') }} — Here's your task overview</p>
        </div>
        <div class="topbar-right">
            <div class="icon-btn"><svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg></div>
            <div class="icon-btn"><svg viewBox="0 0 24 24"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 01-3.46 0"/></svg></div>
            <div class="avatar">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</div>
        </div>
    </div>

    <div class="hero-row">
        <div class="welcome-card">
            <div class="wc-emoji">📋</div>
            <h3>Welcome back!</h3>
            <h2>{{ Auth::user()->name }}</h2>
            <span class="wc-tag">📍 Task Manager</span>
        </div>
        <div class="inbox-card">
            <div>
                <div class="ic-label">All Tasks</div>
                <div class="ic-num">{{ $totalTasks }}</div>
                <div class="ic-sub">{{ $completedTasks }} completed &nbsp;·&nbsp; {{ $pendingTasks }} pending</div>
            </div>
            <div>
                <div style="display:flex;justify-content:space-between;font-size:11px;color:var(--muted);margin-bottom:5px;">
                    <span>Overall Progress</span>
                    <span>{{ $totalTasks > 0 ? round(($completedTasks/$totalTasks)*100) : 0 }}%</span>
                </div>
                <div class="prog-bar">
                    <div class="prog-fill" style="width:{{ $totalTasks > 0 ? round(($completedTasks/$totalTasks)*100) : 0 }}%"></div>
                </div>
            </div>
        </div>
        <div class="mini-stats">
            <div class="mini-stat">
                <div>
                    <div class="ms-label">Completed</div>
                    <div class="ms-val" style="color:#4ECBA5;">{{ $completedTasks }}</div>
                    <div class="ms-sub">tasks done ✅</div>
                </div>
                <canvas class="mini-ring" id="ringDone"></canvas>
            </div>
            <div class="mini-stat">
                <div>
                    <div class="ms-label">Pending</div>
                    <div class="ms-val" style="color:#F2A58E;">{{ $pendingTasks }}</div>
                    <div class="ms-sub">tasks left ⏳</div>
                </div>
                <canvas class="mini-ring" id="ringPending"></canvas>
            </div>
        </div>
    </div>

    <div class="stat-cards">
        <div class="stat-card sc-peach">
            <span class="sc-emoji">📋</span>
            <div class="sc-val">{{ $totalTasks }}</div>
            <div class="sc-lbl">Total Tasks</div>
            <div class="sc-bg">📋</div>
        </div>
        <div class="stat-card sc-teal">
            <span class="sc-emoji">✅</span>
            <div class="sc-val">{{ $completedTasks }}</div>
            <div class="sc-lbl">Completed</div>
            <div class="sc-bg">✅</div>
        </div>
        <div class="stat-card sc-blue">
            <span class="sc-emoji">⏳</span>
            <div class="sc-val">{{ $pendingTasks }}</div>
            <div class="sc-lbl">Pending</div>
            <div class="sc-bg">⏳</div>
        </div>
        <div class="stat-card sc-yellow">
            <span class="sc-emoji">📊</span>
            <div class="sc-val">{{ $totalTasks > 0 ? round(($completedTasks/$totalTasks)*100) : 0 }}%</div>
            <div class="sc-lbl">Completion Rate</div>
            <div class="sc-bg">📊</div>
        </div>
    </div>

    <div class="charts-row">
        <div class="chart-card">
            <h4>Task Distribution</h4>
            <div class="chart-wrap"><canvas id="donutChart"></canvas></div>
            <div class="chart-legend">
                <span class="leg"><span class="leg-dot" style="background:#4ECBA5;"></span>Completed</span>
                <span class="leg"><span class="leg-dot" style="background:#F2A58E;"></span>Pending</span>
            </div>
        </div>
        <div class="chart-card">
            <h4>Weekly Activity</h4>
            <div class="chart-wrap"><canvas id="barChart"></canvas></div>
        </div>
        <div class="chart-card">
            <h4>Monthly Trend</h4>
            <div class="chart-wrap"><canvas id="lineChart"></canvas></div>
        </div>
    </div>

    <div class="tasks-section">
        <div class="tasks-hd">
            <div>
                <h4>Recent Tasks</h4>
                <p>Overview of your latest tasks</p>
            </div>
            <div class="filter-tabs">
                <button class="ftab active" onclick="filterTasks('all',this)">All</button>
                <button class="ftab" onclick="filterTasks('completed',this)">Completed</button>
                <button class="ftab" onclick="filterTasks('pending',this)">Pending</button>
            </div>
        </div>

        @if($recentTasks->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>#</th><th>Task</th><th>Priority</th><th>Status</th><th>Date</th><th>Actions</th>
                </tr>
            </thead>
            <tbody id="taskBody">
                @foreach($recentTasks as $i => $task)
                <tr data-status="{{ $task->completed ? 'completed' : 'pending' }}">
                    <td style="color:var(--muted);font-size:12px;">{{ $i+1 }}</td>
                    <td>
                        <div class="task-name">{{ $task->title }}</div>
                        @if(isset($task->description) && $task->description)
                        <div class="task-desc">{{ Str::limit($task->description, 45) }}</div>
                        @endif
                    </td>
                    <td>
                        @php $p = $task->priority ?? 'medium'; @endphp
                        <span class="p-dot p-{{ $p }}"></span>{{ ucfirst($p) }}
                    </td>
                    <td>
                        @if($task->completed)
                            <span class="badge b-done">✓ Completed</span>
                        @else
                            <span class="badge b-pending">⏳ Pending</span>
                        @endif
                    </td>
                    <td style="color:var(--muted);font-size:12px;">{{ $task->created_at->format('d M Y') }}</td>
                    <td>
                        <div style="display:flex;gap:6px;align-items:center;">
                            <a href="{{ route('todos.edit', $task->id) }}" class="btn-edit">Edit</a>
                            <form action="{{ route('todos.destroy', $task->id) }}" method="POST" onsubmit="return confirm('Delete this task?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-del">Del</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="empty-state">
            <div class="es-emoji">📭</div>
            <p>No tasks yet! <a href="{{ route('todos.index') }}" style="color:var(--peach);font-weight:500;">Create your first task →</a></p>
        </div>
        @endif
    </div>

</main>

<script>
const completed = {{ $completedTasks }};
const pending   = {{ $pendingTasks }};
const total     = {{ $totalTasks }};
const wLabels   = @json($weeklyLabels);
const wData     = @json($weeklyData);
const mLabels   = @json($monthlyLabels);
const mData     = @json($monthlyData);
const grid = 'rgba(0,0,0,0.05)';
const muted = '#9B9BAE';

new Chart(document.getElementById('donutChart'), {
    type:'doughnut',
    data:{ labels:['Completed','Pending'], datasets:[{ data:[completed,pending], backgroundColor:['#4ECBA5','#F2A58E'], borderWidth:0, hoverOffset:8 }] },
    options:{ responsive:true, maintainAspectRatio:false, cutout:'68%', plugins:{ legend:{display:false} } }
});
new Chart(document.getElementById('barChart'), {
    type:'bar',
    data:{ labels:wLabels, datasets:[{ data:wData, backgroundColor:['#F2A58E','#4ECBA5','#6B9EE2','#F5C842','#E87B8C','#4ECBA5','#F2A58E'], borderRadius:8, borderSkipped:false }] },
    options:{ responsive:true, maintainAspectRatio:false, plugins:{legend:{display:false}}, scales:{ x:{grid:{color:grid},ticks:{color:muted,font:{size:11}}}, y:{grid:{color:grid},ticks:{color:muted,font:{size:11},stepSize:1},beginAtZero:true} } }
});
new Chart(document.getElementById('lineChart'), {
    type:'line',
    data:{ labels:mLabels, datasets:[{ data:mData, borderColor:'#F2A58E', backgroundColor:'rgba(242,165,142,0.12)', fill:true, tension:0.42, pointBackgroundColor:'#F2A58E', pointRadius:5, borderWidth:2.5 }] },
    options:{ responsive:true, maintainAspectRatio:false, plugins:{legend:{display:false}}, scales:{ x:{grid:{color:grid},ticks:{color:muted,font:{size:11}}}, y:{grid:{color:grid},ticks:{color:muted,font:{size:11},stepSize:1},beginAtZero:true} } }
});
new Chart(document.getElementById('ringDone'), {
    type:'doughnut',
    data:{ datasets:[{ data:[completed, Math.max(total-completed,0)], backgroundColor:['#4ECBA5','#F0EDE8'], borderWidth:0 }] },
    options:{ responsive:false, cutout:'72%', plugins:{legend:{display:false},tooltip:{enabled:false}} }
});
new Chart(document.getElementById('ringPending'), {
    type:'doughnut',
    data:{ datasets:[{ data:[pending, Math.max(total-pending,0)], backgroundColor:['#F2A58E','#F0EDE8'], borderWidth:0 }] },
    options:{ responsive:false, cutout:'72%', plugins:{legend:{display:false},tooltip:{enabled:false}} }
});

function filterTasks(status, btn) {
    document.querySelectorAll('.ftab').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    document.querySelectorAll('#taskBody tr').forEach(row => {
        row.style.display = (status==='all' || row.dataset.status===status) ? '' : 'none';
    });
}
</script>
</body>
</html>
