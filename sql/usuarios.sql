CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(30) UNIQUE NOT NULL,
    email VARCHAR(50) UNIQUE NOT NULL,
    contrasena VARCHAR(255) NOT NULL,  
    rol ENUM('user', 'admin', 'superadmin') NOT NULL DEFAULT 'user',
    fecha_creacion TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    fecha_modificacion TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    estado ENUM('activo', 'inactivo', 'bloqueado') DEFAULT 'activo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DELIMITER $$

CREATE TRIGGER unico_superadmin_insert
BEFORE INSERT ON usuarios
FOR EACH ROW
BEGIN
    IF NEW.rol = 'superadmin' AND 
       (SELECT COUNT(*) FROM usuarios WHERE rol = 'superadmin') > 0 THEN
        SIGNAL SQLSTATE '45000' 
            SET MESSAGE_TEXT = 'Ya existe un superadmin. No se puede crear otro.';
    END IF;
END$$

CREATE TRIGGER unico_superadmin_update
BEFORE UPDATE ON usuarios
FOR EACH ROW
BEGIN
    IF NEW.rol = 'superadmin' AND 
       (SELECT COUNT(*) FROM usuarios WHERE rol = 'superadmin' AND id <> NEW.id) > 0 THEN
        SIGNAL SQLSTATE '45000' 
            SET MESSAGE_TEXT = 'Ya existe un superadmin. No se puede asignar otro.';
    END IF;
END$$

DELIMITER ;
