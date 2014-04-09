<?php

include_once('iFinanceDAO.php');
include_once('connection.php');
include_once('user.php');

class FinanceDAO implements iFinanceDAO{

    private $conn;

    private static $singleInstance;

    public static function getInstance()
    {
        if(FinanceDAO::$singleInstance==null)
        {
            FinanceDAO::$singleInstance = new FinanceDAO();
        }
        return FinanceDAO::$singleInstance;
    }


    private function __construct(){
        $this->conn= new dbConnect();
    }

    function logIn($email, $pass){

        $connection= $this->conn->getConnected();
        $query="SELECT * FROM users WHERE email = '$email' and password='$pass'";

        try{
            $result=$connection->query($query,MYSQLI_STORE_RESULT);

            if(!$result){
                return trigger_error('Wrong SQL: '.$query.'Error:'.$this->conn->error,E_USER_ERROR);
            }
            else{
                if($result->num_rows){

                    session_start();
                    $data=$result->fetch_assoc();
                    $user=new User($data['id'],$data['firstName'],$data['lastName'], $data['email'], $data['username'],$data['password']);
                    $_SESSION['user']=$user;

                    if($this->getUserSums($user)!=false){
                        header("Location: main.php");
                    }
                    else{
                        header("Location: settings.php");
                    }
                }
                else{
                    header("Location: settings.php");
                }
            }


        }
        catch(Exception $e){
            $e->getMessage();
        }
        $connection->close();
    }


    function getUserSums(User $ob){

        $userid=$ob->getUserId();

        $connection=$this->conn->getConnected();
        $query="SELECT currencies.currencyname, currencies.currencycode, sum.sum FROM sum INNER JOIN currencies ON sum.currencyid= currencies.currencyid WHERE sum.userid=$userid ";

        try{
            $result=$connection->query($query);
            if($result){
                $data=$result->fetch_all(MYSQL_ASSOC);
                return $data;
            }
            else{
                return false;
            }
        }
        catch(Exception $e){
            return "error";
        }
    }


    function getUserByEmail($email){
        $connection= $this->conn->getConnected();

        $query="SELECT * FROM users WHERE email = '$email'";

        try{
            $result=$connection->query($query,MYSQLI_STORE_RESULT);
            if(!$result){
                return trigger_error('Wrong SQL: '.$query.'Error:'.$this->conn->error,E_USER_ERROR);
            }
            else{
                $rows= $result->fetch_all(MYSQL_ASSOC);
                return $rows;
            }
        }
        catch(Exception $e){
            $e->getMessage();
        }
        $connection->close();
    }

    function addSums(User $user, $currencyid,$sum){
        $userid=$user->getUserId();
        $query="INSERT INTO sum (userid, currencyid, sum) VALUES ($userid,$currencyid,$sum)";
        $connection=$this->conn->getConnected();

        try{
            if($connection->query($query)){
                return true;
            }
            else{
                return false;
            }
        }
        catch(Exception $e){
            $e->getMessage();
        }
    }

    function addSumsNew(User $user, $currencyid,$sum){
        $userid=$user->getUserId();

        $queryCheck="SELECT currencyid, sum FROM sum WHERE userid=$userid";
        $queryInsert="INSERT INTO sum (userid, currencyid, sum) VALUES ($userid,$currencyid,$sum)";
        //$queryUpdate="UPDATE sum SET sum= $sum WHERE userid=$userid and currencyid = $currencyid";

        $connection=$this->conn->getConnected();

        try{
            $result=$connection->query($queryCheck);

            if($result){
                $data=$result->fetch_assoc();

                if($data['currencyid']==$currencyid){
                    $newSum=$data['sum']+$sum;
                    //UPDATE EXISTING
                    $stmt=$connection->prepare("UPDATE sum SET sum=? WHERE userid=? and currencyid=?");
                    $stmt->bind_param("iii",$newSum, $userid,$currencyid);

                    try{
                        $stmt->execute();
                        if($stmt->errno){
                            return false;
                        }
                        else{
                            return true;
                        }
                    }
                    catch(Exception $e){
                        return $e->getMessage();
                    }
                    $stmt->close();
                }
                else{
                    //INSERT NEW
                    try{
                        if($connection->query($queryInsert)){
                            return true;
                        }
                        else{
                            return false;
                        }
                    }
                    catch(Exception $e){
                        $e->getMessage();
                    }
                    $connection->close();
                }
            }
            else{
                return false;
            }
        }
        catch(Exception $e){
            $e->getMessage();
        }
        $connection->close();

    }


    function getCurrencies(){
        $connection=$this->conn->getConnected();
        $query="SELECT * FROM currencies";
        $result=$connection->query($query);
        try{
            if($result){
                $data=$result->fetch_all(MYSQL_ASSOC);
                return $data;
            }
            else{
                throw new Exception("no Data");
            }
        }
        catch(Exception $e){
            $e->getMessage();
        }
        $connection->close();

    }


    function setCurrencies(){
        $done=true;
        $data= new SimpleXMLElement('http://www.boi.org.il/currency.xml',NULL,true);

        $connection=$this->conn->getConnected();

        foreach($data as $row){

            $query = "INSERT INTO currencies( currencyname, currencycode ) VALUES ('$row->NAME', '$row->CURRENCYCODE')";

            try{
                if($connection->query($query));
                else{
                    $done=false;
                }
            }
            catch(Exception $e){
                return $e->getMessage();
            }
        }
        $connection->close();
        return $done;
    }

}

