<?php require_once(BASE_PATH . '/app/Views/layouts/journalist/header.php'); ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-plus-circle text-success me-2"></i>
        Tạo bài viết mới
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="<?= url('journalist/posts') ?>" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i>Quay lại
            </a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form method="post" action="<?= url('journalist/post/store') ?>" enctype="multipart/form-data" id="createPostForm">
            <div class="row">
                <div class="col-lg-8">
                    <!-- Title -->
                    <div class="mb-3">
                        <label for="title" class="form-label">
                            <i class="fas fa-heading me-1"></i>Tiêu đề bài viết <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" id="title" name="title" 
                               placeholder="Nhập tiêu đề bài viết..." required autofocus>
                    </div>

                    <!-- Summary -->
                    <div class="mb-3">
                        <label for="summary" class="form-label">
                            <i class="fas fa-file-alt me-1"></i>Tóm tắt
                        </label>
                        <textarea class="form-control" id="summary" name="summary" rows="3" 
                                  placeholder="Nhập tóm tắt ngắn gọn về bài viết..."></textarea>
                        <small class="form-text text-muted">Tóm tắt sẽ hiển thị trong danh sách bài viết</small>
                    </div>

                    <!-- Body -->
                    <div class="mb-3">
                        <label for="body" class="form-label">
                            <i class="fas fa-align-left me-1"></i>Nội dung bài viết <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control" id="body" name="body" rows="15" 
                                  placeholder="Nhập nội dung chi tiết bài viết..." required></textarea>
                        <small class="form-text text-muted">Nội dung chính của bài viết</small>
                    </div>
                </div>

                <div class="col-lg-4">
                    <!-- Publish Settings -->
                    <div class="card mb-3">
                        <div class="card-header">
                            <h6 class="mb-0"><i class="fas fa-cog me-1"></i>Cài đặt xuất bản</h6>
                        </div>
                        <div class="card-body">
                            <!-- Category -->
                            <div class="mb-3">
                                <label for="cat_id" class="form-label">Danh mục <span class="text-danger">*</span></label>
                                <select name="cat_id" id="cat_id" class="form-select" required>
                                    <option value="">Chọn danh mục</option>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?= $category['id'] ?>">
                                            <?= htmlspecialchars($category['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Status -->
                            <div class="mb-3">
                                <label for="status" class="form-label">Trạng thái</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="0">Bản nháp</option>
                                    <option value="1">Xuất bản ngay</option>
                                </select>
                                <small class="form-text text-muted">Chọn "Bản nháp" để lưu và chỉnh sửa sau</small>
                            </div>

                            <!-- Featured -->
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="selected" name="selected" value="1">
                                    <label class="form-check-label" for="selected">
                                        <i class="fas fa-star text-warning me-1"></i>Bài viết nổi bật
                                    </label>
                                </div>
                                <small class="form-text text-muted">Bài viết nổi bật sẽ hiển thị ưu tiên</small>
                            </div>

                            <!-- Breaking News -->
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="breaking_news" name="breaking_news" value="1">
                                    <label class="form-check-label" for="breaking_news">
                                        <i class="fas fa-exclamation-triangle text-danger me-1"></i>Tin nóng
                                    </label>
                                </div>
                                <small class="form-text text-muted">Đánh dấu là tin tức khẩn cấp</small>
                            </div>
                        </div>
                    </div>

                    <!-- Featured Image -->
                    <div class="card mb-3">
                        <div class="card-header">
                            <h6 class="mb-0"><i class="fas fa-image me-1"></i>Hình ảnh đại diện</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <input type="file" id="image" name="image" class="form-control" accept="image/*">
                                <small class="form-text text-muted">Định dạng: JPG, PNG, GIF, WEBP (tối đa 5MB)</small>
                            </div>
                            <div id="imagePreview" class="text-center" style="display: none;">
                                <img id="previewImg" src="" alt="Preview" class="img-fluid rounded" style="max-height: 200px;">
                                <div class="mt-2">
                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="clearImagePreview()">
                                        <i class="fas fa-times me-1"></i>Xóa ảnh
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0"><i class="fas fa-bolt me-1"></i>Thao tác nhanh</h6>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <button type="submit" name="action" value="draft" class="btn btn-outline-warning">
                                    <i class="fas fa-save me-1"></i>Lưu bản nháp
                                </button>
                                <button type="submit" name="action" value="publish" class="btn btn-success">
                                    <i class="fas fa-paper-plane me-1"></i>Xuất bản ngay
                                </button>
                                <a href="<?= url('journalist/posts') ?>" class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-1"></i>Hủy bỏ
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    .form-label {
        font-weight: 600;
        color: #495057;
    }
    
    .card {
        border: none;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    
    .card-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-bottom: 1px solid #dee2e6;
        font-weight: 600;
    }
    
    .form-check-input:checked {
        background-color: #28a745;
        border-color: #28a745;
    }
    
    .btn-success {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        border: none;
    }
    
    .btn-success:hover {
        background: linear-gradient(135deg, #218838 0%, #1e9f86 100%);
        transform: translateY(-1px);
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #28a745;
        box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
    }
    
    #imagePreview {
        border: 2px dashed #dee2e6;
        border-radius: 8px;
        padding: 15px;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const imageInput = document.getElementById('image');
    const imagePreview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');
    const form = document.getElementById('createPostForm');
    
    // Image preview functionality
    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            if (file.size > 5 * 1024 * 1024) { // 5MB
                alert('Kích thước file quá lớn! Vui lòng chọn ảnh dưới 5MB.');
                e.target.value = '';
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                imagePreview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });
    
    // Handle quick action buttons
    document.querySelectorAll('button[name="action"]').forEach(button => {
        button.addEventListener('click', function(e) {
            const action = this.value;
            const statusSelect = document.getElementById('status');
            
            if (action === 'draft') {
                statusSelect.value = '0';
            } else if (action === 'publish') {
                statusSelect.value = '1';
            }
        });
    });
    
    // Auto-save draft functionality (every 30 seconds)
    let autoSaveInterval;
    function startAutoSave() {
        autoSaveInterval = setInterval(() => {
            const title = document.getElementById('title').value;
            const body = document.getElementById('body').value;
            
            if (title.trim() || body.trim()) {
                // Save draft to localStorage
                const draftData = {
                    title: title,
                    summary: document.getElementById('summary').value,
                    body: body,
                    cat_id: document.getElementById('cat_id').value,
                    selected: document.getElementById('selected').checked,
                    breaking_news: document.getElementById('breaking_news').checked,
                    timestamp: Date.now()
                };
                
                localStorage.setItem('journalist_draft', JSON.stringify(draftData));
                
                // Show auto-save indicator
                showAutoSaveIndicator();
            }
        }, 30000); // 30 seconds
    }
    
    // Load draft from localStorage if exists
    function loadDraft() {
        const savedDraft = localStorage.getItem('journalist_draft');
        if (savedDraft) {
            const draft = JSON.parse(savedDraft);
            
            // Check if draft is less than 24 hours old
            if (Date.now() - draft.timestamp < 24 * 60 * 60 * 1000) {
                if (confirm('Tìm thấy bản nháp đã lưu. Bạn có muốn khôi phục không?')) {
                    document.getElementById('title').value = draft.title || '';
                    document.getElementById('summary').value = draft.summary || '';
                    document.getElementById('body').value = draft.body || '';
                    document.getElementById('cat_id').value = draft.cat_id || '';
                    document.getElementById('selected').checked = draft.selected || false;
                    document.getElementById('breaking_news').checked = draft.breaking_news || false;
                }
            }
        }
    }
    
    function showAutoSaveIndicator() {
        // Create or update auto-save indicator
        let indicator = document.getElementById('auto-save-indicator');
        if (!indicator) {
            indicator = document.createElement('div');
            indicator.id = 'auto-save-indicator';
            indicator.className = 'position-fixed top-0 end-0 m-3 alert alert-success alert-dismissible fade show';
            indicator.style.zIndex = '9999';
            document.body.appendChild(indicator);
        }
        
        indicator.innerHTML = `
            <i class="fas fa-save me-1"></i>
            Đã tự động lưu bản nháp
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        // Auto-hide after 3 seconds
        setTimeout(() => {
            if (indicator) {
                indicator.remove();
            }
        }, 3000);
    }
    
    // Clear auto-save when form is submitted
    form.addEventListener('submit', function() {
        if (autoSaveInterval) {
            clearInterval(autoSaveInterval);
        }
        localStorage.removeItem('journalist_draft');
    });
    
    // Initialize
    loadDraft();
    startAutoSave();
});

function clearImagePreview() {
    document.getElementById('image').value = '';
    document.getElementById('imagePreview').style.display = 'none';
    document.getElementById('previewImg').src = '';
}

// Form validation
document.getElementById('createPostForm').addEventListener('submit', function(e) {
    const title = document.getElementById('title').value.trim();
    const body = document.getElementById('body').value.trim();
    const category = document.getElementById('cat_id').value;
    
    if (!title) {
        alert('Vui lòng nhập tiêu đề bài viết!');
        e.preventDefault();
        document.getElementById('title').focus();
        return false;
    }
    
    if (!body) {
        alert('Vui lòng nhập nội dung bài viết!');
        e.preventDefault();
        document.getElementById('body').focus();
        return false;
    }
    
    if (!category) {
        alert('Vui lòng chọn danh mục!');
        e.preventDefault();
        document.getElementById('cat_id').focus();
        return false;
    }
    
    return true;
});
</script>

<?php require_once(BASE_PATH . '/app/Views/layouts/journalist/footer.php'); ?>