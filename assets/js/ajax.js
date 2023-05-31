
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
            $("#leather_hsn").val(jsonData.Hsn_Code);
            $("#leather_uom").val(jsonData.UOM);
            $("#leather_rate").val(jsonData.Rate);
            // console.log(jsonData.Item_No);
        }
    });
});

// {"item_id":"35","item_type":"Leather","Item_No":"1001000108","Item_Name":"Leather","Hsn_Code":"","Qnt":"2.2980","UOM":"SQFT","Rate":"65","Amount":"149.37","Specs":""}




// $("#selectLeather").on("click", function () {
//     let selectedLeatherNo =  $('#select_leather_no').val();
//     $.ajax({
//         type: "POST",
//         data:{
//             leather_no : selectedLeatherNo
//         },
//         url: "ajax/fetch_leather.php",
//         success: function (data) {
//             let jsonData = JSON.parse(data)
//             $("#leather_no").val(jsonData.Item_No);
//             $("#leather_name").val(jsonData.Item_Name);
//             $("#leather_hsn").val(jsonData.Hsn_Code);
//             $("#leather_uom").val(jsonData.UOM);
//             $("#leather_rate").val(jsonData.Rate);
//             // console.log(jsonData.Item_No);
//         }
//     });
// });

function selectItem(sectionId){
   let selectedItem = $("#select_item").val()
   
}