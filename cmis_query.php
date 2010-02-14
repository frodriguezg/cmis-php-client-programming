<?php
//  Author: Rich McKnight rich.mcknight@alfresco.com http://oldschooltechie.com
require_once('cmis_repository_wrapper.php');
$repo_url = $_SERVER["argv"][1];
$repo_username = $_SERVER["argv"][2];
$repo_password = $_SERVER["argv"][3];
$repo_debug = $_SERVER["argv"][4];
   
$client=new CMISService($repo_url,$repo_username,$repo_password);

if ($repo_debug) {
	print "Repository Information:\n===========================================\n";
	print_r($client->workspace);
	print "\n===========================================\n\n";
}

$objs=$client->query("select * from cmis:folder");
if ($repo_debug) {
	print "Returned Objects\n:\n===========================================\n";
	print_r($objs);
	print "\n===========================================\n\n";
}

foreach ($objs->objectList as $obj) {
	if ($obj->properties['cmis:baseTypeId'] == "cmis:document") {
		print "Document: " . $obj->properties['cmis:name'] . "\n";
	} elseif ($obj->properties['cmis:baseTypeId'] == "cmis:folder") {
		print "Folder: " . $obj->properties['cmis:name'] . "\n";
	} else {
		print "Unknown Object Type: " . $obj->properties['cmis:name'] . "\n";
	}
}

if ($repo_debug > 2) {
	print "Final State of CLient:\n===========================================\n";
	print_r($client);
}