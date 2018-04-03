<?php require_once './includes/init.php'; ?>

<?php
$bookid = $_POST['bookid'];
$booktitle = $_POST['booktitle'];

$sql1 = "SELECT MIN(copyid) AS mincopyid
         FROM BookCopy
         WHERE bookid = '".$bookid."' AND copyid NOT IN (
             SELECT copyid FROM CheckedOut WHERE status <> 'Returned')";
$copyid = mysqli_fetch_assoc($db->query($sql1))['mincopyid'];
?>

<?php ob_start(); ?>

<div id="checkout" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">

    <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" id="title">
                <p class="modal-bookid"><?= $bookid ?></p>
                <strong class="modal-booktitle"><?= $booktitle ?></strong>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                <form class="form-inline my-2 my-lg-0" action="holdinglist.php" method="post">
                    <div class="form-group">
                        <strong style="padding-right:0.5em">M</strong>
                        <input class="form-control" type="hidden" name="copyid" value="<?php echo $copyid?>" readonly>
                        <input class="form-control" type="text" name="mid" placeholder="MemberID (without 'M')">
                        <!-- <input class="form-control" type="text" name="mname" placeholder="Name"> -->
                        <button class="btn btn-info btn-md" type="submit">Confirm</button>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

<?php echo ob_get_clean(); ?>
