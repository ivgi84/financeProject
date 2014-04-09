<?php
include("head.php");

if(isset($_POST["submit"])){

    $email=$_POST['email'];
    $password=$_POST['password'];

    $fDAO=FinanceDAO::getInstance();
    $fDAO->logIn($email,md5($password));

}
if(isset($_POST["setCur"])){
    $fDAO=FinanceDAO::getInstance();
    if( $fDAO->setCurrencies()){
        echo "ok";
    }
    else{
        echo "fail";
    }
}

?>

<div class="row">
    <div class="col-md-4">
        <form role="form" action="" method="post">
            <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox"> Check me out
                </label>
            </div>
            <button type="submit" name="submit" class="btn btn-default">Submit</button>
<!--            <button type="submit" name="setCur" class="btn btn-default">setCur</button>-->
        </form>
    </div>
</div>




<?php
include("footer.php");


