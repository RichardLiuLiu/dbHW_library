<?php require_once './includes/init.php'; ?>

<!DOCTYPE html>
<html lang="en">
<?php include './includes/head.php'; ?>

<body>
    <?php include './includes/navbar.php'; ?>

    <div class="container">
        <h3 class="result-title">All Books</h3>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                    <th scope="col">Category</th>
                    <th scope="col">Author</th>
                    <th scope="col">Publish Date</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch info of all books.
                $sql = "SELECT * FROM Book";
                $query = $db -> query($sql);          
                while ($book = mysqli_fetch_assoc($query)):
                    // Count the number of all copies.
                    $sql1 = "SELECT COUNT(*) AS cnt1
                            FROM BookCopy
                            WHERE bookid = '".$book['bookid']."'";
                    // Count the number of copies that are still holding.
                    $sql2 = "SELECT COUNT(*) AS cnt2
                            FROM BookCopy NATURAL JOIN CheckedOut
                            WHERE status <> 'Returned' AND bookid = '".$book['bookid']."'";
                    $cnt1 = mysqli_fetch_assoc($db->query($sql1));
                    $cnt2 = mysqli_fetch_assoc($db->query($sql2));
                    $flag = false;
                    if ($cnt1['cnt1'] > $cnt2['cnt2']) {
                        $flag = true;
                    } ?>
                    <tr>
                        <th scope="row"><?= $book['bookid']; ?></th>
                        <td><?= $book['booktitle']; ?></td>
                        <td><?= $book['category']; ?></td>
                        <td><?= $book['author']; ?></td>
                        <td><?= $book['publishdate']; ?></td>
                        <td>
                            <?php if ($flag): ?>
                                <span class="booklist-copyleft rounded">
                                    <?= $cnt1['cnt1'] - $cnt2['cnt2']; ?> Left
                                </span>
                            <?php else: ?>
                                <span class="booklist-nocopyleft rounded">
                                    0 Left
                                </span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($flag): ?>
                                <button type="button" class="btn btn-info btn-sm" style="float:right"
                                        onclick="modalfunc('<?= $book['bookid']; ?>', '<?= $book['booktitle']; ?>')">
                                    Checkout
                                </button>
                            <?php endif; ?>
                        </td>
                    </tr>                        
                    <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    
    <?php include './includes/modalfunc.php'; ?>
</body>
</html>