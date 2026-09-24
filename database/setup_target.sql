-- ============================================================================
-- CYBERSHIELD 2026 — Target Web Setup (CyberBoard)
-- ============================================================================
USE cybershield_lab;

DROP TABLE IF EXISTS target_users;
CREATE TABLE target_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100),
    role ENUM('admin', 'user') DEFAULT 'user',
    bio TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Password admin: CyberAdmin2026!
-- Password user: password123
INSERT INTO target_users (username, password, email, role, bio) VALUES
('admin', '$2y$12$C.fXDGMNauVO74xnBfL8teVGsey44bikyDwV9uq35k51ucXNQjUEi', 'admin@cyberboard.local', 'admin', 'Saya adalah super admin. Tolong jangan hack saya.'),
('hacker_wannabe', '$2y$10$piISkBjEX/nLRoukeXBAWOgDS.ZS1/f24vee91xjFyiCyAy6brv0y', 'hacker@cyberboard.local', 'user', 'Mencoba mencari celah di web ini...');

DROP TABLE IF EXISTS target_posts;
CREATE TABLE target_posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    author_id INT,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

INSERT INTO target_posts (author_id, content) VALUES
(1, 'Selamat datang di CyberBoard! Ini adalah platform diskusi kita.'),
(1, 'Pengumuman: Jangan klik link sembarangan di komentar ya.');
