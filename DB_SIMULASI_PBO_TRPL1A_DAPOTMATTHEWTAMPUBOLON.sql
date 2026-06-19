-- MySQL dump 10.13  Distrib 8.0.45, for Linux (x86_64)
--
-- Host: localhost    Database: DB_SIMULASI_PBO_TRPL1A_DAPOTMATTHEWTAMPUBOLON
-- ------------------------------------------------------
-- Server version	8.0.45-0ubuntu0.24.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `tabel_pendaftaran`
--

DROP TABLE IF EXISTS `tabel_pendaftaran`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tabel_pendaftaran` (
  `id_pendaftaran` int NOT NULL AUTO_INCREMENT,
  `nama_calon` varchar(100) NOT NULL,
  `asal_sekolah` varchar(100) NOT NULL,
  `nilai_ujian` decimal(5,2) NOT NULL,
  `biaya_pendaftaran_dasar` decimal(10,2) NOT NULL,
  `jalur_pendaftaran` enum('Reguler','Prestasi','Kedinasan') NOT NULL,
  `pilihan_prodi` varchar(100) DEFAULT NULL,
  `lokasi_kampus` varchar(100) DEFAULT NULL,
  `jenis_prestasi` varchar(100) DEFAULT NULL,
  `tingkat_prestasi` varchar(50) DEFAULT NULL,
  `sk_ikatan_dinas` varchar(100) DEFAULT NULL,
  `instansi_sponsor` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_pendaftaran`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tabel_pendaftaran`
--

LOCK TABLES `tabel_pendaftaran` WRITE;
/*!40000 ALTER TABLE `tabel_pendaftaran` DISABLE KEYS */;
INSERT INTO `tabel_pendaftaran` VALUES (1,'Dapot Matthew','SMA Negeri 1 Medan',88.50,150000.00,'Reguler','Teknologi Rekayasa Perangkat Lunak','Kampus Utama',NULL,NULL,NULL,NULL),(2,'Budi Santoso','SMA Negeri 3 Jakarta',82.00,150000.00,'Reguler','Teknik Informatika','Kampus Utama',NULL,NULL,NULL,NULL),(3,'Siti Aminah','MAN 1 Yogyakarta',85.75,150000.00,'Reguler','Sistem Informasi','Kampus Utama',NULL,NULL,NULL,NULL),(4,'Rian Hidayat','SMA Negeri 2 Bandung',79.90,150000.00,'Reguler','Teknologi Rekayasa Perangkat Lunak','Kampus Cabang',NULL,NULL,NULL,NULL),(5,'Dewi Lestari','SMA Negeri 8 Surabaya',91.20,150000.00,'Reguler','Teknik Komputer','Kampus Utama',NULL,NULL,NULL,NULL),(6,'Eko Prasetyo','SMK Negeri 1 Semarang',84.50,150000.00,'Reguler','Sistem Informasi','Kampus Cabang',NULL,NULL,NULL,NULL),(7,'Farhan Alamsyah','SMA Negeri 5 Palembang',77.00,150000.00,'Reguler','Teknik Informatika','Kampus Utama',NULL,NULL,NULL,NULL),(8,'Gita Gutawa','SMA Taruna Nusantara',95.00,150000.00,'Prestasi',NULL,NULL,'Olimpiade Matematika','Nasional',NULL,NULL),(9,'Hendra Setiawan','SMA Kristen Yusuf',92.50,150000.00,'Prestasi',NULL,NULL,'Kejuaraan Bulu Tangkis','Internasional',NULL,NULL),(10,'Indah Permata','SMA Negeri 1 Surakarta',89.00,150000.00,'Prestasi',NULL,NULL,'Lomba Karya Ilmiah Remaja','Provinsi',NULL,NULL),(11,'Joko Widodo','SMA Negeri 6 Surakarta',90.00,150000.00,'Prestasi',NULL,NULL,'Lomba Debat Bahasa Inggris','Nasional',NULL,NULL),(12,'Kartika Putri','SMA Negeri 1 Denpasar',93.40,150000.00,'Prestasi',NULL,NULL,'Olimpiade Fisika','Provinsi',NULL,NULL),(13,'Lukman Hakim','MAN Insan Cendekia',96.10,150000.00,'Prestasi',NULL,NULL,'Hafizh Quran 30 Juz','Nasional',NULL,NULL),(14,'Mega Utami','SMA Negeri 7 Pine',88.00,150000.00,'Prestasi',NULL,NULL,'Lomba Catur','Kabupaten/Kota',NULL,NULL),(15,'Naufal Abyan','SMA Negeri 1 Bogor',87.50,150000.00,'Kedinasan',NULL,NULL,NULL,NULL,'SK-102/KEDINASAN/2026','Kementerian Perhubungan'),(16,'Oki Setiana','SMA Negeri 1 Depok',86.20,150000.00,'Kedinasan',NULL,NULL,NULL,NULL,'SK-205/KEDINASAN/2026','Badan Siber dan Sandi Negara'),(17,'Prabowo Subianto','SMA Negeri 2 Jakarta',89.90,150000.00,'Kedinasan',NULL,NULL,NULL,NULL,'SK-311/KEDINASAN/2026','Kementerian Pertahanan'),(18,'Qori Sandioriva','SMA Negeri 3 Banda Aceh',84.00,150000.00,'Kedinasan',NULL,NULL,NULL,NULL,'SK-419/KEDINASAN/2026','Kementerian Komunikasi dan Informatika'),(19,'Rico Ceper','SMA Negeri 70 Jakarta',81.50,150000.00,'Kedinasan',NULL,NULL,NULL,NULL,'SK-555/KEDINASAN/2026','Kementerian Hukum dan HAM'),(20,'Susi Pudjiastuti','SMA Negeri 1 Pangandaran',90.80,150000.00,'Kedinasan',NULL,NULL,NULL,NULL,'SK-621/KEDINASAN/2026','Kementerian Kelautan dan Perikanan');
/*!40000 ALTER TABLE `tabel_pendaftaran` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-06-19 10:40:26
