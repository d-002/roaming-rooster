let form, submits, startForm;

let pred, next;

let username, email, password, confirmation;

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

function validateInput(callback, name, element, message) {
    let request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (this.readyState === 4) {
            if (this.status === 200) {
                if (this.responseText === "usable") {
                    callback();
                } else {
                    alert(message);
                }
            } else {
                alert(`Cannot verify ${name}, server cannot be reached.`)
            }
        }
    }
    request.ontimeout = function () {
        alert(`Cannot verify ${name}, server cannot be reached.`)
    }
    request.open("GET", `/utils/verify?${name}=${element.value}`, true);
    request.send();
}

function validatePageOne(callback) {
    if (pageNumber === 1) {
        if (password.value !== confirmation.value)
            return alert("The password confirmation is not identical to the password value.");
        if (!password.value.match(/^[A-Za-z]+$/))
            return alert("This website is currently in HTTP. Please enter a dummy password as we cannot assert that our website is secure. A dummy password should only contains letters.");

        validateInput(callback, "email", email, "This email is already used or is invalid. Please choose another one. Example: email@example.com is a valid email, a@a is not.");
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

function main() {
    form = document.getElementById("register-form");
    submits = form.getElementsByClassName("text-submit");
    startForm = submits[0];

    pred = document.getElementById("nav-pred");
    next = document.getElementById("nav-next");

    username = document.getElementById("username");
    email = document.getElementById("email");
    password = document.getElementById("password");
    confirmation = document.getElementById("passwordconfirmation");

    showPage();

    startForm.addEventListener("click", e => {
        e.preventDefault();
        validateInput(
            () => {
                let card = document.getElementsByClassName("card")[0];
                card.classList.replace("card-half-page", "card-full-page");
                pageNumber++;
                showPage();
            },
            "username",
            username,
            "This username is already used. Please choose another one."
        );
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
}

window.addEventListener("load", main);
