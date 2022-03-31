<style>
     .switch {
            position: relative;
            display: inline-block;
            width: 48px;
            height: 23px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 15px;
            width: 15px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked + .slider {
            background-color: #377dff;
        }

        input:focus + .slider {
            box-shadow: 0 0 1px #377dff;
        }

        input:checked + .slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }

    @media(min-width: 700px) {
        .modal-dialog {
            max-width: 90%;
        }
    }
</style>
<div class="modal fade" id="apply" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Masukan data diri</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @php($user = auth('customer')->user())
            {{-- {{ dd($user) }} --}}
            <form action="{{ route('apply.apply') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $product->id }}">
                <div class="modal-body">
                    <div class="container">
                        <div class="row d-flex flex-column">
                            <div class="card">
                                <div class="card-header">DATA PELAMAR KERJA</div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="name">Nama lengkap</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            value="{{ $user->f_name }} {{ $user->l_name }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            value="{{ $user->email }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">Nomor handphone / Telepon</label>
                                        <input type="number" class="form-control" id="phone" name="phone"
                                            value="{{ $user->phone }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="address">Alamat lengkap</label>
                                        <textarea class="form-control" id="address" name="address"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="card mt-3">
                                <div class="card-header">KOMPETENSI PELAMAR KERJA</div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="name">Pendidikan Terakhir</label>
                                        <input type="text" class="form-control" name="pendidikan"
                                            placeholder="Tulis pendidikan terakhir Anda">
                                    </div>
                                    <div class="form-group">
                                        <label>Skill dan Kemampuan</label>
                                        <textarea class="form-control" name="keahlian"
                                            placeholder="Tulis dengan lengkap skill dan kemampuan yang anda miliki, jika pernah ikut pelatihan atau kursus silahkan tulis juga"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">Pengalaman kerja</label>
                                        <textarea class="form-control"
                                            placeholder="Tulis dengan lengkap pengalaman kerja anda selama ini, sertakan berapa lama dan apa saja yang Anda kerjakan"
                                            name="pengalaman"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="address">Penghasilan Terakhir (<small class="text-danger">Jika tidak
                                                ada, tulis 0</small>)</label>
                                        <input type="number" class="form-control" name="penghasilan"></input>
                                    </div>
                                    <div class="form-group">
                                        <label for="address">Ekspektasi Gaji (<small class="text-danger">Tulis
                                                penghasilan yang anda harapkan</small>)</label>
                                        <input type="number" class="form-control" name="gaji"></input>
                                    </div>

                                    <div class="form-group">
                                        <label for="address" class="d-block mb-2">Saya bersedia ditempatkan di:</label>
                                        <p class="d-block">{{ $product->penempatan }}</p>
                                        <div class="row">
                                            <label class="switch">
                                                <input type="checkbox" class="status" id="onsite" name="onsite">
                                                <span class="slider round"></span>
                                            </label>
                                            <span class="ml-3">Saya bersedia</span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
