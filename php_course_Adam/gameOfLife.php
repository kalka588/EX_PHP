<?php 
  define("L",5);
  define("R",15);
  function print_state($t){
  foreach ($t as $idx => $value) {
    echo " ";
    echo $value ? "o" : "x";
  }
    echo "\n";
  }

  $state = [];

  for($i=0 ; $i<L; $i++){
    $state[$i] = (bool) rand(0,1); 
  }

  print_state($state);


  for($j=0 ; $j<R; $j++){
    
    $newLine=$state;
      for($i=0 ; $i<L; $i++){
        $newLine[$i]=$state[($i-  1+L)%L]!=$state[($i+1+L)%L];
      }
    $state=$newLine;
    print_state($state);
    }
  
  ?>
