<?php
include_once("navbar.php");
?>


<div  dir="rtl" class="jumbotron jumbotron-fluid page-header" style="margin-bottom: 90px;background: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url(Images/header.jpg), no-repeat center center;">
        <div class="container text-center py-5">
            <h1 class="text-white display-3 mt-lg-5">الوجبات</h1>
            <div class="d-inline-flex align-items-center text-white">
                <p class="m-0"><a class="text-white" href="index.php">الصفحة الرئيسية</a></p>
                <i class="fa fa-circle px-3"></i>
                <p class="m-0">ابحث حسب مكونات مطبخ</p>
            </div>
        </div>
    </div>   <div class="container-fluid py-5"STYLE="margin-top:-150px;">
        <div class="container py-5">
            
         
        
            <div class="container-fluid py-5">
        <div class="container py-5"dir="rtl">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <h1 class="section-title position-relative text-center mb-5" style="margin-top:-100px;">ابحث حسب مكونات مطبخك</h1>
                </div>
            </div>
            <table id="ingrTable" class="table" style="background-color:white;display:none;" >
                                        <th>
                                            المكون
                                        </th>
                                      

                            </table>
            <?php
                include_once("Action/Connection.php");
                $sql = "SELECT Id,Name FROM ingredient";
                $result = $conn->query($sql);
            ?>
            <div class="col-sm-6 control-group" dir="rtl">
                <select class="form-control " id="ingridanttype" placeholder="المكون" required="required">
                    <option selected disabled value="0">اختر المكون</option>
                    <?php
                        while($row = $result->fetch_assoc()) {

                            echo("<option value='".$row['Id']."'>".$row['Name']."</option>");
                        }        
                    ?>                                
                </select>
                <button class="btn btn-primary" style="margin-top:20px" onclick="adding()">إضافة مكون إلى قائمة البحث</button>
            </div>
            <div class="row" style="margin-top:10px;">
                <button class="btn btn-secondary " style="margin-top:20px;margin-right:28%; width:50%;" onclick="search()"><i class="fa fa-search" ></i>&nbspبحث</button>
            </div>
            <div class="row" style="margin-top:100px;" id="recipes">
              
            <?php

            $user=$_SESSION["Id"];
        
            $sql = "SELECT * FROM recipe";
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
        let ingc=0;
        let ing=[];
        function adding(){
            var c=document.getElementById("ingridanttype").value;
            if(c=="0")
            {
                alert("الرجاء اختيار مكون");
                return;
            }
            for(let i=0;i<ing.length;i++)
            {
                if(c==ing[i])
                {
                    alert("تم إضافة هذا المكون إلى قائمة البحث مسبقاً");
                    return;
                }
            }
            var sel1 = document.getElementById("ingridanttype");
            var text1= sel1.options[sel1.selectedIndex].text;
            var newRow=document.getElementById('ingrTable').insertRow();
            newRow.innerHTML = "<td>"+text1+"</td>";
            document.getElementById('ingrTable').style.display = "";
            
            ing[ingc]=c;
            ingc=ingc+1;
            console.log(ing);

        }

    function search(){

       var c2=document.getElementById("ingridanttype").value;
       document.getElementById("recipes").innerHTML=""  ;
       if(ing.length==0)
       {
           alert("الرجاء إضافة مكونات");
           return;
       }
      
        $.ajax({
            type : "POST",  //type of method
            url  : "Action/search.php?function=LoadPackage",  //your page
            data : {  Ing : JSON.stringify(ing) },// passing the values
            success: function(res)
            {  
               
                    let summ="";
                    res=JSON.parse(res);
                    console.log(res);

                    for(let i=0;i<res.length;i++)
                    {
                        
                        $.ajax({
                            type : "POST",  //type of method
                            url  : "Action/search.php?function=getsum&Id="+res[i]["Id"],  //your page
                            success: function(res1)
                            {  
                                    summ=res1;
                                    summ=summ.replace("\\","");
                                    summ=summ.replace("\"","");
                                    summ=summ.replace("\"","");
                                    if(summ==0)summ="لم تقيم بعد";

                        document.getElementById("recipes").innerHTML+='<div class="col-lg-3 col-md-6 mb-4 pb-2" Id="rrr'+res[i]["Id"]+'"><div class="product-item d-flex flex-column align-items-center text-center bg-light rounded py-5 px-3"><div class="bg-primary mt-n5 py-3" style="width: 80px;"><h4 class="font-weight-bold text-white mb-0">'+summ+'</h4></div><div class="position-relative bg-primary rounded-circle mt-n3 mb-4 p-3" style="width: 150px; height: 150px;"><img class="rounded-circle w-100 h-100" src="Images/rrr'+res[i]["Id"]+'.png" style="object-fit: cover;"></div><h5 class="font-weight-bold mb-4">'+res[i]["Name"]+'</h5><a href="Recipe.php?Id='+res[i]["Id"]+'" class="btn btn-sm btn-secondary">استعراض</a></div></div> ';

                            },
                            error:function(ss)
                            {
                                alert("حدث خطأ غير متوقع")
                            }
                        });



                    }
                    
            },
            error:function(ss)
            {
                alert("حدث خطأ غير متوقع")
            }
        });
        }

    </script>