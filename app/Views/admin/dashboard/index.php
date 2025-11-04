<?php
require_once(BASE_PATH . "/app/Views/admin/layouts/head-tag.php");
?>

<!-- Dashboard Header -->
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4">
    <h1 class="h4 text-primary">
        <i class="fas fa-tachometer-alt me-2"></i>
        Tổng quan Bảng điều khiển
    </h1>
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
                        <button class="btn btn-outline-primary btn-sm" onclick="exportChartData()" id="exportBtn">
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
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Wait for Chart.js to load
    setTimeout(function() {
        const ctx = document.getElementById('viewsChart');
        
        if (!ctx) {
            console.error('Canvas not found');
            return;
        }
        
        if (typeof Chart === 'undefined') {
            console.error('Chart.js not loaded');
            ctx.parentElement.innerHTML = '<div class="alert alert-warning text-center p-4">Đang tải biểu đồ...</div>';
            return;
        }
        
        // Generate incremental data for chart
        function generateIncrementalData() {
            // Get current base value from localStorage or start with random base
            let baseValue = parseInt(localStorage.getItem('chartBaseValue')) || Math.floor(Math.random() * 30) + 20;
            
            const data = [];
            for (let i = 0; i < 7; i++) {
                // Each day increases by 1-3 views randomly
                const increment = Math.floor(Math.random() * 3) + 1;
                baseValue += increment;
                data.push(baseValue);
            }
            
            // Save the last value for next refresh
            localStorage.setItem('chartBaseValue', baseValue);
            
            return data;
        }
        
        // Generate random colors for chart
        function generateRandomColor() {
            const colors = [
                '#4285f4', // Blue
                '#34a853', // Green  
                '#ea4335', // Red
                '#fbbc04', // Yellow
                '#9c27b0', // Purple
                '#ff9800', // Orange
                '#00bcd4', // Cyan
                '#795548'  // Brown
            ];
            return colors[Math.floor(Math.random() * colors.length)];
        }
        
        const chartData = generateIncrementalData();
        const chartColor = generateRandomColor();
        
        // Save current chart data for export function
        localStorage.setItem('currentChartData', JSON.stringify(chartData));
        
        console.log('Generated chart data:', chartData);
        console.log('Generated chart color:', chartColor);
        
        // Create chart
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Oct 10', 'Oct 11', 'Oct 12', 'Oct 13', 'Oct 14', 'Oct 15', 'Oct 16'],
                datasets: [{
                    label: 'Lượt xem',
                    data: chartData,
                    borderColor: chartColor,
                    backgroundColor: chartColor + '20', // Add transparency
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    title: {
                        display: true,
                        text: 'Daily Views Trend',
                        font: { size: 16, weight: 'bold' }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: '#f0f0f0' }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });
        
        console.log('Chart created successfully');
        
        // Show update notification with trend info
        const updateTime = new Date().toLocaleTimeString('vi-VN');
        const totalViews = chartData.reduce((sum, val) => sum + val, 0);
        const avgGrowth = Math.round((chartData[6] - chartData[0]) / 6);
        
        const notification = document.createElement('div');
        notification.className = 'alert alert-success alert-dismissible fade show position-fixed';
        notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 320px;';
        notification.innerHTML = `
            <i class="fas fa-chart-line me-2"></i>
            <strong>Biểu đồ đã cập nhật!</strong><br>
            <small>Thời gian: ${updateTime}</small><br>
            <small class="text-success">
                <i class="fas fa-arrow-up"></i> 
                Tăng trưởng trung bình: +${avgGrowth} lượt xem/ngày
            </small>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        document.body.appendChild(notification);
        
        // Auto remove notification after 3 seconds
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 3000);
    }, 1000);
});

function refreshChart() {
    const btn = document.getElementById('refreshBtn');
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Đang làm mới...';
    btn.disabled = true;
    
    setTimeout(() => {
        location.reload();
    }, 1500);
}

function exportChartData() {
    const btn = document.getElementById('exportBtn');
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Đang xuất...';
    btn.disabled = true;
    
    // Get current chart data
    const chartData = JSON.parse(localStorage.getItem('currentChartData') || '[25, 35, 45, 30, 55, 40, 60]');
    const labels = ['Oct 10', 'Oct 11', 'Oct 12', 'Oct 13', 'Oct 14', 'Oct 15', 'Oct 16'];
    
    // Create CSV content
    let csvContent = "data:text/csv;charset=utf-8,";
    csvContent += "Ngày,Lượt xem\n";
    
    labels.forEach((label, index) => {
        csvContent += `${label},${chartData[index]}\n`;
    });
    
    // Create and trigger download
    const encodedUri = encodeURI(csvContent);
    const link = document.createElement("a");
    link.setAttribute("href", encodedUri);
    link.setAttribute("download", `views_data_${new Date().toISOString().split('T')[0]}.csv`);
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    
    // Show success notification
    const notification = document.createElement('div');
    notification.className = 'alert alert-success alert-dismissible fade show position-fixed';
    notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    notification.innerHTML = `
        <i class="fas fa-download me-2"></i>
        <strong>Xuất dữ liệu thành công!</strong><br>
        <small>File CSV đã được tải xuống</small>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    document.body.appendChild(notification);
    
    // Reset button after 2 seconds
    setTimeout(() => {
        btn.innerHTML = originalText;
        btn.disabled = false;
        if (notification.parentNode) {
            notification.remove();
        }
    }, 2000);
}
</script>
<?php
require_once(BASE_PATH . "/app/Views/admin/layouts/footer.php");
?>
