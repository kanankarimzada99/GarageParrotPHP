const mobileMenu = document.querySelector('.mobile-menu')
const navList = document.querySelector('.nav-list')
const navLinks = document.querySelectorAll('.nav-list li')

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

mobileMenu.addEventListener('click', handleClick)

// SLIDERS ------------------------
