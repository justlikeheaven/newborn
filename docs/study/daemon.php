<?php

set_time_limit(0);
ini_set("memory_limit", "256M");
$pid = $_REQUEST['pid']; //���������������

$pid_file = "{$pid}.pid"; //���ļ�
$ctrl_file = "{$pid}.ctrl"; //�����ļ�

$idle_interval = 10000000; //���еȴ�ʱ��,΢��

//���н�����������
if (file_exists($pid_file)) {
	//�����ļ����ڻ������ļ�5����δ������
	$stop = file_exists($ctrl_file);
	clearstatcache();
	if ($stop || ($_SERVER['REQUEST_TIME'] - fileatime($pid_file) >= 300)) {
		if ($pid = file_get_contents($pid_file)) {
			if ($stop) {
				@unlink($ctrl_file);
			}
			@unlink($pid_file);
			shell_exec("ps -ef | grep 'm=async&p=stat' | grep '{$pid}' | awk '{print \$2}' | xargs --no-run-if-empty kill"); //��ֹ��ɱ
			$logStr = date('Ymd H:i:s') . ($stop ? " Killed by control file: $pid.ctrl" : " Process has gone away: $pid.pid");
			fc::debug($logStr, 'Async_Call');
		}
	}
}else { //��һ������
	if (!file_put_contents($pid_file, getmypid())) {
		die("Can not create PID file: {$pid_file}");
	}
	$starttime = time();
	
	while (1) {
		if(time() - $starttime >= 3600){ //ÿһСʱ����һ��
			break;
		}
		
		touch($pid_file); //���ڼ�¼�������ʱ��
		// some code
		
	}
}