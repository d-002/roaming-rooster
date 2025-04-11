let cancel = document.getElementById("cancel-search");
let validate = document.getElementById("search-symbol");
let search = document.getElementById("s");
let results = document.getElementsByClassName("search-result");
let suggestions = document.getElementById("suggestions");

function getSearchResults(query, callback) {
    let request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            callback(this.responseText.split('°'));
        }
    }
    request.open("GET", "/utils/search?s=" + query);
    request.send();
}

cancel.addEventListener("click", () => {
    cancel.classList.add("reduce-horizontal");
    validate.classList.remove("reduce-horizontal");
    search.value = "";
    for (const result of results) {
        result.classList.add("reduce");
    }
});

search.addEventListener("keyup", () => {
    if (search.value.length > 1) {
        getSearchResults(search.value, values => {
            let children = [];
            for (const value of values) {
                if (value === "") continue;
                let node = document.createElement('p');
                node.textContent = value;
                node.classList.add("suggestion");
                node.addEventListener("click", () => {
                    search.value = node.textContent;
                })
                children.push(node);
            }
            suggestions.replaceChildren(...children);
        });
    }
});
