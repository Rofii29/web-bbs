<style>
    .bbs-paper {
        background: #ffffff;
        color: #000000;
        font-family: 'Arial', sans-serif;
        font-size: 11px;
        line-height: 1.3;
        border: 2px solid #000;
        padding: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        border-radius: 4px;
        max-width: 1100px;
        margin: 0 auto;
    }

    .bbs-header-table {
        width: 100%;
        border-collapse: collapse;
        border: 2px solid #000;
        margin-bottom: 8px;
    }

    .bbs-header-table td {
        border: 1px solid #000;
        padding: 6px 8px;
        vertical-align: middle;
    }

    .bbs-logo-cell {
        width: 32%;
        font-size: 10px;
        font-weight: bold;
        text-align: center;
    }

    .bbs-title-cell {
        width: 36%;
        text-align: center;
        font-size: 16px;
        font-weight: 900;
        letter-spacing: 0.5px;
    }

    .bbs-meta-cell {
        width: 32%;
        padding: 0 !important;
    }

    .bbs-inner-meta {
        width: 100%;
        border-collapse: collapse;
        font-size: 9.5px;
    }

    .bbs-inner-meta td {
        border-bottom: 1px solid #000;
        border-right: 1px solid #000;
        padding: 3px 5px;
    }

    .bbs-inner-meta tr:last-child td {
        border-bottom: none;
    }

    .bbs-inner-meta td:last-child {
        border-right: none;
    }

    .bbs-subhead-grid {
        display: grid;
        grid-template-columns: 2.5fr 2fr 1fr;
        gap: 6px 16px;
        border: 1px solid #000;
        padding: 8px 12px;
        margin-bottom: 8px;
        background: #fdfdfd;
        font-size: 11px;
    }

    .bbs-subhead-grid div {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .bbs-main-layout {
        display: grid;
        grid-template-columns: 62% 38%;
        gap: 8px;
        align-items: start;
    }

    .bbs-checklist-table {
        width: 100%;
        border-collapse: collapse;
        border: 1.5px solid #000;
        font-size: 9.5px;
    }

    .bbs-checklist-table th, 
    .bbs-checklist-table td {
        border: 1px solid #000;
        padding: 2px 4px;
    }

    .bbs-checklist-table th {
        background: #e2e8f0;
        font-weight: bold;
        text-align: center;
    }

    .bbs-cat-header {
        background: #000000;
        color: #ffffff;
        font-weight: bold;
        padding: 3px 6px !important;
        font-size: 10px;
    }

    .bbs-row-selected {
        background: #fef08a !important;
        font-weight: bold;
    }

    .bbs-right-panel {
        border: 1.5px solid #000;
        padding: 8px;
        display: flex;
        flex-direction: column;
        gap: 8px;
        background: #fff;
    }

    .bbs-field-box {
        border: 1px solid #000;
        border-radius: 2px;
        padding: 6px 8px;
    }

    .bbs-field-label {
        font-weight: bold;
        font-size: 10px;
        margin-bottom: 3px;
        color: #1e293b;
    }

    .bbs-field-value {
        font-size: 11px;
        color: #0f172a;
        min-height: 20px;
        word-break: break-word;
    }

    .bbs-footer-section {
        border: 1px solid #000;
        padding: 6px 8px;
        font-size: 10px;
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .bbs-watermark {
        margin-top: 8px;
        text-align: center;
        font-size: 8.5px;
        font-style: italic;
        color: #64748b;
    }

    @media print {
        body * {
            visibility: hidden;
        }
        .bbs-paper, .bbs-paper * {
            visibility: visible;
        }
        .bbs-paper {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            border: none;
            box-shadow: none;
            padding: 0;
        }
        .no-print {
            display: none !important;
        }
    }
</style>

<div class="bbs-paper">
    <!-- Header Dokumen Resmi -->
    <table class="bbs-header-table">
        <tr>
            <td class="bbs-logo-cell">
                <div style="font-size: 9px; line-height: 1.2;">
                    KSO.PT.CATUR ELANG PERKASA - PT.SENTRA MULTIKARYA INFRASTRUKTUR
                </div>
            </td>
            <td class="bbs-title-cell">
                FORMULIR OBSERVASI BBS
            </td>
            <td class="bbs-meta-cell">
                <table class="bbs-inner-meta">
                    <tr>
                        <td style="width: 35%;"><strong>Rev</strong></td>
                        <td>00</td>
                    </tr>
                    <tr>
                        <td><strong>Tgl Terbit</strong></td>
                        <td>01 Agustus 2024</td>
                    </tr>
                    <tr>
                        <td><strong>Hal</strong></td>
                        <td>1</td>
                    </tr>
                    <tr>
                        <td><strong>No. Info Doc</strong></td>
                        <td>KSO CEP SMI-F-HES-014</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- Header Informasi Meta Observasi -->
    <div class="bbs-subhead-grid">
        <div><strong>Tanggal:</strong> <span>{{ date('d F Y', strtotime($observasi->tanggal)) }}</span></div>
        <div><strong>Lokasi:</strong> <span>{{ $observasi->lokasi->nama_lokasi ?? '-' }}</span></div>
        <div>
            <strong>Safe:</strong> 
            <span style="font-size: 13px; font-weight: bold; color: {{ $observasi->jenis_perilaku === 'safe' ? '#16a34a' : '#aaa' }};">
                {{ $observasi->jenis_perilaku === 'safe' ? '✓' : '—' }}
            </span>
        </div>

        <div><strong>Nama:</strong> <span>{{ $observasi->user->name ?? '-' }}</span></div>
        <div><strong>Unit:</strong> <span>{{ $observasi->unit_departemen ?? 'Operasional' }}</span></div>
        <div>
            <strong>At Risk:</strong> 
            <span style="font-size: 13px; font-weight: bold; color: {{ $observasi->jenis_perilaku === 'at_risk' ? '#dc2626' : '#aaa' }};">
                {{ $observasi->jenis_perilaku === 'at_risk' ? '✗' : '—' }}
            </span>
        </div>

        <div style="grid-column: span 3;">
            <strong>Posisi / jabatan:</strong> <span>{{ $observasi->user->jabatan ?? 'Karyawan Lapangan' }}</span>
        </div>
    </div>

    <!-- Layout Utama: Tabel Checklist (Kiri) & Narasi (Kanan) -->
    <div class="bbs-main-layout">
        <!-- Tabel Checklist 10 Kategori -->
        <div>
            <table class="bbs-checklist-table">
                <thead>
                    <tr>
                        <th style="width: 25px;">No.</th>
                        <th>Deskripsi Perilaku</th>
                        <th style="width: 45px;">Status</th>
                        <th style="width: 25px;">No.</th>
                        <th>Deskripsi Perilaku</th>
                        <th style="width: 45px;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Row 1: Posisi Badan | Ergonomi Kantor (Lanjutan) -->
                    <tr>
                        <td colspan="3" class="bbs-cat-header">1. Posisi Badan</td>
                        <td colspan="3" class="bbs-cat-header">6. Ergonomi Kantor (Lanjutan)</td>
                    </tr>
                    @php
                        $katNama = strtolower($observasi->kategori->nama_kategori ?? '');
                        $isPosisi = str_contains($katNama, 'posisi') || str_contains($katNama, 'badan');
                        $isErgo = str_contains($katNama, 'ergonomi') || str_contains($katNama, 'kantor');
                        $isApd = str_contains($katNama, 'apd') || str_contains($katNama, 'pelindung');
                        $isProsedur = str_contains($katNama, 'prosedur') || str_contains($katNama, 'jsa') || str_contains($katNama, 'loto');
                        $isPerkakas = str_contains($katNama, 'perkakas') || str_contains($katNama, 'peralatan');
                        $isArea = str_contains($katNama, 'area') || str_contains($katNama, 'housekeeping');
                        $isLingkungan = str_contains($katNama, 'lingkungan') || str_contains($katNama, 'tumpahan');
                        $isMengemudi = str_contains($katNama, 'mengemudi') || str_contains($katNama, 'kemudi');
                    @endphp

                    <tr class="{{ $isPosisi ? 'bbs-row-selected' : '' }}">
                        <td>1.1</td><td>Menghindari Lintasan Bahaya (line of Fire)</td><td style="text-align:center;">{{ $isPosisi ? '✓' : '' }}</td>
                        <td>6.4</td><td>Penyangga Punggung</td><td style="text-align:center;"></td>
                    </tr>
                    <tr class="{{ $isPosisi ? 'bbs-row-selected' : '' }}">
                        <td>1.2</td><td>Berjalan / Bergerak dg Pandangan ke Arah Gerakan</td><td style="text-align:center;"></td>
                        <td>6.5</td><td>Posisi Pundak</td><td style="text-align:center;"></td>
                    </tr>
                    <tr class="{{ $isPosisi ? 'bbs-row-selected' : '' }}">
                        <td>1.3</td><td>Menjaga Pandangan Mata pada Pekerjaan</td><td style="text-align:center;"></td>
                        <td>6.6</td><td>Posisi Pergelangan Tangan dan Tangan</td><td style="text-align:center;"></td>
                    </tr>
                    <tr class="{{ $isPosisi ? 'bbs-row-selected' : '' }}">
                        <td>1.4</td><td>Menjaga Badan di Luar Posisi Terjepit</td><td style="text-align:center;"></td>
                        <td>6.7</td><td>Memegang / Menggerakkan Mouse</td><td style="text-align:center;"></td>
                    </tr>
                    <tr class="{{ $isPosisi ? 'bbs-row-selected' : '' }}">
                        <td>1.5</td><td>Menaiki / Menuruni Tangga/Fasilitas</td><td style="text-align:center;"></td>
                        <td>6.8</td><td>Mengenali dan Melaporkan Ketidaknyamanan</td><td style="text-align:center;"></td>
                    </tr>

                    <!-- Row 2: Menggunakan Badan | Pemeliharaan Lingkungan -->
                    <tr>
                        <td colspan="3" class="bbs-cat-header">2. Menggunakan Badan</td>
                        <td colspan="3" class="bbs-cat-header">7. Pemeliharaan Lingkungan</td>
                    </tr>
                    <tr>
                        <td>2.1</td><td>Mengangkat / Menurunkan / Menekan / Menarik</td><td></td>
                        <td class="{{ $isLingkungan ? 'bbs-row-selected' : '' }}">7.1</td><td class="{{ $isLingkungan ? 'bbs-row-selected' : '' }}">Mencegah Tumpahan</td><td style="text-align:center;" class="{{ $isLingkungan ? 'bbs-row-selected' : '' }}">{{ $isLingkungan ? '✓' : '' }}</td>
                    </tr>
                    <tr>
                        <td>2.2</td><td>Menghindar dari Gerakan Memuntir</td><td></td>
                        <td class="{{ $isLingkungan ? 'bbs-row-selected' : '' }}">7.2</td><td class="{{ $isLingkungan ? 'bbs-row-selected' : '' }}">Persiapan Membersihkan Tumpahan</td><td></td>
                    </tr>
                    <tr>
                        <td>2.3</td><td>Menggapai / Meraih dalam Jangkauan Aman</td><td></td>
                        <td class="{{ $isLingkungan ? 'bbs-row-selected' : '' }}">7.3</td><td class="{{ $isLingkungan ? 'bbs-row-selected' : '' }}">Menangani Limbah B3 / Non-B3</td><td></td>
                    </tr>
                    <tr>
                        <td>2.4</td><td>Menanggapi Risiko Ergonomi Industri</td><td></td>
                        <td colspan="3" class="bbs-cat-header">8. Alat Pelindung Diri (APD)</td>
                    </tr>

                    <!-- Row 3: Perkakas & Peralatan | APD -->
                    <tr>
                        <td colspan="3" class="bbs-cat-header">3. Perkakas dan Peralatan</td>
                        <td class="{{ $isApd ? 'bbs-row-selected' : '' }}">8.1</td><td class="{{ $isApd ? 'bbs-row-selected' : '' }}">Pelindung Kepala (Safety Helmet)</td><td style="text-align:center;" class="{{ $isApd ? 'bbs-row-selected' : '' }}">{{ $isApd ? '✓' : '' }}</td>
                    </tr>
                    <tr class="{{ $isPerkakas ? 'bbs-row-selected' : '' }}">
                        <td>3.1</td><td>Memilih dan Menggunakan Perkakas / Peralatan</td><td style="text-align:center;">{{ $isPerkakas ? '✓' : '' }}</td>
                        <td class="{{ $isApd ? 'bbs-row-selected' : '' }}">8.2</td><td class="{{ $isApd ? 'bbs-row-selected' : '' }}">Pelindung Mata dan Wajah (Glasses/Shield)</td><td></td>
                    </tr>
                    <tr class="{{ $isPerkakas ? 'bbs-row-selected' : '' }}">
                        <td>3.2</td><td>Menggunakan Pelindung / Barikade / Alat Peringatan</td><td></td>
                        <td class="{{ $isApd ? 'bbs-row-selected' : '' }}">8.3</td><td class="{{ $isApd ? 'bbs-row-selected' : '' }}">Pelindung Pendengaran (Earplug/Muff)</td><td></td>
                    </tr>

                    <!-- Row 4: Prosedur | APD Lanjutan & Mengemudi -->
                    <tr>
                        <td colspan="3" class="bbs-cat-header">4. Prosedur</td>
                        <td class="{{ $isApd ? 'bbs-row-selected' : '' }}">8.4</td><td class="{{ $isApd ? 'bbs-row-selected' : '' }}">Pelindung Pernafasan (Masker/Respirator)</td><td></td>
                    </tr>
                    <tr class="{{ $isProsedur ? 'bbs-row-selected' : '' }}">
                        <td>4.1</td><td>Persiapan Kerja dan JSA (Job Safety Analysis)</td><td style="text-align:center;">{{ $isProsedur ? '✓' : '' }}</td>
                        <td class="{{ $isApd ? 'bbs-row-selected' : '' }}">8.5</td><td class="{{ $isApd ? 'bbs-row-selected' : '' }}">Pelindung Tangan dan Lengan (Gloves)</td><td></td>
                    </tr>
                    <tr class="{{ $isProsedur ? 'bbs-row-selected' : '' }}">
                        <td>4.2</td><td>Mengikuti Prosedur Kerja / SOP</td><td></td>
                        <td class="{{ $isApd ? 'bbs-row-selected' : '' }}">8.6</td><td class="{{ $isApd ? 'bbs-row-selected' : '' }}">Pelindung Jatuh (Full Body Harness)</td><td></td>
                    </tr>
                    <tr class="{{ $isProsedur ? 'bbs-row-selected' : '' }}">
                        <td>4.3</td><td>Mengisolasi Energi (Lock-Out / Tag-Out)</td><td></td>
                        <td class="{{ $isApd ? 'bbs-row-selected' : '' }}">8.7</td><td class="{{ $isApd ? 'bbs-row-selected' : '' }}">Pakaian Pelindung yang Sesuai (Wearpack)</td><td></td>
                    </tr>
                    <tr class="{{ $isProsedur ? 'bbs-row-selected' : '' }}">
                        <td>4.4</td><td>Mengerjakan Hot-Work sesuai izin kerja</td><td></td>
                        <td class="{{ $isApd ? 'bbs-row-selected' : '' }}">8.8</td><td class="{{ $isApd ? 'bbs-row-selected' : '' }}">Pelindung Kaki (Safety Shoes)</td><td></td>
                    </tr>
                    <tr class="{{ $isProsedur ? 'bbs-row-selected' : '' }}">
                        <td>4.5</td><td>Memasuki Ruang Terbatas (Confined Space)</td><td></td>
                        <td colspan="3" class="bbs-cat-header">9. Mengemudi</td>
                    </tr>
                    <tr class="{{ $isProsedur ? 'bbs-row-selected' : '' }}">
                        <td>4.7</td><td>Komunikasi antar Rekan Kerja</td><td></td>
                        <td class="{{ $isMengemudi ? 'bbs-row-selected' : '' }}">9.1</td><td class="{{ $isMengemudi ? 'bbs-row-selected' : '' }}">Perencanaan Perjalanan & Inspection</td><td style="text-align:center;" class="{{ $isMengemudi ? 'bbs-row-selected' : '' }}">{{ $isMengemudi ? '✓' : '' }}</td>
                    </tr>

                    <!-- Row 5: Area Kerja | Mengemudi Lanjutan -->
                    <tr>
                        <td colspan="3" class="bbs-cat-header">5. Area Kerja</td>
                        <td class="{{ $isMengemudi ? 'bbs-row-selected' : '' }}">9.2</td><td class="{{ $isMengemudi ? 'bbs-row-selected' : '' }}">Pre-Trip Inspection & Sabuk Keselamatan</td><td></td>
                    </tr>
                    <tr class="{{ $isArea ? 'bbs-row-selected' : '' }}">
                        <td>5.1</td><td>Bekerja pada Posisi Stabil</td><td style="text-align:center;">{{ $isArea ? '✓' : '' }}</td>
                        <td class="{{ $isMengemudi ? 'bbs-row-selected' : '' }}">9.3</td><td class="{{ $isMengemudi ? 'bbs-row-selected' : '' }}">Menyesuaikan Kecepatan Kendaraan</td><td></td>
                    </tr>
                    <tr class="{{ $isArea ? 'bbs-row-selected' : '' }}">
                        <td>5.2</td><td>Pengaturan Area Kerja / Housekeeping</td><td></td>
                        <td class="{{ $isMengemudi ? 'bbs-row-selected' : '' }}">9.4</td><td class="{{ $isMengemudi ? 'bbs-row-selected' : '' }}">Menjaga Jarak Iring Amannya</td><td></td>
                    </tr>
                    <tr class="{{ $isArea ? 'bbs-row-selected' : '' }}">
                        <td>5.3</td><td>Bekerja di Lingkungan dg Cahaya Cukup</td><td></td>
                        <td class="{{ $isMengemudi ? 'bbs-row-selected' : '' }}">9.8</td><td class="{{ $isMengemudi ? 'bbs-row-selected' : '' }}">Memundurkan Kendaraan dg Panduan</td><td></td>
                    </tr>

                    <!-- Row 6: Ergonomi Kantor | Observasi Lainnya -->
                    <tr>
                        <td colspan="3" class="bbs-cat-header">6. Ergonomi Kantor</td>
                        <td colspan="3" class="bbs-cat-header">10. Observasi Perilaku Lainnya</td>
                    </tr>
                    <tr class="{{ $isErgo ? 'bbs-row-selected' : '' }}">
                        <td>6.1</td><td>Melakukan Istirahat Berkala</td><td style="text-align:center;">{{ $isErgo ? '✓' : '' }}</td>
                        <td>10.1</td><td>Lain-lain</td><td style="text-align:center;"></td>
                    </tr>
                    <tr class="{{ $isErgo ? 'bbs-row-selected' : '' }}">
                        <td>6.2</td><td>Posisi Leher dan Punggung Tegak</td><td></td>
                        <td colspan="3" style="background:#f1f5f9; text-align:center; font-size:9px; font-weight:bold;">Klasifikasi Risiko C4.5: <span style="color: {{ $observasi->tingkat_risiko === 'tinggi' ? '#dc2626' : ($observasi->tingkat_risiko === 'sedang' ? '#d97706' : '#16a34a') }};">{{ strtoupper($observasi->tingkat_risiko) }}</span></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Kolom Kanan: Detail Deskripsi & Pertanyaan Evaluasi -->
        <div class="bbs-right-panel">
            <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1.5px solid #000; padding-bottom: 4px;">
                <div><strong>Observasi Perilaku:</strong></div>
                <div style="font-weight: bold; font-size: 12px;">
                    <span style="margin-right: 8px;">{{ $observasi->jenis_perilaku === 'safe' ? '🔴' : '○' }} Safe</span>
                    <span>{{ $observasi->jenis_perilaku === 'at_risk' ? '🔴' : '○' }} At-Risk</span>
                </div>
            </div>

            <div class="bbs-field-box">
                <div class="bbs-field-label">Area Observasi :</div>
                <div class="bbs-field-value">{{ $observasi->lokasi->nama_lokasi ?? 'Wellpad / Area Operasional' }}</div>
            </div>

            <div class="bbs-field-box">
                <div class="bbs-field-label">Nomor Perilaku (lihat tabel disamping) :</div>
                <div class="bbs-field-value">{{ $observasi->kategori->id ?? '1.1' }} — {{ $observasi->kategori->nama_kategori ?? 'Umum' }}</div>
            </div>

            <div class="bbs-field-box">
                <div class="bbs-field-label">Ketika: (Jelaskan aktivitas yang dilakukan)</div>
                <div class="bbs-field-value">{{ $observasi->ketika ?? 'Pada saat memandu aktivitas operasional di lokasi kerja.' }}</div>
            </div>

            <div class="bbs-field-box" style="border-left: 3px solid #dc2626;">
                <div class="bbs-field-label" style="color: #b91c1c;">Ditemukan: (Jelaskan perilaku beresiko)</div>
                <div class="bbs-field-value" style="font-weight: bold;">{{ $observasi->ditemukan }}</div>
            </div>

            <div class="bbs-field-box">
                <div class="bbs-field-label">Sebab: (Alasan mengapa perilaku beresiko dilakukan)</div>
                <div class="bbs-field-value">{{ $observasi->sebab ?? 'Faktor kebiasaan / pencahayaan / APD kurang memadai.' }}</div>
            </div>

            <div class="bbs-field-box" style="border-left: 3px solid #16a34a;">
                <div class="bbs-field-label" style="color: #15803d;">Saran: (Solusi agar perilaku beresiko tidak berulang) / Mencoba:</div>
                <div class="bbs-field-value">{{ $observasi->saran ?? 'Pastikan bekerja di lingkungan kerja dengan standar pencahayaan dan SOP yang baik.' }}</div>
            </div>

            <!-- Pertanyaan Evaluasi Bawah -->
            <div class="bbs-footer-section">
                <div style="display: flex; justify-content: space-between;">
                    <span>Setuju perilaku terjadi?</span>
                    <span><strong>● Ya</strong> &nbsp;&nbsp; ○ Tidak</span>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <span>Setuju perilaku berisiko?</span>
                    <span><strong>● Ya</strong> &nbsp;&nbsp; ○ Tidak</span>
                </div>
                <div style="display: flex; justify-content: space-between; font-size: 9.5px;">
                    <span>Perilaku selamat:</span>
                    <span><strong>● Mudah/Enabled</strong> &nbsp; ○ Sukar &nbsp; ○ Tidak Mungkin</span>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <span>Tindak lanjut Steering Committee?</span>
                    <span>{{ $observasi->status_tindak_lanjut !== 'open' ? '● Ya' : '○ Ya' }} &nbsp;&nbsp; {{ $observasi->status_tindak_lanjut === 'open' ? '● Tidak' : '○ Tidak' }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="bbs-watermark">
        Document Uncontrolled When Printed. Dokumen Tidak Terkendali Apabila dicetak.
    </div>
</div>
