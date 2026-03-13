<!DOCTYPE html>
<html>

<head>
    <title>Laporan Pengaduan Masyarakat</title>
    <style>
        /* Mengatur Ukuran Kertas A4 */
        @page {
            size: A4 portrait;
            margin: 1.5cm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 2px solid #222;
            padding-bottom: 15px;
        }

        .header h2 {
            margin: 0 0 5px 0;
            font-size: 18px;
            color: #111;
            text-transform: uppercase;
        }

        .header p {
            margin: 2px 0;
            color: #555;
            font-size: 11px;
        }

        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table.data-table th,
        table.data-table td {
            border: 1px solid #ddd;
            padding: 8px 6px;
            vertical-align: top;
        }

        table.data-table th {
            background-color: #f8f9fa;
            color: #222;
            font-weight: bold;
            text-align: left;
            text-transform: uppercase;
            font-size: 10px;
        }

        /* Mengatur persentase kolom agar tepat 100% dan rapi */
        .col-no {
            width: 4%;
            text-align: center;
        }

        .col-tgl {
            width: 12%;
        }

        .col-pelapor {
            width: 18%;
        }

        .col-lokasi {
            width: 18%;
        }

        .col-desc {
            width: 25%;
        }

        .col-teknisi {
            width: 13%;
        }

        .col-status {
            width: 10%;
            text-align: center;
        }

        table.data-table td {
            line-height: 1.4;
        }

        .status-badge {
            font-weight: bold;
            text-transform: uppercase;
            font-size: 9px;
            padding: 3px 5px;
            border-radius: 3px;
        }

        .text-muted {
            color: #666;
            font-size: 9px;
        }

        .font-bold {
            font-weight: bold;
        }

        /* Tabel Footer (Tanpa Garis) untuk Legend & Tanda Tangan */
        table.footer-table {
            width: 100%;
            border: none;
            margin-top: 40px;
        }

        table.footer-table td {
            border: none;
            vertical-align: bottom;
        }

        /* Keterangan Status */
        .status-legend {
            font-weight: 600;
            /* Semi-bold */
            font-size: 10px;
            line-height: 1.6;
            color: #444;
        }

        .signature {
            text-align: center;
            font-size: 11px;
        }
    </style>
</head>

<body>

    <div class="header">
        <h2>REKAPITULASI LAPORAN MASYARAKAT</h2>
        <p><strong>SmartPublicFacility - Sistem Layanan Masyarakat</strong></p>
        <p>Dicetak pada: {{ \Carbon\Carbon::now('Asia/Jakarta')->locale('id')->isoFormat('D MMMM YYYY, HH:mm') }} WIB
        </p>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th class="col-no">No</th>
                <th class="col-tgl">Tgl & Tiket</th>
                <th class="col-pelapor">Pelapor & No. Telp</th>
                <th class="col-lokasi">Lokasi Kejadian</th>
                <th class="col-desc">Deskripsi Masalah</th>
                <th class="col-teknisi">Teknisi</th>
                <th class="col-status">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($laporan as $index => $item)
                <tr>
                    <td class="col-no">{{ $index + 1 }}</td>

                    <td class="col-tgl">
                        <span class="font-bold">{{ $item->created_at->format('d/m/Y') }}</span><br>
                        <span class="text-muted">#{{ $item->tiket }}</span>
                    </td>

                    <td class="col-pelapor">
                        <span class="font-bold">{{ $item->nama }}</span><br>
                        <span class="text-muted">{{ $item->no_telepon ?? '-' }}</span>
                    </td>

                    <td class="col-lokasi">
                        {{ $item->lokasi }}
                    </td>

                    <td class="col-desc">
                        {{ $item->deskripsi }}
                    </td>

                    <td class="col-teknisi">
                        @if ($item->teknisi)
                            <span class="font-bold">{{ $item->teknisi->name }}</span>
                            @if ($item->catatan_teknisi)
                                <br><span class="text-muted"
                                    style="font-style:italic">"{{ \Illuminate\Support\Str::limit($item->catatan_teknisi, 50) }}"</span>
                            @endif
                        @else
                            <span class="text-muted">Belum Ditugaskan</span>
                        @endif
                    </td>

                    <td class="col-status">
                        <span class="status-badge">{{ $item->status }}</span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Footer Layout: Kiri untuk Legend, Kanan untuk Tanda Tangan --}}
    <table class="footer-table">
        <tr>
            <td style="width: 60%; text-align: left;">
                <div class="status-legend">
                    <span style="text-decoration: underline; color: #111;">Konfirmasi Status</span><br>
                    Baru : Laporan Terbaru<br>
                    Diproses : Laporan sedang Ditangani<br>
                    Selesai : Menunggu Validasi<br>
                    Closed : Laporan Tervalidasi dan di tutup
                </div>
            </td>
            <td style="width: 40%;" class="signature">
                <p>Mengetahui,</p>
                <br><br><br><br>
                <p><strong>Admin Pengelola</strong></p>
            </td>
        </tr>
    </table>

</body>

</html>
