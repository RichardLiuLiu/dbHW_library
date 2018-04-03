<nav class="navbar navbar-expand-lg navbar-fixed-top navbar-dark bg-dark">
    <a class="navbar-brand" href=<?= BASEURL ?>>Yicong's Library</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <form class="form-inline my-2 my-lg-0" action="booklist.php" method="post">
            <div class="form-group">
                <input class="form-control" type="text" name="keyword" placeholder="Please enter keyword" aria-label="Search">
                <button class="btn btn-default" type="submit">Search</button>
            </div>
        </form>
    </div>
</nav>