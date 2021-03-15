<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>jQuery Show Hide Elements Using Select Box</title>
<style>
    .box{
       /* color: #fff;
        padding: 20px;
        display: none;
        margin-top: 20px;*/
    }
    /*.one{ background: #ff0000; }*/
    /*.green{ background: #228B22; }*/
    /*.blue{ background: #0000ff; }*/
</style>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<!-- <script>
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
</script> -->
<script type="text/javascript">
$(document).ready(function(){
$(".box").hide();
$("#dropdown").change(function() {
$(".box").hide();
$("#div" + $(this).val()).show();
});
});
</script>
</head>
<body>
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
    <!-- <div class="green box">
        <a href="apply_loan.php" class="btn btn-primary">Proceed (₦ 21,000.00)</a>
        <button type="submit" class="btn btn-primary mr-1 mb-1">Proceed (₦ 21,000.00)</button> 
    </div> -->
    <!-- <div class="blue box">You have selected <strong>blue option</strong> so i am here</div> -->
<form>
<select id="dropdown" name="dropdown">
<option value="0">Choose</option>
<option value="area1">DIV Area 1</option>
<option value="area2">DIV Area 2</option>
<option value="area3">DIV Area 3</option>
</select>
</form>
<div class="box">
<div id="divarea1">DIV Area 1</div>
<div id="divarea2">DIV Area 2</div>
<div id="divarea3">DIV Area 3</div>
</div>
</body>
</html>