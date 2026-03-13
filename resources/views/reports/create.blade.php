<!DOCTYPE html>
<html>
<head>
<title>Form Laporan Kerusakan</title>
</head>
<body>

<h2>Form Pelaporan</h2>

<form method="POST" action="{{ route('reports.store') }}">
@csrf

<input type="text" name="title" placeholder="Judul Kerusakan"><br><br>

<textarea name="description" placeholder="Deskripsi Kerusakan"></textarea><br><br>

<input type="text" name="location" placeholder="Lokasi"><br><br>

<button type="submit">Kirim</button>

@if(session('error'))
<p style="color:red">{{ session('error') }}</p>
@endif

</form>

</body>
</html>
