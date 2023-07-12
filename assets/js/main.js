/*==================== SHOW NAVBAR ====================*/
const showMenu = (headerToggle, navbarId) => {
  const toggleBtn = document.getElementById(headerToggle),
    nav = document.getElementById(navbarId)

  // Validate that variables exist
  if (headerToggle && navbarId) {
    toggleBtn.addEventListener('click', () => {
      // We add the show-menu class to the div tag with the nav__menu class
      nav.classList.toggle('show-menu')
      // change icon
      toggleBtn.classList.toggle('bx-x')
    })
  }
}
showMenu('header-toggle', 'navbar')

/*==================== LINK ACTIVE ====================*/
const linkColor = document.querySelectorAll('.nav__link')

function colorLink() {
  linkColor.forEach(l => l.classList.remove('active'))
  this.classList.add('active')
}

linkColor.forEach(l => l.addEventListener('click', colorLink))



// -----------------Calculating leather part

let leather_part = document.getElementById("leather_part")

leather_part.addEventListener('keyup', function () {
  let length = document.getElementById('leather_length').value
  let width = document.getElementById('leather_width').value
  let part = this.value
  let leather_total = length * width * part
  document.getElementById('leather_total').value = leather_total.toFixed(2)
})

// let leather_wastage = document.getElementById("leather_wastage")

// leather_wastage.addEventListener('keyup', function () {
//   let total = document.getElementById('leather_total').value
//   total_wastage = (total * this.value) / 100
//   final_total = total - total_wastage
//   document.getElementById("final_leather").value = final_total
// })


let selectLeatherBtn = document.getElementById("selectLeatherBtn")

selectLeatherBtn.addEventListener('click', function () {
  let final_leatherqty = document.getElementById("leather_total").value
  document.getElementById("leather_qty").value = final_leatherqty
  let rate = document.getElementById('leather_rate').value
  let Amount = final_leatherqty * rate
  document.getElementById('leather_amount').value = Amount.toFixed(2)
})

// -------------Calculating Items------------

function calculateItem(itemQtyId) {
  let itemLength = document.getElementById(`item_length${itemQtyId}`).value
  let itemWidth = document.getElementById(`item_width${itemQtyId}`).value
  let itemQty = document.getElementById(`item_qty${itemQtyId}`).value
  let totalQTY = (itemLength * itemWidth) * itemQty
  document.getElementById(`item_total${itemQtyId}`).value = totalQTY.toFixed(4)
  // console.log(itemQty)
}
function calculateItemP(itemQtyId) {
  let itemQtyp = document.getElementById(`item_qtyp${itemQtyId}`).value
  document.getElementById(`item_totalp${itemQtyId}`).value = itemQtyp
  // console.log(itemQtyp)
}
// function calculateWastage(itemWastageId) {
//   let itemTotal = document.getElementById(`item_total${itemWastageId}`).value
//   let wastagePercen = document.getElementById(`item_wastage${itemWastageId}`).value
//   totalItemWastage = (itemTotal * wastagePercen) / 100
//   final_total = itemTotal - totalItemWastage
//   document.getElementById(`final_qty${itemWastageId}`).value = final_total
// }


function getItemQty(itemSectionId) {
  let finalItemQty = document.getElementById(`item_total${itemSectionId}`).value
  document.getElementById(`itemQty${itemSectionId}`).value = finalItemQty
  let rate = document.getElementById(`itemRate${itemSectionId}`).value
  let Amount = finalItemQty * rate
  document.getElementById(`itemAmount${itemSectionId}`).value = Amount.toFixed(2)
}



function getItemQtyP(itemSectionId) {
  let finalItemQtyp = document.getElementById(`item_totalp${itemSectionId}`).value
  console.log(finalItemQtyp)
  document.getElementById(`itemQty${itemSectionId}`).value = finalItemQtyp
  let ratep = document.getElementById(`itemRate${itemSectionId}`).value
  let Amountp = finalItemQtyp * ratep
  document.getElementById(`itemAmount${itemSectionId}`).value = Amountp.toFixed(2)
}

// ----------------------------------------------------Calculating 20 Item Cost

let primeCostCalcBtn = document.getElementById("primeCostCalcBtn")

primeCostCalcBtn.addEventListener("click", (e) => {
  e.preventDefault();
  let sum = 0;
  for (let i = 1; i <= 20; i++) {
    let itemAmount = parseFloat(document.getElementById(`itemAmount${i}`).value)
    sum += itemAmount;
  }
  if (sum == 0) {
    alert("Please Select Leather and Items")
  } else {

    let leatherAmount = parseFloat(document.getElementById("leather_amount").value)

    primeCost = sum + leatherAmount

    document.getElementById("prime_cost").value = primeCost.toFixed(2)

    let costSection = document.getElementById("costSection")

    costSection.classList.remove("hide")
  }

})
// function calcPrimeCost() {

// }




// Calculate gross Cost
let grossCostBtn = document.getElementById("grossCostBtn")

grossCostBtn.addEventListener("click", (e) => {
  e.preventDefault();
  let prime_cost = parseFloat(document.getElementById("prime_cost").value)
  if (prime_cost == 0) {
    alert("Please Select Leather and Items")
  } else {
    let labour_charges = parseFloat(document.getElementById("labour_charges").value)
    let pack_charges = parseFloat(document.getElementById("pack_charges").value)

    if (pack_charges == 0 || pack_charges == "") {
      alert("Please Enter Packaging Charges")
    } else {
      gross_cost.value = (prime_cost + labour_charges + pack_charges).toFixed(2)
    }
  }


})



// Calculate Overhead Charges in Value from Percentage


let overheadPercentage = document.getElementById("overhead_percentage")

overheadPercentage.addEventListener('keyup', () => {
  let gross_cost = parseFloat(document.getElementById("gross_cost").value)
  let overheadPercentageInt = parseFloat(document.getElementById("overhead_percentage").value)
  let overheadChargevalue = (gross_cost * overheadPercentageInt) / 100
  document.getElementById("overhead_value").value = overheadChargevalue.toFixed(2)
})

// Calculate Handling Charges in Value from Percentage


let handlingPercentage = document.getElementById("handling_percentage")

handlingPercentage.addEventListener('keyup', () => {
  let gross_cost = parseFloat(document.getElementById("gross_cost").value)
  let handlingInPercentage = parseFloat(document.getElementById("handling_percentage").value)
  let handlingChargeValue = (gross_cost * handlingInPercentage) / 100
  document.getElementById("handling_value").value = handlingChargeValue.toFixed(2)
})



// Calculate Insurance Charges in Value from Percentage



const calcInsurance = () => {
  let gross_cost = parseFloat(document.getElementById("gross_cost").value)
  let insureInPercentage = parseFloat(document.getElementById("insure_percentage").value)
  let insureChargeValue = (gross_cost * insureInPercentage) / 100
  document.getElementById("insure_value").value = insureChargeValue.toFixed(2)
}


// Calculate Bank Charges in Value from Percentage



const calcBank = () => {
  let gross_cost = parseFloat(document.getElementById("gross_cost").value)
  let bankInPercentage = parseFloat(document.getElementById("bank_percentage").value)
  let bankChargeValue = (gross_cost * bankInPercentage) / 100
  document.getElementById("bank_value").value = bankChargeValue.toFixed(2)
}


// Calculate Bank Charges in Value from Percentage



const calcFreight = () => {
  let gross_cost = parseFloat(document.getElementById("gross_cost").value)
  let bankInPercentage = parseFloat(document.getElementById("freight_percentage").value)
  let bankChargeValue = (gross_cost * bankInPercentage) / 100
  document.getElementById("freight_value").value = bankChargeValue.toFixed(2)
}

const clacProfit = () => {
  let gross_cost = parseFloat(document.getElementById("gross_cost").value)
  let profitInPercentage = parseFloat(document.getElementById("profit_percentage").value)
  let profitChargeValue = (gross_cost * profitInPercentage) / 100
  document.getElementById("profit_value").value = profitChargeValue.toFixed(2);
}

let calcTotalCostBtn = document.getElementById("calcTotalCostBtn")


calcTotalCostBtn.addEventListener("click", (e) => {
  e.preventDefault();
  let gross_cost = parseFloat(document.getElementById("gross_cost").value)
  let overhead_cost = parseFloat(document.getElementById("overhead_value").value);
  let handling_cost = parseFloat(document.getElementById("handling_value").value);
  let insure_cost = parseFloat(document.getElementById("insure_value").value);
  let bank_cost = parseFloat(document.getElementById("bank_value").value);
  let freight_cost = parseFloat(document.getElementById("freight_value").value);
  let profit = parseFloat(document.getElementById("profit_value").value);

  if (gross_cost == 0 || gross_cost == "") {
    alert("Please Calculate the Gross Cost")
  } else {
    let net_cost = gross_cost + overhead_cost + handling_cost + insure_cost + bank_cost + freight_cost + profit
    document.getElementById("netCost").value = net_cost.toFixed(2)
  }

})



// ---------------------Converting Currency




function selectConvCur() {
  let convCur = document.getElementById("convCur").value
  document.getElementById("slectedConvCur").innerHTML = convCur

}

// slectedConvCur




let convBtn = document.getElementById("convBtn")

convBtn.addEventListener("click", (e) => {
  e.preventDefault();
  let totalPrice = document.getElementById("netCost").value
  let convRate = parseFloat(document.getElementById("convRate").value)
  if (totalPrice == 0 || totalPrice == "") {
    alert("Please Calculate the Total Costing")
  } else {
    let conv_Price = totalPrice / convRate
    document.getElementById("convPrice").value = conv_Price.toFixed(2)
  }
})

// logical modal length and width showing

function modalToggle(index) {
  let uom = document.getElementById(`itemUom${index}`).value

  if (uom == "Ft" || uom == "PCS") {
    $("#selectItemCalcP" + index).modal("show")
  } else {
    $("#selectItemCalc" + index).modal("show")
  }

}


