-- Table des priorités et objectifs de temps (SLA)
CREATE TABLE IF NOT EXISTS slas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    label VARCHAR(50),          -- ex: 'Urgent', 'Standard'
    resolution_time_hours INT,  -- Temps max pour résoudre
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Table des Tickets
CREATE TABLE IF NOT EXISTS tickets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    subject VARCHAR(255) NOT NULL,
    description TEXT,
    status ENUM('open', 'pending', 'resolved', 'closed') DEFAULT 'open',
    priority_id INT,            -- Jointure vers la table SLA
    client_id INT,              -- ID de l'utilisateur qui crée
    assigned_to INT NULL,       -- ID de l'agent
    deadline_at DATETIME,       -- Calculé selon le SLA
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (priority_id) REFERENCES slas(id)
) ENGINE=InnoDB;

-- Table des Utilisateurs avec gestion des rôles
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL, -- Sera hashé avec password_hash()
    role ENUM('super_admin', 'admin', 'user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Ajout de quelques données de base
INSERT IGNORE INTO slas (label, resolution_time_hours) VALUES 
('Critique', 2), 
('Urgent', 8), 
('Standard', 24);

-- Insertion de comptes de test (Mot de passe par défaut : 'password123')
INSERT IGNORE INTO users (full_name, email, password, role) VALUES 
('Super Admin Demo', 'superadmin@jadi-digital.com', '$2y$10$0Wx8m1YekLmvb6C4mYCmK.qNjomTNH285DwiGJ3oCuVBZkBEvZ6K6', 'super_admin'),
('Admin Demo', 'admin@jadi-digital.com', '$2y$10$0Wx8m1YekLmvb6C4mYCmK.qNjomTNH285DwiGJ3oCuVBZkBEvZ6K6', 'admin'),
('User Demo', 'user@jadi-digital.com', '$2y$10$0Wx8m1YekLmvb6C4mYCmK.qNjomTNH285DwiGJ3oCuVBZkBEvZ6K6', 'user');

