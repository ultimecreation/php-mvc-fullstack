const ul = document.querySelector("nav ul")
/* toggle menu*/
function toggleMenu() {
    ul.classList.toggle("open")
}

window.addEventListener("DOMContentLoaded", (event) => {

    document.querySelectorAll(`nav a`).forEach((a) => {
        a.classList.remove('active')
        if (a.href === window.location.href) {
            a.classList.add('active')
        }
    })
});

CKEDITOR.replace(document.querySelector('#admin-editor'));