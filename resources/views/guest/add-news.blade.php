@extends('guest.layguest')
@section('title', 'Tambah Berita')
@section('contents')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tokenfield/0.12.0/css/bootstrap-tokenfield.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tokenfield/0.12.0/bootstrap-tokenfield.js"></script>

<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
<style>
    /* Override CKEditor's height restrictions */
    .ck-editor__editable {
        min-height: 300px;
        /* Ganti nilai sesuai kebutuhan Anda */
    }
</style>

<section class="section dashboard">
    <div class="row">
        <form class="row needs-validation" action="{{route('send')}}" enctype="multipart/form-data" method="post" novalidate>
            @csrf
            <!-- Left side columns -->
            <div class="col-lg-8">
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <h5 class="card-title ">Add News</h5>
                        <div class="mb-3">
                            <label for="validationCustom01" class="form-label">Judul Artikel <span class="text-danger">*</span></label>
                            <input type="text" name="judul" class="form-control" id="validationCustom01" value="" placeholder="Masukkan Judul..." required>
                            <div class="invalid-feedback">
                                Judul tidak boleh kosong.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Deskripsi <span class="text-danger">*</span></label>
                            <textarea id="editor" name="deskripsi">
                            </textarea>
                        </div>
                    </div>
                </div>
            </div><!-- End Left side columns -->

            <!-- Right side columns -->
            <div class="col-lg-4">
                <div class="card border-0 shadow">
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="gambar" class="form-label">Foto<span class="text-danger">*</span></label>
                            <div class="row align-items-center">
                                <div class="">
                                    <div class="input-group mb-3 ">
                                        <input type="file" id="input-type-file" class="form-control" name="foto" style="border-radius: 5px 0 0 5px;" aria-label="file example" onchange="readUrl(this)" required>
                                        <div class="input-group-append">
                                            <button class="btn btn-primary " style="border-radius: 0 5px 5px 0;" type="button" onclick="hapusGambar()"><i class="ri ri-delete-bin-6-line"></i></button>
                                        </div>
                                    </div>
                                    <div id="invalid-feedback"></div>
                                </div>
                                <div class="mb-3">
                                    <img src="{{asset('/img/blank.jpg')}}" class="w-100 shadow" alt="" for="input-type-file" id="gam">
                                </div>
                                <div class="form-floating">
                                    <textarea class="form-control" name="keterangan_foto" id="keterangan_foto" style="height: 70px" required></textarea>
                                    <label for="keterangan_foto">Keterangan Foto<span class="text-danger">*</span></label>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <!-- Kategori -->
                            <div class="accordion " id="accordionFlushExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="flush-headingOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                            Kategori<span class="text-danger">*</span>
                                        </button>
                                    </h2>
                                    <div id="flush-collapseOne" class="accordion-collapse collapse text-capitalize text-dark show" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body" id="kategori-body">
                                            @forelse ($kategori as $kt)
                                            <div class="form-check" style="font-size: 16px;">
                                                <input class="form-check-input" type="checkbox" name="id_kategori[]" value="{{$kt['id_kategori']}}" id="gridCheck{{$kt['id_kategori']}}">
                                                <label class="form-check-label" for="gridCheck{{$kt['id_kategori']}}">{{$kt["nama_kategori"]}}</label>
                                            </div>
                                            @empty
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Pesan kesalahan untuk Kategori -->
                            <div id="kategori-error" class="text-danger"></div>
                        </div>

                        <div class="mb-3">
                            <label for="zona">Zona Daerah</label>
                            <select class="form-select" id="zona" name="id_wilayah">
                                <option selected disabled value="null">Choose...</option>
                                @forelse ($zona as $z)
                                <option value="{{$z['id_wilayah']}}">{{$z["nama_wilayah"]}}</option>
                                @empty

                                @endforelse

                            </select>
                            <div class="invalid-feedback">
                                Please select a valid state.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="skill" class="form-label">Tags<span class="text-danger">*</span></label>
                            <input type="text" name="tags" id="skill" class="form-control" required />
                            <div class="invalid-feedback">
                                Tag tidak boleh kosong.
                            </div>
                        </div>
                        <div class="col-12 d-grid">
                            <button class="btn btn-cream " type="submit" id="kirim">Simpan</button>
                        </div>
                    </div>
                </div>
            </div><!-- End Right side columns -->
        </form>
    </div>
</section>
<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
        'use strict'

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.querySelectorAll('.needs-validation')

        // Loop over them and prevent submission
        Array.prototype.slice.call(forms)
            .forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            })
    })()

    function validateForm() {
        // Mengambil semua input checkbox kategori
        const checkboxes = document.querySelectorAll('input[type="checkbox"]');
        let kategoriChecked = false;

        checkboxes.forEach((checkbox) => {
            if (checkbox.checked) {
                kategoriChecked = true;
                return; // Setelah menemukan satu yang dipilih, keluar dari loop
            }
        });

        // Jika tidak ada kategori yang dipilih, tampilkan pesan kesalahan
        if (!kategoriChecked) {
            document.getElementById('kategori-error').textContent = 'Pilih minimal satu kategori.';
            return false; // Form tidak akan disubmit
        }

        // Jika ada kategori yang dipilih, form akan disubmit
        return true;
    }

    // Mengaitkan fungsi validasi dengan pengiriman formulir
    document.querySelector('form').addEventListener('submit', function(e) {
        if (!validateForm()) {
            e.preventDefault(); // Mencegah pengiriman formulir jika tidak valid
        }
    });

    /*  */
    $(document).ready(function() {
        <?php
        // Mengambil hanya nilai dari kolom "nama_tag" dari variabel PHP $tags
        $namaTags = array_column($tags, 'nama_tag');
        ?>

        var tags = <?php echo json_encode($namaTags); ?>; // Menggunakan data dari variabel PHP
        $('#skill').tokenfield({
            autocomplete: {
                source: tags, // Menggunakan data dari variabel PHP
                delay: 100
            },
            showAutocompleteOnFocus: true
        });

        ClassicEditor
            .create(document.querySelector('#editor'), {
                ckfinder: {
                    uploadUrl: "http://127.0.0.1:3000/uploadImage"
                }
            })
            .catch(error => {
                console.error(error);
            });
    });

    function hapusGambar() {
        document.getElementById("gam").src = '{{asset("/assets/img/blank.jpg")}}';
        fileInput.value = ''; // Menghapus nilai input file
        errorMessage.textContent = ''; // Menghapus pesan error
        fileInput.classList.remove('is-invalid');
        fileInput.classList.remove('is-valid');
    }

    // end tombol
    // gambar
    var a = document.getElementById("gam");

    function readUrl(input) {
        if (input.files) {
            var reader = new FileReader();
            reader.readAsDataURL(input.files[0]);
            reader.onload = (e) => {
                a.src = e.target.result;
            };
        }
    }
    const fileInput = document.querySelector('#input-type-file');
    const errorMessage = document.querySelector("#invalid-feedback");

    function hapusGambar() {
        $("#button-add").prop("disabled", false);
        document.getElementById("gam").src = "/img/blank.jpg";
        fileInput.value = ""; // Menghapus nilai input file
        errorMessage.textContent = ""; // Menghapus pesan error
        fileInput.classList.remove("is-invalid");
        fileInput.classList.remove("is-valid");
    }

    fileInput.addEventListener("change", function() {
        const file = fileInput.files[0];
        const fileSize = file.size;

        const allowedExtensions = /(\.jpeg|\.jpg|\.png)$/i; // Ekstensi yang diizinkan (jpg, png)

        if (!allowedExtensions.test(file.name.toLowerCase())) {
            errorMessage.textContent =
                "Hanya gambar dengan ekstensi JPG dan PNG yang diizinkan";
            fileInput.classList.add("is-invalid");
            $("#button-add").prop("disabled", true);
        } else {
            errorMessage.textContent = "";
            fileInput.classList.remove("is-invalid");
            fileInput.classList.add("is-valid");
        }
    });
    // end gambar
</script>

@endsection
