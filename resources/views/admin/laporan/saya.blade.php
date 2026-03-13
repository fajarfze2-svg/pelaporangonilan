@extends('layouts.app')

@section('content')
    <div class="container">
        <h3 class="mb-4">Laporan Masuk</h3>

        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>Tiket</th>
                    <th>Nama</th>
                    <th>Deskripsi</th>
                    <th>Lokasi</th>
                    <th>Teknisi</th>
                    <th>Foto Awal</th>
                    <th>Foto Bukti</th>
                    <th>Status / Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($laporans as $laporan)
                    <tr>
                        <td>
                            <span class="badge bg-primary">
                                {{ $laporan->tiket }}
                            </span>
                        </td>

                        <td>{{ $laporan->nama }}</td>

                        <td>{{ $laporan->deskripsi }}</td>

                        <td>{{ $laporan->lokasi }}</td>

                        <td>
                            @if ($laporan->teknisi)
                                <span class="badge bg-info">
                                    {{ $laporan->teknisi->name }}
                                </span>
                            @else
                                <span class="text-muted">Belum Ditugaskan</span>
                            @endif
                        </td>

                        <td>
                            @if ($laporan->foto_awal)
                                <img src="{{ asset('storage/' . $laporan->foto_awal) }}" width="70" class="rounded">
                            @else
                                -
                            @endif
                        </td>

                        <td>
                            @if ($laporan->bukti_foto)
                                <img src="{{ asset('storage/' . $laporan->bukti_foto) }}" width="70" class="rounded">
                            @else
                                -
                            @endif
                        </td>

                        <td>
                            <form action="{{ route('laporan.updateStatus', $laporan->id) }}" method="POST">
                                @csrf
                                @method('PATCH')

                                <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">

                                    <option value="menunggu" {{ $laporan->status == 'menunggu' ? 'selected' : '' }}>
                                        Menunggu
                                    </option>

                                    <option value="diproses" {{ $laporan->status == 'diproses' ? 'selected' : '' }}>
                                        Diproses
                                    </option>

                                    <option value="waiting_validation"
                                        {{ $laporan->status == 'waiting_validation' ? 'selected' : '' }}>
                                        Menunggu Validasi
                                    </option>

                                    <option value="selesai" {{ $laporan->status == 'selesai' ? 'selected' : '' }}>
                                        Selesai
                                    </option>

                                </select>
                            </form>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
