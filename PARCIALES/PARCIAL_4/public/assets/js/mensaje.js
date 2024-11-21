document.addEventListener("DOMContentLoaded", function() {
    const successMessage = document.getElementById('success-message');

    if (successMessage) {
        // Desaparecer el mensaje después de 3 segundos
        setTimeout(function() {
            successMessage.style.display = 'none';
        }, 3000); // 3000 milisegundos = 3 segundos
    }
});

function confirmLogout() {
    const confirmAction = confirm("¿Estás seguro de que deseas cerrar sesión?");
    if (confirmAction) {
        window.location.href = "logout.php"; // Redirige a logout.php
    }
}

