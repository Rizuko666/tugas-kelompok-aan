
<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_POST["submit"])) {

    $username = htmlentities(strip_tags(trim($_POST["username"])));
    $password = htmlentities(strip_tags(trim($_POST["password"])));

    $error_message = "";

    // Validasi username
    if (empty($username)) {
        $error_message .= "- Username belum diisi <br>";
    }

    // Validasi password
    if (empty($password)) {
        $error_message .= "- Password belum diisi <br>";
    }

    // Hanya koneksi database jika input sudah diisi
    if ($error_message === "") {

        include("connection.php");

        // Mengamankan input
        $username = mysqli_real_escape_string($connection, $username);
        $password = mysqli_real_escape_string($connection, $password);

        // Enkripsi password sesuai modul
        $password_sha1 = sha1($password);

        // Query login
        $query = "
            SELECT * FROM admin
            WHERE username = '$username'
            AND password = '$password_sha1'
        ";

        $result = mysqli_query($connection, $query);

        // Cek apakah akun ditemukan
        if (!$result) {

            $error_message = "Database Error: " . mysqli_error($connection);

        } elseif (mysqli_num_rows($result) == 0) {

            $error_message .= "- Username dan/atau Password tidak sesuai";

        }

        if ($result) {
            mysqli_free_result($result);
        }

        mysqli_close($connection);
    }

    // Jika tidak ada error, buat session
    if ($error_message === "") {

        session_start();

        $_SESSION["username"] = $username;

        // Redirect ke halaman anggota kelompok lain
        header("Location: student_view.php");
        exit;
    }

} else {

    $error_message = "";
    $username = "";
    $password = "";

}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login Mahasiswa</title>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            min-height: 100vh;

            background: #f2f2f2;

            display: flex;
            justify-content: center;
            align-items: center;

            padding: 20px;

            color: #111;
        }

        .container {
            width: 100%;
            max-width: 420px;

            background: #fff;

            border: 1px solid #e5e5e5;

            border-radius: 20px;

            padding: 40px;

            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08);
        }

        .brand {
            display: flex;
            align-items: center;

            gap: 12px;

            margin-bottom: 32px;
        }

        .brand-icon {
            width: 48px;
            height: 48px;

            background: #111;

            color: #fff;

            border-radius: 13px;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 20px;

            font-weight: bold;
        }

        .brand-name {
            font-size: 15px;

            font-weight: bold;
        }

        .brand-name span {
            color: #e00000;
        }

        .header {
            margin-bottom: 28px;
        }

        .header h1 {
            font-size: 30px;

            margin-bottom: 9px;
        }

        .header p {
            color: #777;

            font-size: 14px;

            line-height: 1.5;
        }

        .error {
            background: #fff1f1;

            color: #d00000;

            border: 1px solid #ffcaca;

            border-radius: 10px;

            padding: 12px 14px;

            margin-bottom: 20px;

            font-size: 13px;

            line-height: 1.6;
        }

        fieldset {
            border: none;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;

            margin-bottom: 8px;

            font-size: 14px;

            font-weight: 600;
        }

        .form-group input {
            width: 100%;

            height: 48px;

            padding: 0 15px;

            border: 1px solid #d8d8d8;

            border-radius: 10px;

            background: #fafafa;

            font-size: 14px;

            outline: none;

            transition: 0.2s;
        }

        .form-group input:focus {
            background: #fff;

            border-color: #e00000;

            box-shadow: 0 0 0 3px rgba(224, 0, 0, 0.08);
        }

        .login-button {
            width: 100%;

            height: 48px;

            margin-top: 5px;

            border: none;

            border-radius: 10px;

            background: #111;

            color: #fff;

            font-size: 14px;

            font-weight: bold;

            cursor: pointer;

            transition: 0.2s;
        }

        .login-button:hover {
            background: #e00000;

            transform: translateY(-1px);
        }

        .footer {
            text-align: center;

            margin-top: 25px;

            color: #999;

            font-size: 12px;
        }

        .footer span {
            color: #e00000;
        }

        @media (max-width: 500px) {

            .container {
                padding: 30px 25px;
            }

        }

    </style>

</head>

<body>

    <div class="container">

        <div class="brand">

            <div class="brand-icon">
                M
            </div>

            <div class="brand-name">
                Student<span>Portal</span>
            </div>

        </div>

        <div class="header">

            <h1>
                Welcome back.
            </h1>

            <p>
                Login untuk melanjutkan ke Data Mahasiswa.
            </p>

        </div>

        <?php

        if ($error_message !== "") {

            echo "<div class='error'>$error_message</div>";

        }

        ?>

        <form action="login.php" method="post">

            <fieldset>

                <div class="form-group">

                    <label for="username">
                        Username
                    </label>

                    <input
                        type="text"
                        name="username"
                        id="username"
                        placeholder="Masukkan username"
                        value="<?php echo htmlspecialchars($username); ?>"
                    >

                </div>

                <div class="form-group">

                    <label for="password">
                        Password
                    </label>

                    <input
                        type="password"
                        name="password"
                        id="password"
                        placeholder="Masukkan password"
                    >

                </div>

                <button
                    type="submit"
                    name="submit"
                    class="login-button"
                >
                    Log In
                </button>

            </fieldset>

        </form>

        <div class="footer">

            Student Portal
            <span>•</span>
            PHP Project

        </div>

    </div>

</body>

</html>
