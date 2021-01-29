<?php
/**
 *
 * @Project: News sys
 * @Author HybridMind <www.webocean.info>
 * @Version: 0.0.1
 * @File index.php
 * @Created 29.1.2021 г.
 * @License: MIT
 * @Discord: HybridMind#6095
 *
 */
include("./includes/config.php");
include("./includes/phpBB.php");
$getnews = mysqli_query($conn, "SELECT * FROM news ORDER BY id DESC");

if ($getnews->num_rows > 0) {
    while ($row = mysqli_fetch_assoc($getnews)) { ?>
      Заглавие: <?php echo $row['title']; ?><br/>
        <?php echo $row['text']; ?><br/>
        Автор: <?php echo $row['author']; ?> публикувана на <?php echo date("d.m.Y", $row['date']); ?>
        <hr />
    <?php }
} else {
    echo "Няма добавени новини";
}