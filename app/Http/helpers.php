<?php

function checkPermission($route, $method){
    
    if (Auth::user()->isAuthorized($route, $method)) {
      return true;
    }

    return false;
  }


?>