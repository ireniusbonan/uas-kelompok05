<?php
include('header.php');
include('check_session.php');

// Ambil ID dari $_POST
$id = isset($_POST['id']) ? $_POST['id'] : null;
?>

<div class="container mt-5">
    <h2 class="mb-4">Edit News Form</h2>
    <form id="editNewsForm">
        <input type="hidden" id="newsId" value="<?= $id ?>">
        <div class="form-group">
            <label for="judul">Title:</label>
            <input type="text" class="form-control" maxlength="50" id="judul" name="judul" required>
        </div>
        <div class="form-group">
            <label for="deskripsi">Content:</label>
            <!-- Changed from input to textarea for content -->
            <textarea class="form-control" id="deskripsi" name="deskripsi" required></textarea>
        </div>
        <div class="form-group">
            <label for="img_url">Image:</label>
            <!-- Corrected id from "url_image" to "img_url" and name from "url_name" to "img_url" -->
            <input type="file" class="form-control-file" id="img_url" name="img_url" accept="image/*" required>
        </div>
        <button type="button" class="btn btn-primary" onclick="editNews()">Edit News</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
function getData() {
    const newsId = document.getElementById('newsId').value;
    var formData = new FormData();
    formData.append('idnews', newsId);
    //lakukan permintaan AJAX untuk mendapatkan data dari berita berdasakan ID
    axios.post('https://ireniusbonanproject.000webhostapp.com/konfigurasi/selectdata.php', formData)
        .then(function(response) {
            //isi nilai input dengan data yang diterima 
            document.getElementById('judul').value = response.data.title;
            document.getElementById('deskripsi').value = response.data.desc;
        })
        .catch(function(error) {
            console.error(error);
            alert('Error fetching news data');
        });
}

function editNews() {
    const newsId = document.getElementById('newsId').value;
    const judul = document.getElementById('judul').value;
    const deskripsi = document.getElementById('deskripsi').value;
    const img_urlInput = document.getElementById('img_url');
    const img_url = img_urlInput.files[0];
    const tanggal = new Date().toISOString().split('T')[0];
    //get form data
    var formData = new FormData();
    formData.append('idnews', newsId);
    formData.append('judul', judul);
    formData.append('deskripsi', deskripsi);
    formData.append('tanggal', tanggal);

    if (img_urlInput.files.length > 0) {
        formData.append('url_image', img_url);
    } else {
        formData.append('url_image', null);
    }
    //lakukan permintaan AJAX untuk mengedit berita
    axios.post('https://ireniusbonanproject.000webhostapp.com/konfigurasi/editnews.php', formData, {
            headers: {
                "Content-Type": "multipart/form-data",
            },
        })
        .then(function(response) {
            console.log(response.data);
            alert(response.data);
            window.location.href = 'kelola.php';
        })
        .catch(function(error) {
            console.error(error);
            alert('Error Editing news');
        });
}

window.onload = getData;
</script>