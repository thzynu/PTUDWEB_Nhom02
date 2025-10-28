<?php require_once(BASE_PATH . '/app/Views/layouts/journalist/header.php'); ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-newspaper text-success me-2"></i>
        Quản lý bài viết của tôi
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
    <div class="col-md-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h4 class="text-white mb-0"><?= count($postsArray) ?></h4>
                        <p class="mb-0">Tổng bài viết</p>
                    </div>
                    <div class="ms-3">
                        <i class="fas fa-newspaper fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h4 class="text-white mb-0"><?= count(array_filter($postsArray, function($p) { return $p['status'] == 1; })) ?></h4>
                        <p class="mb-0">Đã xuất bản</p>
                    </div>
                    <div class="ms-3">
                        <i class="fas fa-check-circle fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h4 class="text-white mb-0"><?= count(array_filter($postsArray, function($p) { return $p['status'] == 0; })) ?></h4>
                        <p class="mb-0">Bản nháp</p>
                    </div>
                    <div class="ms-3">
                        <i class="fas fa-edit fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h4 class="text-white mb-0"><?= count(array_filter($postsArray, function($p) { return $p['selected'] == 1; })) ?></h4>
                        <p class="mb-0">Nổi bật</p>
                    </div>
                    <div class="ms-3">
                        <i class="fas fa-star fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filters and Search -->
<div class="card mb-4">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" id="searchInput" class="form-control" placeholder="Tìm kiếm bài viết...">
                </div>
            </div>
            <div class="col-md-3">
                <select id="statusFilter" class="form-select">
                    <option value="">Tất cả trạng thái</option>
                    <option value="published">Đã xuất bản</option>
                    <option value="draft">Bản nháp</option>
                    <option value="breaking">Tin nóng</option>
                    <option value="featured">Nổi bật</option>
                </select>
            </div>
            <div class="col-md-3">
                <select id="categoryFilter" class="form-select">
                    <option value="">Tất cả danh mục</option>
                    <?php foreach ($categoriesArray as $category): ?>
                        <option value="<?= $category['id'] ?>"><?= htmlspecialchars($category['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>
</div>

<!-- Posts Table -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="fas fa-list me-2"></i>Danh sách bài viết
        </h5>
    </div>
    <div class="card-body">
        <?php if (!empty($postsArray)): ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Hình ảnh</th>
                            <th>Bài viết</th>
                            <th>Danh mục</th>
                            <th>Lượt xem</th>
                            <th>Trạng thái</th>
                            <th>Ngày tạo</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody id="postsTable">
                        <?php foreach ($postsArray as $post): ?>
                            <tr data-category="<?= $post['cat_id'] ?>">
                                <td>
                                    <?php if (!empty($post['image'])): ?>
                                        <img src="<?= asset($post['image']) ?>" alt="Post Image" class="img-thumbnail" style="width: 60px; height: 40px; object-fit: cover;">
                                    <?php else: ?>
                                        <div class="bg-light d-flex align-items-center justify-content-center" style="width: 60px; height: 40px;">
                                            <i class="fas fa-image text-muted"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <h6 class="mb-1">
                                        <a href="<?= url('show-post/' . $post['id']) ?>" target="_blank" class="text-decoration-none">
                                            <?= htmlspecialchars(strlen($post['title']) > 50 ? substr($post['title'], 0, 50) . '...' : $post['title']) ?>
                                        </a>
                                    </h6>
                                    <?php if (!empty($post['summary'])): ?>
                                        <small class="text-muted">
                                            <?= htmlspecialchars(strlen($post['summary']) > 80 ? substr($post['summary'], 0, 80) . '...' : $post['summary']) ?>
                                        </small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">
                                        <?= htmlspecialchars($categoriesArray[$post['cat_id']]['name'] ?? 'N/A') ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-info">
                                        <i class="fas fa-eye me-1"></i><?= number_format($post['view']) ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex flex-wrap gap-1">
                                        <?php if ($post['status'] == 1): ?>
                                            <span class="badge bg-success">Đã xuất bản</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning">Bản nháp</span>
                                        <?php endif; ?>
                                        
                                        <?php if ($post['breaking_news'] == 1): ?>
                                            <span class="badge bg-danger">Tin nóng</span>
                                        <?php endif; ?>
                                        
                                        <?php if ($post['selected'] == 1): ?>
                                            <span class="badge bg-info">Nổi bật</span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        <?= date('d/m/Y H:i', strtotime($post['created_at'])) ?>
                                    </small>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= url('show-post/' . $post['id']) ?>" 
                                           class="btn btn-outline-info" 
                                           title="Xem bài viết" 
                                           target="_blank">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?= url('journalist/post/edit/' . $post['id']) ?>" 
                                           class="btn btn-outline-primary" 
                                           title="Sửa">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?= url('journalist/post/delete/' . $post['id']) ?>" 
                                           class="btn btn-outline-danger" 
                                           title="Xóa"
                                           onclick="return confirmDelete('Bạn có chắc chắn muốn xóa bài viết này?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                <h4 class="text-muted">Chưa có bài viết nào</h4>
                <p class="text-muted">Bắt đầu tạo bài viết đầu tiên của bạn!</p>
                <a href="<?= url('journalist/post/create') ?>" class="btn btn-success">
                    <i class="fas fa-plus me-1"></i>Tạo bài viết mới
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const categoryFilter = document.getElementById('categoryFilter');
    const tableRows = document.querySelectorAll('#postsTable tr');

    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase();
        const statusValue = statusFilter.value;
        const categoryValue = categoryFilter.value;

        tableRows.forEach(row => {
            const title = row.querySelector('h6 a')?.textContent.toLowerCase() || '';
            const category = row.dataset.category;
            const statusBadges = row.querySelectorAll('.badge');
            
            let statusMatch = true;
            if (statusValue === 'published') {
                statusMatch = Array.from(statusBadges).some(badge => badge.textContent.includes('Đã xuất bản'));
            } else if (statusValue === 'draft') {
                statusMatch = Array.from(statusBadges).some(badge => badge.textContent.includes('Bản nháp'));
            } else if (statusValue === 'breaking') {
                statusMatch = Array.from(statusBadges).some(badge => badge.textContent.includes('Tin nóng'));
            } else if (statusValue === 'featured') {
                statusMatch = Array.from(statusBadges).some(badge => badge.textContent.includes('Nổi bật'));
            }
            
            const categoryMatch = !categoryValue || category === categoryValue;
            const searchMatch = !searchTerm || title.includes(searchTerm);
            
            if (searchMatch && statusMatch && categoryMatch) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    searchInput.addEventListener('input', filterTable);
    statusFilter.addEventListener('change', filterTable);
    categoryFilter.addEventListener('change', filterTable);
});

function confirmDelete(message) {
    return confirm(message);
}
</script>

<?php require_once(BASE_PATH . '/app/Views/layouts/journalist/footer.php'); ?>