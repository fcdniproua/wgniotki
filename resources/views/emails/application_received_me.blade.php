<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Dzięki za wypełnienie formularza</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .container {
            background-color: #ffffff;
            max-width: 600px;
            margin: auto;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .logo {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo img {
            max-width: 150px;
        }
        .content {
            font-size: 16px;
            line-height: 1.6;
        }
        .social {
            text-align: center;
        }
        .social a {
            padding: 0 30px;
            position: relative;
            text-decoration: none;
        }
        .social img {
            width: 60px;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #aaa;
            margin-top: 40px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="logo">
        <img src="{{ asset('img/logo_v4.jpg') }}" alt="Logo">
    </div>
    <div class="content">
        <p><strong> Otrzymano nowe zgłoszenie!</strong></p>
        <p>Szczegóły dostępne są w panelu administracyjnym.</p>
    </div>
    <div class="social">
        <a href="https://usuwanie-wgniecen.pro/admin/dashboard" class="fa-brands" target="_blank">
            Do strony administracyjnej
        </a>
    </div>
    <div class="footer">
        &copy; {{ date('Y') }} Usuwanie Wgnieceń. Wszystkie prawa zastrzeżone.
    </div>
</div>
</body>
</html>
