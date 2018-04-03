<script>
function modalfunc(bookid, booktitle) {
    var data = {
        "bookid": bookid,
        "booktitle": booktitle
    };
    jQuery.ajax({
        url: <?= BASEURL ?> + 'checkout.php',
        method: "post",
        data: data,
        success: function(data){
            console.log("Success!");
            jQuery('body').append(data);
            jQuery('#checkout').modal('toggle');
        },
        error: function(){
            alert("Something went wrong!");
        }
    });
}
</script>