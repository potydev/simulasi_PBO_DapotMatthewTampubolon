<?php
// classes/PendaftaranPrestasi.php

require_once __DIR__ . '/Pendaftaran.php';

class PendaftaranPrestasi extends Pendaftaran {
    private $jenisPrestasi;
    private $tingkatPrestasi;

    public function __construct(
        $id_pendaftaran,
        $nama_calon,
        $asal_sekolah,
        $nilai_ujian,
        $biayaPendaftaranDasar,
        $jenisPrestasi,
        $tingkatPrestasi
    ) {
        parent::__construct($id_pendaftaran, $nama_calon, $asal_sekolah, $nilai_ujian, $biayaPendaftaranDasar);
        $this->jenisPrestasi = $jenisPrestasi;
        $this->tingkatPrestasi = $tingkatPrestasi;
    }

    // Getters for specific properties
    public function getJenisPrestasi() {
        return $this->jenisPrestasi;
    }

    public function getTingkatPrestasi() {
        return $this->tingkatPrestasi;
    }

    // Overriding abstract methods (Tahap 5: Potongan Rp50.000)
    public function hitungTotalBiaya() {
        return $this->biayaPendaftaranDasar - 50000;
    }

    public function tampilkanInfoJalur() {
        return "Prestasi: " . $this->jenisPrestasi . " (" . $this->tingkatPrestasi . ")";
    }

    // Specific database query method
    public static function getDaftarPrestasi($db) {
        $query = "SELECT * FROM tabel_pendaftaran WHERE jalur_pendaftaran = 'Prestasi'";
        $stmt = $db->prepare($query);
        $stmt->execute();

        $daftarPrestasi = [];
        while ($row = $stmt->fetch()) {
            $daftarPrestasi[] = new self(
                $row['id_pendaftaran'],
                $row['nama_calon'],
                $row['asal_sekolah'],
                $row['nilai_ujian'],
                $row['biaya_pendaftaran_dasar'],
                $row['jenis_prestasi'],
                $row['tingkat_prestasi']
            );
        }
        return $daftarPrestasi;
    }
}
?>
