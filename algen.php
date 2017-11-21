<?php

include('config.php'); 





//---------------------------Inisialisasi-----------------------------------------


 //$startakhir = ["R","R"];
 //$kunjungan = ["FEB","FIB"];
 // $jumlahkromosomawal = 10;
 // $probmutasi = 0.3;
 // $probcrossover = 0.8;
 // $generasi = 150;

$query = mysqli_query($dbconnect,"SELECT * FROM variabel_algen WHERE id_variabel=1");
if (!$query) {
  die("Invalid query: " . mysqli_error());
}
else{
	while($row = mysqli_fetch_array($query)) {
		$jumlahkromosomawal = $row['jml_krom_awal'];
		$generasi = $row['jml_generasi'];
		$probmutasi = $row['prob_mutasi'];
		$probcrossover = $row['prob_crossover'];
	}
}

$probmutasi = $probmutasi/100;
$probcrossover = $probcrossover/100;
		

//data titik awal dan tujuan

if (isset($_POST['startakhir']) && isset($_POST['Lewat'])){
	$startakhir=$_POST['startakhir'];
	$kunjungan=$_POST['Lewat'];
	//&& isset($_POST['populasi']) && isset($_POST['generasi'])
	//&& isset($_POST['mutasi']) && isset($_POST['crossover']) ){
	//$jumlahkromosomawal = $_POST['populasi'];
	//$probmutasi = $_POST['mutasi'];
	//$probcrossover = $_POST['crossover'];
	//$generasi = $_POST['generasi']; 
}
//else{
//	echo "Data tidak terikirim";
	
//}
$kromosombaru = array(array()); $kromosom=array(array());
$jumlahkromosom = $jumlahkromosomawal;



//----------------------------------fungsi-fungsi---------------------------------------


function hitungfitness($conn,$array){
	$jumlah=0;
	$panjang = sizeof($array);
	for($n=0; $n<$panjang-1; $n++){
		$awal=$array[$n]; $next=$array[$n+1];
		$query = mysqli_query($conn,"SELECT jarak FROM rute WHERE asal='".$awal."' AND tujuan='".$next."'");
		if (!$query) {
		  die("Invalid query: " . mysqli_error());
		}
		while($row = mysqli_fetch_array($query)) {
				$jarak = $row[0];
				$jumlah=$jumlah+$jarak;
				//echo "<br> jarak=".$jarak;
				//echo "<br> jumlah=".$jumlah;
			}
	}
	$fitness=1/$jumlah;
	//echo "<br><br> fitness=".$fitness;
	return $fitness;
}

function cekprobabilitas($angkarandom,$probabilitas){
	$panjang = sizeof($probabilitas);
	for($n=0; $n<$panjang; $n++){
		if($angkarandom<=$probabilitas[$n]){
			return ($n);
			break;
		}
	}
	
}

function probabilitas_akumulasi($probabilitas){
	$panjang = sizeof($probabilitas);
	for($i=0; $i<$panjang; $i++){
		if($i==0){
			$probakumulasi[$i]=$probabilitas[$i];
		}
		else{
			$probakumulasi[$i]=$probabilitas[$i]+$probakumulasi[$i-1];
		}
		$hasil[$i]=round($probakumulasi[$i]*100);
	}
	return $hasil;
}

function carielemen($array,$elemen){
  $status = false;
  $panjang=sizeof($array);
  for ($n=0; $n<=$panjang-1; $n++){
	  $temp = $array[$n];
	  if ($elemen == $temp){
		  $status = true;
	  }
  }
  return $status;
}

function precrossover($kromosom,$prob){
	//echo "<br>Probabilitas Crossover =".$prob."%";
	$kromcrossover = array();
	$jmlkromosom = sizeof($kromosom);
	$jmlkromcrossover = ceil($prob*$jmlkromosom);
	for($i=0; $i<$jmlkromcrossover; $i++){
		$x = rand(0,($jmlkromosom-1));
		$hasil = carielemen($kromcrossover,$x);
		if($hasil== false){
			$kromcrossover[$i]= $x;
			//echo "<br>i=".$i;
			//echo "<br> Kromosom ke-".($kromcrossover[$i]+1);
		}
		else{
			$i--;
			//echo "<br>i=".$i;
		}	
	}
	if(fmod($jmlkromcrossover,2)==0){
		$hasil=popcrossover($kromosom,$kromcrossover);
	}
	else{
		shuffle($kromcrossover);
		$temp1 = array_pop($kromcrossover);
		$panjang = sizeof($kromcrossover);
		$x = rand(0,($panjang-1));
		$temp2 = $kromcrossover[$x];
		//echo "<br>".($temp1+1)." dan ".($temp2+1);
		$a = $kromosom[$temp1];$b = $kromosom[$temp2];
		$hasil1=crossover($a,$b);
		$hasil2=popcrossover($kromosom,$kromcrossover);
		$x=0;
		for($j=0; $j<2; $j++){
			$hasil[$x]=$hasil1[$j];
			$x++;
		}
		for($j=0; $j<2; $j++){
			$hasil[$x]=$hasil2[$j];
			$x++;
		}
	}
	return $hasil;
	
}

function popcrossover($kromosom,$letakkromosom){
	$panjang = sizeof($letakkromosom);
	for($i=0; $i<$panjang/2; $i++){
			shuffle($letakkromosom);
			$temp1 = array_pop($letakkromosom);
			$temp2 = array_pop($letakkromosom);
			//echo "<br>".($temp1+1)." dan ".($temp2+1);
			$a = $kromosom[$temp1];$b = $kromosom[$temp2];
			$hasil=crossover($a,$b);
		}
	return $hasil;		
}

function crossover($a,$b){
	//global $kromosombaru;
	$hasil = array();
	$random = array();
	//pilih gen acak
	$panjang = sizeof($a);
	$jumlahgencrossover	= rand(2,$panjang-3);
	for($i=0; $i<$jumlahgencrossover; $i++){
		$x = rand(1,$panjang-2);
		$r = sizeof($random);
		if($r==0){
			$random[$i]=$x;
		}
		else{
			$hasil=carielemen($random,$x);
			do{
				$x = rand(1,$panjang-2);
				$hasil=carielemen($random,$x);
			}while($hasil == true);
			$random[$i]=$x;
		}
		$tempa[$i] = $a[$random[$i]];
		$tempb[$i] = $b[$random[$i]];
	}
	$w=0;$v=0;
	for($i=0; $i<$panjang; $i++){
		$x=$b[$i];
		
		$hasila=carielemen($tempa,$x);
		if($hasila==true){
			$childa[$w] = $x;
			$w++;
		}
		$y=$a[$i];
		$hasilb=carielemen($tempb,$y);
		if($hasilb==true){
			$childb[$v] = $y;
			$v++;
		}
	}
	$k=0;
	for($i=0; $i<$panjang; $i++){
			$hasil = carielemen($random,$i);
			if($hasil==true){
				$hasila[$i]=$childa[$k];
				$hasilb[$i]=$childb[$k];
				$k++;
			}
			else{
				$hasila[$i]=$a[$i];
				$hasilb[$i]=$b[$i];
			}
	}
	//$panjangkromosombaru = sizeof($kromosombaru);
	//echo "<br> Panjang Kromosom baru = ".$panjangkromosombaru;
	//$kromosombaru[$panjangkromosombaru]=$hasila;
	//$kromosombaru[$panjangkromosombaru+1]=$hasilb;
	$hasil[0] = $hasila;
	$hasil[1] = $hasilb;
	return $hasil;
}


//fungsi sorting ascending
function my_sort($a,$b)
{
if ($a==$b) return 0;
  return ($a<$b)?-1:1;
}
function mutasi($kromosom,$probabilitas){
	$panjangkromosom = sizeof($kromosom[0])-2;
	//echo "<br>panjang kromosom = ".$panjangkromosom;
	$jumlahkromosom = sizeof($kromosom);
	//echo "<br>jumlah kromosom = ".$jumlahkromosom;
	$jumlahtotalgen = $panjangkromosom * $jumlahkromosom;
	//echo "<br>jumlah total gen = ".$jumlahtotalgen;
	//echo "<br>probabilitas mutasi = ".$probabilitas;
	$jumlahmutasi = ceil($probabilitas*$jumlahtotalgen);
	//echo "<br>jumlah mutasi = ".$jumlahmutasi;
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
	
	//swap gen
	for($i=0; $i<$jumlahmutasi; $i++){
		$sisa=$mutasi[$i]%$panjangkromosom;
		$posisikromosom = floor($mutasi[$i]/$panjangkromosom);
		//echo "<br>Swap ke-".$i."=";
		if($sisa==0){
			//echo $kromosom[$posisikromosom-1][$panjangkromosom]."-".$kromosom[$posisikromosom-1][1];
			$temp=$kromosom[$posisikromosom-1][$panjangkromosom];
			$kromosom[$posisikromosom-1][$panjangkromosom] = $kromosom[$posisikromosom-1][1];
			$kromosom[$posisikromosom-1][1]=$temp;
			//echo "--".$kromosom[$posisikromosom-1][$panjangkromosom]."-".$kromosom[$posisikromosom-1][1];
		}
		else{
			//echo $kromosom[$posisikromosom][$sisa]."-".$kromosom[$posisikromosom][$sisa+1];
			$temp=$kromosom[$posisikromosom][$sisa];
			$kromosom[$posisikromosom][$sisa]=$kromosom[$posisikromosom][$sisa+1];
			$kromosom[$posisikromosom][$sisa+1] = $temp;
			//echo "--".$kromosom[$posisikromosom][$sisa]."-".$kromosom[$posisikromosom][$sisa+1];
		}
	}
	return $kromosom;
}

/*function mutasi($kromosom,$probabilitas){
	$panjangkromosom = sizeof($kromosom[0]);
	$jumlahkromosom = sizeof($kromosom);
	$jumlahmutasi = ceil(($probabilitas/100)*$jumlahkromosom);
	for($i=0; $i<$jumlahmutasi; $i++){
		$mutasi[$i]=rand(0,($jumlahkromosom-1));
		
		//bangkitkan 2 bilangan acak
		$randoma = rand(1,($panjangkromosom-2));
		$randomb = rand(1,($panjangkromosom-2));
		
		//memastikan jika angka ke 2 berbeda
		while($randoma==$randomb){
			$randomb = rand(1,($panjangkromosom-2));
		}
		
		//swap gen
		$temp = $kromosom[$mutasi[$i]][$randoma];
		$kromosom[$mutasi[$i]][$randoma] = $kromosom[$mutasi[$i]][$randomb];
		$kromosom[$mutasi[$i]][$randomb] = $temp;
	}
	return $kromosom;
}*/


//------###################################################################################################################################---------------------------------------------------------------------------------------------------------------------------------------------------------------------------








// -------------main area--------------------

//generate titik awal dan akhir
for ($n=0; $n<$jumlahkromosomawal; $n++){
	$kromosom[$n] = $startakhir;
	//echo "Kromosom ke-".($n+1)." = ";
	// for ($m=0; $m<=1; $m++){
		 // echo $kromosom[$n][$m]." ";
	// }
	//echo"<br>";
}

////pembangkitan populasi awal
$panjangkromosom = sizeof($kunjungan);
for ($n=0; $n<$jumlahkromosomawal; $n++){
	shuffle($kunjungan);
	$temp=0;
	//echo "<br>temp = ",$temp;
	$panjang = sizeof($kromosom[$n]);
	//echo "<br>panjang = ",$panjang;
	$temp = $kromosom[$n][$panjang-1];
	//echo "<br>temp = ", $temp;
	array_pop($kromosom[$n]);
	for ($m=0; $m<=$panjangkromosom-1; $m++){
		array_push($kromosom[$n],$kunjungan[$m]);
	}
	array_push($kromosom[$n],$temp);
}
for($iterasi=1; $iterasi<=$generasi; $iterasi++){
$totalfitness = null;
$probabilitas = array();
$fitness = array();
$probakumulasi = array();
$hasilseleksi= array();
$hasilcrossover = array();
$copyfitness = array();

//echo "---Generasi ke-".$iterasi."---";
//cetak hasil kromosom
/*echo"<br>--Generate Kromosom Awal--<br>"; 
for ($m=0; $m<$jumlahkromosomawal; $m++){
		$panjangbaru= sizeof($kromosom[$m]);
		//echo "<br><br> panjang baru= ".$panjangbaru;
		echo "<br> Kromosom ke-".($m+1)."= ";
		for ($n=0; $n<$panjangbaru; $n++){
			echo "-".$kromosom[$m][$n];
	}
}
echo "<br>";*/

//hitung fitness
for ($m=0; $m<$jumlahkromosomawal; $m++){
		$panjang= sizeof($kromosom[$m]);
		//echo "<br>Kromosom ke-".($m+1);
		$fitness[$m]= hitungfitness($dbconnect,$kromosom[$m]);
		//echo "   fitness=".$fitness[$m];
	}

//hitung total fitness
for ($m=0; $m<$jumlahkromosomawal; $m++){
	$totalfitness=$totalfitness + $fitness[$m];
}
// echo "<br><br> Total Fitness = ".$totalfitness;

// echo "<br>";
//hitung probablitas tiap kromosom
for ($m=0; $m<$jumlahkromosomawal; $m++){
	$panjang= sizeof($kromosom[$m]);
	//echo "<br>Kromosom ke-".($m+1);
	$probabilitas[$m] = $fitness[$m]/$totalfitness;
	//echo "  Probabilitas = ".$probabilitas[$m];
}
$probakumulasi=array(array());
//echo "<br>";
//probabilitas akumulasi
for ($m=0; $m<$jumlahkromosomawal; $m++){
	$panjang= sizeof($kromosom[$m]);
	//echo "<br>Kromosom ke-".($m+1);
	$probakumulasi = probabilitas_akumulasi($probabilitas);
	//echo "  Probabilitas akumulasi= ".$probakumulasi[$m];
}

//echo "<br><br>--Seleksi Roulette Wheel--<br>"; 
//generate angka random untuk seleksi roulette wheel
for ($m=0; $m<$jumlahkromosomawal; $m++){
	$random[$m]=rand(1,$probakumulasi[$jumlahkromosomawal-1]);
	$hasilseleksi[$m]=cekprobabilitas($random[$m],$probakumulasi);
	//echo "<br>".$random[$m]." => Kromosom ".($hasilseleksi[$m]+1); 
}
$kromosombaru= array(array());
//kromosom baru hasil seleksi
for ($n=0; $n<$jumlahkromosomawal; $n++){
	$kromosombaru[$n] = $kromosom[$hasilseleksi[$n]];
}
//unset($kromosom);

 /*echo "<br>";
 //cetak hasil kromosom -----------------------------
 for ($m=0; $m<$jumlahkromosomawal; $m++){
		$panjangbaru= sizeof($kromosombaru[$m]);
		//echo "<br><br> panjang baru= ".$panjangbaru;
		echo "<br> Kromosom ke-".($m+1)."= ";
		 for ($n=0; $n<=$panjangbaru-1; $n++){
			 echo "-".$kromosombaru[$m][$n];
	 }
 }*/
//echo "<br>";


//crossover kromosom hasil seleksi
//echo "<br>--Crossover--<br>";

$hasilcrossover=precrossover($kromosombaru,$probcrossover);
$panjang = sizeof($hasilcrossover);
$panjangbaru = sizeof($kromosombaru);
for($i=0; $i<$panjang; $i++){
	$kromosombaru[$panjangbaru] = $hasilcrossover[$i];
	$panjangbaru++;
}
//echo "<br><br>--Kromosom setelah melalui proses crossover--<br>";

//cetak hasil kromosom --------------------------------
/*$jumlahkromosom = sizeof($kromosombaru);
for ($m=0; $m<$jumlahkromosom; $m++){
		$panjangbaru= sizeof($kromosombaru[$m]);
		//echo "<br><br> panjang baru= ".$panjangbaru;
		echo "<br> Kromosom ke-".($m+1)."= ";
		for ($n=0; $n<=$panjangbaru-1; $n++){
			echo "-".$kromosombaru[$m][$n];
	}
}*/

//mutasi kromosom
$kromosombaru=mutasi($kromosombaru,$probmutasi);
//echo "<br><br>--Mutasi--<br>";

//cetak hasil kromosom 

/*$jumlahkromosom = sizeof($kromosombaru);
for ($m=0; $m<$jumlahkromosom; $m++){
		$panjangbaru= sizeof($kromosombaru[$m]);
		//echo "<br><br> panjang baru= ".$panjangbaru;
		echo "<br> Kromosom ke-".($m+1)."= ";
		for ($n=0; $n<=$panjangbaru-1; $n++){
			echo "-".$kromosombaru[$m][$n];
	}
}*/

//echo "<br>";

//hitung fitness
//echo "<br> Hitung Kembali Fitness";
$jumlahkromosom = sizeof($kromosombaru);
for ($m=0; $m<$jumlahkromosom; $m++){
		//$panjang= sizeof($kromosombaru[$m]);
		//echo "<br>Kromosom ke-".($m+1);
		$fitness[$m]= hitungfitness($dbconnect,$kromosombaru[$m]);
		//echo "   fitness=".$fitness[$m];
	}

	
//ranking kromosom 
$jumlahkromosom = sizeof($kromosombaru);
$copyfitness = $fitness;
arsort($copyfitness);
rsort($fitness);

//echo "<br>";
$m=0;
foreach($copyfitness as $x => $value) {
    //echo "<br>Kromosom ke-" . ($x+1) . " fitness=" . $value;
	$ranking[$m] = $x;
	$m++;
}
$kromosom= array(array());
//echo "<br><br> Hasil ranking fitness";
for($m=0; $m<$jumlahkromosomawal; $m++){
	//echo "<br>Kromosom ke-".($ranking[$m]+1);
	$kromosom[$m]=$kromosombaru[$ranking[$m]];
}
//unset($kromosombaru);

//echo "<br>";
$fitnessterbaik[$iterasi]=$fitness[0];
$solusi[$iterasi]=$kromosom[0];
//echo "<br>Fitness Terbaik ke-".$iterasi." = ".$fitnessterbaik[$iterasi];
//echo "<br> Kromosom Terbaik ke-".$iterasi." = ";
$jumlahgen=sizeof($kromosom[0]);
for($i=0; $i<$jumlahgen; $i++){
//	echo "-".$kromosom[0][$i];
}
//echo "<br>";

}

$copyfitnessterbaik = $fitnessterbaik;
arsort($copyfitnessterbaik);
$m=0;
foreach($copyfitnessterbaik as $x => $value) {
    //echo "<br>Kromosom ke-" . ($x+1) . " fitness=" . $value;
	$rankingterbaik[$m] = $x;
	$m++;
}
$iterasihasilterbaik = $rankingterbaik[0];

//echo "<br>Solusi Terbaik adalah iterasi ke-".$iterasihasilterbaik."";
$hasilakhir = $solusi[$iterasihasilterbaik];


$arrayResult = array();

$sizeHasilAkhir = sizeof($hasilakhir);
$sizeHasilAkhir = $sizeHasilAkhir-1;


for ($i=0; $i < $sizeHasilAkhir ; $i++) { 

	$resultRute = getRute($dbconnect,$hasilakhir[$i], $hasilakhir[$i+1]);

	$od = $hasilakhir[$i]." - ".$hasilakhir[$i+1];
	$odpisah[0] = $hasilakhir[$i];
	$odpisah[1] = $hasilakhir[$i+1];
	$resultPerRute = array("od" => $od, "rute" => $resultRute, "odpisah" => $odpisah, "rutefull" => $hasilakhir);

	$arrayResult[$i] = $resultPerRute;
	
}


echo json_encode($arrayResult);







function getRute($koneksi,$origin, $destination){

	$query = mysqli_query($koneksi, "SELECT rute FROM rute WHERE asal='".$origin."' AND tujuan='".$destination."'");
	if (!$query) {
	  die("Invalid query: " . mysqli_error());
	}
	while($row = mysqli_fetch_array($query)) {
		$rute=$row['rute'];
	}

	$rute = explode(",", $rute);

	$new_rute = '';
	foreach ($rute as $key => $value) {
		if(($key % 2) == 0 ){

			$new_rute = $new_rute.''.$value.',';

		}else{

			$new_rute = $new_rute.''.$value.';';

		}
	}

	$new_rute= rtrim($new_rute, ";");
	return $new_rute;
}

?>

  
