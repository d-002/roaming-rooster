function checkGroup(group, index) {
    let count = 0;
    for (const box of group)
        if (box.children[0].checked)
            count++;

    if (count == 0) {
        if (index == 0) {
            // group[1].checked = true;
            group[1].children[0].checked = true;
        } else {
            // group[0].checked = true;
            group[0].children[0].checked = true;
        }
    }
}

console.log("INFO: inputs.js started");

// Groups that need to have at least one selected item
const groups = document.getElementsByClassName("at-least-one");
for (const group of groups) {
    const check_boxes = group.children;
    if (check_boxes.length == 0) {
        console.log("WARNING: empty group")
    } else if (check_boxes.length == 1) {
        let box = check_boxes[0].children[0];
        box.required = true;
        box.checked = true;
    } else {
        for (let i = 0; i < check_boxes.length; i++) {
            const value = check_boxes[i];
            value.children[0].checked = i === 0;
            value.addEventListener("click", () => checkGroup(group.children, i));
        }
    }
}
