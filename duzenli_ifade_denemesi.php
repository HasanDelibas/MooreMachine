<style>
  .log{
 //     display:none; 
      color:#888;
  }
  .logred{
      
/*       color:#F88; */
  }
  pre{
    margin:2px;
  }
    
*{
/*   font-family:"Arial"; */
  }

</style>

<?php 

// $RE="HA(S)*AD(F)C+HASAN(XXX)*FM(A+V)";
$RE = "(a+b)(a+d)+(ab)*)";
// $RE2 = "HA(S)*A(D+N)DA+NE+444444444+fsf+sdfsd+ad";

// echo $RE."<br>";

// $degisken =minHesapla($RE);

// echo "->".$degisken."<br>";

function sonsuzVarmi($metin){
    $son = strlen($metin);    
    if($son==0) return "";
    $psayisi = 0; // Parantez Sayisi
    $pilk=0;
    $pson=-1;
    for ($i=0;$i<$son;$i++){
	if($metin[$i]=="("){
	    ++$psayisi;
	    if($i==0) $pilk = 1;
	}
	if($metin[$i]==")"){
	  --$psayisi;
	  if($pson==-1 && $psayisi==0) $pson=$i;
	}
	
	
    }
    $yildiz=1;
    $part = $metin;
    if($yildiz==1){
	if($part[0]=="(" && @$part[$son-2]==")" && @$part[$son-1]=="*" && $pilk==1 && $pson+2==$son){
	    return 1;
	}
    }
    
    return 0;
    
}


function parantezSil($metin,$yildiz = 0,$zorunlu=1){

    $son = strlen($metin);
    if($son==0) return "";
    $psayisi = 0; // Parantez Sayisi
    
    $pilk=0;
    $pson=-1;
    
    for ($i=0;$i<$son;$i++){
	if($metin[$i]=="("){
	    ++$psayisi;
	    if($i==0) $pilk = 1;
	}
	if($metin[$i]==")"){
	  --$psayisi;
	  if($pson==-1 && $psayisi==0) $pson=$i;
	}
	
	
    }
//      echo $psayisi;
    if($psayisi!==1 && $zorunlu ==0){
	return $metin;
    }

    
    $part = $metin;
    
    if($part[0]=="(" && @$part[$son-1]==")" && $pilk==1 && $pson+1==$son ){
// 	echo substr($metin,1,$son-2);
	return substr($metin,1,$son-2);
    }    

    if($yildiz==1){
	if($part[0]=="(" && @$part[$son-2]==")" && @$part[$son-1]=="*" && $pilk==1 && $pson+2==$son){
    // 	echo substr($metin,1,$son-3);
	    return substr($metin,1,$son-3);
	}
    }
    
    return $metin;
    
}


function mint($s1,$s2){
  return $s1>$s2 ? $s2 : $s1;
}

function partToplam($part){
    $parantez=0;  $son = strlen($part);
    for($i=0;$i<$son;$i++){
	if($part[$i]=="(") ++$parantez;
	if($part[$i]==")") --$parantez;
	if($part[$i]=="+" && $parantez == 0 ){
// 	    log1($i,"red");
	    return array(substr($part,0,$i),substr($part,$i+1));
	}
    }
    return 0;
}


function partCarpim($part){

    $parantez=0;  $son = strlen($part);
    
    if ($son==0) return 0;
    // 
    

    for($i=0;$i<$son;$i++){


	
	if ($i!=0){
	    if($part[$i]=="(" && $parantez ==0){
		if(!empty(substr($part,$i)))
		return array(substr($part,0,$i),substr($part,$i));
	    }    
	}
	
	if($part[$i]==")" && $parantez ==+1){
	    if($i+1==$son){
		return 0;
	    }
	    
	    if (@$part[$i+1]=="*" ){
	      if(!empty(substr($part,$i+2)))
		return array(substr($part,0,$i+2),substr($part,$i+2));
	    }else{
	      if(!empty(substr($part,$i+1)))
		return array(substr($part,0,$i+1),substr($part,$i+1));}
		    
	}
	
	
	if($part[$i]=="(") ++$parantez;
	if($part[$i]==")") --$parantez;

      }
      return 0;
    
}

function log1($metin,$color="#F88"){
  echo "<pre>";
  echo "<div class=log style=color:$color>".$metin."</div>";
  echo "</pre>";
}
function logd($metin,$color="#F88"){
  echo "<pre>";
  echo "<div class=logd style=color:$color>".$metin."</div>";
  echo "</pre>";
}

function minHesapla($part){

    GLOBAL $zaman;

     $zaman++;
     if($zaman > 100){
//  	return 0;
     }
    
 
    $part = parantezSil($part);// ASD
//    log1(".".$part.".","red");
//     echo ;
    
    $parts = partToplam($part);
    if($parts!=0){
	return min(minHesapla($parts[0]) , minHesapla($parts[1]));
    }
    $parts = partCarpim($part);
    if($parts!=0){
	return minHesapla($parts[0]) + minHesapla($parts[1]);
    }
            
    $son = strlen($part);
    
    
    if($son==0) return 0;
    

//     if($part[0]=="(" && @$part[$son-2]==")" && @$part[$son-1]=="*"){
    if(sonsuzVarmi($part)){
// 	log1("--*  ".$part."--0");
	return 0; // Minterm 0 karakter
    }
    if($part[0]=="(" && $part[$son-1]==")"){
// 	log1("-()".$part,"blue");
	return strlen($part)-2;
    }
    
//      log1( "-()".$part."--".$son);
    return $son;
    
    
    

//     return 1;


}

function maxHesapla($part){

    GLOBAL $zaman;
    $zaman++;
     if($zaman >=100){
//  	return 0;
     }
    
    $part = parantezSil($part);// ASD
//     log1($part);
//     log1(sonsuzVarmi($part),"red");
    $parts = partToplam($part);
    if($parts!=0){
	return max(maxHesapla($parts[0]) , maxHesapla($parts[1]));
    }
    $parts = partCarpim($part);
    if($parts!=0 && !empty($parts[1]) ){

	return maxHesapla($parts[0]) + maxHesapla($parts[1]);
    }
            
    $son = strlen($part);
    
    
    if($son==0) return 0;
    
//     log1("ulaştı","green");

//     if($part[0]=="(" && @$part[$son-2]==")" && @$part[$son-1]=="*"){
    if(sonsuzVarmi($part)){
//  	log1("--*  ".$part."--999");
	return 999; // Minterm 0 karakter
    }
    if($part[0]=="(" && $part[$son-1]==")"){
//  	log1("-()".$part,"blue");
	return strlen($part)-2;
    }
    
//      log1( "-()".$part."--".$son);
    return $son;
    
    
    

     return 1;


}



// echo minHesapla($RE);
echo "--------------";
// echo maxHesapla($RE);
echo "--------------";
/*
Öncelikle değişim yapılacak;
örneğin a* = (a)*
örneğin (a+b)*  == (a+b)a(a+b)

*/
$re = "(ab+c+de+f(g+h(1+2)))(i+j)+(x+y)(u+t)";
// $re = "(f(g+h))(i+j)";
// $re = "(a+b+d)X(a+c)";



// print_r(partCarpim("X(a+c)"));

// log1( parantezSil("(as+b+d+a(d+g))",0,1) );

$tadet = 3;

if(@$_GET['RE']){
    $re    = $_GET['RE'];
}

if(@$_GET['tadet']){    
    $tadet = $_GET['tadet'];
}

log1($re);

// echo maxHesapla("(a)*(b)");

$dizi =array();
// echo substr("(a)*",0,-1);

// echo minHesapla("(a)*");
f($re,"","",$tadet);
logd("------------------------------------------------");
// f("(a+b)*",""," ",$tadet);
listeyiOku();



$s=0;


function erDonustur($m){
// Bu kısımda ER Dönüşümü yapacağız...



}


function listeyiOku(){
    GLOBAL $dizi;
    GLOBAL $tadet;
//     echo $tadet;
//     echo strlen("aaa");
//     print_r($dizi);
    $dizi1 = array_unique($dizi); // Hazır Kod Aynıları Siliyor !!!.
    foreach($dizi1 as $d){
       if(strlen($d)==$tadet || $tadet == -1)  logd($d,"green");
// 	logd($d,"green");
    }
//      print_r($dizi1);
}



function f($part,$spart,$sozcuk,$adet){
    GLOBAL $s;
    GLOBAL $tadet;
    GLOBAL $dizi;
$a1 = "<div style='border-radius:16px;margin-left:10px;margin-right:10px;display:inline-block;background:black;width:16px;height:16px;text-align:center;color:white;'>+</div>";
$a2 = "<div style='border-radius:16px;margin-left:10px;margin-right:10px;display:inline-block;background:gray;width:16px;height:16px;text-align:center;color:white;'>×</div>";
$a3 = "<div style='border-radius:16px;margin-left:10px;margin-right:10px;display:inline-block;background:green;width:16px;height:16px;text-align:center;color:white;'>»</div>";    
    $s++;
//     if($s>100) return 0;
      $kalan = $tadet - strlen($sozcuk);

    $su="";
    if(sonsuzVarmi($part)){
 	if($spart==""){
	  if(minHesapla(parantezSil($part,1,1))==0) {
	  $adet = $kalan;}else{ $adet = $kalan/ minHesapla(parantezSil($part,1,1));}
	}
	for($j=0;$j<$adet;$j++){
 	    	$su.= substr($part,0,-1);
	}
// 	log1("su :'".$su."'","gray");
// 	$part=$su;
    }      
      
    log1("pa:" . $part. "\tsu:$su \tsp:".$spart ."\tso:".$sozcuk."\tad:$adet \tka:$kalan","gray");
 
//     logd($part,"black");
    
    if($part=="") {
     logd($a3.$sozcuk,"green");
     $dizi[] = $sozcuk;
      return 0;
    }
    

    
        if(sonsuzVarmi($part)){
	  $part =$su;
        }
    
    $part = parantezSil($part,0,1);// ASD
     
    
    $pt = partToplam($part);
    if($pt != 0){
// 	return min(maxHesapla($parts[0]) , maxHesapla($parts[1]));
  	logd($pt[0].$a1.$pt[1]);
	f($pt[0],$spart,$sozcuk,$adet);
	f($pt[1],$spart,$sozcuk,$adet);
	
    }
    
   
    $pc = partCarpim($part);
//     log1($part,"blue");  print_r($pc);
    if($pc !== 0 && $pt==0){
	log1($pc[0].$a2.$pc[1],"#49F");
	if($tadet==-1) f($pc[0],$pc[1] .$spart , $sozcuk,$adet);
    
 if($tadet!=-1){
	if(sonsuzVarmi($pc[0])){
	log1($kalan,"red");
    	for($i=0 ; $i<=$kalan ; $i++){
	    logd($i,"red");
   	    f($pc[0],$pc[1].$spart , $sozcuk,$i);
 	    
 	    if(minHesapla($pc[0])<=$i && $i <= maxHesapla($pc[0])){
	      if(minHesapla($pc[1]) <= ($kalan - $i) && ($kalan - $i) <= maxHesapla($pc[1])){
//  		  f($pc[0],$pc[1].$spart , $sozcuk,$i);
 		  logd("i:$i p0:".$pc[0]." p1:".$pc[1]);
	      }
	    }
  	    
 	}    
	}else{
	    f($pc[0],$pc[1].$spart , $sozcuk,0);
	}
	
    }
    }
    
    if ( $pc == 0 && $pt == 0 ){      
//  	log1($part,"gray");	
        f($spart,"",$sozcuk . $part,0);
    }
    
    
}

function f1($part,$spart,$sozcuk,$adet=0){
    GLOBAL $s;
    GLOBAL $tadet;
    GLOBAL $dizi;
    
    $kalan = $tadet - strlen($sozcuk);
    
$a1 = "<div style='border-radius:16px;margin-left:10px;margin-right:10px;display:inline-block;background:black;width:16px;height:16px;text-align:center;color:white;'>+</div>";
$a2 = "<div style='border-radius:16px;margin-left:10px;margin-right:10px;display:inline-block;background:gray;width:16px;height:16px;text-align:center;color:white;'>×</div>";
$a3 = "<div style='border-radius:16px;margin-left:10px;margin-right:10px;display:inline-block;background:green;width:16px;height:16px;text-align:center;color:white;'>»</div>";    
    $s++;
     if($s>100) return 0; 
//     log1("part:" . $part. " spart:".$spart ." sozcuk:".$sozcuk,"gray");
//     log1($part,"gray");
    
    if($part=="") {
//     logd($a3.$sozcuk,"green");
    $dizi[] = $sozcuk;
    return 0;
    }
    $part = parantezSil($part,1,1);// ASD
     
    $pt = partToplam($part);
    if($pt != 0){
// 	return min(maxHesapla($parts[0]) , maxHesapla($parts[1]));
  	log1($pt[0].$a1.$pt[1]);
	f($pt[0],$spart,$sozcuk,$adet);
	f($pt[1],$spart,$sozcuk,$adet);
	
    }
    
   
    $pc = partCarpim($part);
//     log1($part,"blue");  print_r($pc);
    if($pc !== 0 && $pt==0){
 	log1($pc[0].$a2.$pc[1],"#49F");
 	
 	$ib = minHesapla($pc[0]); 	
	$is = min(maxHesapla($pc[0]),$kalan);

  	log1("a".$adet."b".$ib."s".$is,"orange");
  	log1("sp:".$pc[1] .$spart,"orange");
  	for($i=$ib ; $i-1< $is ; $i++){
	    log1("i:$i","blue");

 	    f($pc[0],$pc[1] .$spart , $sozcuk,$i);
 	}
    }
    
    if ( $pc == 0 && $pt == 0 ){      
//  	log1($part,"gray");	
// 	$soz="";
// 	for($i=0;$i<$adet;$i++) $soz .=$part;
// 	log1($spart);
// 	log1($sozcuk . $soz,"gray");
        f($spart,"",$sozcuk . $part,$tadet-strlen($sozcuk . $part)+1);
    }
    
    
}



function d($part,$spart,$sozcuk,$adet=0,$tadet=4){
    GLOBAL $s;
$a1 = "<div style='border-radius:16px;margin-left:10px;margin-right:10px;display:inline-block;background:black;width:16px;height:16px;text-align:center;color:white;'>+</div>";
$a2 = "<div style='border-radius:16px;margin-left:10px;margin-right:10px;display:inline-block;background:gray;width:16px;height:16px;text-align:center;color:white;'>×</div>";
$a3 = "<div style='border-radius:16px;margin-left:10px;margin-right:10px;display:inline-block;background:green;width:16px;height:16px;text-align:center;color:white;'>»</div>";    
    $s++;
     if($s>100) return 0;

    
    
    if ($adet==0){ return 0; }  // Eğer Harf Girilmesi İstenmezise 
    
    if($part=="") {
    log1($a3.$sozcuk,"green");
    return 0;
    }
    
    log1($part." <× parantez ×>".parantezSil($part,1,1),"gray");
    $part = parantezSil($part,1,1);// ASD
//     log1($part,"blue"); 
    
    
    
    $pt = partToplam($part);
    if($pt != 0){
// 	return min(maxHesapla($parts[0]) , maxHesapla($parts[1]));
  	log1($pt[0].$a1.$pt[1]);
//   	$minus = min(maxHesapla($pt[0]),$adet);
//   	for($i=minHesapla($pt[0]); $i < $minus ;$i++){
	  f($pt[0],$spart,$sozcuk, $adet);
	  f($pt[1],$spart,$sozcuk, $adet);
// 	}
    }
    
   
    $pc = partCarpim($part);
//     log1($part,"blue");  print_r($pc);
    if($pc !== 0 && $pt==0){
 	log1($pc[0].$a2.$pc[1],"#49F");
 	
 	log1("min: ". minHesapla($pc[0]) . " maxH:".maxHesapla($pc[0]) . " adet:" . $adet,"orange");
 	
//  	f($pc[0],$pc[1] .$spart , $sozcuk);
 	
 	
  	$minus = min(maxHesapla($pc[0]),$adet);
  	
  	////
  	for($i=minHesapla($pc[0]); $i-1 < $minus ;$i++){
    	  log1($a2."i ".$i,"orange");
    	  log1($pc[1].$spart,"orange");
    	  
	  f($pc[0],$pc[1].$spart,$sozcuk, $i  );
// 	  f($pc[1],$spart,$sozcuk, $minus-$i);
	}
 	
	
    
    }
    
    if ( $pc == 0 && $pt == 0 ){      
  	log1($part,"purple");	
	if( $adet % strlen($part) == 0){
	    log1($part."s".$sozcuk,"purple");		    
	    $soz = "";
	    for($i = 0; $i< $adet / strlen($part);$i++){
		$soz=$soz.$part;
	    }
	    log1($part."--".$spart."kalan:".($tadet - strlen($sozcuk . $soz)),"red");
	    f($spart,"",$sozcuk . $soz,$tadet - strlen($sozcuk . $soz));
	}
/*
	if( $adet==strlen($part) ){
	    f($spart,"",$sozcuk . $part);
	}else{
	    f($spart,"",$sozcuk . "--");
	}
	*/
    }
    
    
}

// class anahtar{
//   $part;
//   $s
// }

function p($part,$adet,$sozcuk){

    $part = parantezSil($part);// ASD

    
    $parts = partToplam($part);
    if($parts!=0){
	return array(p($parts[0],$adet,$sozcuk),p($parts[1],$adet,$sozcuk));
    }
    $parts = partCarpim($part);
    if($parts!=0){
	$d = array();
	for($i=minHesapla($parts[0]);$i<=$adet;$i++){
	   $d[]=p($parts[0],$i,$sozcuk);
	   $d[]=p($parts[1],$adet - $i,$sozcuk);
	    
// 	    return minHesapla($parts[0]) + minHesapla($parts[1]);
	}
	return $d;
    }
       
    $son = strlen($part);
    
    
    if($son==0) return "";
        
    if($part[0]=="(" && @$part[$son-2]==")" && @$part[$son-1]=="*"){
// 	return 0; // Minterm 0 karakter
// 	if (strlen(parantezSil($part,1))=1){
// 	 echo  parantezSil($part,1);
// 	}elseif (strlen(parantezSil($part,1)) % $adet == 0){
// 	  echo  parantezSil($part,1);
// 	}
	$de="";
	for($i=0;$i<$adet / (strlen(parantezSil($part,1) ));$i++){
	  $de=$de.parantezSil($part,1);
	} 
// 	echo parantezSil($part,1);
	return $de;
    }
    if($part[0]=="(" && $part[$son-1]==")"){
	return parantezSil($part,1);
    }
    
    return $part;
    
    
    
    
    

}








?>


<form>
  <input name="RE" value='<?php  echo $re; ?>'>
  <input name="tadet" value='<?php  echo $tadet; ?>'>
  <button>TIKLA </button>
  </form>
  
  
  (ab)* ler tam çalışmıyor.
