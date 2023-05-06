
$("#selectLeather").on("click", function () {
    let selectedLeatherNo =  $('#select_leather_no').val();
    $.ajax({
        type: "POST",
        data:{
            leather_no : selectedLeatherNo
        },
        url: "ajax/fetch_leather.php",
        success: function (data) {
            $("#leatherTable").html(data)
            // console.log(selectedLeatherNo)
        }
    });
});