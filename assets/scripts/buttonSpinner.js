let buttonsSpinning = document.querySelectorAll("button[data-loading]");

if(buttonsSpinning.length) {
    for(let currentButton of buttonsSpinning) {
        if (currentButton.closest('form')) {
             currentButton.closest('form').addEventListener("submit", (e) => {
             currentButton.querySelector("button > div").classList.remove("d-none");
             currentButton.disabled = true;
            })
        }
    }
}