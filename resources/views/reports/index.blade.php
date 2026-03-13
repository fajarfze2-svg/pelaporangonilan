<a href="{{ route('reports.create') }}">Tambah Laporan</a>

<table border="1">
<tr>
<th>Judul</th>
<th>Lokasi</th>
<th>Status</th>
</tr>

@foreach($reports as $r)
<tr>
<td>{{ $r->title }}</td>
<td>{{ $r->location }}</td>
<td>{{ $r->status }}</td>
</tr>
@endforeach
</table>
