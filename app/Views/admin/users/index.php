<?php

        require_once(BASE_PATH . '/app/Views/admin/layouts/head-tag.php');


?>
     <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h5"><i class="fas fa-newspaper"></i> Người dùng</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a role="button" href="<?= url('admin/users/create') ?>" class="btn btn-sm btn-success">Tạo mới</a>
        </div>
    </div>
    <section class="table-responsive">
        <table class="table table-striped table-sm">
            <caption>Danh sách người dùng</caption>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tên đăng nhập</th>
                    <th>Email</th>
                    <th>Quyền</th>
                    <th>Ngày tạo</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $key => $user) { ?>
                <tr>
                    <td><?= $key += 1 ?></td>
                    <td><?= $user['username'] ?></td>
                    <td><?= $user['email'] ?></td>
                    <td>
                        <?php if($user['permission'] == 'admin') { ?>
                            <span class="badge bg-success">Quản trị</span>
                        <?php } else if($user['permission'] == 'journalist') { ?>
                            <span class="badge bg-info">Nhà báo</span>
                        <?php } else { ?>
                            <span class="badge bg-primary">Thành viên</span>
                        <?php } ?>
                    </td>
                    <td><?= date('Y-m-d H:i', strtotime($user['created_at'])) ?></td>
                    <td>
                        <?php if($user['permission'] == 'user') { ?>   
                            <a role="button" class="btn btn-sm btn-success text-white" href="<?= url('admin/users/' . $user['id'] . '/promote') ?>" onclick="return confirm('Bạn có muốn cấp quyền quản trị cho người dùng này?')">Cấp quyền Admin</a>
                        <?php } else { ?>
                            <a role="button" class="btn btn-sm btn-warning text-white" href="<?= url('admin/users/' . $user['id'] . '/demote') ?>" onclick="return confirm('Bạn có muốn hủy quyền quản trị?')">Hủy quyền Admin</a>
                        <?php } ?>
             

                <a role="button" class="btn btn-sm btn-primary text-white" href="<?= url('admin/users/' . $user['id'] . '/edit') ?>">Sửa</a>
                <form style="display: inline-block;" method="POST" action="<?= url('admin/users/' . $user['id']) ?>" onsubmit="return confirm('Bạn có chắc chắn muốn xóa user này không?')">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-sm btn-danger text-white">Xóa</button>
                </form>
                </td>
                </tr>

                <?php } ?>
                </tbody>
                </table>
                </section>


    <?php

        require_once(BASE_PATH . '/app/Views/admin/layouts/footer.php');


?>
