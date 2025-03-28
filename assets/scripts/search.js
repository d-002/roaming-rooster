let cancel = document.getElementById("cancel-search");
let validate = document.getElementById("search-symbol");
let search = document.getElementById("s");
let results = document.getElementsByClassName("search-result");

cancel.addEventListener("click", () => {
    cancel.classList.add("reduce-horizontal");
    validate.classList.remove("reduce-horizontal");
    search.value = "";
    for (const result of results) {
        result.classList.add("reduce");
    }
});
