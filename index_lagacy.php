<?php require_once './includes/init.php'; ?>

<!DOCTYPE html>
<html lang="en">
<?php include './includes/head.php'; ?>

<body>
    <?php include './includes/navbar.php'; ?>
    
    <div class="container">
        <div class="list-group">           
            <?php
            $sql = "SELECT * FROM Book";
            $query = $db -> query($sql);
            while ($book = mysqli_fetch_assoc($query)):
                $sql1 = "SELECT COUNT(*) AS cnt1
                         FROM BookCopy
                         WHERE bookid = '".$book['bookid']."'";
                $sql2 = "SELECT COUNT(*) AS cnt2
                         FROM BookCopy NATURAL JOIN CheckedOut
                         WHERE status <> 'Returned' AND bookid = '".$book['bookid']."'";
                $cnt1 = mysqli_fetch_assoc($db->query($sql1));
                $cnt2 = mysqli_fetch_assoc($db->query($sql2));
                $copyleft = $cnt1['cnt1'] - $cnt2['cnt2'];

                if ($copyleft <= 0): ?>
                    <a class="list-group-item">
                        <span class="booklist-id">
                            <?= $book['bookid']; ?>
                        </span>
                        <strong class="booklist-title">
                            <?= $book['booktitle']; ?>
                        </strong>
                        <span class="booklist-nocopyleft">
                            0 Left
                        </span>
                    </a>
                <?php
                else: ?>
                    <a class="list-group-item">
                        <span class="booklist-id">
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
    </div>
    
    <?php include './includes/modalfunc.php'; ?>
</body>
</html>