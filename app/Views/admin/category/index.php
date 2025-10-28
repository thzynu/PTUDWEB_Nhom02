<?php

        require_once (BASE_PATH . '/app/Views/admin/layouts/head-tag.php')

?>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h5"><i class="fas fa-newspaper"></i> Danh mục</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a role="button" href="<?= url('admin/categories/create') ?>" class="btn btn-sm btn-success">
                Tạo mới
                </a>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <caption>Danh sách danh mục</caption>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tên</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $key => $category) { ?>
                <tr>
                    <td>
                        <?= $key += 1 ?>
                    </td>
                    <td>
                    <?= $category['name'] ?>
                    </td>
                    <td>
                        <a role="button" href="<?= url('admin/categories/' . $category['id'] . '/edit') ?>" class="btn btn-sm btn-info my-0 mx-1 text-white">Sửa</a>
                        <form method="post" action="<?= url('admin/categories/' . $category['id'] . '/delete') ?>" style="display: inline;">
                            <button type="submit" class="btn btn-sm btn-danger my-0 mx-1" 
                                    onclick="return confirm('Bạn có chắc muốn xóa danh mục này không?')"
                                    title="Xóa danh mục">Xóa</button>
                        </form>
                    </td>
                </tr>
                <?php } ?>

            </tbody>
        </table>
    </div>


    <?php

        require_once (BASE_PATH . '/app/Views/admin/layouts/footer.php')

?>
