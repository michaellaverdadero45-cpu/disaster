<?php
session_start();
if(!isset($_SESSION['user'])){
    echo "<script>alert('⚠️ Please login first!'); window.location.href='index.php';</script>";
    exit;

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Disaster Management Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: #333;
        }

        .container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 280px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 2px 0 20px rgba(0,0,0,0.1);
            padding: 20px 0;
            transition: all 0.3s ease;
        }

        .logo {
            text-align: center;
            padding: 20px;
            border-bottom: 1px solid #eee;
            margin-bottom: 30px;
        }

        .logo h2 {
            color: #4a5568;
            font-size: 1.5rem;
            font-weight: 700;
        }

        .logo i {
            color: #667eea;
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .nav-menu {
            list-style: none;
        }

        .nav-item {
            margin-bottom: 5px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 16px 24px;
            color: #4a5568;
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
            position: relative;
        }

        .nav-link:hover,
        .nav-link.active {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border-left-color: #fff;
            transform: translateX(5px);
        }

        .nav-link i {
            width: 24px;
            margin-right: 16px;
            font-size: 1.2rem;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            padding: 40px;
            overflow-y: auto;
        }

        .header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            margin-bottom: 40px;
            text-align: center;
        }

        .header h1 {
            color: #2d3748;
            font-size: 2.5rem;
            margin-bottom: 10px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .welcome-text {
            color: #718096;
            font-size: 1.1rem;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            text-align: center;
            transition: all 0.3s ease;
            border-top: 4px solid transparent;
        }

        .stat-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }

        .stat-card.disaster { border-top-color: #f56565; }
        .stat-card.evacuation { border-top-color: #48bb78; }
        .stat-card.people { border-top-color: #ed8936; }
        .stat-card.goods { border-top-color: #667eea; }

        .stat-icon {
            font-size: 3rem;
            margin-bottom: 15px;
        }

        .stat-card.disaster .stat-icon { color: #f56565; }
        .stat-card.evacuation .stat-icon { color: #48bb78; }
        .stat-card.people .stat-icon { color: #ed8936; }
        .stat-card.goods .stat-icon { color: #667eea; }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 5px;
        }

        .stat-label {
            color: #718096;
            font-size: 1.1rem;
            font-weight: 500;
        }

        /* Quick Actions */
        .quick-actions {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .quick-actions h3 {
            color: #2d3748;
            margin-bottom: 25px;
            font-size: 1.5rem;
        }

        .actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .action-btn {
            display: flex;
            align-items: center;
            padding: 20px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            text-decoration: none;
            border-radius: 15px;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .action-btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(102, 126, 234, 0.6);
        }

        .action-btn i {
            font-size: 1.5rem;
            margin-right: 15px;
            width: 30px;
        }

        .logout-btn {
            background: linear-gradient(135deg, #f56565, #e53e3e) !important;
            box-shadow: 0 5px 15px rgba(245, 101, 101, 0.4) !important;
        }

        .logout-btn:hover {
            box-shadow: 0 15px 30px rgba(245, 101, 101, 0.6) !important;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                position: fixed;
                top: 0;
                left: -100%;
                height: 100vh;
                z-index: 1000;
            }

            .sidebar.active {
                left: 0;
            }

            .main-content {
                padding: 20px;
            }

            .header h1 {
                font-size: 2rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }
        }

        .menu-toggle {
            display: none;
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1001;
            background: rgba(255,255,255,0.95);
            border: none;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .menu-toggle {
                display: block;
            }
        }
    </style>
</head>
<body>
    <button class="menu-toggle" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
    </button>

    <div class="container">
        <!-- Sidebar -->
        <nav class="sidebar" id="sidebar">
            <div class="logo">
                <i class="fas fa-shield-alt"></i>
                <h2>DisasterOps</h2>
            </div>
            
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="disaster_report.php" class="nav-link">
                        <i class="fas fa-exclamation-triangle"></i>
                        <span>Disaster Reports</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="evacuation_center.php" class="nav-link">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Evacuation Centers</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="affected_people.php" class="nav-link">
                        <i class="fas fa-users"></i>
                        <span>Affected People</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="relief_goods.php" class="nav-link">
                        <i class="fas fa-boxes"></i>
                        <span>Relief Goods</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="reports.php" class="nav-link">
                        <i class="fas fa-chart-bar"></i>
                        <span>Reports</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="logout.php" class="nav-link logout-btn">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Main Content -->
        <main class="main-content">
            <div class="header">
                <h1><i class="fas fa-tachometer-alt"></i> Dashboard</h1>
                <p class="welcome-text">Welcome back! Here's what's happening in your disaster management system.</p>
            </div>

            <!-- Stats Cards -->
            <div class="stats-grid">
                <div class="stat-card disaster">
                    <div class="stat-icon">
                        <i class="fas fa-fire"></i>
                    </div>
                    <div class="stat-number">47</div>
                    <div class="stat-label">Active Disasters</div>
                </div>
                <div class="stat-card evacuation">
                    <div class="stat-icon">
                        <i class="fas fa-home"></i>
                    </div>
                    <div class="stat-number">23</div>
                    <div class="stat-label">Evacuation Centers</div>
                </div>
                <div class="stat-card people">
                    <div class="stat-icon">
                        <i class="fas fa-user-injured"></i>
                    </div>
                    <div class="stat-number">1,247</div>
                    <div class="stat-label">Affected People</div>
                </div>
                <div class="stat-card goods">
                    <div class="stat-icon">
                        <i class="fas fa-truck"></i>
                    </div>
                    <div class="stat-number">892</div>
                    <div class="stat-label">Relief Goods</div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="quick-actions">
                <h3><i class="fas fa-bolt"></i> Quick Actions</h3>
                <div class="actions-grid">
                    <a href="disaster_report.php" class="action-btn">
                        <i class="fas fa-plus"></i>
                        New Disaster Report
                    </a>
                    <a href="evacuation_center.php" class="action-btn">
                        <i class="fas fa-map"></i>
                        Manage Centers
                    </a>
                    <a href="affected_people.php" class="action-btn">
                        <i class="fas fa-user-plus"></i>
                        Register People
                    </a>
                    <a href="relief_goods.php" class="action-btn">
                        <i class="fas fa-warehouse"></i>
                        Goods Inventory
                    </a>
                    <a href="reports.php" class="action-btn">
                        <i class="fas fa-file-export"></i>
                        Generate Reports
                    </a>
                </div>
            </div>
        </main>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('active');
        }

        // Set active menu item based on current page
        document.addEventListener('DOMContentLoaded', function() {
            const currentPage = window.location.pathname.split('/').pop();
            const navLinks = document.querySelectorAll('.nav-link');
            
            navLinks.forEach(link => {
                const href = link.getAttribute('href');
                if (href === currentPage) {
                    link.classList.add('active');
                }
            });
        });

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const toggle = document.querySelector('.menu-toggle');
            
            if (window.innerWidth <= 768 && 
                !sidebar.contains(event.target) && 
                !toggle.contains(event.target) &&
                sidebar.classList.contains('active')) {
                sidebar.classList.remove('active');

				 <div class="submenu-content">
                <a href="haha/disater_report.php" target="contentFrame" onclick="setActiveLink(this)"
                <a href="haha/view_retailer.php" target="contentFrame" onclick="setActiveLink(this)"
            </div>
        </div>

            }
        });
    </script>
</body>
</html>