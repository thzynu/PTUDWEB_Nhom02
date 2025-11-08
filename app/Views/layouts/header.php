<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    // Set default values if variables are not set
    if (!isset($setting)) {
        $setting = [
            'title' => 'Online News',
            'description' => 'Latest news and updates',
            'keywords' => 'news, online, latest',
            'icon' => '',
            'logo' => ''
        ];
    }
    if (!isset($categories)) {
        $categories = [];
    }
    if (!isset($bodyBanner)) {
        $bodyBanner = ['image' => ''];
    }
    ?>
    <!-- Mobile Specific Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon-->
    <link rel="shortcut icon" href="<?=asset($setting['icon'])?>">
    <!-- Meta Description -->
    <meta name="description" content="<?=$setting['description']?>">
    <!-- Meta Keyword -->
    <meta name="keywords" content="<?=$setting['keywords']?>">
    <!-- meta character set -->
    <meta charset="UTF-8">
    <!-- Site Title -->
    <title><?=$setting['title']?></title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        :root {
            /* Minimalistic Color Palette */
            --primary: #1a1a1a;           /* Almost black for text */
            --secondary: #666666;         /* Medium gray for secondary text */
            --accent: #f5f5f5;            /* Very light gray for backgrounds */
            --border: #e5e5e5;            /* Light border color */
            --white: #ffffff;             /* Pure white */
            --subtle: #fafafa;            /* Subtle background */
            
            /* Bootstrap overrides */
            --bs-primary: #1a1a1a;
            --bs-secondary: #666666;
            --bs-light: #f5f5f5;
            --bs-dark: #1a1a1a;
            --bs-gray-100: #fafafa;
            --bs-gray-200: #e5e5e5;
            --bs-gray-300: #d4d4d4;
            --bs-gray-600: #666666;
            --bs-gray-900: #1a1a1a;
            
            /* Text Colors */
            --text-primary: #1a1a1a;
            --text-secondary: #666666;
            --text-muted: #999999;
            --text-white: #ffffff;
            
            /* Background Colors */
            --bg-white: #ffffff;
            --bg-light: #fafafa;
            --bg-subtle: #f5f5f5;
            
            /* Border Colors */
            --border-light: #e5e5e5;
            --border-medium: #d4d4d4;
        }
        
        /* Base Typography - Minimalistic */
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            font-size: 16px;
            line-height: 1.6;
            color: var(--text-primary);
            background-color: var(--bg-white);
            font-weight: 400;
        }
        
        /* Clean headings */
        h1, h2, h3, h4, h5, h6 {
            font-weight: 600;
            color: var(--text-primary);
            line-height: 1.3;
            margin-bottom: 0.75rem;
        }
        
        /* Minimal navigation */
        .navbar {
            background-color: var(--bg-white) !important;
            border-bottom: 1px solid var(--border-light);
            padding: 1rem 0;
            box-shadow: none;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--text-primary) !important;
        }
        
        .nav-link {
            color: var(--text-secondary) !important;
            font-weight: 500;
            transition: color 0.2s ease;
        }
        
        .nav-link:hover {
            color: var(--text-primary) !important;
        }
        
        /* Minimal buttons */
        .btn {
            border-radius: 6px;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border: none;
            transition: all 0.2s ease;
        }
        
        .btn-primary {
            background-color: var(--primary);
            color: var(--white);
        }
        
        .btn-primary:hover {
            background-color: var(--secondary);
            transform: none;
        }
        
        /* Clean cards */
        .card {
            border: 1px solid var(--border-light);
            border-radius: 8px;
            box-shadow: none;
            transition: all 0.2s ease;
        }
        
        .card:hover {
            border-color: var(--border-medium);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }
        
        /* Minimal links */
        a {
            color: var(--text-primary);
            text-decoration: none;
            transition: color 0.2s ease;
        }
        
        a:hover {
            color: var(--text-secondary);
        }
        
        /* Remove excessive animations */
        * {
            animation: none !important;
            transition: color 0.2s ease, background-color 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease !important;
        }
        
        /* Clean forms */
        .form-control {
            border: 1px solid var(--border-light);
            border-radius: 6px;
            padding: 0.6rem 0.75rem;
            font-size: 0.95rem;
        }
        
        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 2px rgba(26, 26, 26, 0.1);
        }
        
        /* Clean Navigation */
        .main-navbar {
            background: var(--bg-white);
            border-bottom: 1px solid var(--border-light);
            padding: 20px 0;
            box-shadow: 0 1px 3px rgba(20, 41, 96, 0.1);
        }
        
        .navbar-brand img {
            max-height: 40px;
        }
        
        .navbar-nav .nav-link {
            font-weight: 500;
            color: var(--text-primary);
            padding: 6px 12px;
            border-radius: 6px;
            transition: all 0.3s ease;
            font-size: 14px;
            margin: 0 1px;
            white-space: nowrap;
        }
        
        .navbar-nav .nav-link:hover {
            color: var(--bs-secondary);
            background: var(--bs-light);
        }
        
        .navbar-nav .nav-link.active {
            color: var(--bs-primary);
            background: var(--bs-light);
        }
        
        /* Dropdown styling */
        .dropdown-menu {
            border: none;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            border-radius: 8px;
            padding: 8px 0;
            margin-top: 8px;
            min-width: 180px;
            z-index: 1050;
            position: absolute !important;
            display: none;
        }
        
        .dropdown-menu.show {
            display: block !important;
        }
        
        .dropdown-item {
            padding: 8px 16px;
            font-size: 14px;
            color: var(--text-primary);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
        }
        
        .dropdown-item:hover {
            background: var(--bs-light);
            color: var(--bs-primary);
        }
        
        .dropdown-item i {
            font-size: 13px;
            opacity: 0.8;
            width: 16px;
        }
        
        .dropdown-toggle::after {
            font-family: "Font Awesome 5 Free";
            content: "\f107";
            border: none;
            font-weight: 900;
            vertical-align: 0;
            margin-left: 4px;
        }
        
        /* Search form compact */
        .search-container {
            flex-shrink: 0;
        }
        
        .search-form {
            position: relative;
            display: flex;
            align-items: center;
        }
        
        .search-form input {
            padding-left: 35px;
            border-radius: 20px;
            border: 1px solid #ddd;
            font-size: 13px;
        }
        
        .search-btn {
            position: absolute;
            left: 8px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #666;
            z-index: 10;
        }
        
        /* Bootstrap overrides */
        .btn-primary {
            background-color: var(--bs-primary);
            border-color: var(--bs-primary);
        }
        
        .btn-primary:hover {
            background-color: var(--bs-secondary);
            border-color: var(--bs-secondary);
        }
        
        .bg-primary {
            background-color: var(--bs-primary) !important;
        }
        
        .bg-secondary {
            background-color: var(--bs-secondary) !important;
        }
        
        .text-primary {
            color: var(--bs-primary) !important;
        }
        
        /* User Menu Buttons */
        .navbar-nav .btn {
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
        }
        
        .navbar-nav .btn-success {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            border: none;
            color: white;
        }
        
        .navbar-nav .btn-success:hover {
            background: linear-gradient(135deg, #218838 0%, #1e7e34 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
        }
        
        .navbar-nav .btn-primary {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            border: none;
        }
        
        .navbar-nav .btn-primary:hover {
            background: linear-gradient(135deg, #0056b3 0%, #004085 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
        }
        
        .navbar-nav .btn-outline-primary {
            border: 2px solid var(--bs-primary);
            color: var(--bs-primary);
            background: transparent;
        }
        
        .navbar-nav .btn-outline-primary:hover {
            background: var(--bs-primary);
            color: white;
            transform: translateY(-1px);
        }
        
        .dropdown-menu {
            border-radius: 12px;
            border: none;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            margin-top: 8px;
        }
        
        .dropdown-item {
            padding: 8px 16px;
            border-radius: 6px;
            margin: 2px 6px;
            transition: all 0.2s ease;
        }
        
        .dropdown-item:hover {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            transform: translateX(4px);
        }
        
        .dropdown-item i {
            width: 16px;
            text-align: center;
        }
        
        /* Responsive adjustments */
        @media (max-width: 991px) {
            .navbar-nav .btn {
                margin: 4px 0;
                width: 100%;
                justify-content: center;
            }
            
            .navbar-nav .nav-item.me-2 {
                margin-right: 0 !important;
            }
        }

        /* Minimalistic Search */
        .search-container {
            position: relative;
        }
        
        .search-form {
            position: relative;
            display: flex;
            align-items: center;
        }
        
        .search-form input {
            border: 1px solid var(--border-light);
            border-radius: 8px;
            padding: 10px 16px 10px 40px;
            width: 280px;
            font-size: 14px;
            background: var(--bg-light);
            transition: all 0.2s ease;
        }
        
        .search-form input:focus {
            border-color: var(--bs-secondary);
            background: var(--bg-white);
            box-shadow: 0 0 0 3px rgba(86, 86, 86, 0.1);
            outline: none;
        }
        
        .search-btn {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-muted);
            padding: 0;
            z-index: 10;
        }

        /* Search Results Dropdown */
        .search-results {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
            z-index: 1000;
            max-height: 400px;
            overflow-y: auto;
            margin-top: 5px;
            border: 1px solid #e0e0e0;
        }

        .search-result-item {
            padding: 12px 15px;
            border-bottom: 1px solid #f0f0f0;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .search-result-item:hover {
            background-color: #f8f9fa;
        }

        .search-result-item:last-child {
            border-bottom: none;
        }

        .search-result-title {
            font-weight: 600;
            color: #333;
            margin-bottom: 3px;
            font-size: 14px;
        }

        .search-result-summary {
            color: #666;
            font-size: 12px;
            line-height: 1.4;
            margin-bottom: 5px;
        }

        .search-result-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .search-result-category {
            background: #007bff;
            color: white;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 500;
        }

        .search-result-views {
            color: #999;
            font-size: 11px;
        }

        .no-results {
            padding: 20px;
            text-align: center;
            color: #666;
            font-style: italic;
        }
        
        /* Minimal Banner */
        .banner-section {
            background: var(--bg-light);
            padding: 1rem 0;
            border-bottom: 1px solid var(--border-light);
        }
        
        .banner-img {
            border-radius: 8px;
            max-height: 80px;
            object-fit: cover;
            border: 1px solid var(--border-light);
        }
        
        /* Mobile Responsive */
        @media (max-width: 768px) {
            .search-form input {
                width: 100%;
                margin-top: 16px;
            }
            
            .top-bar {
                text-align: center;
            }
            
            .top-bar .col-md-6:last-child {
                margin-top: 8px;
            }
        }
    </style>
    
    <!-- Search JavaScript -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const searchResults = document.getElementById('searchResults');
        let searchTimeout;
        
        // Debounced search function
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const searchTerm = this.value.trim();
            
            if (searchTerm.length < 2) {
                searchResults.style.display = 'none';
                return;
            }
            
            searchTimeout = setTimeout(() => {
                performLiveSearch(searchTerm);
            }, 300);
        });
        
        // Hide results when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.search-container')) {
                searchResults.style.display = 'none';
            }
        });
        
        // Show results when focusing on search input
        searchInput.addEventListener('focus', function() {
            if (this.value.length >= 2) {
                searchResults.style.display = 'block';
            }
        });
        
        function performLiveSearch(searchTerm) {
            // Create AJAX request
            fetch(`<?= url('/') ?>?search=${encodeURIComponent(searchTerm)}&ajax=1`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                displaySearchResults(data);
            })
            .catch(error => {
                console.error('Search error:', error);
            });
        }
        
        function displaySearchResults(posts) {
            if (posts.length === 0) {
                searchResults.innerHTML = '<div class="no-results">No articles found</div>';
            } else {
                let html = '';
                posts.slice(0, 5).forEach(post => { // Show max 5 results
                    html += `
                        <div class="search-result-item" onclick="goToPost(${post.id})">
                            <div class="search-result-title">${post.title}</div>
                            <div class="search-result-summary">${post.summary || post.body.substring(0, 100) + '...'}</div>
                            <div class="search-result-meta">
                                <span class="search-result-category">${post.category}</span>
                                <span class="search-result-views">${post.view} views</span>
                            </div>
                        </div>
                    `;
                });
                searchResults.innerHTML = html;
            }
            searchResults.style.display = 'block';
        }
        
        // Navigate to post
        function goToPost(postId) {
            window.location.href = `<?= url('/post') ?>/${postId}`;
        }
        
        // Make goToPost globally accessible
        window.goToPost = goToPost;
    });
    </script>
</head>

<body>
    <!-- Top Bar -->
    <div class="top-bar">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="d-flex align-items-center">
                        <span class="text-muted me-4"><?= date('F j, Y') ?></span>
                        <span class="text-muted small">Tin mới nhất</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex justify-content-end align-items-center">
                        <?php if(isset($_SESSION['user']) && $_SESSION['user']): ?>
                            <!-- User is logged in -->
                            <span class="text-muted me-3">
                                <i class="fas fa-user me-1"></i>
                                <?= $_SESSION['username'] ?? 'User' ?>
                            </span>
                            <a href="<?= url('logout') ?>" class="btn btn-outline-danger btn-sm">
                                <i class="fas fa-sign-out-alt me-1"></i>Đăng xuất
                            </a>
                        <?php else: ?>
                            <!-- User is not logged in -->
                            <span class="text-muted">Chào mừng bạn đến với trang tin tức</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Navigation -->
    <nav class="navbar navbar-expand-lg main-navbar">
        <div class="container">
            <!-- Logo -->
            <a class="navbar-brand" href="<?= url('/') ?>">
                <?php if(!empty($setting['logo'])) { ?>
                    <img src="<?=asset($setting['logo'])?>" alt="<?=$setting['title']?>" class="img-fluid">
                <?php } else { ?>
                    <span class="fw-bold"><?=$setting['title']?></span>
                <?php } ?>
            </a>

            <!-- Mobile Menu Toggle -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navigation Menu -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link px-2" href="<?= url('/') ?>">
                            <i class="fas fa-home me-1"></i>Home
                        </a>
                    </li>
                    <?php if(!empty($categories)) { ?>
                        <?php 
                        $visibleCategories = array_slice($categories, 0, 3); // Chỉ hiển thị 3 danh mục
                        $hiddenCategories = array_slice($categories, 3); // Các danh mục còn lại
                        $icons = [
                            'Chính trị' => 'fas fa-landmark',
                            'Công nghệ' => 'fas fa-microchip', 
                            'Khoa học' => 'fas fa-flask',
                            'Kinh doanh' => 'fas fa-chart-line',
                            'Thể thao' => 'fas fa-futbol',
                            'Giải trí' => 'fas fa-film',
                            'Sức khỏe' => 'fas fa-heart',
                            'Du lịch' => 'fas fa-plane'
                        ];
                        ?>
                        
                        <?php foreach ($visibleCategories as $category) { ?>
                        <li class="nav-item">
                            <a class="nav-link px-2" href="<?= url('show-category/' . $category['id']) ?>">
                                <?= $category['name'] ?>
                            </a>
                        </li>
                        <?php } ?>
                        
                        <?php if(!empty($hiddenCategories)) { ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link px-2 dropdown-toggle" href="#" id="moreCategories" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Thêm
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="moreCategories">
                                <?php foreach ($hiddenCategories as $category) { ?>
                                <li>
                                    <a class="dropdown-item" href="<?= url('show-category/' . $category['id']) ?>">
                                        <?= $category['name'] ?>
                                    </a>
                                </li>
                                <?php } ?>
                            </ul>
                        </li>
                        <?php } ?>
                    <?php } ?>
                </ul>

                <!-- Search Form - Compact -->
                <div class="search-container me-2" style="position: relative; max-width: 250px;">
                    <form class="search-form" method="GET" action="<?= url('/') ?>" id="searchForm">
                        <button type="submit" class="search-btn">
                            <i class="fas fa-search"></i>
                        </button>
                        <input type="text" name="search" id="searchInput" class="form-control form-control-sm" placeholder="Tìm kiếm..." autocomplete="off" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                    </form>
                    <!-- Search Results Dropdown -->
                    <div id="searchResults" class="search-results" style="display: none;"></div>
                </div>

                <!-- User Menu -->
                <ul class="navbar-nav">
                    <?php if (isset($_SESSION['user'])): ?>
                        <!-- Admin Panel Button -->
                        <?php if (isset($_SESSION['user']['permission']) && $_SESSION['user']['permission'] == 'admin'): ?>
                            <li class="nav-item me-2">
                                <a class="btn btn-primary btn-sm" href="<?= url('admin') ?>" 
                                   data-bs-toggle="tooltip" data-bs-placement="bottom" 
                                   title="Quản lý toàn bộ hệ thống">
                                    <i class="fas fa-cog me-1"></i>Admin Panel
                                </a>
                            </li>
                        <?php endif; ?>
                        
                        <!-- Journalist Panel Button - CHỈ cho tài khoản journalist -->
                        <?php if (isset($_SESSION['user']['permission']) && $_SESSION['user']['permission'] == 'journalist'): ?>
                            <li class="nav-item me-2">
                                <a class="btn btn-success btn-sm position-relative" href="<?= url('journalist.php') ?>"
                                   data-bs-toggle="tooltip" data-bs-placement="bottom" 
                                   title="Quản lý bài viết và bình luận của bạn">
                                    <i class="fas fa-newspaper me-1"></i>Panel Nhà báo
                                    <?php
                                    // Quick notification count for journalist
                                    if (isset($_SESSION['user'])) {
                                        try {
                                            $postModel = new \App\Models\Post();
                                            $commentModel = new \App\Models\Comment();
                                            $userId = $_SESSION['user']['id'];
                                            
                                            // Count drafts and pending comments
                                            $userPosts = $postModel->getPostsByAuthor($userId);
                                            $draftCount = count(array_filter($userPosts, function($p) { return $p['status'] == 0; }));
                                            
                                            $userComments = $commentModel->getCommentsByAuthorPosts($userId);
                                            $pendingComments = count(array_filter($userComments, function($c) { return $c['status'] == 0; }));
                                            
                                            $totalNotifications = $draftCount + $pendingComments;
                                            
                                            if ($totalNotifications > 0):
                                    ?>
                                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning text-dark">
                                                    <?= $totalNotifications > 99 ? '99+' : $totalNotifications ?>
                                                    <span class="visually-hidden">thông báo</span>
                                                </span>
                                    <?php 
                                            endif;
                                        } catch (Exception $e) {
                                            // Silently ignore errors to prevent breaking the page
                                        }
                                    }
                                    ?>
                                </a>
                            </li>
                        <?php endif; ?>
                        
                        <!-- User Dropdown -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle me-1"></i>
                                <span><?= htmlspecialchars($_SESSION['user']['username'] ?? $_SESSION['username'] ?? 'User') ?></span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <?php if (isset($_SESSION['user']['permission']) && $_SESSION['user']['permission'] == 'admin'): ?>
                                    <li><a class="dropdown-item" href="<?= url('admin') ?>">
                                        <i class="fas fa-cog me-2"></i>Admin Panel
                                    </a></li>
                                <?php endif; ?>
                                
                                <?php if (isset($_SESSION['user']['permission']) && $_SESSION['user']['permission'] == 'journalist'): ?>
                                    <li><a class="dropdown-item" href="<?= url('journalist.php') ?>">
                                        <i class="fas fa-newspaper me-2"></i>Panel Nhà báo
                                    </a></li>
                                <?php endif; ?>
                                
                                <?php if (isset($_SESSION['user']['permission']) && ($_SESSION['user']['permission'] == 'admin' || $_SESSION['user']['permission'] == 'journalist')): ?>
                                    <li><hr class="dropdown-divider"></li>
                                <?php endif; ?>
                                
                                <li><a class="dropdown-item" href="<?= url('/') ?>">
                                    <i class="fas fa-home me-2"></i>Trang chủ
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="<?= url('logout') ?>">
                                    <i class="fas fa-sign-out-alt me-2"></i>Đăng xuất
                                </a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <!-- Login/Register buttons for guests -->
                        <li class="nav-item me-2">
                            <a class="btn btn-outline-primary btn-sm" href="<?= url('login') ?>">
                                <i class="fas fa-sign-in-alt me-1"></i>Đăng nhập
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-primary btn-sm" href="<?= url('register') ?>">
                                <i class="fas fa-user-plus me-1"></i>Đăng ký
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Minimal Banner Section -->
    <?php if(!empty($bodyBanner['image'])) { ?>
    <section class="banner-section">
        <div class="container">
            <div class="text-center">
                <img src="<?=asset($bodyBanner['image'])?>" alt="Banner" class="img-fluid banner-img">
            </div>
        </div>
    </section>
    <?php } ?>

    <!-- Initialize Bootstrap Tooltips and other JS -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Bootstrap tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                });
            });

            // Add animation to panel buttons
            document.querySelectorAll('.btn').forEach(button => {
                button.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-2px)';
                });
                
                button.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });

            // Dropdown fallback - nếu Bootstrap dropdown không hoạt động
            const dropdownToggle = document.getElementById('moreCategories');
            if (dropdownToggle) {
                dropdownToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    const dropdownMenu = this.nextElementSibling;
                    if (dropdownMenu) {
                        // Toggle dropdown
                        if (dropdownMenu.style.display === 'block') {
                            dropdownMenu.style.display = 'none';
                            this.setAttribute('aria-expanded', 'false');
                        } else {
                            dropdownMenu.style.display = 'block';
                            this.setAttribute('aria-expanded', 'true');
                        }
                    }
                });

                // Close dropdown when clicking outside
                document.addEventListener('click', function(e) {
                    if (!dropdownToggle.contains(e.target)) {
                        const dropdownMenu = dropdownToggle.nextElementSibling;
                        if (dropdownMenu) {
                            dropdownMenu.style.display = 'none';
                            dropdownToggle.setAttribute('aria-expanded', 'false');
                        }
                    }
                });
            }
        });
    </script>
