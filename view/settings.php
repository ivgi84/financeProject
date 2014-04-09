<?php
include_once('head.php');

if(!isset($_SESSION['user'])){
    die("Error, user is not set.Please log in");
}

$dao=FinanceDAO::getInstance();
$currencies=$dao->getCurrencies();

if(isset($_POST['addSum'])){
    if(isset($_POST['currency']) && $_POST['currency']!="null" && isset($_POST['sum']) && $_POST['sum']!=""){

        if(!ctype_digit($_POST['sum'])){
            echo "<h4>Sum must be a number Only<h4>";
        }
        else{
            if($dao->addSumsNew($_SESSION['user'],$_POST['currency'],$_POST['sum'])){
                echo "<h4>Successfully added<h4>";
            }
            else{
                echo "<h4>Error<h4>";
            }
        }
    }
    else{
        echo "<h4>Data Missing<h4>";
    }

}


?>

<div class="row">
    <div class="col-lg-4 col-md-6 col-sm-8 col-xs-10">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo $user->getUsername(); ?> Settings</h3>
            </div>
            <div class="panel-body">
                <form role="form" action="" method="post">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Currency:</label>
                        <select id="currencySelect" name="currency">
                            <option value="null">Choose</option>
                            <?php
                            foreach($currencies as $currency){
                                $curId=$currency['currencyid'];
                                $curName=$currency['currencyname'];
                                $curCode=$currency['currencycode'];
                                ?>
                                <option value="<?php echo $curId ?>"> <?php echo $curName." - ".$curCode ?> </option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="sum">Sum</label>
                        <input type="text" name="sum" class="form-control" id="sum" placeholder="sum">
                    </div>
                    <button type="submit" name="addSum" class="btn btn-default">Add</button>
                </form>
            </div>
        </div>
    </div>

</div>

<?php
include_once('footer.php');