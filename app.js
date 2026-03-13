function openModal(ticketId) {
  const modal = document.getElementById("modal-container");
  document.body.classList.add("no-scroll");
  const content = document.getElementById("modal-content");

  // Vous devrez créer un fichier get_ticket_details.php qui renvoie le HTML des détails
  fetch(`get_ticket_details.php?id=${ticketId}`)
    .then((response) => response.text())
    .then((html) => {
      content.innerHTML = html;
      modal.style.display = "block";
    });
}

// Fonction pour fermer la modale
function closeModal() {
  const modal = document.getElementById("modal-container");
  modal.style.display = "none";
  document.body.classList.remove("no-scroll"); // Restitue le scroll
}

function validateStatusChange(ticketId) {
  const status = document.getElementById("modal-status-select").value;
  const comment = document.getElementById("modal-comment").value;

  // Condition 1 : Un statut est sélectionné
  if (!status) {
    alert("Veuillez choisir un statut.");
    return;
  }

  // Condition 2 : Minimum 50 caractères
  if (comment.length < 50) {
    alert(
      "Le commentaire doit contenir au moins 50 caractères. (" +
        comment.length +
        "/50)",
    );
    return;
  }

  // Si tout est bon, on lance l'appel vers update_status.php
  // Vous pouvez passer le commentaire en paramètre si votre script PHP le gère
  fetch(
    `update_status.php?id=${ticketId}&status=${status}&comment=${encodeURIComponent(comment)}`,
  )
    .then((response) => response.text())
    .then((data) => {
      if (data === "success") {
        alert("Statut mis à jour !");
        closeModal(); // Ferme la modale
        location.reload(); // Recharge pour voir le changement
      }
    });
}
