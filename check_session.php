<script>
// Fungsi untuk memeriksa session
function checkSession() {
    // Ambil session_token dari localStorage
    // Membuat objek formData
    const formData = new FormData();
    formData.append('session_token', localStorage.getItem('session_token'));

    // Kirim session_token ke server untuk memeriksa 
    axios.post('https://ireniusbonanproject.000webhostapp.com/konfigurasi/session.php', formData)
        .then(response => {
            console.log(response);
            if (response.data.status == 'success') {
                // Jika session masih aktif, arahkan ke halaman dashboard.php
                const nama = response.data.hasil.name || 'Default Name';
                localStorage.setItem('nama', nama);
            } else {
                // Jika session tidak aktif, lakukan yang sesuai 
                window.location.href = 'login.php';
            }
        })
        .catch(error => {
            console.error('Error checking session', error);
        });
    // Panggil fungsi checkSession saat halaman dimuat
    checkSession();
}
</script>