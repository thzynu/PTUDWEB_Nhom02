<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Panel Nhà báo' ?> - EchoNews</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="<?= asset('public/admin-panel/css/admin.css') ?>" rel="stylesheet">
    
    <style>
        :root {
            --journalist-primary: #28a745;
            --journalist-secondary: #6c757d;
            --journalist-success: #20c997;
            --journalist-info: #17a2b8;
            --journalist-warning: #ffc107;
            --journalist-danger: #dc3545;
            --journalist-light: #f8f9fa;
            --journalist-dark: #343a40;
        }
        
        .navbar-brand {
            color: var(--journalist-primary) !important;
            font-weight: bold;
        }
        
        .btn-primary {
            background-color: var(--journalist-primary);
            border-color: var(--journalist-primary);
        }
        
        .btn-primary:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }
        
        .nav-link.active {
            background-color: var(--journalist-primary) !important;
        }
        
        .badge-journalist {
            background-color: var(--journalist-primary);
            color: white;
        }
        
        .sidebar {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            min-height: 100vh;
        }
        
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8) !important;
            border-radius: 8px;
            margin: 2px 0;
            padding: 12px 15px;
            transition: all 0.3s ease;
        }
        
        .sidebar .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: white !important;
            transform: translateX(5px);
        }
        
        .sidebar .nav-link.active {
            background-color: rgba(255, 255, 255, 0.2);
            color: white !important;
        }
        
        .card {
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
            border: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .card-header {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 12px 12px 0 0 !important;
            font-weight: 600;
        }
        
        .stats-card {
            background: linear-gradient(135deg, #fff 0%, #f8f9fa 100%);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        
        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }
        
        .journalist-badge {
            background: linear-gradient(135deg, var(--journalist-primary) 0%, var(--journalist-success) 100%);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
        }
    </style>
</head>
<body class="bg-light">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-white shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand text-success" href="<?= url('journalist') ?>">
                <i class="fas fa-newspaper me-2"></i>
                <strong>Panel Nhà báo</strong>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="<?= url('journalist') ?>">
                            <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="<?= url('journalist/posts') ?>">
                            <i class="fas fa-newspaper me-1"></i>Bài viết của tôi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="<?= url('journalist/comments') ?>">
                            <i class="fas fa-comments me-1"></i>Bình luận
                        </a>
                    </li>
                </ul>
                
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-dark" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <span class="journalist-badge me-2">Nhà báo</span>
                            <i class="fas fa-user me-1"></i>
                            <?= $_SESSION['user']['username'] ?? 'User' ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="<?= url('/') ?>" target="_blank">
                                <i class="fas fa-globe me-2"></i>Xem trang web
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="<?= url('logout') ?>">
                                <i class="fas fa-sign-out-alt me-2"></i>Đăng xuất
                            </a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content Container -->
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                <div class="position-sticky pt-3">
                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-white">
                        <span><i class="fas fa-chart-line me-2"></i>QUẢN LÝ</span>
                    </h6>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="<?= url('journalist') ?>">
                                <i class="fas fa-tachometer-alt me-2"></i>
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= url('journalist/posts') ?>">
                                <i class="fas fa-newspaper me-2"></i>
                                Bài viết của tôi
                                <?php
                                // Đếm bài viết draft
                                if (isset($_SESSION['user'])) {
                                    $postModel = new \App\Models\Post();
                                    $userPosts = $postModel->getPostsByAuthor($_SESSION['user']['id']);
                                    $draftCount = count(array_filter($userPosts, function($p) { return $p['status'] == 0; }));
                                    if ($draftCount > 0): ?>
                                        <span class="badge bg-warning rounded-pill ms-1"><?= $draftCount ?></span>
                                    <?php endif;
                                }
                                ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= url('journalist/post/create') ?>">
                                <i class="fas fa-plus-circle me-2"></i>
                                Tạo bài viết mới
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= url('journalist/comments') ?>">
                                <i class="fas fa-comments me-2"></i>
                                Quản lý bình luận
                                <?php
                                // Đếm bình luận pending
                                if (isset($_SESSION['user'])) {
                                    $commentModel = new \App\Models\Comment();
                                    $userComments = $commentModel->getCommentsByAuthorPosts($_SESSION['user']['id']);
                                    $pendingCount = count(array_filter($userComments, function($c) { return $c['status'] == 0; }));
                                    if ($pendingCount > 0): ?>
                                        <span class="badge bg-warning rounded-pill ms-1"><?= $pendingCount ?></span>
                                    <?php endif;
                                }
                                ?>
                            </a>
                        </li>
                    </ul>

                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-white">
                        <span><i class="fas fa-tools me-2"></i>CÔNG CỤ</span>
                    </h6>
                    <ul class="nav flex-column mb-2">
                        <li class="nav-item">
                            <a class="nav-link" href="<?= url('/') ?>" target="_blank">
                                <i class="fas fa-external-link-alt me-2"></i>
                                Xem trang web
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-danger" href="<?= url('logout') ?>">
                                <i class="fas fa-sign-out-alt me-2"></i>
                                Đăng xuất
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        <?= $_SESSION['success'] ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php unset($_SESSION['success']); ?>
                <?php endif; ?>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <?= $_SESSION['error'] ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>