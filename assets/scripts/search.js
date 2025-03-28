let cancel = document.getElementById("cancel-search");
let validate = document.getElementById("search-symbol");
let search = document.getElementById("s");
let results = document.getElementsByClassName("search-result");
let suggestions = document.getElementById("suggestions");

cancel.addEventListener("click", () => {
    cancel.classList.add("reduce-horizontal");
    validate.classList.remove("reduce-horizontal");
    search.value = "";
    for (const result of results) {
        result.classList.add("reduce");
    }
});

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

search.addEventListener("change", () => {
    if (search.value.length > 2) {
        getSearchResults(search.value, values => {
            let children = [];
            for (const value of values) {
                let text = document.createTextNode(value);
                let node = document.createElement('p');
                node.appendChild(text);
                node.classList.add("suggestion");
                children.push(node);
            }
            suggestions.replaceChildren(children);
        });
    }
});
