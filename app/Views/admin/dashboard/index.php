<?php
require_once(BASE_PATH . "/app/Views/admin/layouts/head-tag.php");
?>

<!-- Dashboard Header -->
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4">
    <h1 class="h4 text-primary">
        <i class="fas fa-tachometer-alt me-2"></i>
        Tổng quan Bảng điều khiển
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <button type="button" class="btn btn-outline-primary btn-sm">
                <i class="fas fa-download"></i> Xuất dữ liệu
            </button>
        </div>
        <button type="button" class="btn btn-primary btn-sm">
            <i class="fas fa-sync-alt"></i> Làm mới
        </button>
    </div>
</div>

<!-- Views Chart Section - Moved to top -->
<div class="row g-4 mb-5">
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 pb-0">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="card-title text-dark mb-0">
                        <i class="fas fa-chart-line text-primary me-2"></i>
                        Phân tích lượt xem - 7 ngày qua
                    </h5>
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-download me-1"></i>Xuất dữ liệu
                        </button>
                        <button class="btn btn-primary btn-sm" onclick="refreshChart()" id="refreshBtn">
                            <i class="fas fa-sync-alt me-1"></i>Làm mới
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div style="position: relative; height: 400px;">
                    <canvas id="viewsChart"></canvas>
                </div>
                <div class="row mt-4">
                    <div class="col-md-3 text-center">
                        <div class="border rounded p-3">
                            <h6 class="text-primary mb-1"><?= number_format($postsViews['SUM(view)'] ?? 0) ?></h6>
                            <small class="text-muted">Tổng lượt xem</small>
                        </div>
                    </div>
                    <div class="col-md-3 text-center">
                        <div class="border rounded p-3">
                            <h6 class="text-success mb-1">
                                <?php 
                                $totalPosts = $postStats['total'] ?? 0;
                                $totalViews = $postsViews['SUM(view)'] ?? 0;
                                $avgViews = $totalPosts > 0 ? round($totalViews / $totalPosts) : 0;
                                echo number_format($avgViews); 
                                ?>
                            </h6>
                            <small class="text-muted">Trung bình/bài</small>
                        </div>
                    </div>
                    <div class="col-md-3 text-center">
                        <div class="border rounded p-3">
                            <h6 class="text-info mb-1"><?= number_format($postStats['total'] ?? 0) ?></h6>
                            <small class="text-muted">Tổng bài viết</small>
                        </div>
                    </div>
                    <div class="col-md-3 text-center">
                        <div class="border rounded p-3">
                            <h6 class="text-warning mb-1">
                                <?php
                                // Tạm thời hiển thị 0 cho today views
                                $todayViews = 0;
                                echo number_format($todayViews);
                                ?>
                            </h6>
                            <small class="text-muted">Lượt xem hôm nay</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row g-4 mb-5">
    <div class="col-sm-6 col-xl-3">
        <a href="<?= url('admin/categories') ?>" class="text-decoration-none">
            <div class="card border-0 shadow-sm h-100 card-hover">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-gradient bg-primary text-white rounded-3 p-3">
                                <i class="fas fa-clipboard-list fa-lg"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-title text-dark mb-1">Danh mục</h6>
                            <div class="d-flex align-items-center">
                                <h4 class="text-primary mb-0 me-2"><?= $categoryStats['total_categories'] ?? 0; ?></h4>
                                <span class="badge bg-primary bg-opacity-10 text-primary">Tổng</span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="text-muted">
                            <i class="fas fa-arrow-right me-1"></i>
                            Quản lý danh mục
                        </small>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <div class="col-sm-6 col-xl-3">
        <a href="<?= url('admin/users') ?>" class="text-decoration-none">
            <div class="card border-0 shadow-sm h-100 card-hover">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-gradient bg-success text-white rounded-3 p-3">
                                <i class="fas fa-users fa-lg"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-title text-dark mb-1">Người dùng</h6>
                            <div class="d-flex align-items-center">
                                <h4 class="text-success mb-0 me-2"><?= $userStats['total_users'] ?? 0; ?></h4>
                                <span class="badge bg-success bg-opacity-10 text-success">Tổng</span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 d-flex justify-content-between">
                        <small class="text-muted">
                            <i class="fas fa-users-cog me-1"></i>
                            Quản trị: <?= $userStats['admin_count'] ?? 0; ?>
                        </small>
                        <small class="text-muted">
                            <i class="fas fa-user me-1"></i>
                            Thành viên: <?= $userStats['total_users'] ?? 0; ?>
                        </small>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <div class="col-sm-6 col-xl-3">
        <a href="<?= url('admin/posts') ?>" class="text-decoration-none">
            <div class="card border-0 shadow-sm h-100 card-hover">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-gradient bg-info text-white rounded-3 p-3">
                                <i class="fas fa-newspaper fa-lg"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-title text-dark mb-1">Bài viết</h6>
                            <div class="d-flex align-items-center">
                                <h4 class="text-info mb-0 me-2"><?= $postStats['total'] ?? 0; ?></h4>
                                <span class="badge bg-info bg-opacity-10 text-info">Đã xuất bản</span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="text-muted">
                            <i class="fas fa-eye me-1"></i>
                            Tổng lượt xem: <?= number_format($postsViews['SUM(view)'] ?? 0); ?>
                        </small>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <div class="col-sm-6 col-xl-3">
        <a href="<?= url('admin/comments') ?>" class="text-decoration-none">
            <div class="card border-0 shadow-sm h-100 card-hover">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-gradient bg-warning text-white rounded-3 p-3">
                                <i class="fas fa-comments fa-lg"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-title text-dark mb-1">Bình luận</h6>
                            <div class="d-flex align-items-center">
                                <h4 class="text-warning mb-0 me-2"><?= $commentStats['total_comments'] ?? 0; ?></h4>
                                <span class="badge bg-warning bg-opacity-10 text-warning">Tổng</span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 d-flex justify-content-between">
                        <small class="text-muted">
                            <i class="fas fa-eye-slash me-1"></i>
                            Chờ duyệt: <?= $commentStats['pending_count'] ?? 0; ?>
                        </small>
                        <small class="text-muted">
                            <i class="fas fa-check-circle me-1"></i>
                            Đã duyệt: <?= $commentStats['approved_count'] ?? 0; ?>
                        </small>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>

<!-- Analytics Tables -->
<div class="row g-4">
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-0 pb-0">
                <div class="d-flex align-items-center justify-content-between">
                    <h6 class="card-title text-dark mb-0">
                        <i class="fas fa-chart-line text-primary me-2"></i>
                        Bài viết nhiều lượt xem nhất
                    </h6>
                    <a href="<?= url('admin/posts') ?>" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-external-link-alt"></i>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th scope="col" class="border-0 text-muted small">#</th>
                                <th scope="col" class="border-0 text-muted small">Bài viết</th>
                                <th scope="col" class="border-0 text-muted small text-end">Lượt xem</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($postsWithView)): ?>
                                <?php foreach($postsWithView as $key => $post) { ?>
                                <tr>
                                    <td class="border-0">
                                        <span class="text-primary fw-bold"><?= $key + 1 ?></span>
                                    </td>
                                <td class="border-0">
                                    <a href="<?= url('admin/posts') ?>" class="text-dark text-decoration-none">
                                        <div class="fw-medium"><?= strlen($post['title']) > 40 ? substr($post['title'], 0, 40) . '...' : $post['title'] ?></div>
                                    </a>
                                </td>
                                <td class="border-0 text-end">
                                    <span class="badge bg-primary rounded-pill"><?= number_format($post['view']) ?></span>
                                </td>
                            </tr>
                            <?php } ?>
                            <?php else: ?>
                            <tr>
                                <td colspan="3" class="text-center text-muted py-4">
                                    <i class="fas fa-inbox fa-2x mb-2"></i><br>
                                    No posts found
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-0 pb-0">
                <div class="d-flex align-items-center justify-content-between">
                    <h6 class="card-title text-dark mb-0">
                        <i class="fas fa-comment-dots text-success me-2"></i>
                        Most Commented Posts
                    </h6>
                    <a href="<?= url('admin/posts') ?>" class="btn btn-outline-success btn-sm">
                        <i class="fas fa-external-link-alt"></i>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th scope="col" class="border-0 text-muted small">#</th>
                                <th scope="col" class="border-0 text-muted small">Article</th>
                                <th scope="col" class="border-0 text-muted small text-end">Comments</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($topCommentedPosts)): ?>
                                <?php foreach($topCommentedPosts as $key => $post) { ?>
                            <tr>
                                <td class="border-0">
                                    <span class="text-success fw-bold"><?= $key + 1 ?></span>
                                </td>
                                <td class="border-0">
                                    <a href="<?= url('admin/posts') ?>" class="text-dark text-decoration-none">
                                        <div class="fw-medium"><?= strlen($post['title']) > 40 ? substr($post['title'], 0, 40) . '...' : $post['title'] ?></div>
                                    </a>
                                </td>
                                <td class="border-0 text-end">
                                    <span class="badge bg-success rounded-pill"><?= $post['comment_count'] ?></span>
                                </td>
                            </tr>
                            <?php } ?>
                            <?php else: ?>
                            <tr>
                                <td colspan="3" class="text-center text-muted py-4">
                                    <i class="fas fa-inbox fa-2x mb-2"></i><br>
                                    No posts found
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-0 pb-0">
                <div class="d-flex align-items-center justify-content-between">
                    <h6 class="card-title text-dark mb-0">
                        <i class="fas fa-comments text-warning me-2"></i>
                        Recent Comments
                    </h6>
                    <a href="<?= url('admin/comments') ?>" class="btn btn-outline-warning btn-sm">
                        <i class="fas fa-external-link-alt"></i>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th scope="col" class="border-0 text-muted small">#</th>
                                <th scope="col" class="border-0 text-muted small">User</th>
                                <th scope="col" class="border-0 text-muted small">Comment</th>
                                <th scope="col" class="border-0 text-muted small text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($recentComments)): ?>
                                <?php foreach($recentComments as $key => $comment) { ?>
                            <tr>
                                <td class="border-0">
                                    <span class="text-warning fw-bold"><?= $key + 1 ?></span>
                                </td>
                                <td class="border-0">
                                    <a href="<?= url('admin/comments') ?>" class="text-dark text-decoration-none">
                                        <div class="fw-medium"><?= $comment['username'] ?></div>
                                    </a>
                                </td>
                                <td class="border-0">
                                    <div class="text-muted small">
                                        <?= strlen($comment['comment']) > 30 ? substr($comment['comment'], 0, 30) . '...' : $comment['comment'] ?>
                                    </div>
                                </td>
                                <td class="border-0 text-center">
                                    <?php if($comment['status'] == 'approved') { ?>
                                        <span class="badge bg-success rounded-pill">Approved</span>
                                    <?php } elseif($comment['status'] == 'pending') { ?>
                                        <span class="badge bg-warning rounded-pill">Pending</span>
                                    <?php } else { ?>
                                        <span class="badge bg-secondary rounded-pill"><?= ucfirst($comment['status']) ?></span>
                                    <?php } ?>
                                </td>
                            </tr>
                            <?php } ?>
                            <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">
                                    <i class="fas fa-inbox fa-2x mb-2"></i><br>
                                    No recent comments
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Wait for page to load
document.addEventListener('DOMContentLoaded', function() {
    // Check if Chart.js is loaded
    if (typeof Chart === 'undefined') {
        console.error('Chart.js is not loaded!');
        document.getElementById('viewsChart').parentElement.innerHTML = `
            <div class="alert alert-danger text-center py-4">
                <i class="fas fa-exclamation-triangle fa-2x mb-2"></i><br>
                Chart.js library not loaded. Please check your internet connection.
            </div>
        `;
        return;
    }
    
    console.log('Chart.js loaded successfully, version:', Chart.version);
    console.log('Chart.js loaded successfully, version:', Chart.version);
    
    // Debug: Log data from PHP
    console.log('Views data from PHP:', <?= json_encode($viewData ?? []) ?>);

    // Chart configuration
    const ctx = document.getElementById('viewsChart');
    if (!ctx) {
        console.error('Canvas element not found!');
        return;
    }
    
    const context = ctx.getContext('2d');

    // Prepare chart data
    <?php 
    $chartLabels = [];
    for($i = 6; $i >= 0; $i--) {
        $chartLabels[] = date('M j', strtotime("-{$i} days"));
    }
    ?>
    const chartLabels = <?= json_encode($chartLabels) ?>;
    
    const rawViewData = <?= json_encode($viewData ?? []) ?>;
    console.log('Raw view data:', rawViewData);
    
    // Process data for last 7 days
    const chartData = [];
    for (let i = 6; i >= 0; i--) {
        const date = new Date();
        date.setDate(date.getDate() - i);
        const dateStr = date.toISOString().split('T')[0];
        
        let dayViews = 0;
        if (rawViewData) {
            const dayData = rawViewData.find(d => d.date === dateStr);
            dayViews = dayData ? parseInt(dayData.views || 0) : 0;
        }
        chartData.push(dayViews);
    }
    
    console.log('Chart labels:', chartLabels);
    console.log('Chart data:', chartData);

const chartConfig = {
    labels: chartLabels,
    datasets: [{
        label: 'Daily Views',
        data: chartData,
        borderColor: 'rgb(54, 162, 235)',
        backgroundColor: 'rgba(54, 162, 235, 0.1)',
        borderWidth: 3,
        fill: true,
        tension: 0.4,
        pointBackgroundColor: 'rgb(54, 162, 235)',
        pointBorderColor: '#fff',
        pointBorderWidth: 2,
        pointRadius: 6,
        pointHoverRadius: 8
    }]
};

console.log('Chart config:', chartConfig);
console.log('Chart.js version:', Chart.version);
console.log('Canvas element:', ctx.canvas);

// Chart options
const chartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        title: {
            display: true,
            text: 'Daily Views Trend',
            font: {
                size: 16,
                weight: 'bold'
            }
        },
        legend: {
            display: false
        },
        tooltip: {
            backgroundColor: 'rgba(0, 0, 0, 0.8)',
            titleColor: '#fff',
            bodyColor: '#fff',
            borderColor: 'rgb(54, 162, 235)',
            borderWidth: 1,
            cornerRadius: 8,
            displayColors: false,
            callbacks: {
                label: function(context) {
                    return 'Views: ' + context.parsed.y.toLocaleString();
                }
            }
        }
    },
    scales: {
        y: {
            beginAtZero: true,
            grid: {
                color: 'rgba(0, 0, 0, 0.1)'
            },
            ticks: {
                font: {
                    size: 12
                },
                callback: function(value) {
                    return value.toLocaleString();
                }
            }
        },
        x: {
            grid: {
                display: false
            },
            ticks: {
                font: {
                    size: 12
                }
            }
        }
    },
    interaction: {
        intersect: false,
        mode: 'index'
    },
    animation: {
        duration: 2000,
        easing: 'easeInOutQuart'
    }
};

// Create chart
try {
    const viewsChart = new Chart(context, {
        type: 'line',
        data: chartConfig,
        options: chartOptions
    });
    console.log('Chart created successfully:', viewsChart);
} catch (error) {
    console.error('Chart creation error:', error);
    document.getElementById('viewsChart').parentElement.innerHTML = `
        <div class="alert alert-warning text-center py-4">
            <i class="fas fa-exclamation-triangle fa-2x mb-2"></i><br>
            Chart loading error: ${error.message}
        </div>
    `;
}

// Refresh chart function
function refreshChart() {
    const refreshBtn = document.getElementById('refreshBtn');
    const originalContent = refreshBtn.innerHTML;
    refreshBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Refreshing...';
    refreshBtn.disabled = true;
    
    // Hiển thị thông báo đang cập nhật
    const toast = document.createElement('div');
    toast.className = 'position-fixed top-0 end-0 p-3';
    toast.style.zIndex = '9999';
    toast.innerHTML = `
        <div class="toast show" role="alert">
            <div class="toast-header">
                <i class="fas fa-chart-line text-primary me-2"></i>
                <strong class="me-auto">Chart Update</strong>
                <small>just now</small>
            </div>
            <div class="toast-body">
                Refreshing view data...
            </div>
        </div>
    `;
    document.body.appendChild(toast);
    
    // Simulate refresh (reload page to get fresh data)
    setTimeout(() => {
        location.reload();
    }, 1500);
}

// Auto refresh every 30 seconds if user is viewing a post
setInterval(() => {
    // Chỉ auto refresh nếu user không tương tác trong 10 giây
    if (document.visibilityState === 'visible') {
        const lastActivity = localStorage.getItem('lastActivity') || Date.now();
        if (Date.now() - lastActivity > 30000) { // 30 seconds
            console.log('Auto refreshing chart data...');
            // Refresh dữ liệu mà không reload page
            location.reload();
        }
    }
}, 30000);

// Track user activity
document.addEventListener('mousemove', () => {
    localStorage.setItem('lastActivity', Date.now());
});

document.addEventListener('keypress', () => {
    localStorage.setItem('lastActivity', Date.now());
});

// Add hover effects to stats cards
document.querySelectorAll('.border.rounded.p-3').forEach(card => {
    card.addEventListener('mouseenter', function() {
        this.style.transform = 'translateY(-2px)';
        this.style.boxShadow = '0 4px 8px rgba(0,0,0,0.1)';
        this.style.transition = 'all 0.3s ease';
    });
    
    card.addEventListener('mouseleave', function() {
        this.style.transform = 'translateY(0)';
        this.style.boxShadow = 'none';
    });
});

}); // Close DOMContentLoaded
</script>

<?php
require_once(BASE_PATH . "/app/Views/admin/layouts/footer.php");
?>
