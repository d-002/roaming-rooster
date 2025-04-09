function main() {
    let widgetsHeaders = document.getElementsByClassName("widget-header");

    for (const widgetHeader of widgetsHeaders) {
        widgetHeader.addEventListener("click", () => {
            let sibling = widgetHeader.nextElementSibling;
            let parent = widgetHeader.parentElement;
            if (sibling.classList.contains("reduce")) {
                sibling.classList.remove("reduce");
                parent.classList.remove("turned");
            } else {
                sibling.classList.add("reduce");
                parent.classList.add("turned");
            }
        });
    }
}

window.addEventListener("load", main);
