CREATE DATABASE IF NOT EXISTS hotel_db CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
CREATE USER IF NOT EXISTS 'admin'@'localhost' IDENTIFIED BY 'admin123';
GRANT ALL PRIVILEGES ON hotel_db.* TO 'admin'@'localhost';
FLUSH PRIVILEGES;

USE hotel_db;

CREATE TABLE IF NOT EXISTS users (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role ENUM('admin','petugas') NOT NULL DEFAULT 'petugas',
  full_name VARCHAR(150) NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  failed_login INT UNSIGNED NOT NULL DEFAULT 0,
  last_attempt DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO users (username, password, role, full_name) VALUES
('admin', '$2y$10$mVrNMY02IwSPcZLNdM.whes0h.wKH/FfKSQ38jGrpHVu.rKqzyUYq', 'admin', 'Administrator')
ON DUPLICATE KEY UPDATE password = VALUES(password), role = 'admin', full_name = 'Administrator';

CREATE TABLE IF NOT EXISTS room_types (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  type_name VARCHAR(100) NOT NULL UNIQUE,
  description TEXT NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO room_types (type_name, description) VALUES
('Standard', 'Kamar standar untuk 1-2 tamu.'),
('Deluxe', 'Kamar deluxe dengan fasilitas lebih lengkap.'),
('Suite', 'Kamar suite dengan ruang tamu terpisah.')
ON DUPLICATE KEY UPDATE description = VALUES(description);

CREATE TABLE IF NOT EXISTS rooms (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  room_code VARCHAR(50) NOT NULL UNIQUE,
  room_name VARCHAR(150) NOT NULL,
  type_id INT UNSIGNED NOT NULL,
  price DECIMAL(12,2) NOT NULL DEFAULT 0.00,
  capacity TINYINT UNSIGNED NOT NULL DEFAULT 2,
  status ENUM('available','occupied','maintenance') NOT NULL DEFAULT 'available',
  image_path VARCHAR(255) NULL,
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (type_id) REFERENCES room_types(id) ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS reservations (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  room_id INT UNSIGNED NOT NULL,
  user_id INT UNSIGNED NOT NULL,
  guest_name VARCHAR(150) NOT NULL,
  guest_phone VARCHAR(50) NOT NULL,
  check_in DATE NOT NULL,
  check_out DATE NOT NULL,
  total_price DECIMAL(12,2) NOT NULL DEFAULT 0.00,
  status ENUM('booked','checked_in','checked_out','cancelled') NOT NULL DEFAULT 'booked',
  created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (room_id) REFERENCES rooms(id) ON UPDATE CASCADE ON DELETE RESTRICT,
  FOREIGN KEY (user_id) REFERENCES users(id) ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
