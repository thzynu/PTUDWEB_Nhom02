<?php

        require_once(BASE_PATH . '/app/Views/admin/layouts/head-tag.php');

        // Calculate counts for statistics
        $pendingCount = 0;
        $approvedCount = 0;
        foreach ($comments as $comment) {
            if ($comment['status'] == 'pending') {
                $pendingCount++;
            } elseif ($comment['status'] == 'approved') {
                $approvedCount++;
            }
        }

?>

<style>
.comment-text {
    max-width: 300px;
    word-wrap: break-word;
    white-space: pre-wrap;
}
.badge {
    font-size: 0.75em;
}
.btn-group-vertical .btn {
    font-size: 0.75em;
    padding: 0.25rem 0.5rem;
}
.table td {
    vertical-align: middle;
}
.toxic-info {
    font-size: 0.8em;
}
.status-pending {
    background: linear-gradient(45deg, #fff3cd, #ffeaa7);
    border-left: 3px solid #ffc107;
}
.status-approved {
    background: linear-gradient(45deg, #d4edda, #c3e6cb);
    border-left: 3px solid #28a745;
}
</style>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h5">
            <i class="fas fa-comments"></i> Quản lý Bình luận
            <small class="text-muted ms-2">Kiểm duyệt bằng AI</small>
        </h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <button type="button" class="btn btn-sm btn-outline-warning">
                    <i class="fas fa-hourglass-half me-1"></i>
                    Chờ duyệt: <?= $pendingCount ?>
                </button>
                <button type="button" class="btn btn-sm btn-outline-success">
                    <i class="fas fa-check-circle me-1"></i>
                    Đã duyệt: <?= $approvedCount ?>
                </button>
            </div>
        </div>
    </div>
    <section class="table-responsive">
        <table class="table table-striped table-sm">
            <caption>Danh sách bình luận</caption>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Email người dùng</th>
                    <th>Tiêu đề bài viết</th>
                    <th>Bình luận</th>
                    <th>Trạng thái</th>
                    <th>Thông tin độc hại</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($comments as $key => $comment) { ?>
                <tr class="<?= $comment['status'] == 'pending' ? 'status-pending' : ($comment['status'] == 'approved' ? 'status-approved' : '') ?>">
                    <td><strong><?= $key += 1 ?></strong></td>
                    <td>
                        <i class="fas fa-user me-1"></i>
                        <?= $comment['email'] ?? $comment['username'] ?? 'Unknown User' ?>
                    </td>
                    <td>
                        <i class="fas fa-newspaper me-1"></i>
                        <span title="<?= htmlspecialchars($comment['post_title']) ?>">
                            <?= strlen($comment['post_title']) > 30 ? substr($comment['post_title'], 0, 30) . '...' : $comment['post_title'] ?>
                        </span>
                    </td>
                    <td>
                        <div class="comment-text" title="<?= htmlspecialchars($comment['comment']) ?>">
                            <?= strlen($comment['comment']) > 100 ? substr($comment['comment'], 0, 100) . '...' : $comment['comment'] ?>
                        </div>
                    </td>
                <td>
                    <?php if ($comment['status'] == 'approved') { ?>
                        <span class="badge bg-success">
                            <i class="fas fa-check-circle me-1"></i>Đã duyệt
                        </span>
                    <?php } elseif ($comment['status'] == 'pending') { ?>
                        <span class="badge bg-warning">
                            <i class="fas fa-hourglass-half me-1"></i>Chờ duyệt (AI phát hiện)
                        </span>
                    <?php } elseif ($comment['status'] == 'seen') { ?>
                        <span class="badge bg-info">
                            <i class="fas fa-eye me-1"></i>Đang xem xét
                        </span>
                    <?php } else { ?>
                        <span class="badge bg-danger">
                            <i class="fas fa-flag me-1"></i>Cần xem xét
                        </span>
                    <?php } ?>
                </td>
                <td>
                    <?php if ($comment['status'] == 'pending') { ?>
                        <small class="text-warning">
                            <i class="fas fa-robot me-1"></i>AI phát hiện nội dung có thể độc hại
                        </small>
                    <?php } elseif ($comment['status'] == 'approved') { ?>
                        <small class="text-success">
                            <i class="fas fa-check me-1"></i>Nội dung sạch
                        </small>
                    <?php } else { ?>
                        <small class="text-muted">
                            <i class="fas fa-question me-1"></i>Chờ xem xét
                        </small>
                    <?php } ?>
                </td>
                <td>
                    <div class="btn-group-vertical" role="group">
                        <?php if ($comment['status'] != 'approved') { ?>
                            <form method="post" action="<?= url('admin/comments/' . $comment['id'] . '/approve') ?>" style="display: inline;">
                                <button type="submit" class="btn btn-sm btn-success mb-1" 
                                        title="Phê duyệt bình luận này"
                                        onclick="return confirm('Bạn có chắc muốn phê duyệt bình luận này không?')">
                                    <i class="fas fa-check me-1"></i>Duyệt
                                </button>
                            </form>
                        <?php } ?>
                        
                        <?php if ($comment['status'] == 'approved') { ?>
                            <form method="post" action="<?= url('admin/comments/' . $comment['id'] . '/unapprove') ?>" style="display: inline;">
                                <button type="submit" class="btn btn-sm btn-warning mb-1" 
                                        title="Chuyển về chờ duyệt"
                                        onclick="return confirm('Chuyển bình luận này về trạng thái chờ duyệt?')">
                                    <i class="fas fa-undo me-1"></i>Hủy duyệt
                                </button>
                            </form>
                        <?php } ?>
                        
                        <form method="post" action="<?= url('admin/comments/' . $comment['id'] . '/delete') ?>" style="display: inline;">
                            <button type="submit" class="btn btn-sm btn-danger" 
                                    onclick="return confirm('Bạn có chắc muốn xóa bình luận này không?')"
                                    title="Xóa bình luận này">
                                <i class="fas fa-trash me-1"></i>Xóa
                            </button>
                        </form>
                    </div>
                </td>
                </tr>

                <?php } ?>
                </tbody>
                </table>
                </section>




<?php

require_once(BASE_PATH . '/app/Views/admin/layouts/footer.php');


?>
