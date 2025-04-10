function remove_notification(notification) {
    let request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (this.status === 200 && this.readyState === 4) {
            notification.remove();
        }
    }
    let id = notification.getAttribute("not");
    request.open("POST", "/utils/notification.php?id=" + id);
    request.send();
}

let notifications = document.getElementsByClassName("notification");
for (const notification of notifications) {
    let remove = notification.querySelector(".remove-notification");
    if (remove) remove.addEventListener("click", () => remove_notification(this));
}
