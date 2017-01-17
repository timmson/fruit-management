<?
define('CVS_AUTH_CODES', "0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 114, 120, 53, 79, 96, 109, 72, 108, 70, 64, 76, 67, 116, 74, 68, 87, 111, 52, 75, 119, 49, 34, 82, 81, 95, 65, 112, 86, 118, 110, 122, 105, 41, 57, 83, 43, 46, 102, 40, 89, 38, 103, 45, 50, 42, 123, 91, 35, 125, 55, 54, 66, 124, 126, 59, 47, 92, 71, 115, 78, 88, 107, 106, 56, 36, 121, 117, 104, 101, 100, 69, 73, 99, 63, 94, 93, 39, 37, 61, 48, 58, 113, 32, 90, 44, 98, 60, 51, 33, 97, 62, 77, 84, 80, 85, 223, 225, 216, 187, 166, 229, 189, 222, 188, 141, 249, 148, 200, 184, 136, 248, 190, 199, 170, 181, 204, 138, 232, 218, 183, 255, 234, 220, 247, 213, 203, 226, 193, 174, 172, 228, 252, 217, 201, 131, 230, 197, 211, 145, 238, 161, 179, 160, 212, 207, 221, 254, 173, 202, 146, 224, 151, 140, 196, 205, 130, 135, 133, 143, 246, 192, 159, 244, 239, 185, 168, 215, 144, 139, 165, 180, 157, 147, 186, 214, 176, 227, 231, 219, 169, 175, 156, 206, 198, 129, 164, 150, 210, 154, 177, 134, 127, 182, 128, 158, 208, 162, 132, 167, 209, 149, 241, 153, 251, 237, 236, 171, 195, 243, 233, 253, 240, 194, 250, 191, 155, 142, 137, 245, 235, 163, 242, 178, 152" );
define('CVS_INIT_AUTH',"BEGIN AUTH REQUEST");
define('CVS_END_AUTH',"END AUTH REQUEST");
define('CVS_LOGIN',"I LOVE YOU");
define('CVS_WRONG_PASSWORD',"I HATE YOU");
define('CVS_CHECKOUT',"co");
define('TEXT',-1);
define('NONE',0);
define('HTML',1);
define('NOTHING',0);
define('IN_FILE',1);
define('IN_NAME',2);

define('TMP_FOLDER',1);
define('DST_FOLDER',2);
define('IN_MEMORY',3);

class CVSclient {
/**
 *	Server hostname or ip
 *
 *	@var string
 *	@access private
 */
    var $server;
    /**
     *	User
     *
     *	@var string
     *	@access private
     */
    var $user;
    /**
     *	Password
     *
     *	@var string
     *	@access private
     */
    var $password;
    /**
     *	Port to connect
     *
     *	@var integer
     *	@access private
     */
    var $port;
    /**
     *	Server root directory
     *
     *	@var string
     *	@access private
     */
    var $root;
    /**
     *	Module name
     *
     *	@var string
     *	@access private
     */
    var $module;
    /**
     *	Are we connected to a CVS server?
     *
     *	@var bool
     *	@access private
     */
    var $conected;
    /**
     *	Connection object.
     *
     *	@var resource
     *	@access private
     */
    var $fp;
    /**
     *	Error string
     *
     *	@var string
     *	@access public
     */
    var $errorstr;
    /**
     *	Debug
     *
     *	@var bool
     *	@access private
     */
    var $debug;
    /**
     *	Temporary directory
     *
     *	@var string
     *	@access private
     */
    var $tmp="./";
    /**
     *	Debug in this file.
     *
     *	@var string
     *	@access private
     */
    var $debugfile;

    function __construct($server='',$password='',$module='') {
        $this->setServer($server);
        $this->setPassword($password);
        $this->setModule($module);
    }

    /**
     *	Set password
     *
     *	@param string $password Password
     */
    function setPassword($password) {
        $this->password=$password;
        return true;
    }

    /**
     *	Returns actual password
     *
     *	@return string Password
     */
    function getPassword() {
        return $this->password;
    }

    /**
     *	Set Temporary Directory
     *
     *	In the temporary directory, in previous
     * 	version, it was where the transaction file was
     *	saved.
     *
     *	A transaction file was a file with all the transaction
     *	when on "checkout" for improve performance beacouse most
     *	all repositories are too big to keep on main memory. When
     *	the transactions end, and every file was extracted this file
     *	was deleted.
     *
     *	In this version the "checkout" doesn't use transaction file,
     *	every file was saved into its destiny file, and deleted for
     *	main memory.
     *
     *	@param string $tmp Directory path
     */
    function setTmpDir($tmp) {
        $this->tmp=$tmp;
    }

    /**
     *	Get Temporary Directory
     *	@return string
     */
    function getTmpDir() {
        return $this->tmp;
    }

    /**
     *	Set server
     *
     *	Set a new CVS server to connect.
     *
     *	<code>
     *<?php
     *    include("phpcvsclient.php");
     *    $cvs = new phpCVSclient;
     *    $r=$cvs->setServer("cvsread@cvs.php.net:/repository");
     *    if ( !$r ) die("Invalid server");
     *
     *?>
     *  </code>
     *
     *	@param string $server Server connection
     *	@return bool True if success
     */
    function setServer($server) {
        if ( $server == '') return false;
        $port = 2401;
        $info = parse_url($server);
        $this->server     = $info['host'];
        $this->root       = $info['path'];
        $this->user       = $info['user'];
        $this->port       = isset($info['port']) ? $info['port'] : 2401;
        return true;
    }
    /**
     *	Return server information
     *
     *	@return array
     */
    function getServer() {
        return array('server'=>$this->server,'root'=>$this->root,'user'=>$this->user,'port'=>$this->port);
    }

    /**
     *	Set Module.
     *
     *	@param string $module Module name
     *	@return boolean True if success
     */
    function setModule($module) {
        if ( $module == '') return false;
        $this->module = $module;
        return true;
    }

    /**
     *	Get actual module name
     *
     *	@return string Module name
     */
    function getModule() {
        return $this->module;
    }
    /**
     *	Login into a CVS server
     *
     *	@return boolean True if success
     */
    function login() {
        $this->sendline(CVS_INIT_AUTH);
        $this->sendline($this->root);
        $this->sendline($this->user);
        $this->sendline($this->encode($this->getPassword(),"A") );
        $this->sendline(CVS_END_AUTH);
        $r = $this->readline();
        if ( $r != CVS_LOGIN ) {
            if ( $r == CVS_WRONG_PASSWORD) {
                $this->errorstr = "Bad password";
            } else
                $this->errorstr = $r;
            return false;
        }
        $this->sendline("Root $this->root");
        $this->sendline("gzip-file-contents 6");
        return true;
    }
    /**
     *	Checkout
     *
     *	Checkout a repository and download the head
     *	version to a folder in our hdd
     *
     *	<code>
     *<?php
     *    include("phpcvsclient.php");
     *    $cvs = new phpCVSclient;
     *    $r=$cvs->setServer("cvsread@cvs.php.net:/repository");
     *    if ( !$r ) die("Invalid server");
     *    $foo = $cvs->checkout( array(DST_FOLDER=>"folder-in-hdd/") );
     *	  if ( $foo ) print_r($foo);
     *?>
     *  </code>
     *
     *	@param array $param
     *	@return array with files
     */
    function checkout($param) {
        $folder = isset($param[DST_FOLDER]) ? $param[DST_FOLDER] : false;
        $this->addArgument($this->module);
        $this->sendline(CVS_CHECKOUT);

        $r = $this->processFiles($folder,true);

        return $r;
    }

    /**
     *	Get File Logs
     *
     *	Return an array with the change log.
     *
     *	@param string $file File name
     *	@return array
     */
    function getFileLogs($file) {
        $this->addArgument($this->module."/".$file);
        $this->sendline("rlog");
        $f='';
        while (1) {
            $f.=$this->read(4096);
            $fin = substr($f,-4,4);
            if ($fin  == "\nok\n" || $fin=="*ok\n") break;
        }
        $comments = explode("M ----------------------------\n",$f);
        for($i=1; $i < count($comments);$i++)
            $r[] = $this->parsecomments($comments[$i]);
        return $r;
    }

    /**
     *	Get File Logs
     *
     *	Return an array with the change log.
     *
     *	@return array
     */
    function getModuleLogs() {
        $resultf = "";
            for ($i=0; $i<count($this->module); $i++) {
                $this->addArgument($this->module[$i]);
                $this->sendline("rlog");
                $f='';
                while (1) {
                    $f.=$this->read(4096);
                    $fin = substr($f,-4,4);
                    if ($fin  == "\nok\n" || $fin=="*ok\n") break;
                }
                $resultf.=$f;
            }
            $f = @fopen("cvs1.log", "w");
            $resultf = fwrite($f, $resultf, strlen($resultf));
            fclose($f);
        $comments = explode("M =============================================================================\n", $resultf);
        for($i=1; $i < count($comments)-1;$i++) {
            $current = $this->parsecomments($comments[$i]);
            if ($current!=null) {
                $r[] = $current;
            }
        }
        return $r;
    }




    /**
     *	Parse comments.
     *
     *	@param string $txt Text to parse
     *	@retun array parsed comments
     *	@access private
     */
    function parsecomments($txt) {

        $block = explode("M ----------------------------\n",$txt);

        $tmp = explode("\n",$block[0]);
        $head = array();
        for ($i=0; $i<count($tmp); $i++) {
            if (($tmp[$i]!=null) && ($tmp[$i]!="") && (substr($tmp[$i],0,1)!="E")) {
                $head[]=$tmp[$i];
            }
        }

        for ($i=0; $i<count($head); $i++) {
            if (strpos($head[$i], "M RCS") !==false ) {
                $p = explode("/",$head[$i]);
                $ret['project'] = $p[3];
                $ret['filename'] = substr($head[$i], strpos($head[$i], $p[3]));
            }
        }

        $tmp = explode("\n",$block[1]);
        $last = array();

        for ($i=0; $i<count($tmp); $i++) {
            if (($tmp[$i]!=null) && ($tmp[$i]!="") && (substr($tmp[$i],0,1)!="E")) {
                $last[]=$tmp[$i];
            }
        }
        $start = strpos($last[0],"revision ") + 9;
        $ret['version'] = substr($last[0], $start);

        $start = strpos($last[1],"date: ") + 6;
        $ret['date'] = substr($last[1], $start, strpos($last[1],";",$start)-$start);


        $start = strpos($last[1],"author: ") + 8;
        $ret['author'] = substr($last[1], $start, strpos($last[1],";",$start)-$start);

        $ret['comment'] = substr($last[2], strpos($last[2],"M ") + 2);
        if (strripos($ret['comment'],"WPS-")!==false) {
            $start = strripos($ret['comment'],"WPS-");
            $ret['task'] = strtoupper(substr($ret['comment'], $start, $start+7));
        } else if (strripos($ret['comment'],"WS-")!==false) {
                $start = strripos($ret['comment'],"WS-");
                $ret['task'] = strtoupper(substr($ret['comment'], $start, $start+6));
            } else {
                return null;
            }

        return $ret;
    }
    /**
     *	Process file
     *
     *	Handle the file transaction, and save into hard disk.
     *
     *	@param string $folder Destination folder
     *	@param string $infile If it is false all the file will be saved into main memory
     *	@return array File list and version
     *	@access private
     */
    function processFiles($folder,$infile) {
        $buffer='';
        $files = array();
        $fcnt=0;

        $state = NOTHING;
        while ( $r = $this->read(4096) ) {
            $buffer .= $r;
			/* buffer processing loop */
            while ( $buffer != '') {
                switch ( $state ) {
                    case NOTHING:
                        while ( substr($buffer,0,14) == "E cvs checkout" ) {
                            $i = strpos($buffer,"\n");
                            $buffer = substr($buffer,$i+1);
                        }
                        if ( substr($buffer,0,4) != "M U ")
                            break 2;

                        $fin = substr($buffer,-4,4);
                        if (  $fin== "\nok\n" || $fin=="*ok\n" || substr($buffer,-3,3)=="ok\n") {
                            break 3;
                        }
                        # Split the commands into lines
                        #
                        $f = explode("\n",$buffer,7);

                        if ( count($f) != 7) break 2;

                        $file =  & $files[ $fcnt++ ] ;
                        $name = $f[0];
                        if ( substr($name,0,4) == "M U ")
                            $name = substr($name,4);
                        $name = $folder."/".$name;
                        $file['name'] = $name;
                        $version=explode("/",$f[3]);
                        $file['version'] = $version[2];

                        $file['compressed'] = $f[5][0] == "z";

                        $file['size'] =  $file['compressed'] ? substr($f[5],1) : $f[5];

                        $t  = strlen($f[6]);
                        $read = $file['size'] < $t ? $file['size'] : $t;

                        $content=substr( $f[6],0,$read);
                        if ( $infile ) {
                            $this->makefolder($name);
                            $fpn = fopen($name,"wb");
                            fwrite($fpn, $content);
                        } else {
                            $file['content'] = $content;
                        }
                        $file['missing'] = $file['size'] - strlen($content);
                        $buffer=substr($f[6],$read);
                        if ( $file['missing']>0 ) {
                            $buffer="";
                            $state = IN_FILE;
                        } else {
                            if (  $file['compressed'] ) {
                                if ( $infile ) {
                                    $uncompress=gzinflate( substr(file_get_contents($file['name']),10) );
                                    file_put_contents($file['name'], $uncompress );
                                    $file['size'] = strlen($uncompress);
                                }  else {
                                    $file['content'] = gzinflate( substr($file['content'],10) );
                                    $file['size'] = strlen($file['content']);
                                }
                            }
                            unset($file['missing']);
                            unset($file['compressed']);
                        }
                        break;
                    case IN_FILE:
                        $t = strlen($buffer);
                        $missing = $file['missing'] < $t ? $file['missing'] : $t;
                        $content = substr( $buffer,0,$missing);
                        if ( $infile )
                            fwrite($fpn,$content);
                        else
                            $file['content'] .= $content;
                        $file['missing'] -= $missing;
                        $buffer=substr($buffer,$missing);
                        if (  $file['missing']==0 ) {
                            if ( $infile ) {
                                fclose($fpn);
                            }
                            if (  $file['compressed'] ) {
                                if ( $infile ) {
                                    $uncompress=gzinflate( substr(file_get_contents($file['name']),10) );
                                    file_put_contents($file['name'], $uncompress );
                                    $file['size'] = strlen($uncompress);
                                }  else {
                                    $file['content'] = gzinflate( substr($file['content'],10) );
                                    $file['size'] = strlen($file['content']);
                                }
                            }
                            $state = NOTHING;
                            unset($file['missing']);
                            unset($file['compressed']);
                        }
                        break;
                }
            }
        }


        return $files;
    }

    /**
     *	Add argument.
     *
     *	@access private
     */
    function addArgument($arg) {
        $this->sendline("Argument $arg");
    }

    /**
     *	Connect
     *
     *	@return boolean
     *	@access private
     */
    function connect() {
        $fp = & $this->fp;
        $conected = & $this->conected;
        $errorstr = & $this->errorstr;
        $fp = fsockopen( $this->server, $this->port,$e,$errorstr);
        $conected=true;
        if ( ! $fp ) {
            $conected=false;
        }
        return $conected;
    }
    /**
     *	Return to see if it is connected
     *	@return boolean
     *	@access private
     */
    function isConnected() {
        return $this->conected;
    }

    /**
     *	Disconnect client.
     *
     */
    function disconnect() {
        fclose($this->fp);
        $this->conected=false;
    }

    /**
     *	Send a line to the socket
     *
     *	@param string $txt
     *	@return boolean
     *	@access private
     */
    function sendline($txt) {
        return $this->send($txt."\n");
    }

    /**
     *	Write into socket
     *
     *
     *	@param string $txt
     *	@return boolean
     *	@access private
     */
    function send($txt) {
        if ( !$this->isConnected() ) {
            $f=$this->connect();
            if ( !$f ) return false;
        }
        fwrite($this->fp, $txt);
        $this->debug("C",$txt);
        return true;
    }

    /**
     *	Read one line from socket.
     *
     *	@return string
     *	@access private
     */
    function readline() {
        $f = '';
        while ( $t = $this->read(1024) ) {
            $f .= $t;
            if ( ($i=strpos($f,"\n")) !== false) break;
        }
        $f = substr($f,0,$i);
        return $f;
    }

    /**
     *	Read from socket
     *
     *
     *	@param int $size Bytes to read.
     *	@return string
     *	@access private
     */
    function read($size) {
        if ( !$this->isConnected() ) {
            $f=$this->connect();
            if ( !$f ) return false;
        }
        $t=fread($this->fp,$size);
        $this->debug("S",$t);
        return $t;
    }
    /**
     *	Encode a password
     *
     *	@param string $pass Password
     *	@param string $letter First letter
     * 	@return string encoded password
     *	@access private
     */
    function encode($pass, $letter) {
        $code = explode(", ",CVS_AUTH_CODES);
        $f=$letter;
        for($i=0; $i < strlen($pass); $i++)
            $f .=chr( $code[ ord($pass[$i]) ] );
        return $f;
    }
    /**
     *	Set Debug
     *
     *
     *	@param int $dev NONE, TEXT,HTML
     *	@param boolean|string $file Debug in file.
     */
    function setDebug($dev,$file=false) {
        $this->debug = $dev;
        if ( $file) {
            file_put_contents($file,"");
        }
        $this->debugfile=$file;
    }

    /**
     *	Debug
     *
     *	Debugging information
     *
     *	@param string $whom Which module or function trigger the debbug
     *	@param string $what Debug text
     *	@access private
     */
    function debug($whom,$what) {
        if ( $this->debug == NONE) return;
        $txt = ( $this->debug >= HTML ? nl2br(htmlentities("$whom: ".$what))."<br>" : "$whom: $what" );
        if ( $this->debugfile ) {
            $fp = fopen($this->debugfile,"a");
            fwrite($fp,$txt);
            fclose($fp);
            return;
        }
        echo $txt;
        flush();
    }

    /**
     *	Return temporary name
     *
     *	@access private
     */
    function getTmpName() {
        return tempnam($this->tmp,"phpcvs");
    }

    /**
     *	Create directories recursively
     *
     *	@param string $fname Path
     *	@access private
     */
    function makefolder($fname) {
        $f=explode("/",$fname);
        $acc = '';
        for($i=0; $i < count($f)-1;$i++) {
            $acc.=$f[$i]."/";
            @mkdir($acc);
        }

    }
}

?>
