-- --------------------------------------------------------
-- SQL Script for Setting Up Database and Tables
-- Database: DB_SIMULASI_PBO_TRPL1A_DAPOTMATTHEWTAMPUBOLON
-- Table: tabel_pendaftaran
-- --------------------------------------------------------

CREATE DATABASE IF NOT EXISTS DB_SIMULASI_PBO_TRPL1A_DAPOTMATTHEWTAMPUBOLON;
USE DB_SIMULASI_PBO_TRPL1A_DAPOTMATTHEWTAMPUBOLON;

DROP TABLE IF EXISTS tabel_pendaftaran;

CREATE TABLE tabel_pendaftaran (
    id_pendaftaran INT AUTO_INCREMENT PRIMARY KEY,
    nama_calon VARCHAR(100) NOT NULL,
    asal_sekolah VARCHAR(100) NOT NULL,
    nilai_ujian DECIMAL(5,2) NOT NULL,
    biaya_pendaftaran_dasar DECIMAL(10,2) NOT NULL,
    jalur_pendaftaran ENUM('Reguler', 'Prestasi', 'Kedinasan') NOT NULL,
    
    -- Atribut Spesifik (Nullable)
    pilihan_prodi VARCHAR(100) DEFAULT NULL,
    lokasi_kampus VARCHAR(100) DEFAULT NULL,
    jenis_prestasi VARCHAR(100) DEFAULT NULL,
    tingkat_prestasi VARCHAR(50) DEFAULT NULL,
    sk_ikatan_dinas VARCHAR(100) DEFAULT NULL,
    instansi_sponsor VARCHAR(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert Data Sampel (Minimal 20 baris data)
INSERT INTO tabel_pendaftaran (
    nama_calon, asal_sekolah, nilai_ujian, biaya_pendaftaran_dasar, jalur_pendaftaran,
    pilihan_prodi, lokasi_kampus, jenis_prestasi, tingkat_prestasi, sk_ikatan_dinas, instansi_sponsor
) VALUES 
-- Jalur Reguler (7 Data)
('Dapot Matthew', 'SMA Negeri 1 Medan', 88.50, 150000.00, 'Reguler', 'Teknologi Rekayasa Perangkat Lunak', 'Kampus Utama', NULL, NULL, NULL, NULL),
('Budi Santoso', 'SMA Negeri 3 Jakarta', 82.00, 150000.00, 'Reguler', 'Teknik Informatika', 'Kampus Utama', NULL, NULL, NULL, NULL),
('Siti Aminah', 'MAN 1 Yogyakarta', 85.75, 150000.00, 'Reguler', 'Sistem Informasi', 'Kampus Utama', NULL, NULL, NULL, NULL),
('Rian Hidayat', 'SMA Negeri 2 Bandung', 79.90, 150000.00, 'Reguler', 'Teknologi Rekayasa Perangkat Lunak', 'Kampus Cabang', NULL, NULL, NULL, NULL),
('Dewi Lestari', 'SMA Negeri 8 Surabaya', 91.20, 150000.00, 'Reguler', 'Teknik Komputer', 'Kampus Utama', NULL, NULL, NULL, NULL),
('Eko Prasetyo', 'SMK Negeri 1 Semarang', 84.50, 150000.00, 'Reguler', 'Sistem Informasi', 'Kampus Cabang', NULL, NULL, NULL, NULL),
('Farhan Alamsyah', 'SMA Negeri 5 Palembang', 77.00, 150000.00, 'Reguler', 'Teknik Informatika', 'Kampus Utama', NULL, NULL, NULL, NULL),

-- Jalur Prestasi (7 Data)
('Gita Gutawa', 'SMA Taruna Nusantara', 95.00, 150000.00, 'Prestasi', NULL, NULL, 'Olimpiade Matematika', 'Nasional', NULL, NULL),
('Hendra Setiawan', 'SMA Kristen Yusuf', 92.50, 150000.00, 'Prestasi', NULL, NULL, 'Kejuaraan Bulu Tangkis', 'Internasional', NULL, NULL),
('Indah Permata', 'SMA Negeri 1 Surakarta', 89.00, 150000.00, 'Prestasi', NULL, NULL, 'Lomba Karya Ilmiah Remaja', 'Provinsi', NULL, NULL),
('Joko Widodo', 'SMA Negeri 6 Surakarta', 90.00, 150000.00, 'Prestasi', NULL, NULL, 'Lomba Debat Bahasa Inggris', 'Nasional', NULL, NULL),
('Kartika Putri', 'SMA Negeri 1 Denpasar', 93.40, 150000.00, 'Prestasi', NULL, NULL, 'Olimpiade Fisika', 'Provinsi', NULL, NULL),
('Lukman Hakim', 'MAN Insan Cendekia', 96.10, 150000.00, 'Prestasi', NULL, NULL, 'Hafizh Quran 30 Juz', 'Nasional', NULL, NULL),
('Mega Utami', 'SMA Negeri 7 Pine', 88.00, 150000.00, 'Prestasi', NULL, NULL, 'Lomba Catur', 'Kabupaten/Kota', NULL, NULL),

-- Jalur Kedinasan (6 Data)
('Naufal Abyan', 'SMA Negeri 1 Bogor', 87.50, 150000.00, 'Kedinasan', NULL, NULL, NULL, NULL, 'SK-102/KEDINASAN/2026', 'Kementerian Perhubungan'),
('Oki Setiana', 'SMA Negeri 1 Depok', 86.20, 150000.00, 'Kedinasan', NULL, NULL, NULL, NULL, 'SK-205/KEDINASAN/2026', 'Badan Siber dan Sandi Negara'),
('Prabowo Subianto', 'SMA Negeri 2 Jakarta', 89.90, 150000.00, 'Kedinasan', NULL, NULL, NULL, NULL, 'SK-311/KEDINASAN/2026', 'Kementerian Pertahanan'),
('Qori Sandioriva', 'SMA Negeri 3 Banda Aceh', 84.00, 150000.00, 'Kedinasan', NULL, NULL, NULL, NULL, 'SK-419/KEDINASAN/2026', 'Kementerian Komunikasi dan Informatika'),
('Rico Ceper', 'SMA Negeri 70 Jakarta', 81.50, 150000.00, 'Kedinasan', NULL, NULL, NULL, NULL, 'SK-555/KEDINASAN/2026', 'Kementerian Hukum dan HAM'),
('Susi Pudjiastuti', 'SMA Negeri 1 Pangandaran', 90.80, 150000.00, 'Kedinasan', NULL, NULL, NULL, NULL, 'SK-621/KEDINASAN/2026', 'Kementerian Kelautan dan Perikanan');
