<?php
function carielemen($array,$elemen){
  $status = false;
  $panjang=sizeof($array);
  for ($n=0; $n<$panjang; $n++){
	  $temp = $array[$n];
	  if ($elemen == $temp){
		  $status = true;
	  }
  }
  return $status;
}

function mutasi($kromosom,$probabilitas){
	$panjangkromosom = sizeof($kromosom[0])-2;
	echo "<br>panjang kromosom = ".$panjangkromosom;
	$jumlahkromosom = sizeof($kromosom);
	echo "<br>jumlah kromosom = ".$jumlahkromosom;
	$jumlahtotalgen = $panjangkromosom * $jumlahkromosom;
	echo "<br>jumlah total gen = ".$jumlahtotalgen;
	echo "<br>probabilitas mutasi = ".$probabilitas;
	$jumlahmutasi = ceil($probabilitas*$jumlahtotalgen);
	echo "<br>jumlah mutasi = ".$jumlahmutasi;
	for($i=0; $i<$jumlahmutasi; $i++){
		if($i==0){
			//jika i=0 langsung dimasukkan ke array
			$mutasi[$i]=rand(1,($jumlahtotalgen));
		}
		else{
			$random=rand(1,($jumlahtotalgen));
			//cek apakah bilangan random sudah ada di array
			$hasil=carielemen($mutasi,$random);
			if($hasil==true){
				$i--;
			}
			else{
				$mutasi[$i]=$random;
			}
		}
	}
	echo "<br>gen yang dimutasi = ";
	for($i=0; $i<$jumlahmutasi; $i++){
		echo "-".$mutasi[$i];
	}
	echo "<br>";
	
	//swap gen
	for($i=0; $i<$jumlahmutasi; $i++){
		$sisa=$mutasi[$i]%$panjangkromosom;
		$posisikromosom = floor($mutasi[$i]/$panjangkromosom);
		echo "<br>Swap ke-".$i."=";
		if($sisa==0){
			echo $kromosom[$posisikromosom-1][$panjangkromosom]."-".$kromosom[$posisikromosom-1][1];
			$temp=$kromosom[$posisikromosom-1][$panjangkromosom];
			$kromosom[$posisikromosom-1][$panjangkromosom] = $kromosom[$posisikromosom-1][1];
			$kromosom[$posisikromosom-1][1]=$temp;
			echo "--".$kromosom[$posisikromosom-1][$panjangkromosom]."-".$kromosom[$posisikromosom-1][1];
		}
		else{
			echo $kromosom[$posisikromosom][$sisa]."-".$kromosom[$posisikromosom][$sisa+1];
			$temp=$kromosom[$posisikromosom][$sisa];
			$kromosom[$posisikromosom][$sisa]=$kromosom[$posisikromosom][$sisa+1];
			$kromosom[$posisikromosom][$sisa+1] = $temp;
			echo "--".$kromosom[$posisikromosom][$sisa]."-".$kromosom[$posisikromosom][$sisa+1];
		}
	}
	return $kromosom;
}

$kromosom = [["A","B","C","D","E","F","A"],["A","F","E","C","B","D","A"],["A","C","F","B","D","E","A"],["A","C","B","F","E","D","A"],["A","C","D","F","B","E","A"]];

//cetak hasil kromosom -----------------------------
echo "Kromosom Awal<br>";
 for ($m=0; $m<5; $m++){
		$panjangbaru= sizeof($kromosom[$m]);
		//echo "<br><br> panjang baru= ".$panjangbaru;
		echo "<br> Kromosom ke-".($m+1)."= ";
		 for ($n=0; $n<$panjangbaru; $n++){
			 echo "-".$kromosom[$m][$n];
	 }
 }

$kromosom=mutasi($kromosom,0.5);

echo "<br><br>Kromosom Setelah Mutasi";
//cetak hasil kromosom -----------------------------
 for ($m=0; $m<5; $m++){
		$panjangbaru = sizeof($kromosom[$m]);
		//echo "<br><br> panjang baru= ".$panjangbaru;
		echo "<br> Kromosom ke-".($m+1)."= ";
		 for ($n=0; $n<$panjangbaru; $n++){
			 echo "-".$kromosom[$m][$n];
	 }
 }

?>
