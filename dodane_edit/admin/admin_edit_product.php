<?php
session_start();

include('admin_check_userType.php');

include('../server/connection.php');

$errors = [];

// Sprawdzenie, czy parametr 'id' został przekazany w adresie URL
if (isset($_GET['id'])) {
    // Pobranie wartości 'id' i przypisanie ich do zmiennej
    $productId = $_GET['id'];

    // Sprawdzenie, czy formularz został przesłany
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Pobranie wartości pól z formularza
        $productName = $_POST['product_name'];
        $category = $_POST['product_category'];
        $description = $_POST['product_description'];
        $price = $_POST['product_price'];
        $color = $_POST['product_color'];
        $image = $_POST['product_image'];
        // Aktualizacja produktu w bazie danych
        $query = $db->prepare("UPDATE products SET product_name = ?, product_category = ?, product_description = ?, product_price = ?, product_color = ?, product_image = ? WHERE product_id = ?");
        $query->bind_param("sssdssi", $productName, $category, $description, $price, $color, $image ,$productId);
        $query->execute();
        $query->close();

        // Przekierowanie na inną stronę po zakończeniu aktualizacji
        header('Location: admin_edit_product.php');
        exit;
				}

}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sklep meblowy</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/line-awesome.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/admin_panel.css">

</head>

<?php include('../layouts/sidebar.php'); ?>
<div class="col py-3">
    <table>
        <thead>
        <tr class="table-header">
            <th>Nazwa Produktu</th>
            <th>Kategoria Produktu</th>
            <th>Opis Produktu</th>
            <th>Obraz Produktu</th>
            <th>Cena Produktu</th>
            <th>Kolor Produktu</th>
            <th>Akcja</th>
        </tr>
        </thead>
        <tbody>
        <?php
        // Pobierz produkty z bazy danych
        $query = $db->query("SELECT * FROM products");
        while ($row = $query->fetch_assoc()) {
            $productID = $row['product_id'];
            $productName = $row['product_name'];
            $productCategory = $row['product_category'];
            $productDescription = $row['product_description'];
            $productImage = $row['product_image'];
            $productPrice = $row['product_price'];
            $productColor = $row['product_color'];
            ?>
            <tr>
                <td>
                    <?php echo $productName; ?>
                </td>
                <td>
                    <?php echo $productCategory; ?>
                </td>
                <td>
                    <?php echo $productDescription; ?>
                </td>
                <td>
                    <?php
                    $imagePath = '../assets/images/' . basename($productImage);
                    if (!file_exists($imagePath)) {
                        copy($productImage, $imagePath);
                    }
                    ?>
                    <img src="<?php echo $imagePath; ?>" alt="<?php echo $productName; ?>" width="100">
                </td>

                <td>
                    <?php echo $productPrice; ?>
                </td>
                <td>
                    <?php echo $productColor; ?>
                </td>
                <td>
                    <a href="admin_edit_product.php?id=<?php echo $productID; ?>">Edytuj</a>
                </td>
            </tr>
						<?php
				}
				?>
        </tbody>
    </table>
    //formularz  do edycji informacji o produkcie
    <div class="col py-3">
        <form method="POST" action="" enctype="multipart/form-data">
            <label for="product_name">Nazwa produktu:</label>
            <input type="text" name="product_name" id="product_name" required><br>

            <label for="product_category">Kategoria:</label>
            <input type="text" name="product_category" id="product_category" required><br>

            <label for="product_description">Opis:</label>
            <textarea name="product_description" id="product_description" required></textarea><br>

            <label for="product_price">Cena:</label>
            <input type="number" name="product_price" id="product_price" step="0.01" required><br>

            <label for="product_color">Kolor:</label>
            <input type="text" name="product_color" id="product_color" required><br>

            <label for="product_image">Zdjęcie:</label>
            <input type="file" name="product_image" id="product_image" accept="image/*"><br>

            <label for="submit"></label>
            <input type="submit" value="Zapisz zmiany">
        </form>
    </div>
</div>

<?php include('../layouts/admin_footer.php') ?>