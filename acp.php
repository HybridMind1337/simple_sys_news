<?php
/**
 *
 * @Project: News sys
 * @Author HybridMind <www.webocean.info>
 * @Version: 0.0.1
 * @File acp.php
 * @Created 29.1.2021 г.
 * @License: MIT
 * @Discord: HybridMind#6095
 *
 */
include("./includes/config.php");
include("./includes/phpBB.php");
include("./includes/funcs.php");

$getNews = mysqli_query($conn, "SELECT * FROM news ORDER BY id DESC"); // Взимаме всички новини

if (!$bb_is_admin) {
    header("Location: ../index.php");
}

// Функция за добавяне на новината
if (isset($_POST['add'])) {

    if (empty($_POST['author'])) {
        message("acp.php?action=adding", "danger", "Моля, посочете автор на новината");
    } elseif (empty($_POST['title'])) {
        message("acp.php?action=adding", "danger", "Моля, посочете заглавието на новината");
    } elseif (empty($_POST['message'])) {
        message("acp.php?action=adding", "danger", "Моля, напишете съобщението.");
    }

    $author = mysqli_real_escape_string($conn, $_POST['author']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $message = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['message']));
    $date = time();

    mysqli_query($conn, "INSERT INTO news (`title`, `author`, `date`, `text`) VALUES ('$title','$author','$date','$message')");
    message("acp.php", "success", "Успешно добавена новина");
}

// Функция за изтриване на новината
if (isset($_GET['remove'])) {

    if (empty($_GET['remove'])) {
        message("acp.php", "danger", "Нещо се обърка при опита за премахване, моля опитай отново.");
    } elseif (!is_numeric($_GET['remove'])) {
        message("acp.php", "danger", "Нещо се обърка при опита за премахване, моля опитай отново.");
    }
    $id = (int)$_GET['remove'];
    mysqli_query($conn, "DELETE FROM news WHERE id = " . $id);

    message("acp.php", "success", "Новината е успешно изтрита");
}

// Нужни неще за редактирането на новината
$id = (int)$_GET['id'];
$editNews = mysqli_query($conn, "SELECT * FROM news WHERE id =" . $id);
$new = mysqli_fetch_assoc($editNews);
if (isset($_POST['edit'])) {

    $author = mysqli_real_escape_string($conn, $_POST['author']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $message = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['message']));

    mysqli_query($conn, "UPDATE news SET title='$title',author='$author',text='$message' WHERE id =" . $id);
    message("acp.php", "success", "Успешно променана новина");
}

echo showMessage();
if (isset($_GET['add'])) { ?>
    <form method="POST">
        <input type="text" name="author" placeholder="Автор" value="<?php echo $bb_username; ?>"><br/>
        <input type="text" name="title" placeholder="Заглавие на новината"><br/>
        <textarea name="message"></textarea><br/>
        <button type="submit" name="add">Добави</button>
    </form>
<?php } elseif (isset($_GET['edit']) && is_numeric($_GET['id'])) { ?>
    <form method="POST">
        <input type="text" name="author" placeholder="Автор" value="<?php echo $new['author']; ?>"><br/>
        <input type="text" name="title" placeholder="Заглавие на новината" value="<?php echo $new['title']; ?>"><br/>
        <textarea name="message"><?php echo $new['text']; ?></textarea><br/>
        <button type="submit" name="edit">Добави</button>
    </form>
<?php } else {
    echo '<a href="acp.php?add">Добави новина</a><br />';
    if ($getNews->num_rows > 0) {
        while ($row = mysqli_fetch_assoc($getNews)) { ?>
            Заглавие: <?php echo $row['title']; ?>, добавена на <?php echo date("d.m.Y", $row['date']); ?> <a href="acp.php?edit&id=<?php echo $row['id']; ?>">Редактирай</a> <a href="acp.php?remove=<?php echo $row['id']; ?>">Изтрий</a><br/>
            <?php
        }
    } else {
        echo 'Няма добавено новини';
    }
}

sessionRemove("notifications");