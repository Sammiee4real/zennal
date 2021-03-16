<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<style type="text/css">
	/* https://gist.github.com/toddparker/32fc9647ecc56ef2b38a */
/* Some basic page styles */
body {
  font: 100%/1.5 AvenirNext-Regular, Corbel, "Lucida Grande", "Trebuchet Ms", sans-serif;
  color: #111; 
  background-color: #fff;
  margin: 2em 10%
}
/* Label styles: style as needed */
label {
  display:block;
  margin: 2em 1em .25em .75em;
  font-size: 1.25em;
  color:#333;
}
/* Container used for styling the custom select, the buttom class adds the bg gradient, corners, etc. */
.dropdown {
  position: relative;
  display:block;
  margin-top:0.5em;
  padding:0;
}
/* This is the native select, we're making everything the text invisible so we can see the button styles in the wrapper */
.dropdown select {
  width:100%;
  margin:0;
  background:none;
  border: 1px solid transparent;
  outline: none;
  /* Prefixed box-sizing rules necessary for older browsers */
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
  /* Remove select styling */
  appearance: none;
  -webkit-appearance: none;
  /* Magic font size number to prevent iOS text zoom */
  font-size:1.25em;
  /* General select styles: change as needed */
  /* font-weight: bold; */
  color: #444;
  padding: .6em 1.9em .5em .8em;
  line-height:1.3;
}
.dropdown select,
label {
  font-family: AvenirNextCondensed-DemiBold, Corbel, "Lucida Grande","Trebuchet Ms", sans-serif;
}
/* Custom arrow sits on top of the select - could be an image, SVG, icon font, etc. or the arrow could just baked into the bg image on the select */
.dropdown::after {
  content: "";
  position: absolute;
  width: 9px;
  height: 8px;
  top: 50%;
  right: 1em;
  margin-top:-4px;
  z-index: 2;
  background: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 12'%3E%3Cpolygon fill='rgb(102,102,102)' points='8,12 0,0 16,0'/%3E%3C/svg%3E") 0 0 no-repeat;  
  /* These hacks make the select behind the arrow clickable in some browsers */
  pointer-events:none;
}
/* This hides native dropdown button arrow in IE 10/11+ so it will have the custom appearance, IE 9 and earlier get a native select */
@media screen and (-ms-high-contrast: active), (-ms-high-contrast: none) {
  .dropdown select::-ms-expand {
    display: none;
  }
  /* Removes the odd blue bg color behind the text in IE 10/11 and sets the text to match the focus style text */
  select:focus::-ms-value {
    background: transparent;
    color: #222;
  }
}
/* Firefox >= 2 -- Older versions of FF (v2 - 6) won't let us hide the native select arrow, so we'll just hide the custom icon and go with native styling */
/* Show only the native arrow */
body:last-child .dropdown::after, x:-moz-any-link {
  display: none;
}
/* reduce padding */
body:last-child .dropdown select, x:-moz-any-link {
  padding-right: .8em;
}
/* Firefox 7+ -- Will let us hide the arrow, but inconsistently (see FF 30 comment below). We've found the simplest way to hide the native styling in FF is to make the select bigger than its container. */
/* The specific FF selector used below successfully overrides the previous rule that turns off the custom icon; other FF hacky selectors we tried, like `*>.dropdown::after`, did not undo the previous rule */
/* Set overflow:hidden on the wrapper to clip the native select's arrow, this clips hte outline too so focus styles are less than ideal in FF */
_::-moz-progress-bar, body:last-child .dropdown {
  overflow: hidden;
}
/* Show only the custom icon */
_::-moz-progress-bar, body:last-child .dropdown:after {
  display: block;
}
_::-moz-progress-bar, body:last-child .dropdown select {
  /* increase padding to make room for menu icon */
  padding-right: 1.9em;
  /* `window` appearance with these text-indent and text-overflow values will hide the arrow FF up to v30 */
  -moz-appearance: window;
  text-indent: 0.01px;
  text-overflow: "";
  /* for FF 30+ on Windows 8, we need to make the select a bit longer to hide the native arrow */
  width: 110%;
}
/* At first we tried the following rule to hide the native select arrow in Firefox 30+ in Windows 8, but we'd rather simplify the CSS and widen the select for all versions of FF since this is a recurring issue in that browser */
/* @supports (-moz-appearance:meterbar) and (background-blend-mode:difference,normal) {
.dropdown select { width:110%; }
}   */
/* Firefox 7+ focus style - This works around the issue that -moz-appearance: window kills the normal select focus. Using semi-opaque because outline doesn't handle rounded corners */
_::-moz-progress-bar, body:last-child .dropdown select:focus {
  outline: 2px solid rgba(180,222,250, .7);
}
/* Opera - Pre-Blink nix the custom arrow, go with a native select button */
x:-o-prefocus, .dropdown::after {
  display:none;
}
/* Hover style */
.dropdown:hover {
  border:1px solid #888;
}
/* Focus style */
select:focus {
  outline:none;
  box-shadow: 0 0 1px 3px rgba(180,222,250, 1);
  background-color:transparent;
  color: #222;
  border:1px solid #aaa;
}
/* Firefox focus has odd artifacts around the text, this kills that */
select:-moz-focusring {
  color: transparent;
  text-shadow: 0 0 0 #000;
}
option {
  font-weight:normal;
}
/* These are just demo button-y styles, style as you like */
.button {
  border: 1px solid #bbb;
  border-radius: .3em;
  box-shadow: 0 1px 0 1px rgba(0,0,0,.04);
  background: #f3f3f3; /* Old browsers */
  background: -moz-linear-gradient(top, #ffffff 0%, #e5e5e5 100%); /* FF3.6+ */
  background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#ffffff), color-stop(100%,#e5e5e5)); /* Chrome,Safari4+ */
  background: -webkit-linear-gradient(top, #ffffff 0%,#e5e5e5 100%); /* Chrome10+,Safari5.1+ */
  background: -o-linear-gradient(top, #ffffff 0%,#e5e5e5 100%); /* Opera 11.10+ */
  background: -ms-linear-gradient(top, #ffffff 0%,#e5e5e5 100%); /* IE10+ */
  background: linear-gradient(to bottom, #ffffff 0%,#e5e5e5 100%); /* W3C */
}
.output {
  margin: 0 auto;
  padding: 1em; 
}
.colors {
  padding: 2em;
  color: #fff;
  display: none;
}
.red {
  background: #c04;
} 
.yellow {
  color: #000;
  background: #f5e000;
} 
.blue {
  background: #079;
}
footer {
  margin: 5em auto 3em;
  padding: 2em 2.5%;
  text-align: center;
}
a {
  color: #c04;
  text-decoration: none;
}
a:hover {
  color: #903;
  text-decoration: underline;
}
</style>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script type="text/javascript">
	$(function() {
  $('#colorselector').change(function(){
    $('.colors').hide();
    $('#' + $(this).val()).show();
  });
});
</script>
<script>
$(document).ready(function(){
    $("select").change(function(){
        $(this).find("option:selected").each(function(){
            var optionValue = $(this).attr("value");
            if(optionValue){
                $(".box").not("." + optionValue).hide();
                $("." + optionValue).show();
            } else{
                $(".box").hide();
            }
        });
    }).change();
});
</script>

<body>
<form>
<label class="wrapper" for="states">This label is stacked above the select</label>
<div class="button dropdown"> 
  <select id="colorselector">
     <option value="red">Red</option>
     <option value="yellow">Yellow</option>
     <option value="blue">Blue</option>
  </select>
</div>

<div class="output">
  <div id="red" class="colors red">  “Good artists copy, great artists steal” Pablo Picasso
     <div>
        <select>
            <option>Choose Color</option>
            <option value="one">One time Payment</option>
            <option value="green">Physical Delivery</option>
            <!-- <option value="blue">Blue</option> -->
        </select>
    </div>
    <div class="one box">
         <button type="submit" class="btn btn-primary mr-1 mb-1">Proceed (₦ 21,000.00)</button>
    </div>
  </div>
  <div id="yellow" class="colors yellow"> “Art is the lie that enables us to realize the truth” Pablo Picasso</div>
  <div id="blue" class="colors blue"> “If I don't have red, I use blue” Pablo Picasso</div>
</div>



</body>
</html>