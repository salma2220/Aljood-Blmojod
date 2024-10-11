<?php
include_once("navbar.php");
?>


<div  dir="rtl" class="jumbotron jumbotron-fluid page-header" style="margin-bottom: 90px;background: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url(Images/header.jpg), no-repeat center center;">
        <div class="container text-center py-5">
            <h1 class="text-white display-3 mt-lg-5">إنشاء حساب</h1>
            <div class="d-inline-flex align-items-center text-white">
                <p class="m-0"><a class="text-white" href="index.php">الصفحة الرئيسية</a></p>
                <i class="fa fa-circle px-3"></i>
                <p class="m-0">إنشاء حساب</p>
            </div>
        </div>
    </div>   <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <h1 class="section-title position-relative text-center mb-5">إنشاء حساب</h1>
                </div>
            </div>
            <div class="row justify-content-center" dir="rtl">
                <div class="col-lg-9">
                    <div class="contact-form bg-light rounded p-5">
                        <div id="success"></div>
                        <form name="sentMessage" id="contactForm" method="POST" action="Action/Register.php">
                            <div class="form-row">
                                <div class="col-sm-6 control-group">
                                    <input type="text" class="form-control p-4" name="name" id="name" placeholder="الاسم" required="required" data-validation-required-message="الرجاء إدخال الاسم" />
                                    <p class="help-block text-danger"></p>
                                </div>
                                <div class="col-sm-6 control-group">
                                    <input type="text" class="form-control p-4" name="username"id="email" placeholder="اسم المستخدم" required="required" data-validation-required-message="الرجاء إدخال اسم المستخدم" />
                                    <p class="help-block text-danger"></p>
                                </div>
                            </div>
                            <div class="control-group">
                                <input type="password" class="form-control p-4" name="password"id="password" placeholder="كلمة المرور" required="required" data-validation-required-message="كلمة المرور" />
                                <p class="help-block text-danger"></p>
                            </div>
                            <div class="control-group">
                                <input type="password" class="form-control p-4"name="conpassword" id="password" placeholder="تأكيد كلمة المرور" required="required" data-validation-required-message="تأكيد كلمة المرور" />
                                <p class="help-block text-danger"></p>
                            </div>
                            <p style="color:red">
                                <?php
                                   
                                    if(isset($_SESSION['error']))
                                    {
                                        echo $_SESSION['error'];
                                        unset($_SESSION["error"]);

                                    }

                                ?>
                                </p>
                            <div>
                                <button class="btn btn-primary btn-block py-3 px-5" type="submit" id="sendMessageButton">إنشاء حساب</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>