<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>manaBanka</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        header {
            background: linear-gradient(45deg, #ff8520, #ffb347);
            color: rgb(255, 255, 255);
            padding: 10px 0;
            text-align: center;
        }
        nav {
            display: flex;
            justify-content: center;
            background-color: #333;
        }
        nav a {
            margin: 0 15px;
            padding: 10px;
            text-decoration: none;
            color: #fff;
            transition: background-color 0.3s, color 0.3s;
        }
        nav a:hover {
            background-color: #555;
            color: #ff8520;
        }
        main {
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
        aside {
            background-color: #f1f1f1;
            padding: 10px;
            margin: 20px 0;
        }
        .card {
            background: linear-gradient(45deg, #fff, #f1f1f1);
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 20px;
            margin: 10px;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        @media (max-width: 600px) {
            nav {
                flex-direction: column;
            }
            .card {
                width: 100%;
            }
        }
        body.dark-mode {
            background-color: #121212;
            color: #ffffff;
        }
        header.dark-mode {
            background: linear-gradient(45deg, #333, #555);
        }
        nav.dark-mode a {
            color: hsl(0, 0%, 100%);
        }
        nav.dark-mode a:hover {
            background-color: #777;
            color: #ff8520;
        }
        .card.dark-mode {
            background: linear-gradient(45deg, #333, #444);
            border: 1px solid #555;
        }
        aside.dark-mode {
            background-color: #000;
            color: #fff;
        }
        aside.dark-mode ul {
            background-color: #000;
            color: #fff;
        }
        footer {
            text-align: center;
            background-color: #333;
            color: #fff;
            padding: 20px 0;
            position: fixed;
            width: 100%;
            bottom: 0;
        }
        footer a {
            color: #ff8520;
            text-decoration: none;
            margin: 0 10px;
        }
        footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <header>
        <h1>manaBanka</h1>
        <nav>
            <a href="home.html"><i class="fas fa-home"></i> Home</a>
            <a href="about.html"><i class="fas fa-info-circle"></i> About</a>
            <a href="contact.html"><i class="fas fa-envelope"></i> Contact</a>
        </nav>
    </header>
    <main>
        <h1>Welcome to manaBanka</h1>
        <h2>Jūsu uzticamais finanšu partneris</h2>
        <p>Pie manaBanka, mēs piedāvājam virkni finanšu pakalpojumu, lai palīdzētu jums efektīvi pārvaldīt savu naudu.</p>
        <div class="card">Pārskats</div>
        <div class="card">Pakalpojumi</div>
        <div class="card">Maksājumi</div>
    </main>
    <aside>
        <h3>Jums varētu šis noderēt!</h3>
        <ul>
            <li><a href="#article1">Kā ietaupīt naudu</a></li>
            <li><a href="https://azartaatkariba.lv/">Vai tev ir azartspēļu atkarība?</a></li>
            <li><a href="#article3">Kā investēt naudu</a></li>
        </ul>
    </aside>
    <footer>
        <p>&copy; 2024 manaBanka. Visas tiesības aizsargātas.</p>
        <p>Pieseko mums 
            <a href="https://facebook.com">Facebook</a>, 
            <a href="https://x.com/theeuropeanlad">X</a>, 
            <a href="https://www.instagram.com/leomessi/">Instagram</a>
        </p>
    </footer>
</body>
</html>