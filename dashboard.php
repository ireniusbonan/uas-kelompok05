<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!-- DataTablesCSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- Axios -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <!-- DataTables Javascript -->
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- PDFMake -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/vfs_fonts.js"></script>

    <!-- Excel Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>


    <title>Dasbor</title>
</head>

</style>

<body>
    <nav class="navbar navbar-expand-md navbar-light bg-info">
        <a href="#" class="navbar-brand text-white" onclick="dashboard()"> Manajemen Data Pengguna</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggle-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link text-white" href="#" onclick="tambahdata()">Tambah Data</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#" onclick="keloladata()">Kelola Data</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#" onclick="logout()">Logout</a>
                </li>
            </ul>
        </div>
    </nav>
    <script>
    function dashboard() {
        // Periksa apakah pengguna sudah login
        const sessionToken = localStorage.getItem('session_token');
        const currentPage = window.location.pathname.split('/').pop(); // Ambil nama halaman saat ini

        if (!sessionToken && currentPage !== 'dashboard.php') {
            // Jika belum login dan bukan di halaman manajemen data pengguna, redirect ke halaman login
            window.location.href = "login.php";
        } else {
            // Jika sudah login atau di halaman manajemen data pengguna, Anda dapat menyesuaikan perilaku sesuai kebutuhan
            alert("Anda sudah login!");
        }
    }


    function tambahdata() {
        window.location.href = "tambah.php";
    }

    function keloladata() {
        // Periksa apakah pengguna sudah login
        const sessionToken = localStorage.getItem('session_token');

        if (!sessionToken) {
            // Jika belum login, redirect ke halaman login
            window.location.href = "login.php";
        } else {
            // Jika sudah login, arahkan ke halaman kelola.php
            window.location.href = "kelola.php";
        }
    }

    function logout() {
        // Dapatkan session_token dari penyimpanan yang sesuai
        const sessionToken = localStorage.getItem('session_token');
        // Hapus "nama" dari local storage saat logout
        localStorage.removeItem('nama');
        // Buat objek FormData
        const formData = new FormData();
        formData.append('session_token', sessionToken);

        // Konfigurasi Axios untuk logout
        axios.post('https://ireniusbonanproject.000webhostapp.com/konfigurasi/logout.php', formData)
            .then(response => {
                // Tangani respons dari server 
                if (response.data.status == "success") {
                    // Jika logout berhasil, arahkan kembali ke halaman login
                    localStorage.removeItem('nama');
                    localStorage.removeItem('session_token');
                    window.location.href = "login.php";
                } else {
                    // Jika logout gagal, tampilkan pesan kesalahan
                    alert('Logout gagal, silakan coba lagi.');
                }
            })
            .catch(error => {
                // Tangani kesalahan koneksi atau server
                console.error('Error selama logout', error);
            });
    }
    </script>


    <div class="container mt-5">
        <!-- Konten Dashboard -->
        <h2 id="welcomeMessage">Selamat datang di Dashboard</h2>
        <!-- Isi dengan konten lainnya -->
    </div>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <button onclick="downloadExcel()" class="btn btn-success mr-2">
                    <i class="fa fa-download"></i> Unduh Excel
                </button>
                <button onclick="downloadPDF()" class="btn btn-danger">
                    <i class="fas fa-download"></i> Unduh PDF
                </button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 offset-md-3 text-center">
                <div class="card bg-success my-4">
                    <div class="card-header"> Akumulasi Berita</div>
                    <div class="card-body">
                        <h3 id="jumlahBerita" class="text-dark">
                            <i class="fas fa-newspaper"></i> Loading...
                        </h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="tahunSelect">Pilih Tahun</label>
                <select class="form-control" id="tahunSelect"></select>
            </div>
        </div>
        <hr>

        <h2 class="text-center">GRAFIK JUMLAH BERITA DALAM 1 TAHUN</h2>
        <div class="row">
            <div class="col-md-12">
                <canvas id="newsChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>

    <script>
    // Fungsi untuk mengambil data dari API berdasarkan tahun menggunakan axios.post 
    function fetchData(tahun) {
        var formData = new FormData();
        formData.append('tahun', tahun);

        return axios({
            method: 'post',
            url: 'https://ireniusbonanproject.000webhostapp.com/konfigurasi/sum_beritatahun.php',
            data: formData,
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        });
    }

    // Fungsi untuk membuat chart dengan data yang diambil
    function createChart(data) {
        var ctx = document.getElementById('newsChart').getContext('2d');

        // Check if there is an existing chart and destroy it 
        var existingChart = Chart.getChart(ctx);
        if (existingChart) {
            existingChart.destroy();
        }

        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: data.map(item => item.bulan),
                datasets: [{
                    label: 'Jumlah Berita',
                    data: data.map(item => item.jumlah_berita),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtzero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    }

    // Fungsi untuk mengisi select option dengan tahun 
    function populateSelectOptions(data) {
        var selectElement = document.getElementById('tahunSelect');
        data.forEach(item => {
            var option = document.createElement('option');
            option.value = item.tahun;
            option.text = item.tahun;
            selectElement.add(option);
        });

        // Set default selected year to the latest year 
        var latestYear = data[0].tahun;
        document.getElementById('tahunSelect').value = latestYear;

        // Fetch data and create the initial chart
        fetchData(latestYear)
            .then(response => {
                var chartData = response.data;
                createChart(chartData);
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });
    }

    // Event listener untuk perubahan select option tahun
    document.getElementById('tahunSelect').addEventListener('change', function() {
        var selectedYear = this.value;
        fetchData(selectedYear)
            .then(response => {
                var chartData = response.data;
                createChart(chartData);
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });
    });

    // Inisialisasi select option dengan data tahun dari API
    axios.get('https://ireniusbonanproject.000webhostapp.com/konfigurasi/select_tahun.php')
        .then(response => {
            var tahunData = response.data;
            populateSelectOptions(tahunData);
        })
        .catch(error => {
            console.error('Error fetching tahun data:', error);
        });

    axios.get('https://ireniusbonanproject.000webhostapp.com/konfigurasi/sum_berita.php')
        .then(function(response) {
            // Memproses data yang diterima dari API
            var dataJumlahBerita = response.data;
            // Mengambil elemen untuk menampilkan jumlah berita
            var jumlahBeritaElement = document.getElementById('jumlahBerita');
            // Menampilkan jumlah berita pada dashboard dengan Font Awesome icon
            jumlahBeritaElement.innerHTML =
                `<i class="fas fa-newspaper"></i> Jumlah Berita: ${dataJumlahBerita[0].jumlah_berita}`;
        })
        .catch(function(error) {
            console.error('Error fetching data:', error);
        });

    function downloadExcel() {
        // Fetch data based on the selected year
        var selectedYear = document.getElementById('tahunSelect').value;
        fetchData(selectedYear)
            .then(response => {
                var data = response.data;

                // Buat worksheet
                var ws = XLSX.utils.json_to_sheet(data);

                // Buat file Excel
                var wb = XLSX.utils.book_new();
                XLSX.utils.book_append_sheet(wb, ws, "Laporan");

                // Simpan file Excel dan unduh
                XLSX.writeFile(wb, "laporan_excel_" + selectedYear + ".xlsx");
            })
            .catch(error => {
                console.error('Error fetching data for Excel:', error);
            });
    }

    function downloadPDF() {
        // Ambil elemen canvas dari chart
        var canvas = document.getElementById('newsChart');

        // Konversi elemen canvas menjadi gambar 
        var imgData = canvas.toDataURL('image/png');

        // Ambil tahun terpilih dari dropdown
        var selectedYear = document.getElementById('tahunSelect').value;
        // Definisikan content untuk PDF menggunakan pdfmake
        var docDefinition = {
            content: [{
                    text: 'Laporan Tahun ' + selectedYear,
                    style: 'header'
                },
                {
                    image: imgData,
                    width: 500
                },
            ],
            styles: {
                header: {
                    fontSize: 18,
                    bold: true,
                    margin: [0, 0, 0, 10],
                },
            },
        };
        // Buat PDF menggunakan pdfmake
        pdfMake.createPdf(docDefinition).download('laporan_' + selectedYear + '_pdf.pdf');
    }
    </script>
    </script>
    <!-- Footer -->
    <!-- Footer -->
    <?php include'footer.php'?>
</body>

</html>