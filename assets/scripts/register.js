let form = document.getElementById("register-form");
let submit = form.getElementsByClassName("text-submit")[0];

let pageNumber = 0;

function getPage(i) {
    return document.getElementsByClassName("page-" + i);
}

function showPage() {
    let i = 0;
    let page = getPage(i);
    while (page.length > 0) {
        if (i === pageNumber) {
            for (let pageElement of page) {
                if (pageElement.classList.contains("reduce"))
                    pageElement.classList.remove("reduce");
            }
        } else {
            for (let pageElement of page) {
                if (!pageElement.classList.contains("reduce"))
                    pageElement.classList.add("reduce");
            }
        }
        i++;
        page = getPage(i + 1);
    }
}

submit.addEventListener("click", e => {
    e.preventDefault()
    let card = document.getElementsByClassName("card")[0];
    card.classList.replace("card-half-page", "card-full-page");
    pageNumber++;
    showPage();
});
