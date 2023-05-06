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



function selectStyle() {
  let getStyleNo = document.getElementById('style_no').value
  document.getElementById("show_style_no").value = getStyleNo
}

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
  let rate = document.getElementById('rate').value
  document.getElementById('amount').value = final_leatherqty * rate
})

function clacGrossCost(){
  let prime_cost = document.getElementById("prime_cost")
}