<?php 

main();

function main () {
	
	$apiCall = 'https://api.covid19api.com/summary';
	$json_string = curl_get_contents($apiCall);
	$obj = json_decode($json_string);

    $countries_arr=Array();
    $deaths_arr=Array();
   
    foreach($obj->Countries as $i){

        array_push($countries_arr, $i->Country);
        array_push($deaths_arr, $i->TotalDeaths);
    }
    
    #sort the array
    array_multisort($deaths_arr, SORT_DESC,$countries_arr);
    
    #make the html for the page
    CreateHeaderAndTable();
    Filltable($countries_arr,$deaths_arr);
    CloseTable();
}

#read data from a URL into a string
function curl_get_contents($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}
    
function CreateHeaderAndTable(){
    
    #document header and properties set here
    echo "<!DOCTYPE html>";
    echo "<html>";
    echo "<head>";
      echo "<title>Covid API</title>";
      echo "<meta charset='utf-8'>";
      echo "<meta name='viewport' content='width=device-width, initial-scale=1'>";
      echo "<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css'";
      echo "<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>";
      echo "<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js'></script>";
     
    #define div style
    echo "<style>";
      echo ".table-div{";
        echo "width: 550px;";
        echo "margin: 1px auto;";
      echo "}";
      echo "</style>";
    
    
    echo "</head>";
    
    #add github link
    echo "<nav class='navbar navbar-dark'>";
      echo "<form class='form-inline'>";
        echo "<button class='btn btn-outline-success' type='button'><a href='https://github.com/cmkrygier/as18'>Github</a></button>";
      echo "</form>";
    echo "</nav>";
    
    #insert the table into the code
    InsertTable();
    
}
    
function InsertTable() {
        echo "<div class='table-div'>";
        #creating the top of the table
        echo "<table class='table'>";
            echo "<thead class='thead-dark'>";
                echo "<tr>";
                echo "<th scope='col'>Country</th>";
                echo "<th scope='col'>Deaths</th>";
              #  echo "<th scope='col'>Last</th>";
              #  echo "<th scope='col'>Handle</th>";
                echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
    }
    
function Filltable($countries_arr,$deaths_arr){
    
    # get the lenght of the array
    $length_of_arr = count($countries_arr)-1;
    
    #loop over the items in the array
    for ($i = 0; $i <= $length_of_arr; $i++) {
        
        echo "<tr>";
        echo "<td>" . $countries_arr[$i] . "</td>";
        echo "<td>" . $deaths_arr[$i] . "</td>";
        echo "</tr>";
    }
    
}

function CloseTable(){
    
    echo "</tbody>";
    echo "</table>";
    echo "<div>";
    echo "</html>";
    
}
    
?>












