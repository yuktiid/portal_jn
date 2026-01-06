@extends('guest.layguest')
@section('contents')

<link href="{{asset('asset/simple-datatables/style.css')}}" rel="stylesheet">
<!-- Bordered Tabs Justified -->
<section>
    <div class="row">
        <div class="col-12">
            <div class="my-3">
                <a href="{{route('guest.addnews')}}" class="btn btn-cream">+ Tambah Berita</a>
            </div>
            <ul class="nav nav-tabs nav-tabs-bordered d-flex" id="borderedTabJustified" role="tablist">
                <li class="nav-item flex-fill" role="presentation">
                    <button class="nav-link w-100 active" id="publis-tab" data-bs-toggle="tab" data-bs-target="#bordered-justified-home" type="button" role="tab" aria-controls="home" aria-selected="true">Dipublikasikan</button>
                </li>
                <li class="nav-item flex-fill" role="presentation">
                    <button class="nav-link w-100" id="pending-tab" data-bs-toggle="tab" data-bs-target="#bordered-justified-profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Pending</button>
                </li>
                <li class="nav-item flex-fill" role="presentation">
                    <button class="nav-link w-100" id="reject-tab" data-bs-toggle="tab" data-bs-target="#bordered-justified-contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Ditolak</button>
                </li>
            </ul>
            <div class="tab-content pt-2 table-responsive" id="borderedTabJustifiedContent">
                <div class="tab-pane fade show active" id="bordered-justified-home" role="tabpanel" aria-labelledby="publis-tab">
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th scope="row">#</th>
                                <th scope="row">Foto</th>
                                <th scope="row">Judul</th>
                                <th scope="row">Deskripsi</th>
                                <th scope="row">Tanggal Publikasi</th>
                                <th scope="row">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($publis as $pu)
                            <tr>
                                <th scope="col">{{$loop->iteration}}.</th>
                                <td><img src="{{$link}}{{$pu->foto}}" alt="" width="50"></td>
                                <td>{{$pu->judul}}</td>
                                <td>
                                    <!-- Modal Dialog Scrollable -->
                                    <button type="button" class="btn btn-cream btn-sm" data-bs-toggle="modal" data-bs-target="#modalDialogScrollable{{$pu->id_post}}">
                                        Deskripsi
                                    </button>
                                    <div class="modal fade" id="modalDialogScrollable{{$pu->id_post}}" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Deskripsi</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    {!!$pu->deskripsi!!}
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- End Modal Dialog Scrollable-->
                                </td>
                                <td>
                                    @if ($pu->tanggal_publikasi)
                                    {{Carbon\Carbon::parse($pu->tanggal_publikasi)->locale('id_ID')->isoFormat('dddd, DD MMMM YYYY')}}
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-cream btn-sm" data-bs-toggle="dropdown">Action</button>

                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center" target="_blank" href="">
                                                <i class="ri ri-arrow-right-up-line"></i>
                                                <span>Detail</span>
                                            </a>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center" href="{{route('guest.update', ['slug'=>$pu->slug])}}">
                                                <i class="ri ri-ball-pen-fill"></i>
                                                <span>Update</span>
                                            </a>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>

                                        <li>
                                            <a class="dropdown-item d-flex align-items-center hapus" href="{{route('deletePosts',['id'=>$pu->id_post])}}">
                                                <i class="ri ri-delete-bin-6-fill"></i>
                                                <span>Delete</span>
                                            </a>
                                        </li>

                                    </ul><!-- End Profile Dropdown Items -->
                                </td>
                            </tr>
                            @empty

                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="bordered-justified-profile" role="tabpanel" aria-labelledby="pending-tab">
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th scope="row">#</th>
                                <th scope="row">Foto</th>
                                <th scope="row">Judul</th>
                                <th scope="row">Deskripsi</th>
                                <th scope="row">Tanggal Publikasi</th>
                                <th scope="row">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pending as $pu)
                            <tr>
                                <th scope="col">{{$loop->iteration}}.</th>
                                <td><img src="{{$link}}{{$pu->foto}}" alt="" width="50"></td>
                                <td>{{$pu->judul}}</td>
                                <td>
                                    <!-- Modal Dialog Scrollable -->
                                    <button type="button" class="btn btn-cream btn-sm" data-bs-toggle="modal" data-bs-target="#modalDialogScrollable2{{$pu->id_post}}">
                                        Deskripsi
                                    </button>
                                    <div class="modal fade" id="modalDialogScrollable2{{$pu->id_post}}" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Deskripsi</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    {!!$pu->deskripsi!!}
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- End Modal Dialog Scrollable-->
                                </td>
                                <td>
                                    @if (!$pu->tanggal_publikasi)
                                    Menunggu Persetujuan...
                                    @else
                                    {{Carbon\Carbon::parse($pu->tanggal_publikasi)->locale('id_ID')->isoFormat('dddd, DD MMMM YYYY')}}
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-cream btn-sm" data-bs-toggle="dropdown">Action</button>

                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center" target="_blank" href="">
                                                <i class="ri ri-arrow-right-up-line"></i>
                                                <span>Detail</span>
                                            </a>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center" href="{{route('guest.update', ['slug'=>$pu->slug])}}">
                                                <i class="ri ri-ball-pen-fill"></i>
                                                <span>Update</span>
                                            </a>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>

                                        <li>
                                            <a class="dropdown-item d-flex align-items-center hapus" href="{{route('deletePosts',['id'=>$pu->id_post])}}">
                                                <i class="ri ri-delete-bin-6-fill"></i>
                                                <span>Delete</span>
                                            </a>
                                        </li>

                                    </ul><!-- End Profile Dropdown Items -->
                                </td>
                            </tr>
                            @empty

                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="bordered-justified-contact" role="tabpanel" aria-labelledby="reject-tab">
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th scope="row">#</th>
                                <th scope="row">Foto</th>
                                <th scope="row">Judul</th>
                                <th scope="row">Deskripsi</th>
                                <th scope="row">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($tolak as $pu)
                            <tr>
                                <th scope="col">{{$loop->iteration}}.</th>
                                <td><img src="{{$link}}{{$pu->foto}}" alt="" width="50"></td>
                                <td>{{$pu->judul}}</td>
                                <td>
                                    <!-- Modal Dialog Scrollable -->
                                    <button type="button" class="btn btn-cream btn-sm" data-bs-toggle="modal" data-bs-target="#modalDialogScrollable3{{$pu->id_post}}">
                                        Deskripsi
                                    </button>
                                    <div class="modal fade" id="modalDialogScrollable3{{$pu->id_post}}" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Deskripsi</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    {!!$pu->deskripsi!!}
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- End Modal Dialog Scrollable-->
                                </td>
                                <td>
                                    <a href="{{route('deletePosts',['id'=>$pu->id_post])}}" class="btn btn-danger btn-sm"><i class="ri ri-delete-bin-6-fill"></i>
                                        <span>Delete</span></a>
                                </td>
                            </tr>
                            @empty

                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div><!-- End Bordered Tabs Justified -->
        </div>
    </div>
</section>
<script src="{{asset('asset/simple-datatables/simple-datatables.js')}}"></script>
@endsection
