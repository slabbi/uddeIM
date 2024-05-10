/*<!--Make sure the form has the autocomplete function switched off:-->
<form autocomplete="off" action="/action_page.php">
    <div class="autocomplete" style="width:300px;">
        <input id="myInput" type="text" name="myCountry" placeholder="Country">
    </div>
    <input type="submit">
</form>'/

/* <script>
autocomplete(document.getElementById("myInput"), array(values);
var countries = ["Afghanistan","Albania","Algeria","Andorra","Angola","Anguilla","Antigua &amp; Barbuda","Argentina","Armenia","Aruba","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia","Bosnia &amp; Herzegovina","Botswana","Brazil","British Virgin Islands","Brunei","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Canada","Cape Verde","Cayman Islands","Central Arfrican Republic","Chad","Chile","China","Colombia","Congo"];
</script> */


function autocomplete(inp, arr, seperror='', sep=',', start=0, instr=0) {
    /*the autocomplete function takes three arguments,
    the text field element, the optional start counter (letters) and an array of possible autocompleted values:*/
    var currentFocus;
    /*execute a function when someone writes in the text field:*/
    inp.addEventListener("input", function(e) {
            var a, b, i, val = this.value;
            var add = 0;
            /*close any already open lists of autocompleted values*/
            closeAllLists();
            if (!val) { return false;}
            currentFocus = -1;
            /*check if the correct seperator is used */
            if ((sep == ',' && val.indexOf(';')) || (sep == ';' && val.indexOf(','))){
                alert(seperror);
            }
            if (val.indexOf(sep)) {
            var add = val.lastIndexOf(sep);
            val = val.substr(add+1);
            }
            if (val.length >= start){
            /*create a DIV element that will contain the items (values):*/
            a = document.createElement("DIV");
            a.setAttribute("id", this.id + "_autocomplete-list");
            a.setAttribute("class", "autocomplete-items");
            /*append the DIV element as a child of the autocomplete container:*/
            this.parentNode.appendChild(a);
            /*for each item in the array...*/

            for (i = 0; i < arr.length; i++) {
                /*check if the item starts with the same letters as the text field value:*/

                var lc = instr ? arr[i].toUpperCase().indexOf(val.toUpperCase()) : -1;  /*search in name*/

                if (lc > -1 || arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {  /*search from start*/
                    /*create a DIV element for each matching element:*/
                    b = document.createElement("DIV");

                    /*make the matching letters bold:*/
                    if (lc > -1) {
                    b.innerHTML = arr[i].substr(0, lc) + "<strong>" + arr[i].substr(lc, val.length) + "</strong>";
                    b.innerHTML += arr[i].substr(lc+val.length);
                    } else {
                    b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                    b.innerHTML += arr[i].substr(val.length);
                    }

                    /*insert a input field that will hold the current array item's value:*/
                    b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                    /*execute a function when someone clicks on the item value (DIV element):*/
                            b.addEventListener("click", function(e) {
                            /*insert the value for the autocomplete text field:*/
                            if (add) {
                            inp.value =  inp.value.substr(0,add+1)+this.getElementsByTagName("input")[0].value;
                            }
                            else {
                            inp.value = this.getElementsByTagName("input")[0].value;
                            }
                            /*close the list of autocompleted values,
                            (or any other open lists of autocompleted values:*/
                            closeAllLists();
                    });
                    a.appendChild(b);
                }
            }}
    });
    /*execute a function presses a key on the keyboard:*/
    inp.addEventListener("keydown", function(e) {
            var x = document.getElementById(this.id + "_autocomplete-list");
            if (x) x = x.getElementsByTagName("div");
            if (e.keyCode == 40) {
                /*If the arrow DOWN key is pressed,
                increase the currentFocus variable:*/
                currentFocus++;
                /*and and make the current item more visible:*/
                addActive(x);
            } else if (e.keyCode == 38) { //up
                /*If the arrow UP key is pressed,
                decrease the currentFocus variable:*/
                currentFocus--;
                /*and and make the current item more visible:*/
                addActive(x);
            } else if (e.keyCode == 13) {
                /*If the ENTER key is pressed, prevent the form from being submitted,*/
                e.preventDefault();
                if (currentFocus > -1) {
                    /*and simulate a click on the "active" item:*/
                    if (x) x[currentFocus].click();
                }
            }
    });
    function addActive(x) {
        /*a function to classify an item as "active":*/
        if (!x) return false;
        /*start by removing the "active" class on all items:*/
        removeActive(x);
        if (currentFocus >= x.length) currentFocus = 0;
        if (currentFocus < 0) currentFocus = (x.length - 1);
        /*add class "autocomplete-active":*/
        x[currentFocus].classList.add("autocomplete-active");
    }
    function removeActive(x) {
        /*a function to remove the "active" class from all autocomplete items:*/
        for (var i = 0; i < x.length; i++) {
            x[i].classList.remove("autocomplete-active");
        }
    }
    function closeAllLists(elmnt) {
        /*close all autocomplete lists in the document,
        except the one passed as an argument:*/
        var x = document.getElementsByClassName("autocomplete-items");
        for (var i = 0; i < x.length; i++) {
            if (elmnt != x[i] && elmnt != inp) {
            x[i].parentNode.removeChild(x[i]);
        }
    }
}
/*execute a function when someone clicks in the document:*/
document.addEventListener("click", function (e) {
        closeAllLists(e.target);
});
}
