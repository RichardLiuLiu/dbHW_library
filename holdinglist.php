<?php require_once './includes/init.php'; ?>

<!DOCTYPE html>
<html lang="en">
<?php include './includes/head.php'; ?>

<body>
    <?php include './includes/navbar.php'; ?>

    <?php
    $mid = 'M'.$_POST['mid'];
    // $mname = $_POST['mname'];
    $copyid = $_POST['copyid'];

    // Check if mid exists.
    $sql1 = "SELECT mname FROM Member WHERE mid = '".$mid."'";
    $mname = mysqli_fetch_assoc($db->query($sql1))['mname'];

    // Double check if the copy already checked out.
    $sql2 = "SELECT COUNT(*) AS copycnt
             FROM CheckedOut
             WHERE copyid='".$copyid."' AND status <> 'Returned'";
    $copycnt = mysqli_fetch_assoc($db->query($sql2))['copycnt'];

    if ($mname == null) {
        echo '<p style="text-align: center">Error: member not exists!</p>';
    } else if ($copycnt > 0) {
        echo '<p style="text-align: center">Error: copy already checked out!</p>';
    } else {
        // Add new record to `CheckedOut` table.
        $sql3 = "INSERT INTO CheckedOut
                Values ('".$copyid."', '".$mid."', NOW(), DATE_ADD(NOW(), INTERVAL 3 MONTH), 'Holding')";
        if ($db->query($sql3)) {
            echo '<p style="text-align: center">'.$copyid.' checked out!</p>';
        } else {
            echo '<p style="text-align: center">'.$copyid.' failed to checkout!</p>';
        }
    }
    
    // Find all books this member is holding.
    $sql4 = "SELECT *
             FROM CheckedOut NATURAL JOIN BookCopy NATURAL JOIN Book
             WHERE mid = '".$mid."' AND status <> 'Returned'";
    $query = $db->query($sql4); ?>

    <div class="container">
        <h6 class="bookholding-title">Dear <?= $mname ?>, here are the books you are holding:</h6>
        <div class="list-group">
            <?php while ($bookholding = mysqli_fetch_assoc($query)): ?>
                <a class="list-group-item">
                    <span class="booklist-id">
                        <?= $bookholding['copyid']; ?>
                    </span>
                    <strong class="booklist-title">
                        <?= $bookholding['booktitle']; ?>
                    </strong>
                    <?php if ($bookholding['status'] == 'Holding'): ?>
                        <span class="status-holding rounded">
                            <?= $bookholding['status']; ?>
                        </span>
                    <?php else: ?>
                        <span class="status-overdue rounded">
                            <?= $bookholding['status']; ?>
                        </span>
                    <?php endif; ?>
                </a>
            <?php endwhile; ?>
        </div>
        <a style="float:right; padding-top:0.6em;" href="/library">
            <button type="button" class="btn btn-default">Back</button>
        </a>
    </div>

</body>
</html>