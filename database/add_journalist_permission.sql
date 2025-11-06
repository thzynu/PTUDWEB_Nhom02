-- Migration: Add 'journalist' to permission enum
-- Date: 2025-11-06
-- Description: Thêm quyền 'journalist' vào bảng users

ALTER TABLE `users` 
MODIFY COLUMN `permission` ENUM('user', 'admin', 'journalist') NOT NULL DEFAULT 'user';
