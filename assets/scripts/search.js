let cancel = document.getElementById("cancel-search");
let validate = document.getElementById("search-symbol");

cancel.addEventListener("click", () => {
    cancel.classList.add("reduce-horizontal");
    validate.classList.remove("reduce-horizontal");
});
