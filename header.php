<!DOCTYPE html>
<html lang="en">

<head>
    <style>
    body {
        background-color: #f8f9fa;
        font-family: 'Arial', sans-serif;
    }

    .container {
        margin-top: 50px;
    }

    .card-header {
        background-color: #28a745;
        color: #fff;
        font-size: 1.5rem;
    }

    .card-body {
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 10px;
        padding: 20px;
    }

    #newsChart {
        margin-top: 20px;
    }
    </style>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!-- DataTablesCSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <!-- DataTables Javascript -->
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <title>Dashboard</title>
</head>

<body>
    <nav class="navbar navbar-expand-md navbar-light bg-info">
        <a href="#" class="navbar-brand text-white" onclick="dashboard()"> Manajemen Data Pengguna</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label=Toggle navigation>
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
        window.location.href = "dashboard.php";
    }

    function tambahdata() {
        window.location.href = "tambah.php";
    }

    function keloladata() {
        window.location.href = "kelola.php";
    }

    function logout() {
        // Mendapatkan session_token dari tempat penyimpanan yang sesuai
        const sessionToken = localStorage.getItem('session_token');
        // Hapus "nama" dari localStorage saat logout
        localStorage.removeItem('nama');
        // Membuat objek FormData
        const formData = new FormData();
        formData.append('session_token', sessionToken);

        // Konfigurasi Axios untuk logout
        axios.post('https://ireniusbonanproject.000webhostapp.com/konfigurasi/logout.php', formData)
            .then(response => {
                // Handle response dari server 
                if (response.data.status == "success") {
                    // Jika logout berhasil, arahkan kembali ke halaman login
                    localStorage.removeItem('nama');
                    localStorage.removeItem('session_token');
                    window.location.href = "login.php";
                } else {
                    // Jika logout gagal, tampilkan pesan kesalahan
                    alert('Logout failed, Please try again.');
                }
            })
            .catch(error => {
                // Handle kesalahan koneksi atau server
                console.error('Error during logout', error);
            });
    }
    </script>
</body>

</html>