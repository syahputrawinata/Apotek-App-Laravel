@extends ('layouts.template')
@section('content')

    @if(Session::get ('success'))
    <div class="alert alert-success"> {{ Session::get('success') }} </div>
    @endif
    
    @if(Session::get ('failed'))
    <div class="alert alert-warning"> {{ Session::get('failed') }} </div>
    @endif


    <a class="btn btn-primary mb-3" href="{{ route('user.create')}}">Tambah Pengguna</a>


<table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach ($users as $item)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $item['name'] }}</td>
                    <td>{{ $item['email'] }}</td>
                    <td>{{ $item['role'] }}</td>
                    <td class="d-flex justify-content-center">
                        <a href="{{ route('user.edit', $item['id'])}}" class="btn btn-primary me-3">Edit</a>
                        <form action="{{ route('user.delete', $item['id']) }}" method="POST">
                            @csrf 
                            @method('DELETE') 
                            <button type="button" class="btn btn-danger" onclick="showModalDelete('{{ $item->id}}', '{{$item->name}}')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Modal -->
    <div class="modal fade" id="modalDelete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content" method="POST" action="">
                @csrf
                @method('DELETE')
                {{--mengganti method ="post" menjadi delete agar sesuai dengan route web.php ::delete--}}
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Obat</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda Yakin Ingin Menghapus Data Pengguna Ini <b id="name-pengguna"></b>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('script')
{{-- cdn jquery --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
    function showModalDelete(id, name) {
        //mengisi html bagian id="name-medicine" dengan text dari parameter name
        $('#name-pengguna').text(name);
        //tampilkan modal dengan id="modalDelete"
        $('#modalDelete').modal('show');
        //action diisi melalui js karna id dikirim ke js, id akan diisi ke route delete{id}
        let url = "{{route('user.delete', ':id') }}";
        //ganti :id dengan id yang dikirim dari parameter
        url = url.replace(':id', id);
        //masukan url yang sudah di isi id ke actiom form
        $("form").attr('action', url);
    }
</script>
@endpush