const mobileMenu = document.querySelector('.mobile-menu')
const navList = document.querySelector('.nav-list')
const navLinks = document.querySelectorAll('.nav-list li')
const navLinksRef = document.querySelectorAll('.nav-list li a')

const handleClick = () => {
  navList.classList.toggle('active')
  mobileMenu.classList.toggle('active')
  document.body.classList.toggle('noscroll')
}
const exitMenu = () => {
  navList.classList.remove('active')
  mobileMenu.classList.remove('active')
  document.body.classList.remove('noscroll')
}

for (let i = 0; i < navLinksRef.length; i++) {
  navLinksRef[i].addEventListener('click', exitMenu)
}

mobileMenu.addEventListener('click', handleClick)
