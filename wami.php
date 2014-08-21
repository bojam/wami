<?php
//获取录音文件路径
function get_wav_path() {
	parse_str($_SERVER['QUERY_STRING'], $params);
	$name = isset($params['name']) ? escapeshellcmd($params['name']) : 'tmp';
	$path = 'temp/'.$name.'.wav';
	return $path;
}

//将音频流生成录音文件
function record() {
	$path = get_wav_path();
	$content = file_get_contents('php://input');
	$fh = fopen($path, 'w') or die("无法打开文件");
	fwrite($fh, $content);
	fclose($fh);
	return $path;
}

//播放录音
function play() {
	$path = get_wav_path();
	$content = file_get_contents($path);
	echo $content;
}

//翻译录音
function translate() {
	$wavPath = get_wav_path();
	if(file_exists($wavPath)){
		//此处调用后端语音识别接口将录音文件翻译成文字再输出
		echo '无语音识别接口，暂时无法识别';
	} else {
		echo '';
	}
}

function main() {
	$action = $_GET['action'];
	eval($action.'();');
}

main();

?>