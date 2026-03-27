<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel | Questionnaire System</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --bg: #f8fafc;
            --sidebar: #1e293b;
            --text: #334155;
            --text-light: #64748b;
            --white: #ffffff;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --border: #e2e8f0;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: var(--bg); color: var(--text); display: flex; min-height: 100vh; }
        
        /* Sidebar */
        .sidebar { width: 260px; background: var(--sidebar); color: #94a3b8; display: flex; flex-direction: column; position: fixed; height: 100vh; }
        .sidebar-header { padding: 2rem; font-size: 1.25rem; font-weight: 700; color: #fff; border-bottom: 1px solid #334155; }
        .nav { flex: 1; padding: 1rem 0; }
        .nav-item { padding: 0.75rem 2rem; display: flex; align-items: center; text-decoration: none; color: inherit; transition: all 0.2s; }
        .nav-item:hover { background: #334155; color: #fff; }
        .nav-item.active { background: var(--primary); color: #fff; }
        
        /* Main Content */
        .main { margin-left: 260px; flex: 1; padding: 2rem; }
        .top-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
        .page-title { font-size: 1.5rem; font-weight: 700; }
        
        /* Cards & Components */
        .card { background: var(--white); border-radius: 12px; border: 1px solid var(--border); padding: 1.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-bottom: 2rem; }
        .stat-card h3 { color: var(--text-light); font-size: 0.875rem; margin-bottom: 0.5rem; text-transform: uppercase; }
        .stat-card .val { font-size: 2rem; font-weight: 700; color: var(--primary); }
        
        /* Tables */
        table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
        th { text-align: left; padding: 1rem; background: #f1f5f9; font-weight: 600; color: var(--text-light); border-bottom: 1px solid var(--border); }
        td { padding: 1rem; border-bottom: 1px solid var(--border); }
        tr:hover td { background: #f8fafc; }
        
        .badge { padding: 0.25rem 0.75rem; border-radius: 99px; font-size: 0.75rem; font-weight: 600; }
        .badge-success { background: #d1fae5; color: #065f46; }
        .badge-warning { background: #fef3c7; color: #92400e; }
        
        .btn { padding: 0.5rem 1rem; border-radius: 6px; border: none; cursor: pointer; font-weight: 500; transition: all 0.2s; text-decoration: none; display: inline-block; }
        .btn-primary { background: var(--primary); color: #fff; }
        .btn-sm { font-size: 0.875rem; }

        /* Responsive Wrappers */
        .table-responsive { width: 100%; overflow-x: auto; -webkit-overflow-scrolling: touch; }
        .menu-toggle { display: none; background: none; border: none; font-size: 1.5rem; cursor: pointer; color: var(--text); padding: 0.5rem; margin-right: 0.5rem; }
        
        /* Mobile Breakpoint */
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); z-index: 1000; transition: transform 0.3s ease; }
            .sidebar.open { transform: translateX(0); box-shadow: 4px 0 10px rgba(0,0,0,0.1); }
            .main { margin-left: 0; padding: 1rem; }
            .sidebar-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 999; }
            .sidebar-overlay.active { display: block; }
            .menu-toggle { display: block; }
            .top-bar { margin-bottom: 1.5rem; }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">Admin Panel</div>
        <nav class="nav">
            <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->is('admin/dashboard') ? 'active' : '' }}">Dashboard</a>
            <a href="{{ route('admin.sections.index') }}" class="nav-item {{ request()->is('admin/sections*') ? 'active' : '' }}">Manage Sections</a>
            <a href="{{ route('admin.questions') }}" class="nav-item {{ request()->is('admin/questions*') ? 'active' : '' }}">Manage Questions</a>
            <a href="{{ route('admin.responses') }}" class="nav-item {{ request()->is('admin/responses*') ? 'active' : '' }}">View Responses</a>
            <div style="margin-top: auto; padding: 1rem 0;">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="nav-item" style="width:100%; text-align:left; background:none; border:none; cursor:pointer;">Logout</button>
                </form>
            </div>
        </nav>
    </div>
    
    <div class="main">
        <div class="top-bar">
            <div style="display: flex; align-items: center;">
                <button class="menu-toggle" id="menuToggle">☰</button>
                <h1 class="page-title">@yield('title')</h1>
            </div>
            <div class="user-menu">Admin</div>
        </div>
        
        @if(session('success'))
            <div style="background: #d1fae5; color: #064e3b; padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuToggle = document.getElementById('menuToggle');
            const sidebar = document.querySelector('.sidebar');
            
            const overlay = document.createElement('div');
            overlay.className = 'sidebar-overlay';
            document.body.appendChild(overlay);

            if (menuToggle) {
                menuToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('open');
                    overlay.classList.toggle('active');
                    document.body.style.overflow = sidebar.classList.contains('open') ? 'hidden' : '';
                });
            }
            
            overlay.addEventListener('click', function() {
                sidebar.classList.remove('open');
                overlay.classList.remove('active');
                document.body.style.overflow = '';
            });
        });
    </script>
</body>
</html>
