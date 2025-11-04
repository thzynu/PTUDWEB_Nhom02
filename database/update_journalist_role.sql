-- Cập nhật bảng users để thêm role journalist
-- Cập nhật ngày: 2025-10-14

-- Thêm 'journalist' vào enum permission
ALTER TABLE `users` 
MODIFY COLUMN `permission` ENUM('user', 'admin', 'journalist') NOT NULL DEFAULT 'user';

-- Thêm index để tối ưu query theo permission
ALTER TABLE `users` 
ADD INDEX `idx_permission` (`permission`);

-- Tạo user mẫu cho journalist (password: journalist123)
INSERT INTO `users` (`username`, `email`, `password`, `permission`, `is_active`, `created_at`) VALUES
('journalist1', 'journalist@newspaper.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'journalist', 1, NOW());

-- Cập nhật posts table để thêm foreign key tới author (nếu chưa có)
-- Kiểm tra nếu cột author_id chưa tồn tại
ALTER TABLE `posts` 
ADD COLUMN IF NOT EXISTS `author_id` INT(11) DEFAULT NULL AFTER `user_id`,
ADD INDEX IF NOT EXISTS `idx_author` (`author_id`);

-- Thêm foreign key constraint
ALTER TABLE `posts` 
ADD CONSTRAINT `fk_posts_author` 
FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) 
ON DELETE SET NULL ON UPDATE CASCADE;