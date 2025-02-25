<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk SmartLab</title>
    <link rel="icon" type="image/png" href="{{ asset('image/logo.png') }}">
    <link rel="stylesheet" href="style/login.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <style>
        .error-message {
            display: flex;
            align-items: center;
            color: #d9534f;
            background-color: #f8d7da;
            padding: 10px;
            border: 1px solid #f5c6cb;
            border-radius: 5px;
            font-size: 14px;
            margin-top: 5px;
        }

        .error-message i {
            margin-right: 8px;
        }
    </style>
</head>

<body>
    <div class="login-image">
        {{-- <div class="logo-icon">
            <img src="{{ asset('image/SMART-LAB (DARK MODE).png') }}" alt="LOGO SMART-LAB">
        </div> --}}
        <img src="img/background-login.png" alt="Login Image">
        <!-- Animasi Lottie di tengah -->
        <div class="lottie">
            <script src="https://unpkg.com/@dotlottie/player-component@2.7.12/dist/dotlottie-player.mjs" type="module"></script>
            <dotlottie-player src="https://lottie.host/30f2caaf-dad8-4180-8cff-e3764dc3fc17/kxT4zFVdbq.json"
                background="transparent" speed="1" style="width: 450px;" loop autoplay></dotlottie-player>
        </div>
    </div>
    <div style="display: flex; flex-direction:column; width: 50%; justify-content:center; align-items:center;">
        <h2>Masuk</h2>
        <h5>Selamat Datang!</h5>
        <p>Masukkan akun Email beserta Sandi nya yang sesuai</p>
        <div class="login-form">
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <table class="form-table">
                    <!-- Input Email -->
                    <tr>
                        <td colspan="2">
                            <span
                                style="display: flex; align-items: center; border: 1px solid #ddd; border-radius: 10px; padding-left: 15px;">
                                <i class='bx bxs-envelope'
                                    style="font-size: 24px; color: gray; padding-right: 10px;"></i>
                                <input type="email" id="email"  name="email" placeholder="Email"
                                    style="border: none; outline: none; flex: 1;">
                            </span>
                            <!-- Pesan Error Email -->
                            @error('email')
                                <div class="error-message">
                                    <i class='bx bx-error-circle'></i>{{ $message }}
                                </div>
                            @enderror
                        </td>
                    </tr>

                    <!-- Input Password -->
                    <tr>
                        <td colspan="2">
                            <span
                                style="display: flex; align-items: center; border: 1px solid #ddd; border-radius: 10px; padding: 0 15px;">
                                <i class='bx bxs-lock-open'
                                    style="font-size: 24px; color: gray; padding-right: 10px;"></i>
                                <input type="password" id="password"  name="password" placeholder="Password"
                                    style="border: none;  outline: none; flex: 1;">
                                <i class='bx bxs-show' id="toggle-password"
                                    style="font-size: 24px; color: gray; cursor: pointer; padding-left: 10px;"></i>
                            </span>
                            <!-- Pesan Error Password -->
                            @error('password')
                                <div class="error-message">
                                    <i class='bx bx-error-circle'></i>{{ $message }}
                                </div>
                            @enderror
                        </td>
                    </tr>

                    <!-- Tombol Login -->
                    <tr>
                        <td colspan="2"><button type="submit">Masuk</button></td>
                    </tr>
                </table>
            </form>
        </div>

        <div class="link">
            <p>Belum punya akun? <a href="register">Daftar Sekarang!</a></p>
        </div>
    </div>

    <script>
        document.getElementById('toggle-password').addEventListener('click', function () {
            const passwordField = document.getElementById('password');
            const icon = this;
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                icon.classList.remove('bxs-show');
                icon.classList.add('bxs-hide'); // Ganti ikon menjadi "mata tertutup"
            } else {
                passwordField.type = 'password';
                icon.classList.remove('bxs-hide');
                icon.classList.add('bxs-show'); // Ganti ikon kembali ke "mata terbuka"
            }
        });
    </script>
</body>

</html>