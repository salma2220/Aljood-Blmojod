<?php
include_once("navbar.php");
if(!isset($_SESSION['username']))
    header("location: index.php");

?>


<div  dir="rtl" class="jumbotron jumbotron-fluid page-header" style="margin-bottom: 90px;background: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url(Images/header.jpg), no-repeat center center;">
        <div class="container text-center py-5">
            <h1 class="text-white display-3 mt-lg-5"><?php echo($_SESSION['name'])?></h1>
            <div class="d-inline-flex align-items-center text-white">
                <p class="m-0"><a class="text-white" href="index.php">الصفحة الرئيسية</a></p>
                <i class="fa fa-circle px-3"></i>
                <p class="m-0">حسابي</p>
            </div>
        </div>
        
    </div>   <div class="container-fluid py-5">
        <div>
            <a href="AddNewRecipe.php" class="btn btn-primary btn-block py-3 px-5 "style="font-size:25px;width:50%;margin:auto;">إضافة وصفة جديدة</a>
        </div>
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <h1 class="section-title position-relative text-center mb-5">وصفاتي</h1>
                </div>
                <div class="" style="color:red;">
                    <h1 class=" text-center mb-5"><?php
                    if(isset($_SESSION["Delete"]))
                        {
                            echo($_SESSION["Delete"]);
                            unset($_SESSION["Delete"]);
                        }
                    ?></h1>
                </div>
            </div>
         
        
            <div class="container-fluid py-5">
        <div class="container py-5">
        <div class="row">
            <?php
            include_once("Action/Connection.php");

            $user=$_SESSION["Id"];
        
            $sql = "SELECT * FROM recipe WHERE User = '$user'";
            $result1 = mysqli_query($conn,$sql);
            while($row1 = $result1->fetch_assoc()) {
                $rid=$row1["Id"];
                $sql = "SELECT * FROM userrate WHERE recipe = '$rid'";
                $result = mysqli_query($conn,$sql);
                $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
                
                $count = mysqli_num_rows($result);

                $sql = "SELECT sum(rate) as a FROM userrate WHERE recipe = '$rid'";
                $result = mysqli_query($conn,$sql);
                $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
                if($count!=0)
                    $sum=strval(round($row['a']/$count))."/10";
                else $sum="لم تقيم بعد";
                echo('
                <div class="col-lg-3 col-md-6 mb-4 pb-2" Id="rrr'.$rid.'">
                    <div class="product-item d-flex flex-column align-items-center text-center bg-light rounded py-5 px-3">
                        <div class="bg-primary mt-n5 py-3" style="width: 80px;">
                            <h4 class="font-weight-bold text-white mb-0">'.$sum.'</h4>
                        </div>
                        <div class="position-relative bg-primary rounded-circle mt-n3 mb-4 p-3" style="width: 150px; height: 150px;">
                            <img class="rounded-circle w-100 h-100" src="Images/rrr'.$rid.'.png" style="object-fit: cover;">
                        </div>
                        <h5 class="font-weight-bold mb-4">'.$row1["Name"].'</h5>
                        <a href="Recipe.php?Id='.$rid.'" class="btn btn-sm btn-secondary">استعراض</a>
                       
                        <button  class="btn btn-sm btn-warning m-1" onclick="ddd('.$rid.')">حذف</button>
                    </div>
                </div> ');
            } 
            ?>
            </div>
        </div>
    </div>
        
        </div>
    </div>


    <script>

function ddd(id)
{
    alert(id);
                    $.ajax({
        type : "POST",  //type of method
        url  : "Action/DeleteRecipe.php",  //your page
        data : { Id:id },// passing the values
        success: function(res){  
            alert("تم حذف الوصفة بنجاح!");          //do what you want here...
            var ss=document.getElementById("rrr"+id);
            ss.style.display = "none";
        },
        error:function(ss)
        {
            alert("حدث خطأ غير متوقع")
        }
    });
}
</script>
    

