<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
  </head>
  <body class="bg-light">
    <main class="container">

        <!-- START DATA -->

        {{-- MESSAGE INPUT BERHASIL DITAMBAHKAN --}}
        @if (Session::has('success'))
          <div class="pt-3 mb-2 bg-red rounded">
            <div class="alert alert-success">
                {{ Session::get('success') }}
          </div>
        @endif

         {{-- MESSAGE PENCARIAN DATA TIDAK DITEMUKAN --}}
        @if (Session::has('failed'))
          <div class="pt-3 mb-2 bg-red rounded">
            <div class="alert alert-danger">
              {{ Session::get('failed') }}
            </div>
        @endif


        <div class="my-3 p-3 bg-body rounded shadow-sm">
                <!-- FORM PENCARIAN -->
                <div class="pb-3">
                  <form class="d-flex" action="{{url('mahasiswa')}}" method="get">
                      <input class="form-control me-1" type="search" name="katakunci" value="{{ Request::get('katakunci') }}" placeholder="Cari NIM/Nama/Jurusan" aria-label="Search">
                      <button class="btn btn-secondary" type="submit">Cari</button>
                  </form>
                </div>

                <!-- TOMBOL TAMBAH DATA -->
                <div class="pb-3">
                  <a href='{{url('mahasiswa/create')}}' class="btn btn-primary">+ Tambah Data</a>
                </div>

                <!-- TAMPILKAN DATA -->
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="col-md-1">No</th>
                            <th class="col-md-3">NIM</th>
                            <th class="col-md-4">Nama</th>
                            <th class="col-md-2">Jurusan</th>
                            <th class="col-md-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                        <tr>
                            <td>{{ $loop->iteration}}</td>
                            <td>{{ $item->nim}}</td>
                            <td>{{ $item->nama}}</td>
                            <td>{{ $item->jurusan}}</td>
                            <td>
                                <a href='{{url('mahasiswa/'.$item->nim. '/edit')}}' class="btn btn-warning btn-sm">Edit</a>
                                <form action='{{url('mahasiswa/'.$item->nim)}}' method='post' class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Del</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
               {{ $data->withQueryString()->links() }}
                <!-- AKHIR TAMPILKAN DATA -->
          </div>
          <!-- AKHIR DATA -->
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
  </body>
</html>
