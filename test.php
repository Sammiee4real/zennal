<html>
<head>
<style type="text/css">
#bar {visibility:hidden;}
#barr {visibility:hidden;}
</style>
<script>
function show(el, txt){
	var elem = document.getElementById(el);
	elem.style.visibility = (txt == 'other') ? 'visible' : 'hidden';
  elem.style.visibility = (txt == 'choice') ? 'visible' : 'hidden';
	}
  
</script>

</head>
<body>
<form method="POST">
  <select size="1" name="thename" class="asdf" onChange="show('bar', this.options[this.selectedIndex].firstChild.nodeValue)">
  <option selected>--- Choose One ---</option>
  <option>choice 1</option>
  <option >choice</option>
  <option>other</option>
  </select>
  <div id="bar">
    <input type="text">
    <select class="form-select">
      <option>sskak</option>
    </select>
  </div>
  <input type="submit" value="Submit" name="B1"><input type="reset" value="Reset" name="B2"></p>
  <div id="barr">
    <input type="text">
    <select class="form-select">
      <option>sskak</option>
    </select>
  </div>
</form>
</body>
</html>


  
<form id="myForm">
         <select id="selectNow">
            <option>One</option>
            <option>Two</option>
            <option>Three</option>
         </select>
         <input type="button" onclick="display()" value="Click">
      </form>
      <p>Select and click the button</p>
      <script>
         function display() {
            var obj = document.getElementById("selectNow");
            document.write(obj.options[obj.selectedIndex].text);
         }
      </script>