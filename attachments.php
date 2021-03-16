
<?php include("includes/sidebar.php");?>
<div id="main">

<?php include("includes/header.php");?> 
<style type="text/css">
#bar {display:none;}
</style>  

<script>
function show(el, txt){
    var elem1 = document.getElementById('bar');
    elem1.style.display = (txt == 'No') ? 'block' : 'none';
    }
</script>               
<div class="main-content container-fluid">
    <div class="page-title">
        <h3>Provide Vehicle Details</h3>
        <p class="text-subtitle text-muted">Complete the information to purchase your insurance plan</p>
    </div>


 <section class="section mt-5">

<div class="col-md-8 col-sm-12 mx-auto">
    <div class="card">
            <div class="container">
                <ul class="nav nav-tabs" role="tablist">
                    <div class="col-md-6 text-center">
                        <li role="presentation" class="active">
                        <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" title="Step 1">
                            <a href="vehicle_details.php">
                                <i data-feather="book" width="100"></i>
                                <p>Vehicle Details</p>
                                
                            </a>
                        </a>
                    </li>
                    </div>

                    <div class="col-md-6 text-center">
                        <li role="presentation" class="disabled">
                        <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="Step 2">
                            <a href="attachments.php" class="">
                                <i data-feather="git-commit" width="100"></i>
                                <p>Attachments</p>
                            </a>
                        </a>
                    </li>
                    </div>
                </ul>
                </div>
    </div>
</div>
<!-- details -->

    <div class="col-md-8 col-sm-12 mx-auto">
      <div class="card">
         <div class="card-body">

                    <div class="tab-content">
                    <div class="tab-pane active" role="tabpanel" id="step1">
                        <form class="form" action="buy_package.php">
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <span for="InsuredName"> Insured Name</span>
                                            <input type="text" id="InsuredName" class="form-control" name="InsuredName" placeholder="Insured Name">
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <span for="SumInsured">Sum Insured (Value of Vehicle of to be Insured)</span>
                                            <input type="text" id="SumInsured" class="form-control" name="SumInsured" placeholder="Sum Insured">
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <span for="SumInsured">Insured Type (Are you the Primary User)</span>
                                            <select name="thename" class="form-select" onChange="show('bar', this.options[this.selectedIndex].firstChild.nodeValue)">
                                                <option>Select Insured Type</option>
                                                <option>Yes</option>
                                                <option>No</option>
                                            </select>
                                        </div>

                                        <div id="bar">
                                        <div class="form-group">
                                            <input type="text" id="" class="form-control" name="" placeholder="Name">
                                            <input type="text" id="" class="form-control" name="" placeholder="Relationship (e.g Sister, Mother)">
                                        </div>

                                       </div>
                                    </div>

                                    
                                      
                                   
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <span for="PolicyStartDate">Policy Start Date</span>
                                            <input type="date" id="PolicyStartDate" class="form-control" name="PolicyStartDate" placeholder="Policy Start Date">
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <span for="company-column">Risk Images (4 Corners of Car including Plate number)</span>
                                            <div class="input-group mb-3">
                                        <div class="form-file">
                                            <input type="file" class="form-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                            <label class="form-file-label" for="inputGroupFile01">
                                                <span class="form-file-text">Choose file...</span>
                                                <span class="form-file-button">Browse</span>
                                            </label>
                                        </div>
                                    </div>
                                        </div>
                                    </div>

                                    

                                    <!-- <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <span for="PolicyEndDate">Policy End Date</span>
                                            <input type="date" id="PolicyEndDate" class="form-control" name="PolicyEndDate" placeholder="Policy End Date">
                                        </div>
                                    </div> -->

                                    <!-- <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <span for="SumInsuredType">Sum Insured Type</span>
                                            <input type="text" id="SumInsuredType" class="form-control" name="SumInsuredType" placeholder="Sum Insured Type">
                                        </div>
                                    </div>
 -->
                                    <!-- <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <span for="Currency">Currency</span>
                                            <input type="text" id="Currency" class="form-control" name="Currency" placeholder="Currency">
                                        </div>
                                    </div> -->
                                    
                                    <div class="col-12 d-flex justify-content-end">
                                      <a href=""><button type="submit" class="btn btn-primary mr-1 mb-1">Submit</button></a>
                                    </div>
                                </div>
                            </form>

                    </div>



                </div>
         
         </div>
     </div>
    </div>
</section>   

</div>
<script type="text/javascript">
    
</script>
<?php include("includes/footer.php");?>
            

