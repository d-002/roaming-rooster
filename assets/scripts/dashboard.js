const iterations = 11;

let elts = Array.from(document.querySelector(".temp-widget-list").children);
// typed array to be able to create subarrays
let heights = new Uint16Array(elts.map(elt => elt.offsetHeight));

// get the number of columns
let parent = document.querySelector(".widget-list");
let n_columns = Math.floor(parent.offsetWidth/430);

// populate page with them
let columns = new Array(n_columns);

for (let i = 0; i < n_columns; i++) {
    let elt = document.createElement("div");
    elt.className = "widget-column";

    parent.appendChild(elt);
    columns[i] = elt;
}

// assign elements to columns

let sum_arr = arr => arr.reduce((sum, x) => sum+x, 0);

// finding the best solution is expensive,
// so try to optimize it locally by running
// a simple algorithm multiple times

let average_height = sum_arr(heights) / n_columns;
console.log("target:", average_height);

let indices = new Array(n_columns-1);
for (let i = 0; i < n_columns-1; i++)
    indices[i] = Math.floor((i+1) / n_columns * elts.length);

let cols_heights = new Array(n_columns);
let requests = new Array(n_columns-1);

for (let i = 0; i < iterations; i++) {
    for (let j = 0; j < n_columns; j++) {
        let a = j ? indices[j-1] : 0;
        let b = j < n_columns-1 ? indices[j] : elts.length;

        // elements
        cols_heights[j] = sum_arr(heights.subarray(a, b));
        // padding
        cols_heights[j] += 21*(b-a-1);
    }

    // make requests to change the indices
    // based on how the heights differ
    // from the average height
    for (let j = 0; j < n_columns-1; j++) requests[j] = 0;

    for (let j = 0; j < n_columns; j++) {
        let size_request = 1 - (cols_heights[j]/average_height);

        // if in the middle, both surrounding indices
        // can be changed, therefore half the change
        if (j && j < n_columns-1) size_request *= .5;

        if (j) requests[j-1] -= size_request;
        if (j < n_columns-1) requests[j] += size_request;
    }

    // apply changes
    let has_changed = 0;
    for (let j = 0; j < n_columns-1; j++) {
        let change = Math.round(requests[j]);

        // avoid having empty columns
        change = Math.max(change, (j ? indices[j-1] : 0)-indices[j]+1);

        has_changed |= change;
        indices[j] += change;
    }

    // break early if found a local minimum
    if (!has_changed) break;
}

// populate columns
let column = 0;
for (let i = 0; i < n_columns; i++) {
    let a = i ? indices[i-1] : 0;
    let b = i < n_columns-1 ? indices[i] : elts.length;

    // appendChild moves the node,
    // no need to delete it in the temp div
    for (let j = a; j < b; j++)
        columns[column].appendChild(elts[j]);
    column++;
}
