<?php
// classes/PendaftaranKedinasan.php

require_once __DIR__ . '/Pendaftaran.php';

class PendaftaranKedinasan extends Pendaftaran {
    private $skIkatanDinas;
    private $instansiSponsor;

    public function __construct(
        $id_pendaftaran,
        $nama_calon,
        $asal_sekolah,
        $nilai_ujian,
        $biayaPendaftaranDasar,
        $skIkatanDinas,
        $instansiSponsor
    ) {
        parent::__construct($id_pendaftaran, $nama_calon, $asal_sekolah, $nilai_ujian, $biayaPendaftaranDasar);
        $this->skIkatanDinas = $skIkatanDinas;
        $this->instansiSponsor = $instansiSponsor;
    }

    // Getters for specific properties
    public function getSkIkatanDinas() {
        return $this->skIkatanDinas;
    }

    public function getInstansiSponsor() {
        return $this->instansiSponsor;
    }

    // Overriding abstract methods (Tahap 5: 1.25 surcharge)
    public function hitungTotalBiaya() {
        return $this->biayaPendaftaranDasar * 1.25;
    }

    public function tampilkanInfoJalur() {
        return "SK Dinas: " . $this->skIkatanDinas . " | Sponsor: " . $this->instansiSponsor;
    }

    // Specific database query method
    public static function getDaftarKedinasan($db) {
        $query = "SELECT * FROM tabel_pendaftaran WHERE jalur_pendaftaran = 'Kedinasan'";
        $stmt = $db->prepare($query);
        $stmt->execute();

        $daftarKedinasan = [];
        while ($row = $stmt->fetch()) {
            $daftarKedinasan[] = new self(
                $row['id_pendaftaran'],
                $row['nama_calon'],
                $row['asal_sekolah'],
                $row['nilai_ujian'],
                $row['biaya_pendaftaran_dasar'],
                $row['sk_ikatan_dinas'],
                $row['instansi_sponsor']
            );
        }
        return $daftarKedinasan;
    }
}
?>
