DROP TABLE IF EXISTS `bono_module_reviews`;
CREATE TABLE `bono_module_reviews` (
	`id` INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`lang_id` INT NOT NULL,
	`timestamp` INT NOT NULL,
	`ip` varchar(254) NOT NULL,
	`published` BOOLEAN NOT NULL,
	`name` varchar(254) NOT NULL,
	`email` varchar(254) NOT NULL,
	`review` LONGTEXT NOT NULL,
    FOREIGN KEY (lang_id) REFERENCES bono_module_cms_languages(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
