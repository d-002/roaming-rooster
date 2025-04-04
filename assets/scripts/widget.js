let widgets_headers = document.getElementsByClassName("widget-header");
for (const widgetHeader of widgets_headers) {
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
