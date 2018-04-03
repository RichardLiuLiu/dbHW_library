<?php require_once './includes/init.php'; ?>

<!DOCTYPE html>
<html lang="en">
<?php include './includes/head.php'; ?>

<body>
    <?php include './includes/navbar.php'; ?>

    <?php
    $keyword = $_POST['keyword'];
    if (empty($keyword)) {
        $sql = "SELECT * FROM Book";
    } else {
        $sql = "SELECT *
                FROM Book
                WHERE booktitle LIKE '%".$keyword."%' OR category LIKE '%".$keyword."%'";
    }
    $query = $db->query($sql); ?>

    <div class="container">
        <h2 class="result-title">Available Books</h2>
        <div class="list-group">
            <?php                
            while ($book = mysqli_fetch_assoc($query)):
                $sql1 = "SELECT COUNT(*) AS cnt1
                         FROM BookCopy
                         WHERE bookid = '".$book['bookid']."'";
                $sql2 = "SELECT COUNT(*) AS cnt2
                         FROM BookCopy NATURAL JOIN CheckedOut
                         WHERE status <> 'Returned' AND bookid = '".$book['bookid']."'";
                $cnt1 = mysqli_fetch_assoc($db->query($sql1));
                $cnt2 = mysqli_fetch_assoc($db->query($sql2));
                if ($cnt1['cnt1'] > $cnt2['cnt2']): ?>
                    <a class="list-group-item">
                        <span class="booklist-id" name="bookid">
                            <?= $book['bookid']; ?>
                        </span>
                        <strong class="booklist-title">
                            <?= $book['booktitle']; ?>
                        </strong>
                        <span class="booklist-copyleft">
                            <?= $cnt1['cnt1'] - $cnt2['cnt2']; ?> Left
                        </span>
                        <button type="button" class="btn btn-info btn-sm" style="float:right"
                                onclick="modalfunc('<?= $book['bookid']; ?>', '<?= $book['booktitle']; ?>')">
                            Checkout
                        </button>
                    </a>
                <?php
                endif;
            endwhile; ?>
        </div>
        <a style="float:right; padding-top:0.6em;" href=<?= BASEURL ?>>
            <button type="button" class="btn btn-default">Back</button>
        </a>
    </div>
    
    <?php include './includes/modalfunc.php'; ?>
</body>
</html>