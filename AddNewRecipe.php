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
        
    </div> 
      <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <h1 class="section-title position-relative text-center mb-5">إضافة وصفة جديدة</h1>
                </div>
            </div>
            <div class="container-fluid py-5">
        <div class="container py-5"dir="rtl">
        <h2 class=" position-relative text-right mb-5">المكونات</h2>
            
                             <div class="control-group" id="ingridiants">
                                <?php?>
                               
                             <p class="help-block text-danger"></p>
                            </div>
                          
                            <div dir="rtl" >
                            <table id="ingrTable" class="table" style="background-color:white;display:none;" >
                                        <th>
                                            المكون
                                        </th>
                                        <th>
                                            الكمية
                                        </th>
                                        <th>
                                            الواحدة
                                        </th>

                            </table>
                                <div id="ingredianDiv">
                                   
                                    <?php
                                        include_once("Action/Connection.php");
                                        $sql = "SELECT Id,Name FROM ingredient";
                                        $result = $conn->query($sql);
                                    ?>
                                    <div class="col-sm-6 control-group">
                                        <select class="form-control " id="ingridanttype" placeholder="المكون" required="required">
                                            <option selected disabled>اختر المكون</option>
                                            <?php
                                                while($row = $result->fetch_assoc()) {

                                                    echo("<option value='".$row['Id']."'>".$row['Name']."</option>");
                                                }        
                                            ?>                                
                                        </select>
                                    </div>
                                    <div class="col-sm-6 control-group" style="margin-top:40px;" >
                                        <input type="number" class="form-control" id="amount" placeholder="الكمية" required="required" data-validation-required-message="الرجاء إدخال البريد الإلكتروني" />
                                        <div id="ingredianDiv">
                                        <?php
                                            include_once("Action/Connection.php");
                                            $sql = "SELECT Id,Name FROM amounttype";
                                            $result = $conn->query($sql);
                                        ?>
                                            <select class="form-control " id="fffffff" placeholder="الواحدة" required="required"style="margin-top:10px;">
                                                <option selected disabled>الواحدة</option>
                                                <?php
                                                    while($row = $result->fetch_assoc()) {

                                                        echo("<option value='".$row['Id']."'>".$row['Name']."</option>");
                                                    }        
                                                ?>                                
                                            </select>
                                    </div>
                                <button class="btn btn-primary" style="margin-top:20px" onclick="adding()">إضافة مكون</button>

                                </div>
                               </div>
            <h2 class=" position-relative text-right mb-5"style="margin-top:100px;">تفاصيل الوصفة</h2>

            <div class="row " dir="rtl">
                <div class="col-lg-12">
                    <div class="contact-form bg-light rounded p-5">
                        <div id="success"></div>
                        <div name="addre" id="addrec" novalidate="novalidate">
                            
                            <div class="control-group">
                                <input type="text" class="form-control p-4" id="nameofrec" placeholder="اسم الوصفة" required="required" data-validation-required-message="اسم الوصفة" />
                                <p class="help-block text-danger"></p>
                            </div>
                            <div class="control-group">
                                <table>
                                <tr>
                                    <td>
                                        <h5>الصورة:</h5>
                                    </td>
                                    <td>
                                        <form action="Action/Upload.php" method="post" id="myForm" enctype="multipart/form-data">
                                            <input type="text" id="rid"hidden name="rid">
                                            <input type="file" name="image" accept="image/*" id="imageButton"/>
                                        </form>
                                    </td>             
                                </tr>
                                </table>
                                
                                <p class="help-block text-danger"></p>
                            </div>
                            <div class="control-group">
                                <TEXTAREA class="form-control p-4" id="descriptionofrec" placeholder="طريقة التحضير" required="required" data-validation-required-message="تفاصيل الوصفة"></textarea>
                               
                                <p class="help-block text-danger"></p>
                            </div>
                            
                            <div>
                                <button class="btn btn-primary btn-block py-3 px-5" onclick="add()" id="addnewrec">إضافة وصفة جديدة</button>
                            </div>
                           
                            </div>
                    </div>
                </div>
            </div>
        

        </div>
    </div>
        
        </div>
    </div>

    <script>
        let ingc=0;
        let ing=[];

        let amountc=0;
        let amounts=[];

        let unitc=0;
        let units=[];
    function adding()
        {
            var sel1 = document.getElementById("ingridanttype");
            var text1= sel1.options[sel1.selectedIndex].text;

            var sel2 = document.getElementById("fffffff");
            var text2= sel2.options[sel2.selectedIndex].text;
            
            var c=document.getElementById("ingridanttype").value;
            var c2=document.getElementById("amount").value;
            var c3=document.getElementById("fffffff").value;

            if(c==0||c3==0||c2=="")
            {
                alert("الرجاء ملئ جميع الحقول!")
                return;
            }

            //document.getElementById("ingrTable").append("<tr><td>123</td><td>123</td><td>123</td></tr>");
            var newRow=document.getElementById('ingrTable').insertRow();
            newRow.innerHTML = "<td>"+text1+"</td><td>"+c2+"</td><td>"+text2+"</td>";
            document.getElementById('ingrTable').style.display = "";
            ing[ingc]=c;
            ingc=ingc+1;
            amounts[amountc]=c2;
            amountc=amountc+1;
            units[unitc]=c3;
            unitc=unitc+1;
            console.log(ing);
            console.log(amounts);
            console.log(units);
        }
    function add(){
       
        
          
            var c=document.getElementById("nameofrec").value;
            var img=document.getElementById("file1");
        
            var c2=document.getElementById("descriptionofrec").value;
            if(amounts.length==0)
            {
                alert("الرجاء إضافة مكونات");
                return;
            }
            else if(c==""||c2=="")
            {
                alert("الرجاء ملئ جميع الحقول!")
                return;
            }
    $.ajax({
            type : "POST",  //type of method
            url  : "Action/AddNewRecipe.php",  //your page
            data : { Name : c, Descriprion : c2, Ing : JSON.stringify(ing),amounts:JSON.stringify(amounts),units:JSON.stringify(units),ImageUrl:JSON.stringify(img) },// passing the values
            success: function(res){  
                alert("تم إضافة الوصفة بنجاح!");          //do what you want here...
                
                document.getElementById("rid").value=res;
                //document.getElementById("rid").value=<?php if(isset($_SESSION["RID"])){echo($_SESSION["RID"]);$_SESSION["RID"]="00";unset($_SESSION["RID"]);}else{echo("0");} ?>;
                document.getElementById("myForm").submit();

            },
            error:function(ss)
            {
                alert("حدث خطأ غير متوقع")
            }
        });
    }

    </script>