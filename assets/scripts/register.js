let form = document.getElementById("register-form");
let submit = form.getElementsByClassName("text-submit")[0];

let pageNumber = 0;
let numberOfPages = 4;
let checkedTags = new Set();

function showPage() {
    let page = document.getElementsByClassName("page");
    for (let pageElement of page) {
        let elementPage = parseInt(pageElement.getAttribute("page"));
        if (pageNumber === elementPage) {
            if (pageElement.classList.contains("preload"))
                pageElement.classList.remove("preload");
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
            if (pageElement.classList.contains("preload"))
                pageElement.classList.remove("preload");
            if (pageElement.classList.contains("reduce"))
                pageElement.classList.remove("reduce");
        } else {
            if (!pageElement.classList.contains("reduce"))
                pageElement.classList.add("reduce");
        }
    }
    let circles = document.getElementsByClassName("page-circle");
    for (let circle of circles) {
        circle.setAttribute("checked", (parseInt(circle.getAttribute("circle")) === pageNumber).toString());
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
let next = document.getElementById("nav-next");

pred.addEventListener("click", () => {
    pageNumber--;
    next.classList.remove("reduce");
    if (pageNumber === 0) {
        let card = document.getElementsByClassName("card")[0];
        card.classList.replace("card-full-page", "card-half-page")
    }
    showPage();
});

next.addEventListener("click", () => {
    if (pageNumber + 1 < numberOfPages) {
        pageNumber++;
        showPage();
        if (pageNumber + 1 >= numberOfPages) {
            next.classList.add("reduce");
        }
    }
});

let circles = document.getElementsByClassName("circle");
for (let circle of circles) {
    circle.addEventListener("click", () => {
        pageNumber = parseInt(circle.getAttribute("circle"));
        showPage();
    });
}

let tags = document.getElementsByClassName("tag");
let tagsInput = document.getElementById("tags-input");
for (const tag of tags) {
    tag.addEventListener("click", () => {
        if (tag.getAttribute("checked") === "true") {
            checkedTags.delete(tag.textContent);
            tag.setAttribute("checked", "false");
        } else {
            checkedTags.add(tag.textContent);
            tag.setAttribute("checked", "true");
        }
        tagsInput.value = Array.from(checkedTags).join(",");
    });
}
