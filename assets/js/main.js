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
  document.getElementById('leather_total').value = length * width * part
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
  document.getElementById(`item_total${itemQtyId}`).value = itemLength * itemWidth * itemQty
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


// ----------------------------------------------------Calculating 20 Item Cost

let primeCostCalcBtn = document.getElementById("primeCostCalcBtn")

primeCostCalcBtn.addEventListener("click",(e)=>{
  e.preventDefault();
  let sum = 0;
  for (let i = 1; i <= 20; i++) {
    let itemAmount = parseFloat(document.getElementById(`itemAmount${i}`).value)
    sum += itemAmount;
  }
  let leatherAmount = parseFloat(document.getElementById("leather_amount").value)

  primeCost = sum + leatherAmount

  document.getElementById("prime_cost").value = primeCost

  let costSection = document.getElementById("costSection")

  costSection.classList.remove("hide")

})
// function calcPrimeCost() {
  
// }




// Calculate gross Cost

function clacGrossCost() {
  let prime_cost = parseFloat(document.getElementById("prime_cost").value)
  let labour_charges = parseFloat(document.getElementById("labour_charges").value)

  gross_cost.value = prime_cost + labour_charges


}


// Calculate Packaging Charges in Value from Percentage


let packInPercentage = document.getElementById("pack_percentage")

packInPercentage.addEventListener('keyup',()=>{
  let gross_cost = parseFloat(document.getElementById("gross_cost").value)
  let packInPercentageValue = parseFloat(document.getElementById("pack_percentage").value)
  let packChargevalue = (gross_cost * packInPercentageValue) /100
  document.getElementById("pack_value").value = packChargevalue
})

// Calculate Overhead Charges in Value from Percentage


let overheadPercentage = document.getElementById("overhead_percentage")

overheadPercentage.addEventListener('keyup',()=>{
  let gross_cost = parseFloat(document.getElementById("gross_cost").value)
  let overheadPercentageInt = parseFloat(document.getElementById("overhead_percentage").value)
  let overheadChargevalue = (gross_cost * overheadPercentageInt) /100
  document.getElementById("overhead_value").value = overheadChargevalue
})

// Calculate Handling Charges in Value from Percentage


let handlingPercentage = document.getElementById("handling_percentage")

handlingPercentage.addEventListener('keyup',()=>{
  let gross_cost = parseFloat(document.getElementById("gross_cost").value)
  let handlingInPercentage= parseFloat(document.getElementById("handling_percentage").value)
  let handlingChargeValue = (gross_cost * handlingInPercentage) /100
  document.getElementById("handling_value").value = handlingChargeValue
})



// Calculate Insurance Charges in Value from Percentage



const calcInsurance = ()=>{
  let gross_cost = parseFloat(document.getElementById("gross_cost").value)
  let insureInPercentage= parseFloat(document.getElementById("insure_percentage").value)
  let insureChargeValue = (gross_cost * insureInPercentage) /100
  document.getElementById("insure_value").value = insureChargeValue
}


// Calculate Bank Charges in Value from Percentage



const calcBank = ()=>{
  let gross_cost = parseFloat(document.getElementById("gross_cost").value)
  let bankInPercentage= parseFloat(document.getElementById("bank_percentage").value)
  let bankChargeValue = (gross_cost * bankInPercentage) /100
  document.getElementById("bank_value").value = bankChargeValue
}


// Calculate Bank Charges in Value from Percentage



const calcFreight= ()=>{
  let gross_cost = parseFloat(document.getElementById("gross_cost").value)
  let bankInPercentage= parseFloat(document.getElementById("freight_percentage").value)
  let bankChargeValue = (gross_cost * bankInPercentage) /100
  document.getElementById("freight_value").value = bankChargeValue
}