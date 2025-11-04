<?php

require_once BASE_PATH . '/app/Views/admin/layouts/head-tag.php';

?>

<section class="pt-3 pb-1 mb-2 border-bottom">
        <h1 class="h5">Edit User</h1>
    </section>

<section class="row my-3">
    <section class="col-12">

        <form method="post" action="<?= url('admin/users/' . $user['id']) ?>">
            <!-- DEBUG INFO -->
            <div class="alert alert-info">
                <strong>Debug Info:</strong><br>
                Current user permission: <code><?= $user['permission'] ?></code><br>
                User ID: <code><?= $user['id'] ?></code><br>
                Form action: <code><?= url('admin/users/' . $user['id']) ?></code>
            </div>
            
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="<?= $user['username'] ?>" autocomplete="username">
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= $user['email'] ?>" autocomplete="email">
            </div>

        <div class="form-group">
            <label for="permission">Quyền</label>
            <select name="permission" id="permission" class="form-control" required autocomplete="off">
                <option value="user" <?php if($user['permission'] == 'user') echo 'selected'?>>Thành viên</option>
                <option value="journalist" <?php if($user['permission'] == 'journalist') echo 'selected'?>>Nhà báo</option>
                <option value="admin" <?php if($user['permission'] == 'admin') echo 'selected'?>>Quản trị viên</option>
            </select>
            <small class="form-text text-muted">
                Currently selected: <span id="current-selection"><?= $user['permission'] ?></span>
            </small>
        </div>
        
        <script>
        document.getElementById('permission').addEventListener('change', function() {
            console.log('Permission changed to:', this.value);
            document.getElementById('current-selection').textContent = this.value;
        });
        
        // Debug form submission
        document.querySelector('form').addEventListener('submit', function(e) {
            var selectedValue = document.getElementById('permission').value;
            console.log('Form submitting with permission:', selectedValue);
            
            // Add hidden input to ensure value is sent
            var hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'permission_debug';
            hiddenInput.value = selectedValue;
            this.appendChild(hiddenInput);
        });
        </script>
        <button type="submit" class="btn btn-primary btn-sm">update</button>
        </form>

        </section>
        </section>


        <?php

        require_once BASE_PATH . '/app/Views/admin/layouts/footer.php';

        ?>
