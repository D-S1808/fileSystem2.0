const themeToggler = document.getElementById('themeToggler');

let storedTheme = localStorage.getItem("theme");

if (storedTheme == 'dark' || storedTheme == 'light') {
  document.documentElement.setAttribute('data-bs-theme', storedTheme);
  if (storedTheme == 'dark') {
    themeToggler.checked = false
  }
} else {
  if (window.matchMedia && window.matchMedia('(prefers-color-scheme: light)').matches) {
    themeToggler.checked = true
    document.documentElement.setAttribute('data-bs-theme', 'light')
    localStorage.setItem("theme", "light");
  }
}

themeToggler.addEventListener('click', (event) => {
  console.log(event.target.checked)
  if (themeToggler.checked) {
    document.documentElement.setAttribute('data-bs-theme', 'light')
    localStorage.setItem("theme", "light");
  } else {
    document.documentElement.setAttribute('data-bs-theme', 'dark')
    localStorage.setItem("theme", "dark");
  }
})