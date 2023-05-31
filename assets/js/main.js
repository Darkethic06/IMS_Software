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

let leather_wastage = document.getElementById("leather_wastage")

leather_wastage.addEventListener('keyup', function () {
  let total = document.getElementById('leather_total').value
  total_wastage = (total * this.value) / 100
  final_total = total - total_wastage
  document.getElementById("final_leather").value = final_total
})


let selectLeatherBtn = document.getElementById("selectLeatherBtn")

selectLeatherBtn.addEventListener('click', function () {
  let final_leatherqty = document.getElementById("final_leather").value
  document.getElementById("leather_qty").value = final_leatherqty
  let rate = document.getElementById('leather_rate').value
  document.getElementById('leather_amount').value = final_leatherqty * rate
})

// -------------Selecting Items------------




// Calculate gross Cost

// function clacGrossCost(){
//   let prime_cost = parseInt(document.getElementById("prime_cost").value) 
//   let labour_charges = parseInt(document.getElementById("labour_charges").value)

//   gross_cost.value = prime_cost + labour_charges


// }
// let gross_cost = document.getElementById("gross_cost")

// gross_cost.addEventListener("focus",clacGrossCost)

// Calculate Packaging Charges in Value from Percentage


// let packInPercentage = document.getElementById("pack_percentage")

// packInPercentage.addEventListener('keyup',()=>{
//   let gross_cost = parseInt(document.getElementById("gross_cost").value)
//   let packInPercentageInt = parseInt(document.getElementById("pack_percentage").value)
//   let packChargevalue = (gross_cost * packInPercentageInt) /100
//   document.getElementById("pack_value").value = packChargevalue
// })

// Calculate Overhead Charges in Value from Percentage


// let overheadPercentage = document.getElementById("overhead_percentage")

// overheadPercentage.addEventListener('keyup',()=>{
//   let gross_cost = parseInt(document.getElementById("gross_cost").value)
//   let overheadPercentageInt = parseInt(document.getElementById("overhead_percentage").value)
//   let overheadChargevalue = (gross_cost * overheadPercentageInt) /100
//   document.getElementById("overhead_value").value = overheadChargevalue
// })

// Calculate Handling Charges in Value from Percentage


// let handlingPercentage = document.getElementById("overhead_percentage")

// overheadPercentage.addEventListener('keyup',()=>{
//   let gross_cost = parseInt(document.getElementById("gross_cost").value)
//   let overheadPercentageInt = parseInt(document.getElementById("overhead_percentage").value)
//   let overheadChargevalue = (gross_cost * overheadPercentageInt) /100
//   document.getElementById("overhead_value").value = overheadChargevalue
// })


