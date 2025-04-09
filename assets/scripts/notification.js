function remove_notification(notification) {
    let request = new XMLHttpRequest();
    request.onreadystatechange = function () {
        if (this.status === 200 && this.readyState === 4) {
            notification.remove();
        }
    }
    request.open("POST", "/utils/notification.php");
    request.send("id=" + notification.getAttribute("not"));
}
