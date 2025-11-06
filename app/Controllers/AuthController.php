<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\User;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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
            // Check if email is verified (skip for admin and existing users)
            if (isset($user['is_active']) && $user['is_active'] == 0 && $user['permission'] != 'admin') {
                return $this->redirectBack('Vui lòng xác thực email trước khi đăng nhập. Kiểm tra hộp thư của bạn.', 'error');
            }
            
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
        
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old_input'] = $input;
            $_SESSION['register_error'] = 'Vui lòng kiểm tra thông tin nhập vào.';
            return $this->redirectBack('Please check your input.', 'error');
        }
        
        // Create user WITHOUT verify_token first (NULL by default)
        $userData = [
            'username' => $this->sanitize($input['username']),
            'email' => $this->sanitize($input['email']),
            'password' => $input['password'],
            'permission' => 'user', // Regular user (default role)
            'is_active' => 0 // Not active until email verified
        ];
        
        $userId = $this->userModel->createUser($userData);
        
        if ($userId) {
            // Generate verification token AFTER user is created
            $verifyToken = bin2hex(random_bytes(32));
            
            // Update user with verification token
            $this->userModel->update($userId, ['verify_token' => $verifyToken]);
            
            // Send verification email
            $verificationLink = url('verify-email?token=' . $verifyToken . '&email=' . urlencode($input['email']));
            $emailSent = $this->sendVerificationEmail($input['email'], $input['username'], $verificationLink);
            
            if ($emailSent) {
                return $this->redirect('login', 'Đăng ký thành công! Vui lòng kiểm tra email để xác thực tài khoản.', 'success');
            } else {
                return $this->redirect('login', 'Đăng ký thành công! Tuy nhiên có lỗi khi gửi email xác thực. Vui lòng liên hệ admin.', 'warning');
            }
        } else {
            $_SESSION['register_error'] = 'Đăng ký thất bại. Vui lòng thử lại.';
            return $this->redirectBack('Đăng ký thất bại. Vui lòng thử lại.', 'error');
        }
    }
    
    /**
     * Send verification email using PHPMailer
     */
    private function sendVerificationEmail($email, $username, $verificationLink)
    {
        require_once BASE_PATH . '/lib/PHPMailer/PHPMailer/PHPMailer.php';
        require_once BASE_PATH . '/lib/PHPMailer/PHPMailer/SMTP.php';
        require_once BASE_PATH . '/lib/PHPMailer/PHPMailer/Exception.php';
        
        $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
        
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host       = MAIL_HOST;
            $mail->SMTPAuth   = SMTP_AUTH;
            $mail->Username   = MAIL_USERNAME;
            $mail->Password   = MAIL_PASSWORD;
            $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = MAIL_PORT;
            $mail->CharSet    = 'UTF-8';
            
            // Recipients
            $mail->setFrom('noreply@onlinenews.com', 'Online News Site');
            $mail->addAddress($email, $username);
            
            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Xác thực tài khoản - Online News Site';
            $mail->Body    = $this->getVerificationEmailTemplate($username, $verificationLink);
            $mail->AltBody = "Xin chào $username,\n\nVui lòng click vào link sau để xác thực tài khoản:\n$verificationLink";
            
            $mail->send();
            return true;
        } catch (\Exception $e) {
            error_log("Mailer Error: {$mail->ErrorInfo}");
            // Log to file for debugging
            file_put_contents(BASE_PATH . '/email_error.log', date('Y-m-d H:i:s') . " - Error: " . $mail->ErrorInfo . "\n", FILE_APPEND);
            return false;
        }
    }
    
    /**
     * Email verification template
     */
    private function getVerificationEmailTemplate($username, $verificationLink)
    {
        return "
        <!DOCTYPE html>
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: #1a1a1a; color: white; padding: 20px; text-align: center; }
                .content { background: #f9f9f9; padding: 30px; }
                .button { display: inline-block; padding: 12px 30px; background: #007bff; color: white; text-decoration: none; border-radius: 5px; margin: 20px 0; }
                .footer { text-align: center; padding: 20px; color: #666; font-size: 12px; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>Xác thực tài khoản</h1>
                </div>
                <div class='content'>
                    <h2>Xin chào $username!</h2>
                    <p>Cảm ơn bạn đã đăng ký tài khoản tại Online News Site.</p>
                    <p>Vui lòng click vào nút bên dưới để xác thực địa chỉ email của bạn:</p>
                    <p style='text-align: center;'>
                        <a href='$verificationLink' class='button'>Xác thực Email</a>
                    </p>
                    <p>Hoặc copy link sau vào trình duyệt:</p>
                    <p style='word-break: break-all; color: #007bff;'>$verificationLink</p>
                    <p>Nếu bạn không đăng ký tài khoản này, vui lòng bỏ qua email này.</p>
                </div>
                <div class='footer'>
                    <p>&copy; 2025 Online News Site. All rights reserved.</p>
                </div>
            </div>
        </body>
        </html>
        ";
    }
    
    /**
     * Verify email
     */
    public function verifyEmail()
    {
        $token = $_GET['token'] ?? '';
        $email = $_GET['email'] ?? '';
        
        if (empty($token) || empty($email)) {
            return $this->redirect('login', 'Link xác thực không hợp lệ.', 'error');
        }
        
        // Find user by email and token
        $user = $this->userModel->getByEmailAndToken($email, $token);
        
        if (!$user) {
            return $this->redirect('login', 'Link xác thực không hợp lệ hoặc đã hết hạn.', 'error');
        }
        
        // Activate user account
        $updated = $this->userModel->activateAccount($user['id']);
        
        if ($updated) {
            return $this->redirect('login', 'Xác thực email thành công! Bạn có thể đăng nhập ngay bây giờ.', 'success');
        } else {
            return $this->redirect('login', 'Có lỗi xảy ra. Vui lòng thử lại.', 'error');
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
            // Don't reveal if email exists or not (security best practice)
            return $this->redirectBack('Nếu email tồn tại, link đặt lại mật khẩu đã được gửi.', 'success');
        }
        
        // Generate reset token
        $resetToken = bin2hex(random_bytes(32));
        $expireTime = date('Y-m-d H:i:s', time() + 3600); // 1 hour from now
        
        // Update user with reset token
        $this->userModel->update($user['id'], [
            'forgot_token' => $resetToken,
            'forgot_token_expire' => $expireTime
        ]);
        
        // Send reset password email
        $resetLink = url('reset-password?token=' . $resetToken . '&email=' . urlencode($user['email']));
        $emailSent = $this->sendResetPasswordEmail($user['email'], $user['username'], $resetLink);
        
        if ($emailSent) {
            return $this->redirectBack('Link đặt lại mật khẩu đã được gửi đến email của bạn. Vui lòng kiểm tra hộp thư.', 'success');
        } else {
            return $this->redirectBack('Có lỗi khi gửi email. Vui lòng thử lại sau.', 'error');
        }
    }
    
    /**
     * Send reset password email using PHPMailer
     */
    private function sendResetPasswordEmail($email, $username, $resetLink)
    {
        require_once BASE_PATH . '/lib/PHPMailer/PHPMailer/PHPMailer.php';
        require_once BASE_PATH . '/lib/PHPMailer/PHPMailer/SMTP.php';
        require_once BASE_PATH . '/lib/PHPMailer/PHPMailer/Exception.php';
        
        $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
        
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host       = MAIL_HOST;
            $mail->SMTPAuth   = SMTP_AUTH;
            $mail->Username   = MAIL_USERNAME;
            $mail->Password   = MAIL_PASSWORD;
            $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = MAIL_PORT;
            $mail->CharSet    = 'UTF-8';
            
            // Recipients
            $mail->setFrom('noreply@onlinenews.com', 'Online News Site');
            $mail->addAddress($email, $username);
            
            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Đặt lại mật khẩu - Online News Site';
            $mail->Body    = $this->getResetPasswordEmailTemplate($username, $resetLink);
            $mail->AltBody = "Xin chào $username,\n\nClick vào link sau để đặt lại mật khẩu:\n$resetLink\n\nLink này sẽ hết hạn sau 1 giờ.";
            
            $mail->send();
            return true;
        } catch (\Exception $e) {
            error_log("Mailer Error: {$mail->ErrorInfo}");
            file_put_contents(BASE_PATH . '/email_error.log', date('Y-m-d H:i:s') . " - Reset Password Error: " . $mail->ErrorInfo . "\n", FILE_APPEND);
            return false;
        }
    }
    
    /**
     * Reset password email template
     */
    private function getResetPasswordEmailTemplate($username, $resetLink)
    {
        return "
        <!DOCTYPE html>
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: #1a1a1a; color: white; padding: 20px; text-align: center; }
                .content { background: #f9f9f9; padding: 30px; }
                .button { display: inline-block; padding: 12px 30px; background: #dc3545; color: white; text-decoration: none; border-radius: 5px; margin: 20px 0; }
                .footer { text-align: center; padding: 20px; color: #666; font-size: 12px; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h1>Đặt lại mật khẩu</h1>
                </div>
                <div class='content'>
                    <h2>Xin chào $username!</h2>
                    <p>Chúng tôi nhận được yêu cầu đặt lại mật khẩu cho tài khoản của bạn.</p>
                    <p>Vui lòng click vào nút bên dưới để đặt lại mật khẩu:</p>
                    <p style='text-align: center;'>
                        <a href='$resetLink' class='button'>Đặt lại mật khẩu</a>
                    </p>
                    <p>Hoặc copy link sau vào trình duyệt:</p>
                    <p style='word-break: break-all; color: #007bff;'>$resetLink</p>
                    <p><strong>Lưu ý:</strong> Link này sẽ hết hạn sau 1 giờ.</p>
                    <p>Nếu bạn không yêu cầu đặt lại mật khẩu, vui lòng bỏ qua email này.</p>
                </div>
                <div class='footer'>
                    <p>&copy; 2025 Online News Site. All rights reserved.</p>
                </div>
            </div>
        </body>
        </html>
        ";
    }
    
    /**
     * Hiển thị form reset password
     */
    public function resetPasswordForm()
    {
        $token = $_GET['token'] ?? '';
        $email = $_GET['email'] ?? '';
        
        if (!$token || !$email) {
            return $this->redirect('forgot-password', 'Link đặt lại mật khẩu không hợp lệ.', 'error');
        }
        
        // Verify token and check expiry
        $user = $this->userModel->getByEmailAndResetToken($email, $token);
        
        if (!$user) {
            return $this->redirect('forgot-password', 'Link đặt lại mật khẩu không hợp lệ hoặc đã hết hạn.', 'error');
        }
        
        // Check if token is expired
        if (strtotime($user['forgot_token_expire']) < time()) {
            return $this->redirect('forgot-password', 'Link đặt lại mật khẩu đã hết hạn. Vui lòng yêu cầu lại.', 'error');
        }
        
        return $this->render('auth.reset-password', ['token' => $token, 'email' => $email]);
    }
    
    /**
     * Xử lý reset password
     */
    public function resetPassword()
    {
        $input = $this->getInput();
        $token = $input['token'] ?? '';
        $email = $input['email'] ?? '';
        
        // Validate token
        if (!$token || !$email) {
            return $this->redirect('forgot-password', 'Link đặt lại mật khẩu không hợp lệ.', 'error');
        }
        
        // Verify token and check expiry
        $user = $this->userModel->getByEmailAndResetToken($email, $token);
        
        if (!$user) {
            return $this->redirect('forgot-password', 'Link đặt lại mật khẩu không hợp lệ hoặc đã hết hạn.', 'error');
        }
        
        // Check if token is expired
        if (strtotime($user['forgot_token_expire']) < time()) {
            return $this->redirect('forgot-password', 'Link đặt lại mật khẩu đã hết hạn. Vui lòng yêu cầu lại.', 'error');
        }
        
        // Validate password
        $errors = $this->validate($input, [
            'password' => 'required|min:6'
        ]);
        
        if (isset($input['password_confirmation']) && $input['password'] !== $input['password_confirmation']) {
            $errors['password_confirmation'][] = 'Xác nhận mật khẩu không khớp.';
        }
        
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            return $this->redirectBack('Vui lòng kiểm tra thông tin nhập vào.', 'error');
        }
        
        // Update password and clear reset token
        $this->userModel->updatePassword($user['id'], $input['password']);
        $this->userModel->update($user['id'], [
            'forgot_token' => null,
            'forgot_token_expire' => null
        ]);
        
        return $this->redirect('login', 'Đặt lại mật khẩu thành công! Vui lòng đăng nhập với mật khẩu mới.', 'success');
    }
}