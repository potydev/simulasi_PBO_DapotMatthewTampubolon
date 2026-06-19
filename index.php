<?php
// index.php
require_once __DIR__ . '/koneksi/database.php';
require_once __DIR__ . '/classes/Pendaftaran.php';
require_once __DIR__ . '/classes/PendaftaranReguler.php';
require_once __DIR__ . '/classes/PendaftaranPrestasi.php';
require_once __DIR__ . '/classes/PendaftaranKedinasan.php';

$dbClass = new Database();
$db = null;
$dbError = null;

try {
    $db = $dbClass->getConnection();
} catch (Exception $e) {
    $dbError = $e->getMessage();
}

$daftarReguler = [];
$daftarPrestasi = [];
$daftarKedinasan = [];
$allPendaftaran = [];

if ($db) {
    try {
        $daftarReguler = PendaftaranReguler::getDaftarReguler($db);
        $daftarPrestasi = PendaftaranPrestasi::getDaftarPrestasi($db);
        $daftarKedinasan = PendaftaranKedinasan::getDaftarKedinasan($db);
        $allPendaftaran = array_merge($daftarReguler, $daftarPrestasi, $daftarKedinasan);
    } catch (Exception $e) {
        $dbError = "Gagal mengambil data dari database. Silakan periksa apakah tabel 'tabel_pendaftaran' sudah terisi. Detail: " . $e->getMessage();
    }
}

// Calculate Statistics
$totalPendaftar = count($allPendaftaran);
$rataRataNilai = 0;
$totalBiayaTerpenuhi = 0;

if ($totalPendaftar > 0) {
    $totalNilai = 0;
    foreach ($allPendaftaran as $p) {
        $totalNilai += $p->getNilaiUjian();
        $totalBiayaTerpenuhi += $p->hitungTotalBiaya();
    }
    $rataRataNilai = $totalNilai / $totalPendaftar;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pendaftaran Mahasiswa Baru | Simulasi PBO</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --bg-color: #f1f5f9;
            --card-bg: rgba(255, 255, 255, 0.45);
            --card-border: rgba(255, 255, 255, 0.55);
            --text-primary: #0f172a;
            --text-secondary: #475569;
            
            --primary: #6d28d9;
            --primary-glow: rgba(109, 40, 217, 0.12);
            --reguler-color: #0891b2;
            --reguler-bg: rgba(8, 145, 178, 0.08);
            --prestasi-color: #7c3aed;
            --prestasi-bg: rgba(124, 58, 237, 0.08);
            --kedinasan-color: #059669;
            --kedinasan-bg: rgba(5, 150, 105, 0.08);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            scrollbar-width: thin;
            scrollbar-color: rgba(15, 23, 42, 0.2) transparent;
        }

        body {
            background-color: var(--bg-color);
            background-image: 
                radial-gradient(at 10% 10%, rgba(109, 40, 217, 0.12) 0px, transparent 40%),
                radial-gradient(at 90% 10%, rgba(8, 145, 178, 0.1) 0px, transparent 40%),
                radial-gradient(at 50% 90%, rgba(5, 150, 105, 0.08) 0px, transparent 40%);
            background-attachment: fixed;
            color: var(--text-primary);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            padding: 2rem 1.5rem;
        }

        .container {
            max-width: 1300px;
            width: 100%;
            margin: 0 auto;
            flex: 1;
        }

        /* Header Style */
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2.5rem;
            border-bottom: 1px solid rgba(15, 23, 42, 0.06);
            padding-bottom: 1.5rem;
        }

        .header-title h1 {
            font-size: 1.85rem;
            font-weight: 800;
            background: linear-gradient(135deg, #0f172a 30%, #6d28d9 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -0.5px;
        }

        .header-title p {
            color: var(--text-secondary);
            font-size: 0.95rem;
            margin-top: 0.25rem;
        }

        .header-badge {
            background: rgba(255, 255, 255, 0.65);
            border: 1px solid var(--card-border);
            backdrop-filter: blur(10px);
            padding: 0.6rem 1.2rem;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.85rem;
            color: var(--text-primary);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.03);
        }

        .header-badge i {
            color: var(--primary);
        }

        /* Error States */
        .error-card {
            background: rgba(239, 68, 68, 0.05);
            border: 1px solid rgba(239, 68, 68, 0.15);
            backdrop-filter: blur(12px);
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 2rem;
            text-align: center;
            box-shadow: 0 10px 30px rgba(239, 68, 68, 0.05);
        }

        .error-card i {
            font-size: 3rem;
            color: #ef4444;
            margin-bottom: 1rem;
        }

        .error-card h3 {
            font-size: 1.4rem;
            margin-bottom: 0.5rem;
            color: #b91c1c;
        }

        .error-card p {
            color: var(--text-secondary);
            max-width: 600px;
            margin: 0 auto 1.5rem;
            line-height: 1.6;
        }

        .btn-action {
            background: var(--primary);
            border: none;
            color: white;
            padding: 0.75rem 1.5rem;
            font-size: 0.9rem;
            font-weight: 600;
            border-radius: 10px;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s ease;
            box-shadow: 0 4px 14px var(--primary-glow);
        }

        .btn-action:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(109, 40, 217, 0.3);
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2.5rem;
        }

        .stat-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1.25rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            box-shadow: 0 8px 30px rgba(15, 23, 42, 0.04);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            transform: translateX(-100%);
            transition: transform 0.6s ease;
        }

        .stat-card:hover::before {
            transform: translateX(100%);
        }

        .stat-card:hover {
            transform: translateY(-4px);
            border-color: rgba(255, 255, 255, 0.9);
            box-shadow: 0 15px 35px rgba(15, 23, 42, 0.08);
        }

        .stat-icon {
            width: 54px;
            height: 54px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .stat-info {
            flex: 1;
        }

        .stat-info p {
            color: var(--text-secondary);
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-info h2 {
            font-size: 1.75rem;
            font-weight: 800;
            margin-top: 0.15rem;
            color: var(--text-primary);
        }

        .stat-blue .stat-icon { background: rgba(8, 145, 178, 0.1); color: #0891b2; }
        .stat-purple .stat-icon { background: rgba(109, 40, 217, 0.1); color: #6d28d9; }
        .stat-green .stat-icon { background: rgba(5, 150, 105, 0.1); color: #059669; }

        /* Main Workspace & Tabs */
        .workspace-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 2rem;
            box-shadow: 0 20px 40px rgba(15, 23, 42, 0.06);
            margin-bottom: 2.5rem;
        }

        .workspace-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        /* Tabs Styling */
        .tabs-container {
            display: flex;
            background: rgba(15, 23, 42, 0.04);
            padding: 0.35rem;
            border-radius: 14px;
            border: 1px solid rgba(15, 23, 42, 0.03);
        }

        .tab-btn {
            background: transparent;
            border: none;
            color: var(--text-secondary);
            padding: 0.65rem 1.25rem;
            font-size: 0.9rem;
            font-weight: 600;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .tab-btn:hover {
            color: var(--text-primary);
        }

        .tab-btn.active {
            background: #ffffff;
            color: var(--text-primary);
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.06);
        }

        .tab-btn[data-target="all"].active { border-bottom: 2px solid var(--primary); }
        .tab-btn[data-target="reguler"].active { border-bottom: 2px solid var(--reguler-color); }
        .tab-btn[data-target="prestasi"].active { border-bottom: 2px solid var(--prestasi-color); }
        .tab-btn[data-target="kedinasan"].active { border-bottom: 2px solid var(--kedinasan-color); }

        /* Search Box */
        .search-box {
            position: relative;
            min-width: 280px;
        }

        .search-box i {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary);
            font-size: 0.9rem;
        }

        .search-input {
            width: 100%;
            background: rgba(255, 255, 255, 0.65);
            border: 1px solid rgba(15, 23, 42, 0.08);
            border-radius: 12px;
            padding: 0.65rem 1rem 0.65rem 2.5rem;
            color: var(--text-primary);
            font-size: 0.9rem;
            transition: all 0.2s ease;
        }

        .search-input:focus {
            outline: none;
            background: #ffffff;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px var(--primary-glow);
        }

        /* Table Design */
        .table-responsive {
            width: 100%;
            overflow-x: auto;
            border-radius: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 0.95rem;
        }

        th {
            background: rgba(15, 23, 42, 0.02);
            padding: 1rem 1.25rem;
            color: var(--text-primary);
            font-weight: 700;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid rgba(15, 23, 42, 0.06);
        }

        td {
            padding: 1.15rem 1.25rem;
            border-bottom: 1px solid rgba(15, 23, 42, 0.04);
            color: #334155;
            transition: all 0.25s ease;
        }

        tr:hover td {
            background: rgba(255, 255, 255, 0.35);
            color: var(--text-primary);
        }

        /* Badges */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            padding: 0.35rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
        }

        .badge-reguler { background: var(--reguler-bg); color: var(--reguler-color); }
        .badge-prestasi { background: var(--prestasi-bg); color: var(--prestasi-color); }
        .badge-kedinasan { background: var(--kedinasan-bg); color: var(--kedinasan-color); }

        .score-badge {
            background: rgba(15, 23, 42, 0.03);
            border: 1px solid rgba(15, 23, 42, 0.06);
            padding: 0.25rem 0.5rem;
            border-radius: 6px;
            font-weight: 700;
            color: var(--text-primary);
        }

        /* Custom Specific detail text styling */
        .detail-info {
            font-size: 0.85rem;
            color: #334155;
            background: rgba(255, 255, 255, 0.55);
            padding: 0.4rem 0.75rem;
            border-radius: 8px;
            border-left: 3px solid var(--primary);
            display: inline-block;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.01);
        }
        
        .detail-reguler { border-left-color: var(--reguler-color); }
        .detail-prestasi { border-left-color: var(--prestasi-color); }
        .detail-kedinasan { border-left-color: var(--kedinasan-color); }

        /* Cost Styling showing overriding results */
        .cost-container {
            display: flex;
            flex-direction: column;
            gap: 0.15rem;
        }

        .cost-base {
            font-size: 0.75rem;
            color: var(--text-secondary);
            text-decoration: line-through;
        }

        .cost-final {
            font-weight: 700;
            color: var(--text-primary);
            font-size: 0.95rem;
        }

        .cost-green { color: #059669; }
        .cost-amber { color: #d97706; }

        /* Animation */
        .animate-row {
            animation: fadeIn 0.4s ease forwards;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(6px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Footer */
        footer {
            text-align: center;
            color: var(--text-secondary);
            font-size: 0.85rem;
            margin-top: auto;
            padding-top: 2rem;
            border-top: 1px solid rgba(15, 23, 42, 0.06);
        }

        footer a {
            color: var(--primary);
            text-decoration: none;
        }

        /* Empty State */
        .empty-state {
            padding: 4rem 2rem;
            text-align: center;
            color: var(--text-secondary);
        }

        .empty-state i {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        @media (max-width: 768px) {
            header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }
            .workspace-header {
                flex-direction: column;
                align-items: stretch;
            }
            .search-box {
                width: 100%;
            }
            .tabs-container {
                overflow-x: auto;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <header>
            <div class="header-title">
                <h1>Sistem Informasi PMB</h1>
                <p>Simulasi Pemrograman Berorientasi Objek (PBO) &bull; Dapot Matthew Tampubolon</p>
            </div>
            <div class="header-badge">
                <i class="fa-solid fa-graduation-cap"></i>
                <span>Tugas Ujian Praktikum</span>
            </div>
        </header>

        <!-- Database Setup Error Info -->
        <?php if ($dbError): ?>
            <div class="error-card">
                <i class="fa-solid fa-triangle-exclamation"></i>
                <h3>Koneksi Basis Data Bermasalah</h3>
                <p><?php echo htmlspecialchars($dbError); ?></p>
                <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                    <a href="?action=setup" class="btn-action">
                        <i class="fa-solid fa-database"></i> Jalankan Setup Database Otomatis
                    </a>
                </div>
            </div>
        <?php endif; ?>

        <!-- Database Auto Setup Success State -->
        <?php if (isset($_GET['setup_success'])): ?>
            <div class="error-card" style="background: rgba(16, 185, 129, 0.1); border-color: rgba(16, 185, 129, 0.25);">
                <i class="fa-solid fa-circle-check" style="color: #34d399;"></i>
                <h3 style="color: #a7f3d0;">Database Berhasil Disiapkan!</h3>
                <p>Skrip SQL <code>db_setup.sql</code> berhasil dijalankan. Tabel <code>tabel_pendaftaran</code> dan data sampel telah dimasukkan ke database.</p>
                <a href="index.php" class="btn-action" style="background: var(--kedinasan-color); box-shadow: 0 4px 14px rgba(16, 185, 129, 0.25);">
                    <i class="fa-solid fa-arrows-rotate"></i> Muat Ulang Dashboard
                </a>
            </div>
        <?php endif; ?>

        <!-- Setup logic handler -->
        <?php
        if (isset($_GET['action']) && $_GET['action'] == 'setup') {
            try {
                // Connect to MySQL server first to create database
                $rawPdo = new PDO("mysql:host=localhost;charset=utf8mb4", "root", "");
                $rawPdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                $sql = file_get_contents(__DIR__ . '/db_setup.sql');
                
                // Execute SQL script
                $rawPdo->exec($sql);
                
                echo "<script>window.location.href = 'index.php?setup_success=1';</script>";
                exit;
            } catch (Exception $ex) {
                echo "<div class='error-card'>";
                echo "<i class='fa-solid fa-circle-xmark'></i>";
                echo "<h3>Gagal Menyiapkan Database</h3>";
                echo "<p>Pesan kesalahan: " . htmlspecialchars($ex->getMessage()) . "</p>";
                echo "<a href='index.php' class='btn-action'><i class='fa-solid fa-chevron-left'></i> Kembali</a>";
                echo "</div>";
            }
        }
        ?>

        <!-- Stats Section -->
        <?php if (!$dbError): ?>
            <div class="stats-grid">
                <div class="stat-card stat-blue">
                    <div class="stat-icon">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <div class="stat-info">
                        <p>Total Calon Mahasiswa</p>
                        <h2><?php echo $totalPendaftar; ?></h2>
                    </div>
                </div>
                <div class="stat-purple">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fa-solid fa-star"></i>
                        </div>
                        <div class="stat-info">
                            <p>Rata-rata Nilai Ujian</p>
                            <h2><?php echo number_format($rataRataNilai, 2, ',', '.'); ?></h2>
                        </div>
                    </div>
                </div>
                <div class="stat-green">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fa-solid fa-wallet"></i>
                        </div>
                        <div class="stat-info">
                            <p>Total Biaya Pendaftaran</p>
                            <h2>Rp <?php echo number_format($totalBiayaTerpenuhi, 0, ',', '.'); ?></h2>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Workspace Card with Table & Tabs -->
            <div class="workspace-card">
                <div class="workspace-header">
                    <!-- Tab Menu -->
                    <div class="tabs-container">
                        <button class="tab-btn active" data-target="all">
                            <i class="fa-solid fa-list"></i> Semua Jalur
                        </button>
                        <button class="tab-btn" data-target="reguler">
                            <i class="fa-solid fa-user-graduate"></i> Reguler (<?php echo count($daftarReguler); ?>)
                        </button>
                        <button class="tab-btn" data-target="prestasi">
                            <i class="fa-solid fa-award"></i> Prestasi (<?php echo count($daftarPrestasi); ?>)
                        </button>
                        <button class="tab-btn" data-target="kedinasan">
                            <i class="fa-solid fa-building-columns"></i> Kedinasan (<?php echo count($daftarKedinasan); ?>)
                        </button>
                    </div>

                    <!-- Search Input -->
                    <div class="search-box">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <input type="text" id="searchInput" class="search-input" placeholder="Cari nama atau asal sekolah...">
                    </div>
                </div>

                <!-- Table Content -->
                <div class="table-responsive">
                    <table id="pendaftaranTable">
                        <thead>
                            <tr>
                                <th style="width: 60px;">No</th>
                                <th>Nama Calon</th>
                                <th>Asal Sekolah</th>
                                <th style="width: 120px;">Nilai Ujian</th>
                                <th style="width: 150px;">Jalur</th>
                                <th>Informasi Jalur (Spesifik)</th>
                                <th style="width: 220px; text-align: right;">Kalkulasi Biaya (Polimorfisme)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $index = 1;
                            
                            function renderRows($list, $type, &$index) {
                                foreach ($list as $mhs) {
                                    $jalurLower = strtolower($type);
                                    $costBase = $mhs->getBiayaPendaftaranDasar();
                                    $costFinal = $mhs->hitungTotalBiaya();
                                    $costDiff = $costFinal - $costBase;
                                    
                                    $costClass = '';
                                    if ($costDiff < 0) {
                                        $costClass = 'cost-green'; // discount
                                    } elseif ($costDiff > 0) {
                                        $costClass = 'cost-amber'; // surcharge
                                    }
                                    
                                    echo "<tr class='animate-row mhs-row' data-jalur='{$jalurLower}'>";
                                    echo "<td>" . $index++ . "</td>";
                                    echo "<td class='col-nama'><strong>" . htmlspecialchars($mhs->getNamaCalon()) . "</strong></td>";
                                    echo "<td class='col-sekolah'>" . htmlspecialchars($mhs->getAsalSekolah()) . "</td>";
                                    echo "<td><span class='score-badge'>" . number_format($mhs->getNilaiUjian(), 2, ',', '.') . "</span></td>";
                                    echo "<td><span class='badge badge-{$jalurLower}'>" . htmlspecialchars($type) . "</span></td>";
                                    
                                    // Polymorphic call 1: tampilkanInfoJalur()
                                    echo "<td><div class='detail-info detail-{$jalurLower}'>" . htmlspecialchars($mhs->tampilkanInfoJalur()) . "</div></td>";
                                    
                                    // Polymorphic call 2: hitungTotalBiaya() and displaying it beautifully
                                    echo "<td style='text-align: right;'>";
                                    echo "<div class='cost-container'>";
                                    if ($costDiff != 0) {
                                        echo "<span class='cost-base'>Rp " . number_format($costBase, 0, ',', '.') . "</span>";
                                    }
                                    echo "<span class='cost-final {$costClass}'>Rp " . number_format($costFinal, 0, ',', '.') . "</span>";
                                    
                                    // Print rule detail
                                    if ($costDiff < 0) {
                                        echo "<span style='font-size:0.75rem; color:#34d399;'>Diskon Prestasi (Rp 50rb)</span>";
                                    } elseif ($costDiff > 0) {
                                        echo "<span style='font-size:0.75rem; color:#fbbf24;'>Surcharge Administrasi (25%)</span>";
                                    } else {
                                        echo "<span style='font-size:0.75rem; color:var(--text-secondary);'>Biaya Standar</span>";
                                    }
                                    
                                    echo "</div>";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            }
                            
                            $index = 1; // reset for overall rendering
                            renderRows($daftarReguler, 'Reguler', $index);
                            renderRows($daftarPrestasi, 'Prestasi', $index);
                            renderRows($daftarKedinasan, 'Kedinasan', $index);
                            
                            if ($totalPendaftar === 0) {
                                echo "<tr><td colspan='7' class='empty-state'><i class='fa-regular fa-folder-open'></i><p>Tidak ada data pendaftaran ditemukan. Silakan jalankan Setup Database di atas.</p></td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?>

        <!-- Footer -->
        <footer>
            <p>&copy; 2026 &bull; Dapot Matthew Tampubolon &bull; Sistem Informasi Pendaftaran Mahasiswa Baru</p>
        </footer>
    </div>

    <!-- Client-side filter scripting -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.tab-btn');
            const rows = document.querySelectorAll('.mhs-row');
            const searchInput = document.getElementById('searchInput');
            let currentFilter = 'all';

            // Tab Switcher
            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    tabs.forEach(t => t.classList.remove('active'));
                    tab.classList.add('active');
                    currentFilter = tab.getAttribute('data-target');
                    applyFilter();
                });
            });

            // Search Event
            if (searchInput) {
                searchInput.addEventListener('input', applyFilter);
            }

            function applyFilter() {
                const searchVal = searchInput ? searchInput.value.toLowerCase() : '';
                let visibleCount = 0;

                rows.forEach(row => {
                    const rowJalur = row.getAttribute('data-jalur');
                    const nama = row.querySelector('.col-nama').textContent.toLowerCase();
                    const sekolah = row.querySelector('.col-sekolah').textContent.toLowerCase();
                    
                    const matchesTab = (currentFilter === 'all' || rowJalur === currentFilter);
                    const matchesSearch = (nama.includes(searchVal) || sekolah.includes(searchVal));

                    if (matchesTab && matchesSearch) {
                        row.style.display = '';
                        visibleCount++;
                        // Reset line numbering dynamically
                        row.querySelector('td:first-child').textContent = visibleCount;
                    } else {
                        row.style.display = 'none';
                    }
                });
            }
        });
    </script>
</body>
</html>
