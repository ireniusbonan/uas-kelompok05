<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <title>Add News Form</title>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-md navbar-light bg-info">
        <a href="#" class="navbar-brand text-white" onclick="redirectToDashboard()">Manajemen Data Pengguna</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggle-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link text-white" href="#" onclick="redirectToTambahData()">Tambah Data</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#" onclick="redirectToKelolaData()">Kelola Data</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#" onclick="logout()">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="mb-4">Add News Form</h2>
        <form id="addNewsForm">
            <div class="form-group">
                <label for="judul">Title:</label>
                <input type="text" class="form-control" maxlength="50" id="judul" name="judul" required>
            </div>

            <div class="form-group">
                <label for="deskripsi">Content:</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" cols="30" rows="10" required></textarea>
            </div>

            <div class="form-group">
                <label for="url_image">Image:</label>
                <input type="file" class="form-control-file" id="url_image" name="url_image" accept="image/*" required>
            </div>
            <button type="button" class="btn btn-primary" onclick="addNews()">Add News</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
    function redirectToDashboard() {
        window.location.href = 'dashboard.php';
    }

    function redirectToTambahData() {
        window.location.href = 'tambah.php';
    }

    function redirectToKelolaData() {
        window.location.href = 'kelola.php';
    }

    function logout() {
        // Implement your logout logic here
        // ...

        // Redirect to the login page after logout
        window.location.href = 'login.php';
    }

    function addNews() {
        const judul = document.getElementById('judul').value;
        const deskripsi = document.getElementById('deskripsi').value;
        const url_image_input = document.getElementById('url_image');
        const url_image = url_image_input.files[0];
        const tanggal = new Date().toISOString().split('T')[0];

        var formData = new FormData();
        formData.append('judul', judul);
        formData.append('deskripsi', deskripsi);
        formData.append('url_image', url_image);
        formData.append('tanggal', tanggal);

        axios.post('https://ireniusbonanproject.000webhostapp.com/konfigurasi/addnews.php', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
            })
            .then(function(response) {
                console.log(response.data);
                alert(response.data);
                document.getElementById('addNewsForm').reset();
            })
            .catch(function(error) {
                console.error(error);
                alert('Error Adding news');
            });
    }
    </script>
    <!-- Footer -->
    <?php include'footer.php'?>
</body>

</html>