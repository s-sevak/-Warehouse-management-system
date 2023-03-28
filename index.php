<?php
require_once('connect_database.php');

if (isset($_POST['submit'])) {
    $selected_date = $_POST['selected_date'];

    if (strtotime($selected_date) === false) {
        $error_message = 'Неверный формат даты';
    } else {

        $stmt = $pdo->prepare("SELECT s.quantity AS ostatok, ROUND(s.cost * 1.3, 2) AS price 
                           FROM supplies s 
                           WHERE s.date <= :selected_date 
                           ORDER BY s.date DESC 
                           LIMIT 1");
        $stmt->bindValue(':selected_date', $selected_date);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            $error_message = 'Информация для выбранной даты не найдена';
        } else {

            $ostatok = $row['ostatok'];
            $price = $row['price'];
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Система управления складом</title>
    <!-- Подключение Bootstrap 5 через CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css"
          integrity="sha512-8pGv7zA31tTKABJtOWtnsdnF+1XfuPO4Zp3G4sWlT8/AH45IhRyJQOmExgItn0eL+X9Gx76xq3i4Pz8bovM+lg=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
</head>
<body class="text-center">
<div class="mx-auto" style="max-width: 600px;">
    <h1>Система управления складом</h1>

    <?php if (isset($error_message)): ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>

    <form method="post">
        <label for="selected_date">Выберите дату:</label>
        <input type="date" id="selected_date" name="selected_date" required>
        <button type="submit" name="submit">Применить</button>
    </form>

    <?php if (isset($ostatok)): ?>
        <h2>Остаток на складе: <?php echo $ostatok; ?> шт.</h2>
        <h2>Текущая цена: <?php echo $price; ?> руб.</h2>
    <?php endif; ?>
</div>
</body>
</html>