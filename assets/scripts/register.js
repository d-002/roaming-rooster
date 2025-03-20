let form = document.getElementById("register-form");
let submit = form.getElementsByClassName("text-submit")[0];

let pageNumber = 0;

function showPage() {
    let page = document.getElementsByClassName("page");
    for (let pageElement of page) {
        let elementPage = parseInt(pageElement.getAttribute("page"));
        if (pageNumber === elementPage) {
            if (pageElement.classList.contains("reduce"))
                pageElement.classList.remove("reduce");
        } else {
            if (!pageElement.classList.contains("reduce"))
                pageElement.classList.add("reduce");
        }
    }
    let special = document.getElementsByClassName("page-ex");
    for (let pageElement of special) {
        let exception = parseInt(pageElement.getAttribute("page-ex"));
        if (pageNumber !== exception) {
            if (pageElement.classList.contains("reduce"))
                pageElement.classList.remove("reduce");
        } else {
            if (!pageElement.classList.contains("reduce"))
                pageElement.classList.add("reduce");
        }
    }
}

submit.addEventListener("click", e => {
    e.preventDefault()
    let card = document.getElementsByClassName("card")[0];
    card.classList.replace("card-half-page", "card-full-page");
    pageNumber++;
    showPage();
});

showPage();

let pred = document.getElementById("nav-pred");
pred.addEventListener("click", () => {
    pageNumber--;
    showPage();
});
let next = document.getElementById("nav-next");
next.addEventListener("click", () => {
    pageNumber++;
    showPage();
})
