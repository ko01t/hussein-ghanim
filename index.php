<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_movie'])) {
    $name = $_POST['name'];
    $release_year = $_POST['release_year'];
    $description = $_POST['description'];
    $type = $_POST['type'];
    $rating = $_POST['rating'];

    $sql = "INSERT INTO movies (name, release_year, description, type, rating) 
            VALUES ('$name', $release_year, '$description', '$type', $rating)";
    
    if ($conn->query($sql) === TRUE) {
        echo "تمت إضافة الفيلم بنجاح!";
    } else {
        echo "خطأ: " . $conn->error;
    }
}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_movie'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $release_year = $_POST['release_year'];
    $description = $_POST['description'];
    $type = $_POST['type'];
    $rating = $_POST['rating'];

    $sql = "UPDATE movies SET 
            name = '$name', 
            release_year = $release_year, 
            description = '$description', 
            type = '$type', 
            rating = $rating 
            WHERE id = $id";

    $conn->query($sql);
    header('Location: index.php');
}


if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM movies WHERE id = $id";
    $conn->query($sql);
    header('Location: index.php');
}


$result = $conn->query("SELECT * FROM movies");
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>نظام سينما</title>
    <link rel="stylesheet" href="stylesss.css">
</head>
<body>
    <h1>نظام ادارة المسلسلات الافلام</h1>
    <form method="POST" action="">
        <input type="hidden" name="add_movie" value="1">
        <input type="text" name="name" placeholder="اسم الفلم" required>
        <input type="number" name="release_year" placeholder="سنة الاصدار" required>
        <input type="text" name="description" placeholder="الوصف" required>
        <input type="text" name="type" placeholder="النوع" required>
        <input type="number"  name="rating" placeholder="التقييم (من 10)" required>
        <button type="submit">إضافة فيلم</button>
    </form > 
</form>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>الاسم</th>
                <th>سنة الإصدار</th>
                <th>الوصف</th>
                <th>النوع</th>
                <th>التقييم</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>     
<?php while ($row = $result->fetch_assoc()): ?>
     <tr>
         <td><?php echo $row['id']; ?></td>
         <td><?php echo $row['name']; ?></td>
         <td><?php echo $row['release_year']; ?></td>
         <td><?php echo $row['description']; ?></td>
         <td><?php echo $row['type']; ?></td>
         <td><?php echo $row['rating']; ?></td>
         <td>
     <a href="index.php?edit=<?php echo $row['id']; ?>" class="edit-link">✏️</a>
     <a href="index.php?delete=<?php echo $row['id']; ?>" class="delete-link">❌</a>
         </td>
    </tr>
<?php endwhile; ?>
 </tbody>
 </table>

<?php if (isset($_GET['edit'])): 
        $id = $_GET['edit'];
        $movie = $conn->query("SELECT * FROM movies WHERE id = $id")->fetch_assoc();
    ?>
    <h2>تعديل الفيلم</h2>
    <form method="POST" action="">
        <input type="hidden" name="update_movie" value="1">
        <input type="hidden" name="id" value="<?php echo $movie['id']; ?>">
        <input type="text" name="name" value="<?php echo $movie['name']; ?>" required>
        <input type="number" name="release_year" value="<?php echo $movie['release_year']; ?>" required>
        <input type="text" name="description" value="<?php echo $movie['description']; ?>" required>
        <input type="text" name="type" value="<?php echo $movie['type']; ?>" required>
        <input type="number"  name="rating" value="<?php echo $movie['rating']; ?>" required>
        <button type="submit">حفظ التعديلات</button>
    </form>
    <?php endif; ?>
</body>
</html>
