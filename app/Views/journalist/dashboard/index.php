<?php require_once(BASE_PATH . '/app/Views/layouts/journalist/header.php'); ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-tachometer-alt text-success me-2"></i>
        Dashboard Nhà báo
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="<?= url('journalist/post/create') ?>" class="btn btn-sm btn-success">
                <i class="fas fa-plus me-1"></i>Tạo bài viết mới
            </a>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stats-card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            <i class="fas fa-newspaper me-1"></i>Tổng bài viết
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= count($myPosts) ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-file-alt fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stats-card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            <i class="fas fa-check-circle me-1"></i>Đã xuất bản
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= $publishedCount ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-check fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stats-card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            <i class="fas fa-edit me-1"></i>Bản nháp
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= $draftCount ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-edit fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card stats-card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            <i class="fas fa-comments me-1"></i>Bình luận chờ duyệt
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= $pendingCommentsCount ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-comment fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Recent Posts -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-newspaper me-2"></i>Bài viết gần đây
                </h6>
            </div>
            <div class="card-body">
                <?php if (!empty($recentPosts)): ?>
                    <?php foreach (array_slice($recentPosts, 0, 5) as $post): ?>
                        <div class="d-flex align-items-center py-2 border-bottom">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">
                                    <a href="<?= url('show-post/' . $post['id']) ?>" target="_blank" class="text-decoration-none">
                                        <?= htmlspecialchars(strlen($post['title']) > 50 ? substr($post['title'], 0, 50) . '...' : $post['title']) ?>
                                    </a>
                                </h6>
                                <small class="text-muted">
                                    <i class="fas fa-calendar me-1"></i>
                                    <?= date('d/m/Y H:i', strtotime($post['created_at'])) ?>
                                </small>
                            </div>
                            <div class="ms-2">
                                <?php if ($post['status'] == 1): ?>
                                    <span class="badge bg-success">Đã xuất bản</span>
                                <?php else: ?>
                                    <span class="badge bg-warning">Bản nháp</span>
                                <?php endif; ?>
                                
                                <?php if ($post['breaking_news'] == 1): ?>
                                    <span class="badge bg-danger ms-1">Tin nóng</span>
                                <?php endif; ?>
                                
                                <?php if ($post['selected'] == 1): ?>
                                    <span class="badge bg-info ms-1">Nổi bật</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    
                    <div class="text-center mt-3">
                        <a href="<?= url('journalist/posts') ?>" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-eye me-1"></i>Xem tất cả bài viết
                        </a>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4">
                        <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Chưa có bài viết nào</h5>
                        <p class="text-muted">Bắt đầu tạo bài viết đầu tiên của bạn!</p>
                        <a href="<?= url('journalist/post/create') ?>" class="btn btn-success">
                            <i class="fas fa-plus me-1"></i>Tạo bài viết mới
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Recent Comments -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-warning">
                    <i class="fas fa-comments me-2"></i>Bình luận gần đây cần duyệt
                </h6>
            </div>
            <div class="card-body">
                <?php if (!empty($recentComments)): ?>
                    <?php foreach (array_slice($recentComments, 0, 5) as $comment): ?>
                        <div class="d-flex align-items-start py-2 border-bottom">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">
                                    <small class="text-muted">trên bài:</small>
                                    <a href="<?= url('show-post/' . $comment['post_id']) ?>" target="_blank" class="text-decoration-none">
                                        <?= htmlspecialchars(strlen($comment['post_title']) > 40 ? substr($comment['post_title'], 0, 40) . '...' : $comment['post_title']) ?>
                                    </a>
                                </h6>
                                <p class="mb-1 small">
                                    <?= htmlspecialchars(strlen($comment['comment']) > 80 ? substr($comment['comment'], 0, 80) . '...' : $comment['comment']) ?>
                                </p>
                                <small class="text-muted">
                                    <i class="fas fa-user me-1"></i><?= htmlspecialchars($comment['username']) ?>
                                    <i class="fas fa-calendar ms-2 me-1"></i><?= date('d/m/Y H:i', strtotime($comment['created_at'])) ?>
                                </small>
                            </div>
                            <div class="ms-2">
                                <div class="btn-group btn-group-sm">
                                    <a href="<?= url('journalist/comment/approve/' . $comment['id']) ?>" 
                                       class="btn btn-outline-success" title="Duyệt">
                                        <i class="fas fa-check"></i>
                                    </a>
                                    <a href="<?= url('journalist/comment/reject/' . $comment['id']) ?>" 
                                       class="btn btn-outline-warning" title="Từ chối">
                                        <i class="fas fa-times"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    
                    <div class="text-center mt-3">
                        <a href="<?= url('journalist/comments') ?>" class="btn btn-sm btn-outline-warning">
                            <i class="fas fa-eye me-1"></i>Quản lý tất cả bình luận
                        </a>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4">
                        <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Không có bình luận nào cần duyệt</h5>
                        <p class="text-muted">Tất cả bình luận đã được xử lý.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Quick Stats Chart -->
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-chart-bar me-2"></i>Tổng quan hoạt động
                </h6>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-3">
                        <div class="border-end">
                            <div class="h4 text-success mb-0"><?= count($myPosts) ?></div>
                            <small class="text-muted">Tổng bài viết</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="border-end">
                            <div class="h4 text-info mb-0"><?= $publishedCount ?></div>
                            <small class="text-muted">Đã xuất bản</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="border-end">
                            <div class="h4 text-warning mb-0"><?= $draftCount ?></div>
                            <small class="text-muted">Bản nháp</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="h4 text-primary mb-0"><?= $approvedCommentsCount + $pendingCommentsCount ?></div>
                        <small class="text-muted">Tổng bình luận</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .border-left-success {
        border-left: 0.25rem solid #28a745 !important;
    }
    
    .border-left-info {
        border-left: 0.25rem solid #17a2b8 !important;
    }
    
    .border-left-warning {
        border-left: 0.25rem solid #ffc107 !important;
    }
    
    .border-left-primary {
        border-left: 0.25rem solid #007bff !important;
    }
    
    .stats-card:hover {
        transform: translateY(-2px);
        transition: all 0.2s ease;
    }
</style>

<?php require_once(BASE_PATH . '/app/Views/layouts/journalist/footer.php'); ?>