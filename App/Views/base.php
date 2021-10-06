<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Test</title>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" type="text/css" href="./Tools/css/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
    <!-- Bootstrap CSS -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous"> -->

</head>

<body>
    <nav>
        <div class="logo">
            <h4>Logo</h4>
        </div>
        <ul class="nav-links">
            <li>
                <a href="#">Home</a>
            </li>
            <li>
                <a href="#">About</a>
            </li>
            <li>
                <a href="#">Work</a>
            </li>
            <li>
                <a href="#">Project</a>
            </li>
        </ul>
        <div class="burger">
            <div class="line1"></div>
            <div class="line2"></div>
            <div class="line3"></div>
        </div>
    </nav>
    <div class="container">
        <?= $content ?>
    </div>
    <script type="text/javascript" src="./Tools/js/main.js">

    </script>
</body>

</html>