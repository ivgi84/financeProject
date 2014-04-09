<?php

interface iFinanceDAO{

    function logIn($email, $pass);

    function getUserSums(User $ob);

    function addSums(User $user, $currencyid,$sum);



}