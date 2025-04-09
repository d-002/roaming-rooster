function main() {
    let notifications = document.getElementsByClassName("notification");

    for (const notification of notifications) {
        let remove = notification.querySelector(".remove-notification");
        if (remove) {
            remove.addEventListener("click", () => {
                let request = new XMLHttpRequest();
                request.onreadystatechange = function () {
                    if (this.status === 200 && this.readyState === 4) {
                        notification.remove();
                    }
                }
                request.open("POST", "/utils/notification.php");
                request.send("id=" + notification.getAttribute("not"));
            });
        }
    }
}

window.addEventListener("load", main);
