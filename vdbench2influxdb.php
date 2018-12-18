#!/usr/bin/php
<?php
$host = 'localhost';
$port = '8086';
$db = 'g200';

$url = 'http://'.$host.':'.$port.'/write?db='.$db.'&precision=ms';

$tag = isset($argv[2])?$argv[2]:'n/a';
$handle = fopen($argv[1], "r");
$data = "";
$timestamp = 0;

if ($handle) {
    while (($line = fgets($handle)) !== false) {
        $iteration = array_map('trim',explode(" ",$line));
        if (count($iteration) != 35) continue;
        list($tod, $timestamp, $run, $interval, $reqrate, 
        $rate, $mbsec, $bytesio,$readpct,$resp,$read_resp,$write_resp,$resp_max,$read_max,$write_max,$resp_std,$read_std,$write_std,
        $xfersize,$threads,$rdpct,$rhpct,$whpct,$seekpct,$lunsize,$version,$compratio,$dedupratio,$queue_depth,$cpu_used,$cpu_user,$cpu_kernel,$cpu_wait,$cpu_idle) = $iteration;

	$time = preg_replace('/-/',' ',$timestamp);
	$ms = preg_replace('/.*\./','',$tod);
	$timestamp = strtotime($time).$ms;
	$data .= "reqrate,tag=${tag},run=${run} value=".floatval($reqrate)." ".$timestamp."\n";
	$data .= "rate,tag=${tag},run=${run} value=".floatval($rate)." ".$timestamp."\n";
	$data .= "mbsec,tag=${tag},run=${run} value=".floatval($mbsec)." ".$timestamp."\n";
	$data .= "bytesio,tag=${tag},run=${run} value=".floatval($bytesio)." ".$timestamp."\n";
	$data .= "readpct,tag=${tag},run=${run} value=".floatval($readpct)." ".$timestamp."\n";
	$data .= "resp,tag=${tag},run=${run} value=".floatval($resp)." ".$timestamp."\n";
	$data .= "read_resp,tag=${tag},run=${run} value=".floatval($read_resp)." ".$timestamp."\n";
	$data .= "write_resp,tag=${tag},run=${run} value=".floatval($write_resp)." ".$timestamp."\n";
	$data .= "resp_max,tag=${tag},run=${run} value=".floatval($resp_max)." ".$timestamp."\n";
	$data .= "read_max,tag=${tag},run=${run} value=".floatval($read_max)." ".$timestamp."\n";
	$data .= "write_max,tag=${tag},run=${run} value=".floatval($write_max)." ".$timestamp."\n";
	$data .= "resp_std,tag=${tag},run=${run} value=".floatval($resp_std)." ".$timestamp."\n";
	$data .= "read_std,tag=${tag},run=${run} value=".floatval($read_std)." ".$timestamp."\n";
	$data .= "write_std,tag=${tag},run=${run} value=".floatval($write_std)." ".$timestamp."\n";
	$data .= "xfersize,tag=${tag},run=${run} value=".floatval($xfersize)." ".$timestamp."\n";
	$data .= "threads,tag=${tag},run=${run} value=".floatval($threads)." ".$timestamp."\n";
	$data .= "rdpct,tag=${tag},run=${run} value=".floatval($rdpct)." ".$timestamp."\n";
	$data .= "rhpct,tag=${tag},run=${run} value=".floatval($rhpct)." ".$timestamp."\n";
	$data .= "whpct,tag=${tag},run=${run} value=".floatval($whpct)." ".$timestamp."\n";
	$data .= "seekpct,tag=${tag},run=${run} value=".floatval($seekpct)." ".$timestamp."\n";
	$data .= "lunsize,tag=${tag},run=${run} value=".floatval($lunsize)." ".$timestamp."\n";
	$data .= "version,tag=${tag},run=${run} value=".floatval($version)." ".$timestamp."\n";
	$data .= "compratio,tag=${tag},run=${run} value=".floatval($compratio)." ".$timestamp."\n";
	$data .= "dedupratio,tag=${tag},run=${run} value=".floatval($dedupratio)." ".$timestamp."\n";
	$data .= "queue_depth,tag=${tag},run=${run} value=".floatval($queue_depth)." ".$timestamp."\n";
	$data .= "cpu_used,tag=${tag},run=${run} value=".floatval($cpu_used)." ".$timestamp."\n";
	$data .= "cpu_user,tag=${tag},run=${run} value=".floatval($cpu_user)." ".$timestamp."\n";
	$data .= "cpu_kernel,tag=${tag},run=${run} value=".floatval($cpu_kernel)." ".$timestamp."\n";
	$data .= "cpu_wait,tag=${tag},run=${run} value=".floatval($cpu_wait)." ".$timestamp."\n";
	$data .= "cpu_idle,tag=${tag},run=${run} value=".floatval($cpu_idle)." ".$timestamp."\n";
    }
    fclose($handle);

    $options = array(
	'http' => array(
    	    'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
    	    'method'  => 'POST',
    	    'content' => $data
	)
    );
    $context  = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    if ($result === FALSE) { /* Handle error */ };

    var_dump($result);

} else {
    // error opening the file.
} 

?>