<?php
//pobieranie danych z bazy na podstawie parametru product_id
include('server/connection.php');

if (isset($_GET['product_id'])) {
//Funkcja bind_param  służy do bezpiecznego powiązania wartości parametrów zapytania SQL
    $product_id = $_GET['product_id'];
    //Funkcja prepare w PHP służy do analizowania i kompilowania zapytania SQL, tworząc przygotowane wyrażenie, które może być później wykorzystane do bezpiecznego wykonywania zapytań, oddzielając zapytanie od danych.
    $statement = $db->prepare("SELECT * FROM products WHERE product_id = ?");
    $statement->bind_param("i", $product_id);
    $statement->bind_param("i", $product_id);
// wykonuje przygotowane wyrażenie SQL, wysyłając zapytanie do bazy danych i zwracając wynik, jeśli istnieje.
    $statement->execute();
//pobiera wyniki zapytania wykonanego przy użyciu przygotowanego wyrażenia i zwraca te wyniki w postaci obiektu
    $product = $statement->get_result();





} else {
    // header('location: index.php');
}
?>





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sklep meblowy</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/line-awesome.min.css">
    <link rel="stylesheet" href="assets/css/style.css">

</head>

<body>

    <nav class="navbar navbar-expand-sm navbar-light navbar-style">
        <div class="container-fluid nav-container">
            <a class="navbar-brand" href="index.html">Logo</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarID"
                aria-controls="navbarID" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarID" style="flex-grow: 0;">
                <div class="navbar-nav navbar-functions">
                    <a class="nav-link active" aria-current="page" href="#">
                        Kategorie
                    </a>
                    <a class="nav-link active userFunctions" aria-current="page" href="/login.html">
                        <i class="las la-user"></i>
                        Zaloguj się
                    </a>
                    <a class="nav-link active userFunctions" aria-current="page" href="#">
                        <i class="lar la-heart"></i>
                        Ulubione
                    </a>
                    <a class="nav-link active userFunctions" aria-current="page" href="#">
                        <i class="las la-shopping-cart"></i>
                        Koszyk
                    </a>

                </div>
            </div>
        </div>
    </nav>



    <section id="product-main" class="main" style="min-height: 1200px; margin-top: 200px; position: relative;">

        <div class="container">
            <?php while ($row = $product->fetch_assoc()) { ?>


                <div class="row essa">


                    <div class="product-gallery1">
                        <div class="product-main">
                            <img src="assets/images/<?php echo $row['product_image']; ?>" alt="">
                        </div>
                        <div class="product-mini">
                            <img src="assets/images/<?php echo $row['product_image']; ?>" alt="">
                            <img src="assets/images/<?php echo $row['product_image2']; ?>" alt="">
                            <img src="assets/images/<?php echo $row['product_image3']; ?>" alt="">
                            <img src="assets/images/<?php echo $row['product_image4']; ?>" alt="">
                        </div>
                    </div>

                    <div class="product-infos">
                        <h1>
                            <?php echo $row['product_name']; ?>
                        </h1>
                        <span class="product-id">ID:
                            <?php echo $row['product_id']; ?>
                        </span>

                        <div class="product-price">
                            <?php echo $row['product_price']; ?> zł
                        </div>

                        <div class="product-color">
                                <span>Wybierz kolor: </span>
                                <div class="select" tabindex="1">
                                    <input class="selectopt" name="test" type="radio" id="opt1" checked>
                                    <label for="opt1" class="option">Czarny</label>
                                    <input class="selectopt" name="test" type="radio" id="opt2">
                                    <label for="opt2" class="option">Niebieski</label>
                                    <input class="selectopt" name="test" type="radio" id="opt3">
                                    <label for="opt3" class="option">Brązowy</label>
                                    <input class="selectopt" name="test" type="radio" id="opt4">
                                    <label for="opt4" class="option">Szary</label>
                                    <input class="selectopt" name="test" type="radio" id="opt5">
                                    <label for="opt5" class="option">Zielony</label>
                                </div>
                            </div>
                        <form method="POST" action="cart.php">
                            <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>"/>
                            <input type="hidden" name="product_image" value="<?php echo $row['product_image']; ?>" />
                            <input type="hidden" name="product_name" value="<?php echo $row['product_name']; ?>" />
                            <input type="hidden" name="product_price" value="<?php echo $row['product_price']; ?>" />

                            <div class="product-number">
                                <span>Ilość: </span>
                                <input type="number" name="product_quantity" value="1"/>
                            </div>
                            <button class="add-btn" type="submit" name="add-to-cart">Dodaj do koszyka</button>
                        </form>
                            <button id="favbtn" class="favorite-btn" onclick="changeFun()">
                                <i id="heart" class="lar la-heart"></i>
                                Dodaj do listy ulubionych
                            </button>
                            <div class="delivery-info">
                                <i class="las la-truck"></i>
                                <div class="delivery-info2">
                                    <span class="deliv-h">Produkt dostępny online <div class="dot"></div></span>
                                    <span>Dostawa w ciągu 2-5 dni roboczych</span>
                                </div>
                            </div>
                    </div>
                </div>


                <div class="desc">
                    <div class="product-desc">
                        <span class="headings">Opis</span>
                        <div class="product-line"></div>
                        <p>
                            <?php echo $row['product_description']; ?>
                        </p>
                    </div>
                    
                <?php } ?>

                <div class="product-delivery">
                    <span class="headings">Sposób dosostawy</span>
                    <div class="product-line"></div>
                    <div class="deliv-banner"></div>
                    <p>Zamawiając towar w naszym sklepie internetowym mogą Państwo skorzystać z kilku dostępnych
                        sposobów dostawy. Od lat współpracujemy z firmami specjalizującymi się z transporcie
                        międzynarodowym, takimi jak: DHL, UPS czy GLS.</p>
                    <strong class="mini-heading">Sposób płatności</strong>
                    <p>W naszym sklepie oferujemy ci dwa sposoby zapłacenia - przy odbiorze własnym oraz online.</p>
                    <p><strong>Przy odbiorze własnym - </strong>przy odbiorze w naszym magazynie. Możliwa jest płatność
                        gotówką lub kartą płatniczą</p>
                    <p><strong>Płatność online - </strong> zapłać wygodnie blikiem, kartą płatniczą lub zrób przelew na
                        nasz rachunek, który zostanie ci wysłany mailem. W razie problemów z płatnością online możesz
                        skontaktować się z naszym help center</p>
                    <div class="payment-banners" style="width: 100%;">
                        <img src="assets/images/blik.png" alt="">
                        <img src="assets/images/visa-mastercard.jpg" alt="">
                        <img src="assets/images/przelewy.png" alt="">
                    </div>
                </div>
            </div>
        </div>




    </section>


    <div class="newsletter-container">
        <h4>Zapisz się do newslettera!</h4>
        <div class="">
            <div class="newsletter-form">
                <input class="sub-form" type="text" placeholder="Podaj swój email">
                <button class="subscribe-btn">Zasubskrybuj</button>
            </div>

        </div>
    </div>
    <div class="faq-container"></div>

    <script src="assets/js/main.js"></script>
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>