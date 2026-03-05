-- Table des priorités et objectifs de temps (SLA)
CREATE TABLE slas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    label VARCHAR(50),          -- ex: 'Urgent', 'Standard'
    resolution_time_hours INT,  -- Temps max pour résoudre
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Table des Tickets
CREATE TABLE tickets (
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

-- 3. Ajout de quelques données de base
INSERT INTO slas (label, resolution_time_hours) VALUES 
('Critique', 2), 
('Urgent', 8), 
('Standard', 24);