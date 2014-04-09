<?php

include_once('head.php');
include_once('../utils.php');

if(!isset($_SESSION['user'])){
    die("Error, user is not set.Please log in");
}

$user=$_SESSION['user'];

$fDao= FinanceDAO::getInstance();
$sums=$fDao->getUserSums($user);

?>

<div class="row">
    <div class="col-md-6">
        <h1>Hello <?php echo $user->getFirstName()." ". $user->getLastName();?></h1>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="panel panel-default">
            <!-- Default panel contents -->
            <div class="panel-heading">Sums information, user: <?php echo $user->getUsername(); ?></div>
            <!-- Table -->
            <table class="table">
                <tr>
                    <td><strong>Currency</strong></td>
                    <td align="center"><strong>Summery</strong></td>
                </tr>
            </table>
            <table class="table" id="chartsTable">
               <?php
                foreach($sums as $sum){
                    $currency=$sum["currencyname"];
                    $currencyCode=$sum['currencycode'];
                    $currencySum=$sum['sum'];
                    $sumInNis=Utils::convertToNis($currencyCode,$currencySum);
                    ?>
                    <tr>
                        <td><?php echo $currency." - ".$currencyCode ?></td>
                        <td><?php echo $currencySum ?></td>
                    </tr>
                <?php
                }
               ?>
            </table>
        </div>
    </div>
    <div class="col-md-2">
        <div class="panel panel-default">

            <div class="panel-heading">Information in Shekel</div>

        <table class="table">
            <tr>
                <td align="center"><strong>Shekel</strong></td>
            </tr>
            <?php
            foreach($sums as $sum){
                $currencyCode=$sum['currencycode'];
                $currencySum=$sum['sum'];
                $sumInNis=Utils::convertToNis($currencyCode,$currencySum);
                ?>
                <tr>
                    <td align="center"><?php echo $sumInNis ?></td>
                </tr>
            <?php
            }
            ?>
        </table>
            </div>
    </div>
    <div class="col-md-6" id="chart_div">

    </div>
</div>

    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="../js/chart.js"></script>

<?php
include_once('footer.php');
