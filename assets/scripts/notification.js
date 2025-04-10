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
