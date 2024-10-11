<?php
include_once("navbar.php");
if(!isset($_SESSION['username']))
    header("location: index.php");

?>
<?php
include_once("Action/Connection.php");

$Id=$_GET["Id"];

$sql = "SELECT * FROM recipe WHERE Id = '$Id'";
$result = mysqli_query($conn,$sql);
$row = mysqli_fetch_array($result);

$sql2 = "SELECT r.Name as rName,Amount,a.Name as aName FROM recipeingredient rg left Join ingredient r on rg.Ingredient = r.Id left Join amounttype a on a.Id=rg.AmountType WHERE rg.Recipe = '$Id'";
$result1 = mysqli_query($conn,$sql2);

$u=$_SESSION["Id"];

$sql3 = "SELECT Rate FROM userrate WHERE Recipe = '$Id' and User='$u'";
$result3 = mysqli_query($conn,$sql3);
$row3 = mysqli_fetch_array($result3);

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
       
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <h1 class="section-title position-relative text-center mb-5" style="margin-top:-150px;"><?php echo($row["Name"]);   ?></h1>
                </div>
                <div style="background-color:red; width:80%;height:500px;">
                    <img src="Images/rrr<?php echo($row["Id"]); ?>.png" style="width:100%;height:100%;"/>
                </div>
               
                <div dir="" style="width:80%;">
                   
                   <table id="ingrTable" class="table" style="background-color:white;text-align:center;" dir="rtl" >   

                        <th>
                            المكون
                        </th>
                        <th>
                            الكمية
                        </th>
                        <th>
                            الواحدة
                        </th>
                        <?php
                         while($row1 = $result1->fetch_assoc()) 
                         {
                            echo('<tr><td>'.$row1["rName"].'</td><td>'.$row1["Amount"].'</td><td>'.$row1["aName"].'</td></tr>');
                         }
                        ?>
                    </table>
                </div>
                <div dir="" style="width:80%;background-color:white;text-align:center;">
                         <h2>طريقة التحضير</h2>
                         <p>
                            <?php
                                echo($row["Description"]);
                            ?>

                         </p>
                </div>

            </div>
         
            
            <div class="row" dir="rtl" style="margin-top:50px;">
            <div class="col-lg-12" dir="rtl" id="rrtrt">
                    <h1 class="section-title text-center" >تقييمك</h1>
                    <?php
                     $count = mysqli_num_rows($result3);
                     if($count==0){

                    ?>
                    <select class="text-center" id="select"style="margin-left:70%; width:150px;">
                    
                        <option selected disabled>اختر تقييمك</option>

                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                        <option>6</option>
                        <option>7</option>
                        <option>8</option>
                        <option>9</option>
                        <option>10</option>
                    </select>
                    <button class="btn btn-warning"style="margin-left:70%;margin-top:20px;" onclick="rate()" id="ratebtn">تقييم</button>
                    <?php
                     }
                     else{
                        echo('<h2 class="section-title text-center" >'.$row3["Rate"].'/10</h2>');
                     }
                    ?>
                </div>
            </div>
    </div>
        
        </div>
    </div>


    <script>

function rate()
{
     var c=document.getElementById("select").value;
     $.ajax({
            type : "POST",  //type of method
            url  : "Action/Rate.php",  //your page
            data : { User : <?php echo($u);?>, Recipe : <?php echo($Id);?>, Rate: c},// passing the values
            success: function(res){  
                alert("تم إضافة التقييم بنجاح!");          //do what you want here...
              
                var d=document.getElementById("select");
                d.style.display = "none";
                var ss=document.getElementById("ratebtn");
                ss.style.display = "none";
                document.getElementById("rrtrt").innerHTML+='<h2 class="section-title text-center" >'+c+'/10</h2>';
            },
            error:function(ss)
            {
                alert("حدث خطأ غير متوقع")
            }
        });
   
}
</script>
    

