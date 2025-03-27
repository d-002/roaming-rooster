let cancel = document.getElementById("cancel-search");
let validate = document.getElementById("search-symbol");
let search = document.getElementById("s");

cancel.addEventListener("click", () => {
    cancel.classList.add("reduce-horizontal");
    validate.classList.remove("reduce-horizontal");
    search.value = "";
});
