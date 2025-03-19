let form = document.getElementById("register-form");
let submit = form.getElementsByClassName("text-submit")[0];

submit.addEventListener("click", e => {
    e.preventDefault()
    let removing = document.getElementsByClassName("remove-on-submit");
    console.log(removing.length)
    for (let mustBeRemoved of removing) {
        mustBeRemoved.classList.add("hidden");
        mustBeRemoved.remove();
    }
});
