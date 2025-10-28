<?php require_once(BASE_PATH . '/app/Views/layouts/journalist/header.php'); ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-comments text-success me-2"></i>
        Quản lý bình luận
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-success" id="approveSelected" disabled>
                <i class="fas fa-check me-1"></i>Duyệt đã chọn
            </button>
            <button type="button" class="btn btn-sm btn-outline-warning" id="rejectSelected" disabled>
                <i class="fas fa-times me-1"></i>Từ chối đã chọn
            </button>
        </div>
    </div>
</div>

<!-- Statistics -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h4 class="text-white mb-0"><?= count($commentsArray) ?></h4>
                        <p class="mb-0">Tổng bình luận</p>
                    </div>
                    <div class="ms-3">
                        <i class="fas fa-comments fa-2x"></i>
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
                        <h4 class="text-white mb-0"><?= count(array_filter($commentsArray, function($c) { return $c['status'] == 0; })) ?></h4>
                        <p class="mb-0">Chờ duyệt</p>
                    </div>
                    <div class="ms-3">
                        <i class="fas fa-hourglass-half fa-2x"></i>
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
                        <h4 class="text-white mb-0"><?= count(array_filter($commentsArray, function($c) { return $c['status'] == 1; })) ?></h4>
                        <p class="mb-0">Đã duyệt</p>
                    </div>
                    <div class="ms-3">
                        <i class="fas fa-check-circle fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h4 class="text-white mb-0"><?= count(array_unique(array_column($commentsArray, 'post_id'))) ?></h4>
                        <p class="mb-0">Bài viết có comment</p>
                    </div>
                    <div class="ms-3">
                        <i class="fas fa-newspaper fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" id="searchInput" class="form-control" placeholder="Tìm kiếm bình luận...">
                </div>
            </div>
            <div class="col-md-3">
                <select id="statusFilter" class="form-select">
                    <option value="">Tất cả trạng thái</option>
                    <option value="pending">Chờ duyệt</option>
                    <option value="approved">Đã duyệt</option>
                </select>
            </div>
            <div class="col-md-3">
                <select id="postFilter" class="form-select">
                    <option value="">Tất cả bài viết</option>
                    <?php 
                    $uniquePosts = [];
                    foreach ($commentsArray as $comment) {
                        if (!isset($uniquePosts[$comment['post_id']])) {
                            $uniquePosts[$comment['post_id']] = $comment['post_title'];
                        }
                    }
                    foreach ($uniquePosts as $postId => $postTitle): 
                    ?>
                        <option value="<?= $postId ?>"><?= htmlspecialchars(strlen($postTitle) > 40 ? substr($postTitle, 0, 40) . '...' : $postTitle) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>
</div>

<!-- Comments Table -->
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-list me-2"></i>Danh sách bình luận
            </h5>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="selectAll">
                <label class="form-check-label" for="selectAll">
                    Chọn tất cả
                </label>
            </div>
        </div>
    </div>
    <div class="card-body">
        <?php if (!empty($commentsArray)): ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th width="40px">
                                <input type="checkbox" id="selectAllHeader" class="form-check-input">
                            </th>
                            <th>Bình luận</th>
                            <th>Bài viết</th>
                            <th>Người dùng</th>
                            <th>Trạng thái</th>
                            <th>Ngày tạo</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody id="commentsTable">
                        <?php foreach ($commentsArray as $comment): ?>
                            <tr data-post-id="<?= $comment['post_id'] ?>" data-comment-id="<?= $comment['id'] ?>">
                                <td>
                                    <input type="checkbox" class="form-check-input comment-checkbox" value="<?= $comment['id'] ?>">
                                </td>
                                <td>
                                    <div class="comment-content">
                                        <p class="mb-1">
                                            <?= htmlspecialchars(strlen($comment['comment']) > 100 ? substr($comment['comment'], 0, 100) . '...' : $comment['comment']) ?>
                                        </p>
                                        <?php if (strlen($comment['comment']) > 100): ?>
                                            <button class="btn btn-sm btn-link p-0" onclick="toggleFullComment(this)">
                                                <small>Xem thêm</small>
                                            </button>
                                            <div class="full-comment" style="display: none;">
                                                <?= htmlspecialchars($comment['comment']) ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td>
                                    <a href="<?= url('show-post/' . $comment['post_id']) ?>" target="_blank" class="text-decoration-none">
                                        <?= htmlspecialchars(strlen($comment['post_title']) > 50 ? substr($comment['post_title'], 0, 50) . '...' : $comment['post_title']) ?>
                                    </a>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <strong><?= htmlspecialchars($comment['username']) ?></strong><br>
                                            <small class="text-muted"><?= htmlspecialchars($comment['email']) ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <?php if ($comment['status'] == 1): ?>
                                        <span class="badge bg-success">
                                            <i class="fas fa-check me-1"></i>Đã duyệt
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-warning">
                                            <i class="fas fa-hourglass-half me-1"></i>Chờ duyệt
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        <?= date('d/m/Y H:i', strtotime($comment['created_at'])) ?>
                                    </small>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <?php if ($comment['status'] == 0): ?>
                                            <a href="<?= url('journalist/comment/approve/' . $comment['id']) ?>" 
                                               class="btn btn-outline-success" 
                                               title="Duyệt bình luận">
                                                <i class="fas fa-check"></i>
                                            </a>
                                        <?php else: ?>
                                            <a href="<?= url('journalist/comment/reject/' . $comment['id']) ?>" 
                                               class="btn btn-outline-warning" 
                                               title="Hủy duyệt">
                                                <i class="fas fa-times"></i>
                                            </a>
                                        <?php endif; ?>
                                        <a href="<?= url('show-post/' . $comment['post_id']) ?>" 
                                           class="btn btn-outline-info" 
                                           title="Xem bài viết" 
                                           target="_blank">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?= url('journalist/comment/delete/' . $comment['id']) ?>" 
                                           class="btn btn-outline-danger" 
                                           title="Xóa bình luận"
                                           onclick="return confirmDelete('Bạn có chắc chắn muốn xóa bình luận này?')">
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
                <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                <h4 class="text-muted">Chưa có bình luận nào</h4>
                <p class="text-muted">Bình luận sẽ xuất hiện khi người dùng comment trên bài viết của bạn.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const postFilter = document.getElementById('postFilter');
    const tableRows = document.querySelectorAll('#commentsTable tr');
    const selectAll = document.getElementById('selectAll');
    const selectAllHeader = document.getElementById('selectAllHeader');
    const commentCheckboxes = document.querySelectorAll('.comment-checkbox');
    const approveSelected = document.getElementById('approveSelected');
    const rejectSelected = document.getElementById('rejectSelected');

    // Filter functionality
    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase();
        const statusValue = statusFilter.value;
        const postValue = postFilter.value;

        tableRows.forEach(row => {
            const comment = row.querySelector('.comment-content')?.textContent.toLowerCase() || '';
            const postId = row.dataset.postId;
            const statusBadge = row.querySelector('.badge');
            
            let statusMatch = true;
            if (statusValue === 'pending') {
                statusMatch = statusBadge && statusBadge.textContent.includes('Chờ duyệt');
            } else if (statusValue === 'approved') {
                statusMatch = statusBadge && statusBadge.textContent.includes('Đã duyệt');
            }
            
            const postMatch = !postValue || postId === postValue;
            const searchMatch = !searchTerm || comment.includes(searchTerm);
            
            if (searchMatch && statusMatch && postMatch) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
        
        updateSelectedCount();
    }

    // Select all functionality
    function updateSelectAll() {
        const visibleCheckboxes = Array.from(commentCheckboxes).filter(cb => 
            cb.closest('tr').style.display !== 'none'
        );
        const checkedCount = visibleCheckboxes.filter(cb => cb.checked).length;
        
        selectAll.indeterminate = checkedCount > 0 && checkedCount < visibleCheckboxes.length;
        selectAll.checked = checkedCount === visibleCheckboxes.length && visibleCheckboxes.length > 0;
        selectAllHeader.indeterminate = selectAll.indeterminate;
        selectAllHeader.checked = selectAll.checked;
        
        updateSelectedCount();
    }

    function updateSelectedCount() {
        const checkedBoxes = document.querySelectorAll('.comment-checkbox:checked');
        const count = checkedBoxes.length;
        
        approveSelected.disabled = count === 0;
        rejectSelected.disabled = count === 0;
        
        if (count > 0) {
            approveSelected.innerHTML = `<i class="fas fa-check me-1"></i>Duyệt đã chọn (${count})`;
            rejectSelected.innerHTML = `<i class="fas fa-times me-1"></i>Từ chối đã chọn (${count})`;
        } else {
            approveSelected.innerHTML = '<i class="fas fa-check me-1"></i>Duyệt đã chọn';
            rejectSelected.innerHTML = '<i class="fas fa-times me-1"></i>Từ chối đã chọn';
        }
    }

    // Event listeners
    searchInput.addEventListener('input', filterTable);
    statusFilter.addEventListener('change', filterTable);
    postFilter.addEventListener('change', filterTable);

    selectAll.addEventListener('change', function() {
        const visibleCheckboxes = Array.from(commentCheckboxes).filter(cb => 
            cb.closest('tr').style.display !== 'none'
        );
        visibleCheckboxes.forEach(cb => cb.checked = this.checked);
        updateSelectedCount();
    });

    selectAllHeader.addEventListener('change', function() {
        selectAll.checked = this.checked;
        selectAll.dispatchEvent(new Event('change'));
    });

    commentCheckboxes.forEach(cb => {
        cb.addEventListener('change', updateSelectAll);
    });

    // Batch actions
    approveSelected.addEventListener('click', function() {
        const selected = document.querySelectorAll('.comment-checkbox:checked');
        if (selected.length === 0) return;
        
        if (confirm(`Bạn có chắc chắn muốn duyệt ${selected.length} bình luận đã chọn?`)) {
            const ids = Array.from(selected).map(cb => cb.value);
            batchAction('approve', ids);
        }
    });

    rejectSelected.addEventListener('click', function() {
        const selected = document.querySelectorAll('.comment-checkbox:checked');
        if (selected.length === 0) return;
        
        if (confirm(`Bạn có chắc chắn muốn từ chối ${selected.length} bình luận đã chọn?`)) {
            const ids = Array.from(selected).map(cb => cb.value);
            batchAction('reject', ids);
        }
    });

    function batchAction(action, ids) {
        // For now, redirect to individual actions
        // In a real implementation, you'd want a batch endpoint
        if (ids.length > 0) {
            window.location.href = `<?= url('journalist/comment/') ?>${action}/${ids[0]}`;
        }
    }

    updateSelectedCount();
});

function toggleFullComment(button) {
    const commentDiv = button.closest('.comment-content');
    const fullComment = commentDiv.querySelector('.full-comment');
    const shortComment = commentDiv.querySelector('p');
    
    if (fullComment.style.display === 'none') {
        fullComment.style.display = 'block';
        shortComment.style.display = 'none';
        button.innerHTML = '<small>Thu gọn</small>';
    } else {
        fullComment.style.display = 'none';
        shortComment.style.display = 'block';
        button.innerHTML = '<small>Xem thêm</small>';
    }
}

function confirmDelete(message) {
    return confirm(message);
}
</script>

<style>
.comment-content {
    max-width: 300px;
}

.full-comment {
    white-space: pre-wrap;
    word-wrap: break-word;
}

.table th {
    border-top: none;
    font-weight: 600;
    background-color: #f8f9fa;
}

.badge {
    font-size: 0.75rem;
}

.btn-group-sm > .btn, .btn-sm {
    font-size: 0.775rem;
}

.card-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}
</style>

<?php require_once(BASE_PATH . '/app/Views/layouts/journalist/footer.php'); ?>