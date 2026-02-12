/*M!999999\- enable the sandbox mode */ 
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*M!100616 SET @OLD_NOTE_VERBOSITY=@@NOTE_VERBOSITY, NOTE_VERBOSITY=0 */;
DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `custom_field_values`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `custom_field_values` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `custom_field_id` bigint(20) unsigned NOT NULL,
  `value` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `custom_field_values_user_id_foreign` (`user_id`),
  KEY `custom_field_values_custom_field_id_foreign` (`custom_field_id`),
  CONSTRAINT `custom_field_values_custom_field_id_foreign` FOREIGN KEY (`custom_field_id`) REFERENCES `custom_fields` (`id`) ON DELETE CASCADE,
  CONSTRAINT `custom_field_values_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `custom_fields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `custom_fields` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `category` enum('registration','document') NOT NULL,
  `is_required` tinyint(1) NOT NULL DEFAULT 0,
  `options` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`options`)),
  `order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `data_transportasi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `data_transportasi` (
  `id_alat_transport` float NOT NULL,
  `nm_alat_transport` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id_alat_transport`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `data_wilayah`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `data_wilayah` (
  `id_wil` char(8) NOT NULL,
  `nm_wil` varchar(50) NOT NULL,
  `id_induk_wilayah` varchar(50) DEFAULT NULL,
  `id_level_wil` int(11) NOT NULL,
  PRIMARY KEY (`id_wil`) USING BTREE,
  KEY `id_induk_wilayah` (`id_induk_wilayah`) USING BTREE,
  KEY `id_wil` (`id_wil`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `documents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `documents` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `photo_formal` varchar(255) DEFAULT NULL,
  `ktp_scan` varchar(255) DEFAULT NULL,
  `kk_scan` varchar(255) DEFAULT NULL,
  `ijazah_scan` varchar(255) DEFAULT NULL,
  `report_scan` varchar(255) DEFAULT NULL,
  `achievement_certificate` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `documents_user_id_foreign` (`user_id`),
  CONSTRAINT `documents_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `exam_answers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `exam_answers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `exam_session_id` bigint(20) unsigned NOT NULL,
  `exam_question_id` bigint(20) unsigned NOT NULL,
  `exam_option_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `exam_answers_exam_session_id_foreign` (`exam_session_id`),
  KEY `exam_answers_exam_question_id_foreign` (`exam_question_id`),
  KEY `exam_answers_exam_option_id_foreign` (`exam_option_id`),
  CONSTRAINT `exam_answers_exam_option_id_foreign` FOREIGN KEY (`exam_option_id`) REFERENCES `exam_options` (`id`) ON DELETE CASCADE,
  CONSTRAINT `exam_answers_exam_question_id_foreign` FOREIGN KEY (`exam_question_id`) REFERENCES `exam_questions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `exam_answers_exam_session_id_foreign` FOREIGN KEY (`exam_session_id`) REFERENCES `exam_sessions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `exam_options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `exam_options` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `exam_question_id` bigint(20) unsigned NOT NULL,
  `option_text` varchar(255) NOT NULL,
  `is_correct` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `exam_options_exam_question_id_foreign` (`exam_question_id`),
  CONSTRAINT `exam_options_exam_question_id_foreign` FOREIGN KEY (`exam_question_id`) REFERENCES `exam_questions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `exam_questions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `exam_questions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `exam_id` bigint(20) unsigned NOT NULL,
  `question_text` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `exam_questions_exam_id_foreign` (`exam_id`),
  CONSTRAINT `exam_questions_exam_id_foreign` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `exam_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `exam_sessions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `exam_id` bigint(20) unsigned NOT NULL,
  `start_at` timestamp NULL DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `score` int(11) NOT NULL DEFAULT 0,
  `status` enum('progress','done') NOT NULL DEFAULT 'progress',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `exam_sessions_user_id_foreign` (`user_id`),
  KEY `exam_sessions_exam_id_foreign` (`exam_id`),
  CONSTRAINT `exam_sessions_exam_id_foreign` FOREIGN KEY (`exam_id`) REFERENCES `exams` (`id`) ON DELETE CASCADE,
  CONSTRAINT `exam_sessions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `exams`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `exams` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `duration` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `identities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `identities` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `nik` varchar(16) NOT NULL,
  `birth_place` varchar(255) NOT NULL,
  `birth_date` date NOT NULL,
  `gender` enum('L','P') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `identities_nik_unique` (`nik`),
  KEY `identities_user_id_foreign` (`user_id`),
  CONSTRAINT `identities_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `jenis_tinggal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `jenis_tinggal` (
  `id_jns_tinggal` float NOT NULL,
  `nm_jns_tinggal` varchar(50) NOT NULL,
  PRIMARY KEY (`id_jns_tinggal`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `payments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `account_name` varchar(255) NOT NULL DEFAULT 'Unknown',
  `proof_file` varchar(255) NOT NULL,
  `status` enum('pending','success','failed') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `payments_user_id_foreign` (`user_id`),
  CONSTRAINT `payments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `pekerjaan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `pekerjaan` (
  `id_pekerjaan` float NOT NULL,
  `nm_pekerjaan` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_pekerjaan`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC COMMENT='id_pekerjaan	nm_pekerjaan';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `penghasilan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `penghasilan` (
  `id_penghasilan` float NOT NULL,
  `nm_penghasilan` varchar(50) DEFAULT '0',
  `batas_bawah` int(11) DEFAULT 0,
  `batas_atas` int(11) DEFAULT 0,
  PRIMARY KEY (`id_penghasilan`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=DYNAMIC COMMENT='id_penghasilan	nm_penghasilan	batas_bawah	batas_atas';
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `registration_periods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `registration_periods` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `price` int(11) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `registrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `registrations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `registration_period_id` bigint(20) unsigned DEFAULT NULL,
  `entry_path` varchar(255) NOT NULL,
  `participant_number` varchar(255) DEFAULT NULL,
  `nim` varchar(255) DEFAULT NULL,
  `school_origin` varchar(255) NOT NULL,
  `graduation_year` int(11) NOT NULL,
  `study_program_id` bigint(20) unsigned NOT NULL,
  `study_program_id_second` bigint(20) unsigned DEFAULT NULL,
  `achievement_certificate` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status_kelulusan` enum('lulus','tidak_lulus','pending') NOT NULL DEFAULT 'pending',
  `accepted_study_program_id` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `registrations_user_id_foreign` (`user_id`),
  KEY `registrations_study_program_id_foreign` (`study_program_id`),
  KEY `registrations_registration_period_id_foreign` (`registration_period_id`),
  KEY `registrations_study_program_id_second_foreign` (`study_program_id_second`),
  KEY `registrations_accepted_study_program_id_foreign` (`accepted_study_program_id`),
  CONSTRAINT `registrations_accepted_study_program_id_foreign` FOREIGN KEY (`accepted_study_program_id`) REFERENCES `study_programs` (`id`) ON DELETE SET NULL,
  CONSTRAINT `registrations_registration_period_id_foreign` FOREIGN KEY (`registration_period_id`) REFERENCES `registration_periods` (`id`),
  CONSTRAINT `registrations_study_program_id_foreign` FOREIGN KEY (`study_program_id`) REFERENCES `study_programs` (`id`) ON DELETE CASCADE,
  CONSTRAINT `registrations_study_program_id_second_foreign` FOREIGN KEY (`study_program_id_second`) REFERENCES `study_programs` (`id`) ON DELETE CASCADE,
  CONSTRAINT `registrations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `rekening` varchar(255) DEFAULT '123',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `nama_rekening` varchar(255) DEFAULT 'admin',
  `nama_bank` varchar(255) DEFAULT 'bca',
  `nowa` varchar(255) DEFAULT '08123456789',
  `thumb1` varchar(255) DEFAULT NULL,
  `thumb2` varchar(255) DEFAULT NULL,
  `thumb3` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `student_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `student_details` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `registration_id` bigint(20) unsigned NOT NULL,
  `kewarganegaraan` varchar(255) NOT NULL DEFAULT 'Indonesia',
  `nisn` varchar(10) DEFAULT NULL,
  `npwp` varchar(255) DEFAULT NULL,
  `provinsi` varchar(255) DEFAULT NULL,
  `jalan` varchar(255) DEFAULT NULL,
  `dusun` varchar(255) DEFAULT NULL,
  `rt` varchar(5) DEFAULT NULL,
  `rw` varchar(5) DEFAULT NULL,
  `kelurahan` varchar(255) DEFAULT NULL,
  `kecamatan` varchar(255) DEFAULT NULL,
  `kode_pos` varchar(5) DEFAULT NULL,
  `telepon` varchar(255) DEFAULT NULL,
  `hp` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `penerima_kps` varchar(255) DEFAULT NULL,
  `alat_transportasi` varchar(255) DEFAULT NULL,
  `jenis_tinggal` varchar(255) DEFAULT NULL,
  `kebutuhan_khusus_mahasiswa` varchar(255) DEFAULT 'Tidak Ada',
  `kebutuhan_khusus_ayah` varchar(255) DEFAULT 'Tidak Ada',
  `kebutuhan_khusus_ibu` varchar(255) DEFAULT 'Tidak Ada',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `kabupaten_kota` varchar(255) DEFAULT NULL,
  `province_id` char(8) DEFAULT NULL,
  `city_id` char(8) DEFAULT NULL,
  `district_id` char(8) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `student_details_registration_id_unique` (`registration_id`),
  CONSTRAINT `student_details_registration_id_foreign` FOREIGN KEY (`registration_id`) REFERENCES `registrations` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `student_families`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `student_families` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `registration_id` bigint(20) unsigned NOT NULL,
  `nik_ayah` varchar(255) DEFAULT NULL,
  `nama_ayah` varchar(255) DEFAULT NULL,
  `tgl_lahir_ayah` date DEFAULT NULL,
  `pendidikan_ayah` varchar(255) DEFAULT NULL,
  `pekerjaan_ayah` varchar(255) DEFAULT NULL,
  `penghasilan_ayah` varchar(255) DEFAULT NULL,
  `nik_ibu` varchar(255) DEFAULT NULL,
  `nama_ibu` varchar(255) DEFAULT NULL,
  `tgl_lahir_ibu` date DEFAULT NULL,
  `pendidikan_ibu` varchar(255) DEFAULT NULL,
  `pekerjaan_ibu` varchar(255) DEFAULT NULL,
  `penghasilan_ibu` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `student_families_registration_id_foreign` (`registration_id`),
  CONSTRAINT `student_families_registration_id_foreign` FOREIGN KEY (`registration_id`) REFERENCES `registrations` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `student_profiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `student_profiles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `registration_id` bigint(20) unsigned NOT NULL,
  `religion` varchar(255) NOT NULL,
  `nama_pondok` varchar(255) DEFAULT NULL,
  `alamat_pondok` varchar(255) DEFAULT NULL,
  `nisn` varchar(10) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `student_profiles_nisn_unique` (`nisn`),
  KEY `student_profiles_registration_id_foreign` (`registration_id`),
  CONSTRAINT `student_profiles_registration_id_foreign` FOREIGN KEY (`registration_id`) REFERENCES `registrations` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `study_programs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `study_programs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `faculty` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `study_programs_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `nik` varchar(255) NOT NULL,
  `nama_ibu` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  `status` varchar(255) NOT NULL DEFAULT 'invalid',
  `registration_period_id` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_registration_period_id_foreign` (`registration_period_id`),
  CONSTRAINT `users_registration_period_id_foreign` FOREIGN KEY (`registration_period_id`) REFERENCES `registration_periods` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `validities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `validities` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `is_data_valid` tinyint(1) NOT NULL DEFAULT 0,
  `is_payment_valid` tinyint(1) NOT NULL DEFAULT 0,
  `is_document_valid` tinyint(4) DEFAULT 0,
  `final_status` enum('pending','valid','invalid') NOT NULL DEFAULT 'pending',
  `admin_note` text DEFAULT NULL,
  `verified_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `validities_user_id_foreign` (`user_id`),
  CONSTRAINT `validities_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*M!100616 SET NOTE_VERBOSITY=@OLD_NOTE_VERBOSITY */;

/*M!999999\- enable the sandbox mode */ 
set autocommit=0;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (1,'0001_01_01_000000_create_users_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (2,'0001_01_01_000001_create_cache_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (3,'0001_01_01_000002_create_jobs_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (4,'2025_12_23_144935_add_role_to_users_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (5,'2025_12_23_160353_add_status_to_users_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (6,'2025_12_24_000000_create_study_programs_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (7,'2025_12_25_213033_create_identities_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (8,'2025_12_25_213641_create_registrations_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (9,'2025_12_25_214022_create_documents_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (10,'2025_12_25_214626_create_payments_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (11,'2025_12_25_233134_create_validities_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (12,'2025_12_26_141949_create_registration_periods_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (13,'2025_12_26_194117_add_registration_period_id_to_registrations_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (14,'2025_12_29_123837_create_exams_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (15,'2025_12_29_123838_create_exam_questions_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (16,'2025_12_29_123843_create_exam_options_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (17,'2025_12_29_123844_create_exam_sessions_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (18,'2025_12_29_123845_create_exam_answers_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (19,'2025_12_30_191655_custom_fields',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (20,'2025_12_30_191723_custom_field_values',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (21,'2025_12_30_200032_update_graduation_year_in_registrations_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (22,'2025_12_30_204337_add_registration_period_id_to_users_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (23,'2026_01_14_111059_add_is_document_valid_to_validities_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (24,'2026_01_16_132614_create_settings_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (25,'2026_01_17_054439_add_nama_rekening_to_settings_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (26,'2026_01_17_055830_add_nama_bank_to_settings_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (27,'2026_01_25_103326_student_profiles',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (28,'2026_01_25_103337_student_families',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (29,'2026_01_25_103348_student_details',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (30,'2026_01_25_111723_add_pondok_to_student_profiles_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (31,'2026_01_26_133425_add_second_study_program_to_registrations_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (32,'2026_01_27_151956_add_column_nowa_to_settings',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (33,'2026_01_27_200240_add_column_thumb1_to_settings_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (34,'2026_01_27_203718_add_column_status_kelulusan_to_registrations_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (35,'2026_01_27_214950_add_column_nim_to_registrations_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (36,'2026_01_28_113728_add_column_kabupaten_to_student_details_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (37,'2026_02_04_064514_add_nullable_to_account_name_in_payments_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (38,'2026_02_07_123601_create_data_transportasi_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (39,'2026_02_07_123601_create_data_wilayah_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (40,'2026_02_07_123601_create_penghasilan_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (41,'2026_02_07_125036_create_jenis_tinggal_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (42,'2026_02_07_125036_create_pekerjaan_table',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (43,'2026_02_07_143411_add_provinsi_to_student_details',1);
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES (44,'2026_02_11_215836_add_accepted_study_program_id_to_registrations_table',2);
commit;
