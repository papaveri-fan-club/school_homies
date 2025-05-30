console.log("Sidebar script loaded");
document.addEventListener("DOMContentLoaded", function () {
    const sidebar = document.querySelector(".sidebar");
    const hamburgerMenu = document.querySelector(".hamburger-menu");

    // Aggiungi evento click per aprire/chiudere la sidebar
    hamburgerMenu.addEventListener("click", function () {
        sidebar.classList.toggle("sidebar-open");
    });

    // Chiudi la sidebar quando si clicca fuori
    document.addEventListener("click", function (event) {
        if (!sidebar.contains(event.target) && !hamburgerMenu.contains(event.target)) {
            sidebar.classList.remove("sidebar-open");
        }
    });
});
//script per far apparire il bottone hamburger
document.addEventListener("DOMContentLoaded", function () {
    const hamburgerMenu = document.querySelector(".hamburger-menu");
    const sidebar = document.querySelector(".sidebar");

    // Mostra il pulsante hamburger su schermi piccoli
    if (window.innerWidth <= 768) {
        hamburgerMenu.style.display = "flex";
    } else {
        hamburgerMenu.style.display = "none";
    }

    // Aggiungi evento resize per mostrare/nascondere il pulsante hamburger
    window.addEventListener("resize", function () {
        if (window.innerWidth <= 768) {
            hamburgerMenu.style.display = "flex";
        } else {
            hamburgerMenu.style.display = "none";
            sidebar.classList.remove("sidebar-open"); // Chiudi la sidebar se aperta
        }
    });
});
