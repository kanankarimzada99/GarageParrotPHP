//menu hamburger
const mobileMenu = document.querySelector('.mobile-menu')
const navList = document.querySelector('.nav-list')
const navLinks = document.querySelectorAll('.nav-list li')
const navLinksRef = document.querySelectorAll('.nav-list li a')

const handleClick = () => {
  navList.classList.toggle('active')
  mobileMenu.classList.toggle('active')
  document.body.classList.toggle('noscroll')
}
for (let i = 0; i < navLinksRef.length; i++) {
  navLinksRef[i].addEventListener('click', handleClick)
}
mobileMenu.addEventListener('click', handleClick)
