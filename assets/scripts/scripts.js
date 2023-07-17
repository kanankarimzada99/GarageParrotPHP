const mobileMenu = document.querySelector('.mobile-menu')
const navList = document.querySelector('.nav-list')
const navLinks = document.querySelectorAll('.nav-list li')
const navLinksRef = document.querySelectorAll('.nav-list li a')

const animateLinks = () => {
  navLinks.forEach((link, index) => {
    link.style.animation
      ? (link.style.animation = '')
      : (link.style.animation = `navLinkFade 0.5s ease forwards ${
          index / 7 + 0.3
        }s`)
  })
}

const handleClick = () => {
  navList.classList.toggle('active')
  mobileMenu.classList.toggle('active')
  document.body.classList.toggle('noscroll')
  animateLinks()
}
const exitMenu = () => {
  navList.classList.toggle('active')
  mobileMenu.classList.toggle('active')
  document.body.classList.remove('noscroll')
  animateLinks()
}

for (let i = 0; i < navLinksRef.length; i++) {
  navLinksRef[i].addEventListener('click', exitMenu)
}

mobileMenu.addEventListener('click', handleClick)
