document.querySelectorAll(".status-select").forEach((select) => {
  select.addEventListener("change", function () {
    const ticketId = this.getAttribute("data-id");
    const newStatus = this.value;
    const badge = document.getElementById("badge-" + ticketId);
    const selectElement = this;

    fetch(`update_status.php?id=${ticketId}&status=${newStatus}`)
      .then((response) => response.text())
      .then((data) => {
        if (data === "success") {
          // 1. Mettre à jour le badge
          badge.innerText = newStatus.toUpperCase();
          const colors = {
            open: "background: #ffc107; color: black;",
            pending: "background: #17a2b8; color: white;",
            resolved: "background: #28a745; color: white;",
          };
          badge.style.cssText =
            "display: inline-block; width: 80px; text-align: center; padding: 3px 10px; border-radius: 12px; font-size: 0.8em; " +
            colors[newStatus];

          // 2. Mettre à jour les options du SELECT dynamiquement
          let optionsHtml = `<option value="" disabled selected>Faîtes un choix</option>`;

          if (newStatus === "open") {
            optionsHtml += `<option value="pending">Prendre en charge</option>
                                        <option value="resolved">Clôturer</option>`;
          } else if (newStatus === "pending") {
            optionsHtml += `<option value="open">Réouvrir</option>
                                        <option value="resolved">Clôturer</option>`;
          } else if (newStatus === "resolved") {
            optionsHtml += `<option value="open">Réouvrir</option>`;
          }

          selectElement.innerHTML = optionsHtml;
        }
      });
  });
});

function openModal(ticketId) {
  const modal = document.getElementById("modal-container");
  const content = document.getElementById("modal-content");

  // Vous devrez créer un fichier get_ticket_details.php qui renvoie le HTML des détails
  fetch(`get_ticket_details.php?id=${ticketId}`)
    .then((response) => response.text())
    .then((html) => {
      content.innerHTML = html;
      modal.style.display = "block";
    });
}

function updateStatusInModal(ticketId, newStatus) {
  fetch(`update_status.php?id=${ticketId}&status=${newStatus}`)
    .then((response) => response.text())
    .then((data) => {
      if (data === "success") {
        // 1. Recharger le contenu de la modale pour rafraîchir le select
        fetch(`get_ticket_details.php?id=${ticketId}`)
          .then((r) => r.text())
          .then((html) => {
            document.getElementById("modal-content").innerHTML = html;
          });

        // 2. Mettre à jour le badge dans le tableau principal (si besoin)
        location.reload(); // Solution simple : rafraîchit la page pour la synchro
      }
    });
}
