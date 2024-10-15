<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema UNICA - Escolha</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(to right, #003150, #1b4f72);
            color: white;
            text-align: center;
        }

        h1 {
            margin-bottom: 50px;
            font-size: 2.5rem;
            color: #ffffff;
            animation: fadeIn 1s ease-in-out;
        }

        .container {
            display: flex;
            justify-content: center;
            gap: 50px;
        }

        a {
            text-decoration: none;
            color: #ffffff;
            background-color: #004a73;
            padding: 15px 30px;
            border-radius: 10px;
            font-size: 1.2rem;
            transition: background-color 0.3s ease, transform 0.3s ease;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        a:hover {
            background-color: #59CBE8;
            transform: scale(1.1);
        }

        a:active {
            transform: scale(0.95);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        .container a:nth-child(1) {
            animation: slideInFromLeft 0.8s ease-out;
        }

        .container a:nth-child(2) {
            animation: slideInFromRight 0.8s ease-out;
        }

        @keyframes slideInFromLeft {
            from {
                transform: translateX(-100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideInFromRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
    </style>
</head>
<body>

    <div>
        <h1>Escolha qual sistema deseja acessar</h1>
        <div class="container">
            <a href="sistema_oficina/login/login.php">Oficina</a>
            <a href="sistema_orgao_publico/index.php">Órgão Público</a>
        </div>
    </div>

</body>
</html>
