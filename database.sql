-- ZephaChat Database — run this in phpMyAdmin > SQL tab
CREATE DATABASE IF NOT EXISTS zephachat CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE zephachat;

CREATE TABLE IF NOT EXISTS users (
  id           INT AUTO_INCREMENT PRIMARY KEY,
  username     VARCHAR(30)  NOT NULL UNIQUE,
  password     VARCHAR(255) NOT NULL,
  display_name VARCHAR(50)  DEFAULT NULL,
  bio          VARCHAR(160) DEFAULT NULL,
  avatar_type  ENUM('photo','initials') DEFAULT 'initials',
  avatar_photo VARCHAR(255) DEFAULT NULL,
  contact_info VARCHAR(100) DEFAULT NULL,
  last_seen    TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  created_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS messages (
  id         INT AUTO_INCREMENT PRIMARY KEY,
  user_id    INT NOT NULL,
  msg_type   ENUM('text','image','audio','video','document') DEFAULT 'text',
  message    TEXT,
  media_path VARCHAR(255) DEFAULT NULL,
  file_name  VARCHAR(255) DEFAULT NULL,
  sent_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  INDEX idx_id (id),
  INDEX idx_sent_at (sent_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS conversations (
  id         INT AUTO_INCREMENT PRIMARY KEY,
  user1_id   INT NOT NULL,
  user2_id   INT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY unique_convo (user1_id, user2_id),
  FOREIGN KEY (user1_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (user2_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS private_messages (
  id              INT AUTO_INCREMENT PRIMARY KEY,
  conversation_id INT NOT NULL,
  sender_id       INT NOT NULL,
  msg_type        ENUM('text','image','audio','video','document') DEFAULT 'text',
  message         TEXT,
  media_path      VARCHAR(255) DEFAULT NULL,
  file_name       VARCHAR(255) DEFAULT NULL,
  is_read         TINYINT(1) DEFAULT 0,
  sent_at         TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (conversation_id) REFERENCES conversations(id) ON DELETE CASCADE,
  FOREIGN KEY (sender_id) REFERENCES users(id) ON DELETE CASCADE,
  INDEX idx_convo (conversation_id),
  INDEX idx_id (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
