var currentCaret;

function sortTable(n) {
    var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
    table = document.querySelector("table");
    switching = true;
    dir = "asc";
    
    while(switching) {
        switching = false;
        rows = table.getElementsByTagName("TR");
        for(i = 1; i < (rows.length - 1); i++) {
            shouldSwitch = false;
            x = rows[i].getElementsByTagName("TD")[n];
            y = rows[i + 1].getElementsByTagName("TD")[n];
            
            if(dir == "asc") {
                if(x.innerHTML > y.innerHTML) {
                    shouldSwitch = true;
                    break;
                }
            } else if(dir == "desc") {
                if(x.innerHTML < y.innerHTML) {
                    shouldSwitch = true;
                    break;
                }
            }
        }
        
        if(shouldSwitch) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
            switchcount++; 
        } else {
            if(switchcount == 0 && dir == "asc") {
                dir = "desc";
                switching = true;
            }
        }
    }
    
    var dropup = document.querySelector('span[data-toggle="' + n + '"]');
    var caret = document.querySelector('span[data-toggle="' + n + '"] .caret')
    
    if(dir == "asc") {
        // point down
        dropup.classList.remove("dropup");
    } else if(dir == "desc") {
        // point up
        dropup.classList.add("dropup");
    }
    
    if(currentCaret != null) {
        currentCaret.style.color = null;
        currentCaret.style.opacity = null;
    }
    
    caret.style.color = '#aaa';
    caret.style.opacity = 1;
    currentCaret = caret;
}