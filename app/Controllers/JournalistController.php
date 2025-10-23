<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Category;
use App\Models\User;

/**
 * JournalistController
 * Xử lý các chức năng dành cho nhà báo
 */
class JournalistController extends BaseController
{
    private $postModel;
    private $commentModel;
    private $categoryModel;
    private $userModel;

    public function __construct()
    {
        parent::__construct();
        
        // Kiểm tra đăng nhập và quyền journalist
        $this->checkJournalistAuth();
        
        $this->postModel = new Post();
        $this->commentModel = new Comment();
        $this->categoryModel = new Category();
        $this->userModel = new User();
    }

    /**
     * Kiểm tra quyền truy cập của journalist
     */
    private function checkJournalistAuth()
    {
        if (!isset($_SESSION['user'])) {
            $this->redirect('login');
            exit;
        }

        $userPermission = $_SESSION['user']['permission'];
        if (!in_array($userPermission, ['journalist', 'admin'])) {
            $this->redirect('/');
            exit;
        }
    }

    /**
     * Dashboard cho nhà báo
     */
    public function index()
    {
        $currentUserId = $_SESSION['user']['id'];
        
        // Thống kê bài viết của nhà báo hiện tại
        $myPosts = $this->postModel->getPostsByAuthor($currentUserId);
        $publishedCount = count(array_filter($myPosts, function($post) {
            return $post['status'] == 1;
        }));
        $draftCount = count(array_filter($myPosts, function($post) {
            return $post['status'] == 0;
        }));
        
        // Thống kê bình luận trên bài viết của mình
        $myComments = $this->commentModel->getCommentsByAuthorPosts($currentUserId);
        $pendingCommentsCount = count(array_filter($myComments, function($comment) {
            return $comment['status'] == 0;
        }));
        $approvedCommentsCount = count(array_filter($myComments, function($comment) {
            return $comment['status'] == 1;
        }));

        // Bài viết gần đây
        $recentPosts = array_slice($myPosts, 0, 5);
        
        // Bình luận gần đây cần duyệt
        $recentComments = array_slice(array_filter($myComments, function($comment) {
            return $comment['status'] == 0;
        }), 0, 5);

        $data = [
            'title' => 'Dashboard Nhà báo',
            'myPosts' => $myPosts,
            'publishedCount' => $publishedCount,
            'draftCount' => $draftCount,
            'pendingCommentsCount' => $pendingCommentsCount,
            'approvedCommentsCount' => $approvedCommentsCount,
            'recentPosts' => $recentPosts,
            'recentComments' => $recentComments
        ];

        echo $this->render('journalist/dashboard/index', $data);
    }

    /**
     * Hiển thị danh sách bài viết của nhà báo
     */
    public function posts()
    {
        $currentUserId = $_SESSION['user']['id'];
        $myPosts = $this->postModel->getPostsByAuthor($currentUserId);
        
        // Lấy thông tin categories để hiển thị
        $categories = $this->categoryModel->all();
        $categoriesArray = [];
        foreach ($categories as $category) {
            $categoriesArray[$category['id']] = $category;
        }

        $data = [
            'title' => 'Quản lý bài viết',
            'postsArray' => $myPosts,
            'categoriesArray' => $categoriesArray
        ];

        echo $this->render('journalist/post/index', $data);
    }

    /**
     * Hiển thị form tạo bài viết mới
     */
    public function createPost()
    {
        $categories = $this->categoryModel->all();
        
        $data = [
            'title' => 'Tạo bài viết mới',
            'categories' => $categories
        ];

        echo $this->render('journalist/post/create', $data);
    }

    /**
     * Xử lý lưu bài viết mới
     */
    public function storePost()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('journalist/posts');
            return;
        }

        $currentUserId = $_SESSION['user']['id'];
        
        // Validate dữ liệu
        $title = trim($_POST['title'] ?? '');
        $summary = trim($_POST['summary'] ?? '');
        $body = trim($_POST['body'] ?? '');
        $cat_id = intval($_POST['cat_id'] ?? 0);
        $selected = intval($_POST['selected'] ?? 0);
        $breaking_news = intval($_POST['breaking_news'] ?? 0);
        $status = intval($_POST['status'] ?? 0);

        if (empty($title) || empty($body) || $cat_id <= 0) {
            $_SESSION['error'] = 'Vui lòng điền đầy đủ thông tin bắt buộc!';
            $this->redirect('journalist/post/create');
            return;
        }

        // Xử lý upload ảnh
        $imagePath = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $imagePath = $this->uploadPostImage($_FILES['image']);
            if (!$imagePath) {
                $_SESSION['error'] = 'Có lỗi khi tải lên hình ảnh!';
                $this->redirect('journalist/post/create');
                return;
            }
        }

        // Tạo bài viết
        $data = [
            'title' => $title,
            'summary' => $summary,
            'body' => $body,
            'cat_id' => $cat_id,
            'user_id' => $currentUserId,
            'image' => $imagePath,
            'selected' => $selected,
            'breaking_news' => $breaking_news,
            'status' => $status,
            'view' => 0,
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        $result = $this->postModel->create($data);        if ($result) {
            $_SESSION['success'] = 'Bài viết đã được tạo thành công!';
            $this->redirect('journalist/posts');
        } else {
            $_SESSION['error'] = 'Có lỗi khi tạo bài viết!';
            $this->redirect('journalist/post/create');
        }
    }

    /**
     * Hiển thị form chỉnh sửa bài viết
     */
    public function editPost($id)
    {
        $currentUserId = $_SESSION['user']['id'];
        $post = $this->postModel->find($id);
        
        // Kiểm tra quyền sở hữu bài viết
        if (!$post || $post['user_id'] != $currentUserId) {
            $_SESSION['error'] = 'Bạn không có quyền chỉnh sửa bài viết này!';
            $this->redirect('journalist/posts');
            return;
        }

        $categories = $this->categoryModel->all();
        
        $data = [
            'title' => 'Chỉnh sửa bài viết',
            'post' => $post,
            'categories' => $categories
        ];

        echo $this->render('journalist/post/edit', $data);
    }

    /**
     * Xử lý cập nhật bài viết
     */
    public function updatePost($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('journalist/posts');
            return;
        }

        $currentUserId = $_SESSION['user']['id'];
        $post = $this->postModel->find($id);
        
        // Kiểm tra quyền sở hữu
        if (!$post || $post['user_id'] != $currentUserId) {
            $_SESSION['error'] = 'Bạn không có quyền chỉnh sửa bài viết này!';
            $this->redirect('journalist/posts');
            return;
        }

        // Validate và cập nhật tương tự storePost
        $title = trim($_POST['title'] ?? '');
        $summary = trim($_POST['summary'] ?? '');
        $body = trim($_POST['body'] ?? '');
        $cat_id = intval($_POST['cat_id'] ?? 0);
        $selected = intval($_POST['selected'] ?? 0);
        $breaking_news = intval($_POST['breaking_news'] ?? 0);
        $status = intval($_POST['status'] ?? 0);

        if (empty($title) || empty($body) || $cat_id <= 0) {
            $_SESSION['error'] = 'Vui lòng điền đầy đủ thông tin bắt buộc!';
            $this->redirect("journalist/post/edit/{$id}");
            return;
        }

        $updateData = [
            'title' => $title,
            'summary' => $summary,
            'body' => $body,
            'cat_id' => $cat_id,
            'selected' => $selected,
            'breaking_news' => $breaking_news,
            'status' => $status,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // Xử lý ảnh mới nếu có
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $imagePath = $this->uploadPostImage($_FILES['image']);
            if ($imagePath) {
                $updateData['image'] = $imagePath;
            }
        }

        $result = $this->postModel->update($id, $updateData);
        
        if ($result) {
            $_SESSION['success'] = 'Bài viết đã được cập nhật thành công!';
        } else {
            $_SESSION['error'] = 'Có lỗi khi cập nhật bài viết!';
        }
        
        $this->redirect('journalist/posts');
    }

    /**
     * Xóa bài viết
     */
    public function deletePost($id)
    {
        $currentUserId = $_SESSION['user']['id'];
        $post = $this->postModel->find($id);
        
        // Kiểm tra quyền sở hữu
        if (!$post || $post['user_id'] != $currentUserId) {
            $_SESSION['error'] = 'Bạn không có quyền xóa bài viết này!';
            $this->redirect('journalist/posts');
            return;
        }

        $result = $this->postModel->delete($id);
        
        if ($result) {
            $_SESSION['success'] = 'Bài viết đã được xóa thành công!';
        } else {
            $_SESSION['error'] = 'Có lỗi khi xóa bài viết!';
        }
        
        $this->redirect('journalist/posts');
    }

    /**
     * Quản lý bình luận trên bài viết của mình
     */
    public function comments()
    {
        $currentUserId = $_SESSION['user']['id'];
        $myComments = $this->commentModel->getCommentsByAuthorPosts($currentUserId);
        
        $data = [
            'title' => 'Quản lý bình luận',
            'commentsArray' => $myComments
        ];

        echo $this->render('journalist/comment/index', $data);
    }

    /**
     * Duyệt bình luận
     */
    public function approveComment($id)
    {
        $currentUserId = $_SESSION['user']['id'];
        $comment = $this->commentModel->find($id);
        
        if (!$comment) {
            $_SESSION['error'] = 'Bình luận không tồn tại!';
            $this->redirect('journalist/comments');
            return;
        }

        // Kiểm tra xem bình luận có thuộc bài viết của mình không
        $post = $this->postModel->find($comment['post_id']);
        if (!$post || $post['user_id'] != $currentUserId) {
            $_SESSION['error'] = 'Bạn không có quyền duyệt bình luận này!';
            $this->redirect('journalist/comments');
            return;
        }

        $result = $this->commentModel->update($id, [
            'status' => 1,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        
        if ($result) {
            $_SESSION['success'] = 'Bình luận đã được duyệt!';
        } else {
            $_SESSION['error'] = 'Có lỗi khi duyệt bình luận!';
        }
        
        $this->redirect('journalist/comments');
    }

    /**
     * Từ chối/hủy duyệt bình luận
     */
    public function rejectComment($id)
    {
        $currentUserId = $_SESSION['user']['id'];
        $comment = $this->commentModel->find($id);
        
        if (!$comment) {
            $_SESSION['error'] = 'Bình luận không tồn tại!';
            $this->redirect('journalist/comments');
            return;
        }

        // Kiểm tra quyền sở hữu
        $post = $this->postModel->find($comment['post_id']);
        if (!$post || $post['user_id'] != $currentUserId) {
            $_SESSION['error'] = 'Bạn không có quyền từ chối bình luận này!';
            $this->redirect('journalist/comments');
            return;
        }

        $result = $this->commentModel->update($id, [
            'status' => 0,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        
        if ($result) {
            $_SESSION['success'] = 'Bình luận đã được từ chối!';
        } else {
            $_SESSION['error'] = 'Có lỗi khi từ chối bình luận!';
        }
        
        $this->redirect('journalist/comments');
    }

    /**
     * Xóa bình luận
     */
    public function deleteComment($id)
    {
        $currentUserId = $_SESSION['user']['id'];
        $comment = $this->commentModel->find($id);
        
        if (!$comment) {
            $_SESSION['error'] = 'Bình luận không tồn tại!';
            $this->redirect('journalist/comments');
            return;
        }

        // Kiểm tra quyền sở hữu
        $post = $this->postModel->find($comment['post_id']);
        if (!$post || $post['user_id'] != $currentUserId) {
            $_SESSION['error'] = 'Bạn không có quyền xóa bình luận này!';
            $this->redirect('journalist/comments');
            return;
        }

        $result = $this->commentModel->delete($id);
        
        if ($result) {
            $_SESSION['success'] = 'Bình luận đã được xóa!';
        } else {
            $_SESSION['error'] = 'Có lỗi khi xóa bình luận!';
        }
        
        $this->redirect('journalist/comments');
    }

    /**
     * Upload hình ảnh cho bài viết
     */
    private function uploadPostImage($file)
    {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $maxSize = 5 * 1024 * 1024; // 5MB

        if (!in_array($file['type'], $allowedTypes)) {
            return false;
        }

        if ($file['size'] > $maxSize) {
            return false;
        }

        $uploadDir = BASE_PATH . '/public/post-image/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $fileName = date('Y-m-d-H-i-s') . '.' . $extension;
        $uploadPath = $uploadDir . $fileName;

        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            return 'public/post-image/' . $fileName;
        }

        return false;
    }
}
