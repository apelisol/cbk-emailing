-- Create users table
CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create password reset tokens table
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create sessions table
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create clients table
CREATE TABLE `clients` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `clients_email_unique` (`email`),
  KEY `clients_user_id_foreign` (`user_id`),
  CONSTRAINT `clients_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create email_templates table
CREATE TABLE `email_templates` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `body` longtext NOT NULL,
  `placeholders` json DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `email_templates_user_id_foreign` (`user_id`),
  CONSTRAINT `email_templates_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create email_jobs table
CREATE TABLE `email_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `subject` varchar(255) NOT NULL,
  `body` longtext NOT NULL,
  `recipient_ids` json NOT NULL,
  `type` enum('template','custom') NOT NULL,
  `template_id` bigint(20) UNSIGNED DEFAULT NULL,
  `scheduled_at` datetime NOT NULL,
  `status` enum('pending','processing','completed','failed') NOT NULL DEFAULT 'pending',
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `email_jobs_template_id_foreign` (`template_id`),
  KEY `email_jobs_user_id_foreign` (`user_id`),
  CONSTRAINT `email_jobs_template_id_foreign` FOREIGN KEY (`template_id`) REFERENCES `email_templates` (`id`) ON DELETE CASCADE,
  CONSTRAINT `email_jobs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create sent_emails table
CREATE TABLE `sent_emails` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `recipient_email` varchar(255) NOT NULL,
  `recipient_name` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `body` longtext NOT NULL,
  `status` enum('sent','pending','failed') NOT NULL DEFAULT 'pending',
  `error_message` varchar(255) DEFAULT NULL,
  `sent_at` datetime DEFAULT NULL,
  `email_job_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sent_emails_email_job_id_foreign` (`email_job_id`),
  KEY `sent_emails_client_id_foreign` (`client_id`),
  KEY `sent_emails_user_id_foreign` (`user_id`),
  CONSTRAINT `sent_emails_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE,
  CONSTRAINT `sent_emails_email_job_id_foreign` FOREIGN KEY (`email_job_id`) REFERENCES `email_jobs` (`id`) ON DELETE SET NULL,
  CONSTRAINT `sent_emails_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;