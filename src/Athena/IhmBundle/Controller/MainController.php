<?php

namespace Athena\IhmBundle\Controller;

use Athena\IhmBundle\Entity\Save;
use Athena\IhmBundle\Entity\Conf;
use Athena\IhmBundle\Form\ConfType;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\Process\Process;

use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\RedirectResponse;



////////////////////////////////////////////////////
use Symfony\Component\HttpFoundation\Session\Session;


class MainController extends Controller {

	public function saveStateAction() {

		$manager = $this->getDoctrine()->getManager();

		$saves = $manager->getRepository('AthenaIhmBundle:Save')->weekSaves();

		if (null === $saves) {
			throw new NotFoundHttpException("Le jour demandé n'existe pas");
		}

		return $this->render('AthenaIhmBundle:Main:save.html.twig', array('Saves' => $saves));
	}

	public function indexAction(Request $request) {
		if ($this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
			return $this->render('AthenaIhmBundle:Main:index.html.twig');
		}

		$authenticationUtils = $this->container->get('security.authentication_utils');

		return $this->render('AthenaUserBundle:Security:login.html.twig', array(
			'last_username' => $authenticationUtils->getLastUsername(),
			'error'         => $authenticationUtils->getLastAuthenticationError(),
		));
	}

	public function	freqAction() {

		$FlagM = new Process('ls /home/athena/Core/flags | grep "PS-001"');
		$FlagHi = new Process('ls /home/athena/Core/flags | grep "PS-003"');
		$FlagHf = new Process('ls /home/athena/Core/flags | grep "PS-002"');
		$FlagJ = new Process('ls /home/athena/Core/flags | grep "PS-004"');
		$FlagSQL = new Process('ls /home/athena/Core/flags | grep "PS-005"');
		$FlagEx = new Process('ls /home/athena/Core/flags | grep "EX-000"');
		$FlagDP = new Process('ls /home/athena/Core/flags | grep "PS-000"');

		$FlagM->run();
		$FlagHi->run();
		$FlagHf->run();
		$FlagJ->run();
		$FlagSQL->run();
		$FlagEx->run();
		$FlagDP->run();

		$resM = $FlagM->getOutput();
		$resHi = $FlagHi->getOutput();
		$resHf = $FlagHf->getOutput();
		$resJ = $FlagJ->getOutput();
		$resSQL = $FlagSQL->getOutput();
		$resEx = $FlagEx->getOutput();
		$resDP = $FlagDP->getOutput();

		return $this->render('AthenaIhmBundle:Main:freq.html.twig', 
								array(
										'FlagM' => $resM,
										'FlagHi' => $resHi,
										'FlagHf' => $resHf,
										'FlagJ' => $resJ,
										'FlagSQL' => $resSQL,
										'FlagEx' => $resEx,
										'FlagDP' => $resDP))
		;


	}

	public function excepAction() {
		$FlagDP = new Process('ls /home/athena/Core/flags | grep "PS-000"');
		$FlagEx = new Process('ls /home/athena/Core/flags | grep "EX-000"');
		$FlagDP->run();
		$FlagEx->run();
		$resDP = $FlagDP->getOutput();
		$resEx = $FlagEx->getOutput();

		return $this->render('AthenaIhmBundle:Main:excep.html.twig', 
									array(
										'FlagDP' => $resDP,
										'FlagEx' => $resEx))
			;

	}

	public function getExcepAction() {
		$cmd = new Process('mv /home/athena/Core/flags/block/EX-000 /home/athena/Core/flags/');
		$cmd->run();


		if (!$cmd->isSuccessful()) {
			throw new ProcessFailedException($cmd);
		}

		return $this->redirectToRoute('athena_freq');

	}

	public function includeAction() {

		$MenInc = file_get_contents('/home/athena/Core/listSave/ListSaveMen');
		$HebInc = file_get_contents('/home/athena/Core/listSave/ListSaveHeb');

		return $this->render('AthenaIhmBundle:Main:include.html.twig', array("includeMenContent" => $MenInc, "includeHebContent" => $HebInc));
	}

	public function excludeAction() {

		$MenExc = file_get_contents('/home/athena/Core/excludeSave/ListExcludeMen');
		$HebExc = file_get_contents('/home/athena/Core/excludeSave/ListExcludeHeb');

		return $this->render('AthenaIhmBundle:Main:exclude.html.twig', array("excludeMenContent" => $MenExc, "excludeHebContent" => $HebExc));
	}

	public function setIncludeAction(Request $request) {

		if ($request->query->get('InMen')) {
			$IncMen = $request->query->get('InMen');
			$ArrayIncMen = explode("\n", $IncMen);
			$IncMenFile = fopen("/home/athena/Core/listSave/ListSaveMen", 'w+');

			foreach ($ArrayIncMen as $line) {
				fputs($IncMenFile, $line);
			}
			$Sed = new Process('sed \'s/\s\+/\n/g\' /home/athena/Core/listSave/ListSaveMen > /home/athena/Core/listSave/ListSaveMentmp');
			$Sed->run();
			$Mv = new Process('mv /home/athena/Core/listSave/ListSaveMentmp /home/athena/Core/listSave/ListSaveMen');
			$Mv->run();
		}

		if ($request->query->get('InHeb')) {
			$IncHeb = $request->query->get('InHeb');
			$ArrayIncHeb = explode("\n", $IncHeb);
			$IncHebFile = fopen("/home/athena/Core/listSave/ListSaveHeb", 'w+');

			foreach ($ArrayIncHeb as $line) {
				fputs($IncHebFile, $line);
			}
			$Sed = new Process('sed \'s/\s\+/\n/g\' /home/athena/Core/listSave/ListSaveHeb > /home/athena/Core/listSave/ListSaveHebtmp');
			$Sed->run();
			$Mv = new Process('mv /home/athena/Core/listSave/ListSaveHebtmp /home/athena/Core/listSave/ListSaveHeb');
			$Mv->run();
		}

		return $this->redirectToRoute('athena_include');
	}

	public function setExcludeAction(Request $request) {

		if ($request->query->get('ExMen')) {
			$ExMen = $request->query->get('ExMen');
			$ArrayExMen = explode("\n", $ExMen);
			$ExMenFile = fopen("/home/athena/Core/excludeSave/ListExcludeMen", 'w+');

			foreach ($ArrayExMen as $line) {
				fputs($ExMenFile, $line);
			}
			$Sed = new Process('sed \'s/\s\+/\n/g\' /home/athena/Core/excludeSave/ListExcludeMen > /home/athena/Core/excludeSave/ListExcludeMentmp');
			$Sed->run();
			$Mv = new Process('mv /home/athena/Core/excludeSave/ListExcludeMentmp /home/athena/Core/excludeSave/ListExcludeMen');
			$Mv->run();
		}

		if ($request->query->get('ExHeb')) {
			$ExHeb = $request->query->get('ExHeb');
			$ArrayExHeb = explode("\n", $ExHeb);
			$ExHebFile = fopen("/home/athena/Core/excludeSave/ListExcludeHeb", 'w+');

			foreach ($ArrayExHeb as $line) {
				fputs($ExHebFile, $line);
			}
			$Sed = new Process('sed \'s/\s\+/\n/g\' /home/athena/Core/excludeSave/ListExcludeHeb > /home/athena/Core/excludeSave/ListExcludeHebtmp');
			$Sed->run();
			$Mv = new Process('mv /home/athena/Core/excludeSave/ListExcludeHebtmp /home/athena/Core/excludeSave/ListExcludeHeb');
			$Mv->run();
		}

		return $this->redirectToRoute('athena_exclude');
	}

	public function paramAction() {
		$FlagM = new Process('ls /home/athena/Core/flags | grep "PS-001"');
		$FlagHi = new Process('ls /home/athena/Core/flags | grep "PS-003"');
		$FlagHf = new Process('ls /home/athena/Core/flags | grep "PS-002"');
		$FlagJ = new Process('ls /home/athena/Core/flags | grep "PS-004"');
		$FlagSQL = new Process('ls /home/athena/Core/flags | grep "PS-005"');
		$FlagEx = new Process('ls /home/athena/Core/flags | grep "EX-000"');
		$FlagDP = new Process('ls /home/athena/Core/flags | grep "PS-000"');

		$FlagM->run();
		$FlagHi->run();
		$FlagHf->run();
		$FlagJ->run();
		$FlagSQL->run();
		$FlagEx->run();
		$FlagDP->run();

		$resM = $FlagM->getOutput();
		$resHi = $FlagHi->getOutput();
		$resHf = $FlagHf->getOutput();
		$resJ = $FlagJ->getOutput();
		$resSQL = $FlagSQL->getOutput();
		$resEx = $FlagEx->getOutput();
		$resDP = $FlagDP->getOutput();

		return $this->render('AthenaIhmBundle:Main:param.html.twig', 
								array(
										'FlagM' => $resM,
										'FlagHi' => $resHi,
										'FlagHf' => $resHf,
										'FlagJ' => $resJ,
										'FlagSQL' => $resSQL,
										'FlagEx' => $resEx,
										'FlagDP' => $resDP))
		;
	}

	public function upDownAction(Request $request) {

		if (isset($_GET['UpSave'])){
			$cmd = new Process('mv /home/athena/Core/flags/PS-000 /home/athena/Core/flags/block/');
		}
		elseif (isset($_GET['DownSave'])){
			$cmd = new Process('mv /home/athena/Core/flags/block/PS-000 /home/athena/Core/flags/');
			$cmd2 = new Process('mv /home/athena/Core/flags/* /home/athena/Core/flags/block/');
			$cmd2->run();
		}

		$cmd->run();

		return $this->redirectToRoute('athena_freq');
	}

	public function setParamAction(Request $request) {

		if ($request->query->get('SaveM')) {
			$cmdM = new Process('mv /home/athena/Core/flags/PS-001 /home/athena/Core/flags/block/');
		}
		else{
			$cmdM = new Process('mv /home/athena/Core/flags/block/PS-001 /home/athena/Core/flags/');
		}

	if ($request->query->get('SaveHi')) {
			$cmdHi = new Process('mv /home/athena/Core/flags/PS-003 /home/athena/Core/flags/block/');
		}
		else{
			$cmdHi = new Process('mv /home/athena/Core/flags/block/PS-003 /home/athena/Core/flags/');
		}

		if ($request->query->get('SaveHf')) {
			$cmdHf = new Process('mv /home/athena/Core/flags/PS-002 /home/athena/Core/flags/block/');
		}
		else{
			$cmdHf = new Process('mv /home/athena/Core/flags/block/PS-002 /home/athena/Core/flags/');
		}

		if ($request->query->get('SaveJ')) {
			$cmdJ = new Process('mv /home/athena/Core/flags/PS-004 /home/athena/Core/flags/block/');
		}
		else{
			$cmdJ = new Process('mv /home/athena/Core/flags/block/PS-004 /home/athena/Core/flags/');
		}

		$cmdM->run();
		$cmdHi->run();
		$cmdHf->run();
		$cmdJ->run();

		return $this->redirectToRoute('athena_freq');
	}

	public function restoAction() {

		return $this->render('AthenaIhmBundle:Main:resto.html.twig', array (
			'serviceIndispo' => "La fonctionnalité de restaurationest actuellement en cours de refonte et indisponible. Nous nous excusons de la gêne occasionnée",
		));

	}

	public function restaurationAction(Request $request) {
/*
		$session = new Session();

		$manager = $this->getDoctrine()->getManager();

		if (empty($request->request->get('TargetDate'))) {
			$message = "Merci de choisir une date avec le calendrier";
			$session->getFlashBag()->add('notice', $message);
			return $this->render('AthenaIhmBundle:Main:resto.html.twig');
		}

		$Target = date("Y-m-d", strtotime($request->request->get('TargetDate')));
		$Now = date("Y-m-d");

		if ($Target > $Now) {
			$message = "Une erreur c'est produite : la sauvegarde choisie n'est pas encore passée";
		}
		else {
			
			$date = explode("-", $Target);
			$res = $manager->getRepository('AthenaIhmBundle:Save')->targetResto($date[1], $date[2]);
			$res = $res[0]['displayState'];
			if($res != "OK"){
						$message = "La sauvegarde cible n'est pas exploitable, car à l'état $res. Merci d'en choisir une autre";
					}
					else{
						var_dump($Target);
						$cmd = new Process("sudo -u athena /bin/bash /var/www/html/web/file/scripts_sh/ask_backup.sh $Target");
					}
		}
		$session->getFlashBag()->add('notice', $message);
		return $this->render('AthenaIhmBundle:Main:resto.html.twig');
*/
#		$manager = $this->getDoctrine()->getManager();

#		$saves = $manager->getRepository('AthenaIhmBundle:Save')->weekSaves();

#		$array = array_keys($_POST);

#		$Tar=exec('ls -ltr /var/www/html/web/file/resto/tarball | tail -n1 | head -n1 | rev | cut -d' ' -f1 | rev ');

#		foreach ($array as $line) {
#			$line=$file = str_replace("\r", "", $line);
#			$cmd = "sudo -u athena /bin/bash /var/www/html/web/file/scripts_sh/restauration.sh \"$Tar\" \"$line\"";
#			exec ($cmd.' 2>&1', $out);
#		}

#		exec('rm /var/www/html/web/file/resto/tarball/'.$Tar, $out);
#		echo '<script type="text/javascript">window.alert("La restauration est terminée, merci de vérifier les données");</script>';
#		header('Refresh: 0; url=../index.php?Cat=1');
		return $this->redirectToRoute('athena_resto');
	}

	public function importAction(Request $request) {

		return $this->redirectToRoute('athena_upload');

	}

	public function exportAction() {

		$AthenaFile = "/var/www/html/Athena/web/file/webacces/download/Athena.conf";

		$Athena = fopen($AthenaFile, 'w+');
		fputs($Athena, "[Flag]".chr(13).chr(13));

		if (empty(exec('ls /home/athena/Core/flags/ | grep -v -E "block"'))){
			fputs($Athena, "	[block]".chr(13).chr(13));
			fputs($Athena, "		All".chr(13).chr(13));
			fputs($Athena, "	[/block]".chr(13).chr(13));
		}
		else{
		fputs($Athena, "	[block]".chr(13));

		$List_Block = scandir('/home/athena/Core/flags/block');
		foreach ($List_Block as $Flag) {
			if ($Flag != "." && $Flag != "..")
			{
				fputs($Athena, "		$Flag".chr(13));
			}
		}
		fputs($Athena, "	[/block]".chr(13).chr(13));

		$List_NoBlock = scandir('/home/athena/Core/flags');
		foreach ($List_NoBlock as $Flag) {
			if ($Flag != "." && $Flag != ".." && $Flag != "block")
				{
					fputs($Athena, "	$Flag".chr(13));
				}
			}
		}
		fputs($Athena, chr(13)."[/Flag]");
		fclose($Athena);

		self::CryptConf($AthenaFile);

		return $this->render('AthenaIhmBundle:Main:export.html.twig');



	}

	public function downloadAction() {
		$AthenaFile = "/var/www/html/Athena/web/file/webacces/download/Athena.conf";
		$response = new BinaryFileResponse($AthenaFile);
		$response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT);
		return $response;
		$cmd = new Process('rm '.$AthenaFile);
		$cmd->run();
	}

	public function uploadAction(Request $request) {

		$conf = new Conf();
		$cmd = new Process('sudo -u athena /bin/bash /var/www/html/Athena/web/file/scripts_sh/update_conf.sh');

		$form = $this->createForm(ConfType::class, $conf);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			/** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
			$file = $conf->getConf();

			$fileName = "Athena.conf";

			$file->move(
				$this->getParameter('conf_directory'),
				$fileName
			);

			$conf->setConf($fileName);

			self::UnCryptConf($this->getParameter('conf_directory').$fileName);
			$cmd2 = new Process('chmod 777 '.$this->getParameter('conf_directory').$fileName);
			$cmd2->run();
			$cmd->run();

		}

		return $this->render('AthenaIhmBundle:Main:import.html.twig', array(
			'form' => $form->createView(),
			));

		
	}

	private function CryptConf($filename) {
		if (file_exists($filename)) {

			# --- CHIFFREMENT ---

			$AthenaKeyFile = "/var/www/html/Athena/web/file/secure/Athena.key";

			if (!file_exists($AthenaKeyFile)) {
				$rand1=rand(0, 100);
				$rand2=rand(0, 100);

				$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
				$charactersLength = strlen($characters);
				$passphrase = '';
				for ($i = 0; $i < 10; $i++) {
					$passphrase .= $characters[rand(0, $charactersLength - 1)];
				}

				$key = substr(md5("$rand1".$passphrase, true).md5("$rand2".$passphrase, true), 0, 24);
				$AthenaKey = fopen($AthenaKeyFile, 'w+');
				fputs($AthenaKey, $key);
			} else {
				$AthenaKey = fopen($AthenaKeyFile, 'r');
				$key = fgets($AthenaKey);
			}

			fclose($AthenaKey);

			$AthenaIvFile = "/var/www/html/Athena/web/file/secure/Athena.size";

			if (!file_exists($AthenaIvFile)) {
				$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
				$AthenaIvSize = fopen("$AthenaIvFile", 'w+');
				fputs($AthenaIvSize, $iv_size);

			} else {
				$AthenaIvSize = fopen($AthenaIvFile, 'r');
				$iv_size = fgets($AthenaIvSize);
			}
			
			$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
			fclose($AthenaIvSize);

			$AthenaConf = fopen($filename, 'r');
			$plaintext = file_get_contents($filename);
			fclose($AthenaConf);

			$ciphertext = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $plaintext, MCRYPT_MODE_CBC, $iv);
			$ciphertext = $iv . $ciphertext;
			$ciphertext_base64 = base64_encode($ciphertext);

			$AthenaConf = fopen($filename, 'w+');
			fputs($AthenaConf, $ciphertext_base64);
			fclose($AthenaConf);
		}
	}

	private function UnCryptConf($filename) {

		if (file_exists($filename)) {

			$AthenaKey = fopen("/var/www/html/Athena/web/file/secure/Athena.key", 'r');
			$key = fgets($AthenaKey);
			fclose($AthenaKey);

			$AthenaIvSize = fopen("/var/www/html/Athena/web/file/secure/Athena.size", 'r');
			$iv_size = fgets($AthenaIvSize);
			fclose($AthenaIvSize);
			
			# --- DECHIFFREMENT ---
			
			$AthenaConf = fopen($filename, 'r');
			$ciphertext_dec = base64_decode(fgets($AthenaConf));  
			fclose($AthenaConf);

			$iv_dec = substr($ciphertext_dec, 0, $iv_size);

			$ciphertext_dec = substr($ciphertext_dec, $iv_size);

			$plaintext_dec = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $ciphertext_dec, MCRYPT_MODE_CBC, $iv_dec);
			
			$AthenaConf = fopen($filename, 'w+');
			fputs($AthenaConf, $plaintext_dec);
			fclose($AthenaConf);

			return $this->redirectToRoute('athena_freq');
		}

	}
}
