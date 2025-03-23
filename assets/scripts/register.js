let form = document.getElementById("register-form");
let submits = form.getElementsByClassName("text-submit");
let startForm = submits[0];

let pred = document.getElementById("nav-pred");
let next = document.getElementById("nav-next");

let username = document.getElementById("username");
let email = document.getElementById("email");

let pageNumber = 0;
let numberOfPages = 4;
let checkedTags = new Set();

function showElement(pageElement) {
    if (pageElement.classList.contains("preload"))
        pageElement.classList.remove("preload");
    if (pageElement.classList.contains("reduce"))
        pageElement.classList.remove("reduce");
}

function hideElement(pageElement) {
    if (!pageElement.classList.contains("reduce"))
        pageElement.classList.add("reduce");
}

function validatePageOne(callback) {
    if (pageNumber === 1) {
        let request = new XMLHttpRequest();
        request.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                if (this.responseText === "usable") {
                    callback();
                } else {
                    alert("This email is already used or is invalid. Please choose another one.");
                }
            }
        }
        request.open("GET", "/utils/verify.php?email=" + email.value, true);
        request.send();
    } else {
        callback();
    }
}

function showPage() {
    let page = document.getElementsByClassName("page");
    for (let pageElement of page) {
        let elementPage = parseInt(pageElement.getAttribute("page"));
        if (pageNumber === elementPage) {
            showElement(pageElement);
        } else {
            hideElement(pageElement);
        }
    }
    let special = document.getElementsByClassName("page-ex");
    for (let pageElement of special) {
        let exception = parseInt(pageElement.getAttribute("page-ex"));
        if (pageNumber !== exception) {
            showElement(pageElement);
        } else {
            hideElement(pageElement)
        }
    }
    let circles = document.getElementsByClassName("page-circle");
    for (let circle of circles) {
        circle.setAttribute("checked", (parseInt(circle.getAttribute("circle")) === pageNumber).toString());
    }
    if (pageNumber + 1 >= numberOfPages) {
        next.classList.add("reduce");
    } else {
        next.classList.remove("reduce");
    }
    if (pageNumber === 0) {
        let card = document.getElementsByClassName("card")[0];
        card.classList.replace("card-full-page", "card-half-page")
    }
}

showPage();

startForm.addEventListener("click", e => {
    e.preventDefault();
    let request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            if (this.responseText === "usable") {
                let card = document.getElementsByClassName("card")[0];
                card.classList.replace("card-half-page", "card-full-page");
                pageNumber++;
                showPage();
            } else {
                alert("This username is already used. Please choose another one.");
            }
        }
    }
    request.open("GET", "/utils/verify.php?username=" + username.value, true);
    request.send();
});

pred.addEventListener("click", () => {
    pageNumber--;
    showPage();
});

next.addEventListener("click", () => {
    validatePageOne(() => {
        if (pageNumber + 1 < numberOfPages) {
            pageNumber++;
            showPage();
        }
    });
});

let circles = document.getElementsByClassName("circle");
for (let circle of circles) {
    circle.addEventListener("click", () => {
        validatePageOne(() => {
            pageNumber = parseInt(circle.getAttribute("circle"));
            showPage();
        });
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

let inputs = document.getElementsByTagName("input");
let canHandle = true;
for (const input of inputs) {
    if (input.required) {
        let parent = input.closest(".page");
        if (parent != null) {
            console.log("Adding event");
            input.addEventListener("invalid", () => {
                if (!canHandle) return;
                console.log("Handling");
                pageNumber = parseInt(parent.getAttribute("page"));
                showPage();
                input.classList.add("required-tip");
                canHandle = false;
                setTimeout(() => {
                    input.focus();
                    input.reportValidity();
                    setTimeout(() => {
                        canHandle = true;
                    }, 5);
                }, 500);
            });
        }
    }
}
