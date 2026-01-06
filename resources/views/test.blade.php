<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contoh Tombol btn-outline-warning Tanpa Bootstrap</title>
    <style>
        /* Gaya dasar tombol */
        .btn {
            display: inline-block;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            cursor: pointer;
            border: 1px solid transparent;
            border-radius: 0.25rem;
        }

        /* Gaya untuk tombol dengan kelas .btn-outline-warning */
        .btn-outline-cream {
            color: #d38900;
            /* Warna teks */
            border-color: #d38900;
            /* Warna border */
            background-color: transparent;
            /* Latar belakang transparan */
        }

        /* Gaya untuk tombol dengan kelas .btn-outline-cream saat di-hover */
        .btn-outline-cream:hover {
            background-color: #d38900;
            color: white;
            /* Warna teks saat di-hover */
        }
    </style>
</head>

<body>
    <button class="btn btn-outline-warning">Tombol Warning</button>
    <div class="container">
        <h1>Detail Wilayah</h1>
        <p>ID Wilayah: {{ $post->id_wilayah }}</p>
        <p>Nama Wilayah: {{ $post->nama_wilayah}}</p>
        <h2>Post Terkait:</h2>
        <ul>
            @foreach ($post->posts as $data)
                <li>
                    <h3>{{ $data->judul }}</h3>
                    <!-- Tambahkan kode HTML lainnya sesuai kebutuhan -->
                </li>
            @endforeach
        </ul>
        <!-- Tambahkan kode HTML dan Blade lainnya untuk menampilkan data lainnya sesuai kebutuhan -->
    </div>
</body>

</html>
