# Online News Site

Một hệ thống quản lý tin tức trực tuyến được xây dựng bằng PHP thuần, với tính năng phát hiện bình luận độc hại sử dụng Machine Learning.

## Tính năng chính

### Quản lý người dùng
- **3 Loại tài khoản**: Admin, Nhà báo, Người dùng thường
- **Xác thực**: Đăng ký, đăng nhập, quên mật khẩu
- **Phân quyền**: Quản lý quyền truy cập theo vai trò

### Quản lý nội dung
- **Bài viết**: Tạo, sửa, xóa bài viết với editor WYSIWYG
- **Danh mục**: Phân loại bài viết theo chủ đề
- **Banner**: Quản lý banner quảng cáo
- **Menu**: Tùy chỉnh menu điều hướng

### Hệ thống bình luận thông minh
- **AI-Powered**: Phát hiện bình luận độc hại tự động
- **Machine Learning**: Sử dụng scikit-learn để phân loại
- **Flask API**: Microservice xử lý ML riêng biệt

### Giao diện
- **Responsive**: Tương thích đa thiết bị
- **Modern UI**: Bootstrap 5 + FontAwesome
- **Admin Panel**: Giao diện quản trị trực quan

## Công nghệ sử dụng

### Backend
- **PHP 8.1+**: Core language
- **MySQL/MariaDB**: Cơ sở dữ liệu
- **Custom MVC**: Kiến trúc tự xây dựng
- **PHPMailer**: Gửi email
- **Jalali Calendar**: Hỗ trợ lịch Persian

### Frontend
- **HTML5/CSS3**: Markup & Styling
- **Bootstrap 5**: CSS Framework
- **JavaScript/jQuery**: Client-side scripting
- **FontAwesome**: Icon library

### Machine Learning
- **Python 3.8+**: ML runtime
- **Flask**: API framework
- **scikit-learn**: ML library
- **pandas/numpy**: Data processing

## Yêu cầu hệ thống

### Server Requirements
- PHP 8.1 hoặc cao hơn
- MySQL 5.7+ hoặc MariaDB 10.3+
- Apache/Nginx web server
- PHP Extensions: PDO, mbstring, openssl

### ML Service Requirements
- Python 3.8+
- pip package manager
- Virtual environment (khuyến nghị)

## Cài đặt

### 1. Clone Repository
```bash
git clone https://github.com/thzynu/PTUDWEB_Nhom02.git
cd OnlineNewsSite
```

### 2. Cấu hình Database
```sql
-- Tạo database
CREATE DATABASE news_project;

-- Import schema
mysql -u root -p news_project < database/news-project.sql
```

### 3. Cấu hình PHP
```php
// Cập nhật thông tin database trong index.php
define('DB_HOST', 'localhost');
define('DB_NAME', 'news-project');
define('DB_USERNAME', 'your_username');
define('DB_PASSWORD', 'your_password');
```

### 4. Cấu hình Email (Mailtrap)
```php
// Cập nhật thông tin email trong index.php
define('MAIL_USERNAME', 'your_mailtrap_username');
define('MAIL_PASSWORD', 'your_mailtrap_password');
```

### 5. Thiết lập ML Service
```bash
cd "Toxic Comment Classification"

# Tạo virtual environment
python -m venv venv
source venv/bin/activate  # Linux/Mac
# hoặc
venv\Scripts\activate     # Windows

# Cài đặt dependencies
pip install -r requirements.txt

# Chạy Flask API
python flask_api.py
```

### 6. Khởi động Server
```bash
# PHP Development Server
php -S localhost:8000

# Hoặc sử dụng XAMPP/WAMP
# Copy project vào htdocs/www folder
```

## Sử dụng

### Truy cập hệ thống
- **Trang chủ**: `http://localhost:8000`
- **Admin Panel**: `http://localhost:8000/admin`
- **Đăng ký nhà báo**: `http://localhost:8000/journalist`

### Tài khoản mặc định
```
Admin:
- Username: admin
- Password: admin123

Journalist:
- Username: journalist
- Password: journalist123
```

### ML API
```bash
# Test toxic comment detection
curl -X POST http://localhost:5000/predict \
  -H "Content-Type: application/json" \
  -d '{"comment": "This is a test comment"}'
```

## Cấu trúc thư mục

```
OnlineNewsSite/
├── app/
│   ├── Controllers/        # Controllers (MVC)
│   │   ├── Admin/         # Admin controllers
│   │   └── ...
│   ├── Core/              # Core framework classes
│   ├── Models/            # Data models
│   └── Views/             # View templates
│       ├── admin/         # Admin views
│       ├── auth/          # Authentication views
│       └── home/          # Public views
├── database/              # Database files
│   ├── news-project.sql   # Database schema
│   └── DataBase.php       # Database connection
├── lib/                   # Third-party libraries
│   ├── PHPMailer/         # Email library
│   ├── Parsidev/          # Jalali calendar
│   └── ...
├── public/                # Public assets
│   ├── admin-panel/       # Admin CSS/JS
│   ├── app/               # Frontend assets
│   ├── auth/              # Auth page assets
│   ├── banner-image/      # Uploaded banners
│   └── post-image/        # Uploaded post images
├── Toxic Comment Classification/  # ML Service
│   ├── cls.py             # ML classifier
│   ├── flask_api.py       # Flask API
│   └── requirements.txt   # Python dependencies
├── routes.php             # Application routes
├── index.php              # Entry point
└── README.md              # This file
```

## API Endpoints

### Authentication
```
POST /auth/login           # Đăng nhập
POST /auth/register        # Đăng ký
POST /auth/logout          # Đăng xuất
GET  /auth/forgot-password # Quên mật khẩu
```

### Admin Panel
```
GET    /admin                    # Dashboard
GET    /admin/users              # Quản lý users
GET    /admin/posts              # Quản lý bài viết
GET    /admin/categories         # Quản lý danh mục
GET    /admin/comments           # Quản lý bình luận
DELETE /admin/users/{id}         # Xóa user
```

### ML Service
```
POST /predict                    # Phát hiện bình luận độc hại
```

## Đóng góp

1. Fork repository
2. Tạo feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Tạo Pull Request

## License

Dự án này được phân phối dưới MIT License. Xem file `LICENSE` để biết thêm chi tiết.

## Nhóm phát triển

**PTUDWEB_Nhom02**
- GitHub: [@thzynu](https://github.com/thzynu)

## Báo lỗi

Nếu phát hiện lỗi, vui lòng tạo [Issue](https://github.com/thzynu/PTUDWEB_Nhom02/issues) trên GitHub.

## Liên hệ

- Project Link: [https://github.com/thzynu/PTUDWEB_Nhom02](https://github.com/thzynu/PTUDWEB_Nhom02)

---

Nếu dự án hữu ích, hãy cho chúng tôi 5 star nhé!
