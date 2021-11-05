<?php

if( $roww['bid'] >=  $sellprice15){
	    $bgcolor = 'background-color:#000000';
	    $bgclass='blink-bg';
  }else if( $roww['bid'] >=  $sellprice12){
	    $bgcolor = 'background-color:#00b30c';
	  	$bgclass='';
  }else if( $roww['bid'] >=  $sellprice9){
	    $bgcolor = 'background-color:#00FFD5';
	  	$bgclass='';
  }else if( $roww['bid'] >=  $sellprice6){
	    $bgcolor = 'background-color:#FFD400';
	  	$bgclass='';
  }else if( $roww['bid'] >=  $buyprice){
	    $bgcolor = 'background-color:#FF8000';
	  	$bgclass='';
  }else{
	    $bgcolor = 'background-color:pink';
	   	$bgclass='';
  }
  ?>