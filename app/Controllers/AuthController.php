<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\User;

/**
 * AuthController
 * Xử lý authentication: login, register, logout
 */
class AuthController extends BaseController
{
    protected $userModel;
    
    public function __construct()
    {
        parent::__construct();
        $this->userModel = new User();
    }
    
    /**
     * Hiển thị form login
     */
    public function loginForm()
    {
        // Redirect if already logged in
        if (isset($_SESSION['user'])) {
            // Check if user is admin
            if (isset($_SESSION['admin']) && $_SESSION['admin']) {
                return $this->redirect('admin', 'Bạn đã đăng nhập với tư cách quản trị viên!');
            } else {
                return $this->redirect('', 'Bạn đã đăng nhập rồi!');
            }
        }
        
        return $this->render('auth.login');
    }
    
    /**
     * Xử lý login
     */
    public function login()
    {
        $input = $this->getInput();
        
        // Validate input
        $errors = $this->validate($input, [
            'email' => 'required|email',
            'password' => 'required|min:3'  // Relaxed for existing admin accounts
        ]);
        
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old_input'] = $input;
            return $this->redirectBack('Vui lòng kiểm tra thông tin nhập vào.', 'error');
        }
        
        // Verify credentials
        $user = $this->userModel->verifyCredentials($input['email'], $input['password']);
        
        if ($user) {
            // Set session
            $_SESSION['user'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            
            // Set role flags
            $_SESSION['user'] = [
                'id' => $user['id'],
                'username' => $user['username'],
                'email' => $user['email'],
                'permission' => $user['permission']
            ];
            
            if ($user['permission'] == 'admin' || $user['permission'] == 1) {
                $_SESSION['admin'] = true;
            } elseif ($user['permission'] == 'journalist') {
                $_SESSION['journalist'] = true;
            }
            
            // Update last login
            $this->userModel->updateLastLogin($user['id']);
            
            // Redirect based on user role
            if ($user['permission'] == 'admin' || $user['permission'] == 1) {
                // Admin user - redirect to admin panel
                $redirectUrl = 'admin';
            } elseif ($user['permission'] == 'journalist') {
                // Journalist user - redirect to journalist panel
                $redirectUrl = 'journalist';
            } else {
                // Regular user - redirect to intended page or home
                $redirectUrl = $_SESSION['intended_url'] ?? '';
            }
            unset($_SESSION['intended_url']);
            
            return $this->redirect($redirectUrl, 'Chào mừng bạn trở lại, ' . $user['username'] . '!');
        } else {
            return $this->redirectBack('Email hoặc mật khẩu không đúng.', 'error');
        }
    }
    
    /**
     * Hiển thị form register
     */
    public function registerForm()
    {
        // Redirect if already logged in
        if (isset($_SESSION['user'])) {
            // Check if user is admin
            if (isset($_SESSION['admin']) && $_SESSION['admin']) {
                return $this->redirect('admin', 'Bạn đã đăng nhập với tư cách quản trị viên!');
            } else {
                return $this->redirect('', 'Bạn đã đăng nhập rồi!');
            }
        }
        
        return $this->render('auth.register');
    }
    
    /**
     * Xử lý register
     */
    public function register()
    {
        $input = $this->getInput();
        
        // Validate input
        $errors = $this->validate($input, [
            'first_name' => 'required|min:2|max:50',
            'last_name' => 'required|min:2|max:50',
            'username' => 'required|min:3|max:30',
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);
        
        // Check if email exists
        if ($this->userModel->emailExists($input['email'])) {
            $errors['email'][] = 'Email này đã được đăng ký.';
        }
        
        // Check if username exists
        if ($this->userModel->usernameExists($input['username'])) {
            $errors['username'][] = 'Tên người dùng này đã được sử dụng.';
        }
        
        // Check password confirmation
        if ($input['password'] !== $input['password_confirmation']) {
            $errors['password_confirmation'][] = 'Xác nhận mật khẩu không khớp.';
        }
        
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old_input'] = $input;
            return $this->redirectBack('Please check your input.', 'error');
        }
        
        // Create user
        $userData = [
            'first_name' => $this->sanitize($input['first_name']),
            'last_name' => $this->sanitize($input['last_name']),
            'username' => $this->sanitize($input['username']),
            'email' => $this->sanitize($input['email']),
            'password' => $input['password'],
            'permission' => 0 // Regular user
        ];
        
        $result = $this->userModel->createUser($userData);
        
        if ($result) {
            return $this->redirect('login', 'Đăng ký thành công! Vui lòng đăng nhập.', 'success');
        } else {
            return $this->redirectBack('Đăng ký thất bại. Vui lòng thử lại.', 'error');
        }
    }
    
    /**
     * Logout
     */
    public function logout()
    {
        // Destroy session
        session_unset();
        session_destroy();
        
        return $this->redirect('/', 'Bạn đã đăng xuất thành công.');
    }
    
    /**
     * Hiển thị form forgot password
     */
    public function forgotPasswordForm()
    {
        return $this->render('auth.forgot-password');
    }
    
    /**
     * Xử lý forgot password
     */
    public function forgotPassword()
    {
        $input = $this->getInput();
        
        // Validate email
        $errors = $this->validate($input, [
            'email' => 'required|email'
        ]);
        
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            return $this->redirectBack('Please enter a valid email.', 'error');
        }
        
        $user = $this->userModel->getByEmail($input['email']);
        
        if (!$user) {
            return $this->redirectBack('No account found with that email address.', 'error');
        }
        
        // Generate reset token (simplified)
        $resetToken = bin2hex(random_bytes(32));
        $_SESSION['reset_token'] = $resetToken;
        $_SESSION['reset_email'] = $user['email'];
        $_SESSION['reset_expires'] = time() + 3600; // 1 hour
        
        // In real application, send email here
        return $this->redirect('reset-password?token=' . $resetToken, 'Password reset link sent! (Demo: use the link to reset)', 'success');
    }
    
    /**
     * Hiển thị form reset password
     */
    public function resetPasswordForm()
    {
        $token = $this->getInput('token');
        
        if (!$token || 
            !isset($_SESSION['reset_token']) || 
            $_SESSION['reset_token'] !== $token ||
            time() > $_SESSION['reset_expires']) {
            return $this->redirect('forgot-password', 'Invalid or expired reset token.', 'error');
        }
        
        return $this->render('auth.reset-password', ['token' => $token]);
    }
    
    /**
     * Xử lý reset password
     */
    public function resetPassword()
    {
        $input = $this->getInput();
        $token = $input['token'];
        
        // Validate token
        if (!$token || 
            !isset($_SESSION['reset_token']) || 
            $_SESSION['reset_token'] !== $token ||
            time() > $_SESSION['reset_expires']) {
            return $this->redirect('forgot-password', 'Invalid or expired reset token.', 'error');
        }
        
        // Validate password
        $errors = $this->validate($input, [
            'password' => 'required|min:6'
        ]);
        
        if ($input['password'] !== $input['password_confirmation']) {
            $errors['password_confirmation'][] = 'Password confirmation does not match.';
        }
        
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            return $this->redirectBack('Please check your input.', 'error');
        }
        
        // Get user and update password
        $user = $this->userModel->getByEmail($_SESSION['reset_email']);
        
        if ($user) {
            $this->userModel->updatePassword($user['id'], $input['password']);
            
            // Clear reset session
            unset($_SESSION['reset_token']);
            unset($_SESSION['reset_email']);
            unset($_SESSION['reset_expires']);
            
            return $this->redirect('login', 'Password reset successful! Please log in with your new password.', 'success');
        } else {
            return $this->redirect('forgot-password', 'User not found.', 'error');
        }
    }
}