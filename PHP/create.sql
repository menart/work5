CREATE DATABASE `work5`
    /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */
    /*!80016 DEFAULT ENCRYPTION='N' */;

CREATE TABLE `user` (
                        `id` int unsigned NOT NULL AUTO_INCREMENT,
                        `login` varchar(45) DEFAULT NULL,
                        `fio` varchar(255) DEFAULT NULL,
                        `email` varchar(255) DEFAULT NULL,
                        `pwd` varchar(100) DEFAULT NULL,
                        PRIMARY KEY (`id`),
                        UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
