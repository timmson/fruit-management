<?
class NTLMStream {
    private $path;
    private $mode;
    private $options;
    private $opened_path;
    private $buffer;
    private $pos;
    private $debug=false;
    protected $user = 'svc_jiraautobuild';
    protected $password = '/xmV*%eS;d';


    /**
     * Open the stream
     *
     * @param unknown_type $path
     * @param unknown_type $mode
     * @param unknown_type $options
     * @param unknown_type $opened_path
     * @return unknown
     */
    public function stream_open($path, $mode, $options, $opened_path) {
        if ($this->debug) {
            echo "[NTLMStream::stream_open] $path , mode=$mode \n";
        }
        $this->path = $path;
        $this->mode = $mode;
        $this->options = $options;
        $this->opened_path = $opened_path;

        $this->createBuffer($path);

        return true;
    }

    /**
     * Close the stream
     *
     */
    public function stream_close() {
        if ($this->debug) {
            echo "[NTLMStream::stream_close] \n";
        }
        curl_close($this->ch);
    }

    /**
     * Read the stream
     *
     * @param int $count number of bytes to read
     * @return content from pos to count
     */
    public function stream_read($count) {
        if ($this->debug) {
            echo "[NTLMStream::stream_read] $count \n";
        }
        if(strlen($this->buffer) == 0) {
            return false;
        }

        $read = substr($this->buffer,$this->pos, $count);

        $this->pos += $count;

        return $read;
    }
    /**
     * write the stream
     *
     * @param int $count number of bytes to read
     * @return content from pos to count
     */
    public function stream_write($data) {
        if ($this->debug) {
            echo "[NTLMStream::stream_write] \n";
        }
        if(strlen($this->buffer) == 0) {
            return false;
        }
        return true;
    }


    /**
     *
     * @return true if eof else false
     */
    public function stream_eof() {
        if ($this->debug) {
            echo "[NTLMStream::stream_eof] ";
        }

        if($this->pos > strlen($this->buffer)) {
            if ($this->debug) {
                echo "true \n";
            }
            return true;
        }

       if ($this->debug) {
           echo "false \n";
       }
        return false;
    }

    /**
     * @return int the position of the current read pointer
     */
    public function stream_tell() {
        if ($this->debug) {
            echo "[NTLMStream::stream_tell] \n";
        }
        return $this->pos;
    }

    /**
     * Flush stream data
     */
    public function stream_flush() {
        if ($this->debug) {
            echo "[NTLMStream::stream_flush] \n";
        }
        $this->buffer = null;
        $this->pos = null;
    }

    /**
     * Stat the file, return only the size of the buffer
     *
     * @return array stat information
     */
    public function stream_stat() {
        if ($this->debug) {
            echo "[NTLMStream::stream_stat] \n";
        }

        $this->createBuffer($this->path);
        $stat = array(
            'size' => strlen($this->buffer),
        );

        return $stat;
    }
    /**
     * Stat the url, return only the size of the buffer
     *
     * @return array stat information
     */
    public function url_stat($path, $flags) {
        if ($this->debug) {
            echo "[NTLMStream::url_stat] \n";
        }
        $this->createBuffer($path);
        $stat = array(
            'size' => strlen($this->buffer),
        );

        return $stat;
    }

    /**
     * Create the buffer by requesting the url through cURL
     *
     * @param unknown_type $path
     */
    private function createBuffer($path) {
        if($this->buffer) {
            return;
        }

        if ($this->debug) {
            echo "[NTLMStream::createBuffer] create buffer from : $path\n";
        }
        $this->ch = curl_init($path);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($this->ch, CURLOPT_HTTPAUTH, CURLAUTH_NTLM);
        curl_setopt($this->ch, CURLOPT_USERPWD, $this->user.':'.$this->password);
        $this->buffer = curl_exec($this->ch);
        
        if ($this->debug) {
            echo $str;
        }

        if ($this->debug) {
            echo "[NTLMStream::createBuffer] buffer size : ".strlen($this->buffer)."bytes\n";
        }
        $this->pos = 0;

    }
}
?>