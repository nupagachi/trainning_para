
<p>Click the button to demonstrate line-breaks in a confirm box.</p>

<a onclick="myFunction()">Try it</a>

<p id="demo"></p>

<script>
    function myFunction() {
        var txt;
        var r = confirm("Press a button!\nEither OK or Cancel.\nThe button you pressed will be displayed in the result window.");
        if (r == true) {
            txt = "You pressed OK!";
        } else {
            txt = "You pressed Cancel!";
        }
        document.getElementById("demo").innerHTML = txt;
    }
</script>
