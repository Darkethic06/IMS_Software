
$("#selectLeather").on("click", function () {
    let selectedLeatherNo =  $('#select_leather_no').val();
    $.ajax({
        type: "POST",
        data:{
            leather_no : selectedLeatherNo
        },
        url: "ajax/fetch_leather.php",
        success: function (data) {
            let jsonData = JSON.parse(data)
            $("#leather_no").val(jsonData.Item_No);
            $("#leather_name").val(jsonData.Item_Name);
            $("#leather_uom").val(jsonData.UOM);
            $("#leather_rate").val(jsonData.Rate);
        }
    });
});





function selectItem(sectionId){
   let selectedItem = $(`#select_item${sectionId}`).val()
   $.ajax({
    type: "POST",
    data:{
        item_no : selectedItem
    },
    url: "ajax/fetch_item.php",
    success: function (data) {
        let jsonData = JSON.parse(data)
        $(`#itemNo${sectionId}`).val(jsonData.Item_No);
        $(`#itemName${sectionId}`).val(jsonData.Item_Name);
        $(`#itemUom${sectionId}`).val(jsonData.UOM);
        $(`#itemRate${sectionId}`).val(jsonData.Rate);
    }
});
}

// 


$("#selectBuyerBtn").on("click", function () {
    let selectBuyer =  $('#selectBuyer').val();
    $.ajax({
        type: "POST",
        data:{
            selectBuyerId : selectedLeatherNo
        },
        url: "ajax/fetch_leather.php",
        success: function (data) {
            let jsonData = JSON.parse(data)
            $("#leather_no").val(jsonData.Item_No);
            $("#leather_name").val(jsonData.Item_Name);
            $("#leather_uom").val(jsonData.UOM);
            $("#leather_rate").val(jsonData.Rate);
        }
    });

    console.log(selectBuyer)
});