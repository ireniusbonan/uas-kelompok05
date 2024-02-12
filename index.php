<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <title>Login</title>
    <style>
    body {
        background-color: #f8f9fa;
        font-family: 'Arial', sans-serif;
    }

    .container {
        margin-top: 50px;
    }

    .col-md-6 {
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="mb-4">Login</h2>
                <form id="loginForm">
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="button" class="btn btn-primary" onclick="login()">Login</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
    // Function to handle login
    function login() {
        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;

        // Create FormData object
        const formData = new FormData();
        formData.append('username', username);
        formData.append('password', password);

        // Make a post request using Axios
        axios.post('https://ireniusbonanproject.000webhostapp.com/konfigurasi/login.php', formData)
            .then(response => {
                if (response.data.status === 'success') {
                    // If login is successful, redirect to the dashboard
                    window.location.href = 'dashboard.php';
                } else {
                    // If login fails, display an error message
                    alert('Login failed. Please check your credentials.');
                }
            })
            .catch(error => {
                console.error('Error during login', error);
                alert('An error occurred during login. Please try again.');
            });
    }

    // Function to check the session on page load
    function checkSession() {
        // Create FormData object with session_token
        const formData = new FormData();
        formData.append('session_token', localStorage.getItem('session_token'));

        // Make a post request using Axios
        axios.post('https://ireniusbonanproject.000webhostapp.com/konfigurasi/session.php', formData)
            .then(response => {
                if (response.data.status === 'success') {
                    const nama = response.data.hasil.name || 'Default Name';
                    localStorage.setItem('nama', nama);
                    window.location.href = 'dashboard.php';
                } else {
                    window.location.href = 'login.php';
                }
            })
            .catch(error => {
                console.error('Error checking session', error);
            });
    }

    // Call the checkSession function when the document is fully loaded
    document.addEventListener('DOMContentLoaded', checkSession);
    </script>
</body>

</html>