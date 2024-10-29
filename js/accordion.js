const bb_acc = document.getElementsByClassName("bb-accordion");
let bb_i;

for (bb_i = 0; i < bb_acc.length; bb_i++) {
    bb_acc[i].addEventListener("click", function() {
        this.classList.toggle("active");
        let icon = this.lastElementChild
        let panel = this.nextElementSibling;
        if (panel.style.maxHeight) {
            panel.style.maxHeight = null;
            icon.className = "bb-color dashicons dashicons-arrow-down-alt2 bb-icon-translation"
        } else {
            icon.className = "bb-color dashicons dashicons-arrow-down-alt2 bb-icon-translation bb-icon-rotate"
            panel.style.maxHeight = panel.scrollHeight + 22 + "px";
        }
    });
}