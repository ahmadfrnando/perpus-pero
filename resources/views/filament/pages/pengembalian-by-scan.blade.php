<x-filament-panels::page>
    @vite('resources/css/app.css')
    <div class="row border border-gray-200 border-1 rounded-xl p-4">
        <!-- Kamera -->
        <div class="col-md-6 card">
            <div class="card-body">
                <div class="flex gap-4">
                    <div>
                        <div id="reader" style="width: 500px;"></div>
                    </div>
                    <div class="flex flex-col w-full gap-4">
                        <h4 class="text-2xl font-bold dark:text-white uppercase">Informasi Peminjaman</h4>

                        <dl class="flex flex-col gap-4 max-w-md text-gray-900 divide-y divide-gray-200 dark:text-white dark:divide-gray-700">
                            <div class="flex flex-col pb-3">
                                <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Nama Anggota</dt>
                                <dd id="nama_anggota" class="text-lg font-semibold"></dd>
                            </div>
                            <div class="flex flex-col py-3">
                                <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Buku Yang Dipinjam</dt>
                                <dd id="judul_buku" class="text-lg font-semibold"></dd>
                            </div>
                            <div class="flex flex-col pt-3">
                                <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Tanggal Peminjaman</dt>
                                <dd id="tanggal_pinjam" class="text-lg font-semibold"></dd>
                            </div>
                            <div class="flex flex-col pt-3">
                                <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Tanggal Pengembalian Tercatat</dt>
                                <dd id="tanggal_kembali" class="text-lg font-semibold"></dd>
                            </div>
                        </dl>
                        <div>
                            <form action="{{ route('pengembalian.store') }}" method="POST">
                                @csrf
                                <div class="mb-5 hidden">
                                    <label for="peminjaman_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Peminjaman ID</label>
                                    <input type="number" id="peminjaman_id" name="peminjaman_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-yellow-500 dark:focus:border-yellow-500" required />
                                </div>
                                <div class="mb-5">
                                    <label for="tanggal_pengembalian" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Pengembalian</label>
                                    <input type="date" id="tanggal_pengembalian" name="tanggal_pengembalian" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-yellow-500 dark:focus:border-yellow-500" required />
                                </div>
                                <div class="mb-5">
                                    <label for="denda" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Denda</label>
                                    <input type="text" id="denda" name="denda" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-yellow-500 focus:border-yellow-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-yellow-500 dark:focus:border-yellow-500"/>
                                </div>
                                <button type="submit" class="text-white bg-yellow-700 hover:bg-yellow-800 focus:ring-4 focus:outline-none focus:ring-yellow-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">Submit</button>
                            </form>

                            <x-filament-actions::modals />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row border border-gray-200 border-1 rounded-xl p-4">
        {{ $this->table }}
    </div>
    <script src="{{ asset('html5-qrcode/html5-qrcode.min.js') }}"></script>
    <script src="{{ asset('js/jquery/dist/jquery.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        let html5QRCodeScanner = new Html5QrcodeScanner(
            "reader", {
                fps: 10,
                qrbox: {
                    width: 200,
                    height: 200,
                },
            }
        );

        function onScanSuccess(decodedText, decodedResult) {
            // redirect ke link hasil scan
            let data14 = decodedResult.decodedText;
            $.ajax({
                type: 'POST',
                url: "{{ route('barcode.scan') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    code: data14
                },
                beforeSend: function() {
                    Swal.fire({
                        title: 'Processing...',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                },
                success: function(response) {
                    if (response.success) {
                        $('#nama_anggota').html(response.data.nama_anggota);
                        $('#judul_buku').html(response.data.judul_buku);
                        $('#tanggal_pinjam').html(response.data.tanggal_pinjam);
                        $('#tanggal_kembali').html(response.data.tanggal_kembali);
                        $('#peminjaman_id').val(response.data.peminjaman_id);
                        $('#tanggal_pengembalian').val(response.data.tanggal_pengembalian);

                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: 'Data berhasil ditemukan dan dimuat ke form.'
                        });
                        window.refresh();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: response.message || 'Data tidak ditemukan!',
                        });
                    }
                },
                error: function(xhr) {
                    console.error(xhr);
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Terjadi kesalahan dalam proses pemindaian!',
                    });
                }
            });
            html5QRCodeScanner.pause();
        }
        html5QRCodeScanner.render(onScanSuccess);


        const dendaInput = document.getElementById('denda');

        function formatCurrency(event) {
            let value = event.target.value.replace(/\D/g, '');
            value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            event.target.value = value;
        }
        dendaInput.addEventListener('input', formatCurrency);
    </script>
</x-filament-panels::page>