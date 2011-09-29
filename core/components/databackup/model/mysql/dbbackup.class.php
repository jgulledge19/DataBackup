<?php
/**
 *
 * Use this class to do a backup of your database
 * @author Raul Souza Silva (raul.3k@gmail.com)
 * @category Database
 * @copyright No one. You can copy, edit, do anything you want. If you change anything to better, please let me know.
 * Based From: http://www.phpclasses.org/browse/file/33388.html
 * 
 */
Class DBBackup {
	/**
	 *
	 * The host you will connect
	 * @var String
	 */
	protected $host;
	/**
	 *
	 * The driver you will use to connect
	 * @var String
	 */
	protected $driver;
	/**
	 *
	 * The user you will use to connect to a database
	 * @var String
	 */
	protected $user;
	/**
	 *
	 * The password you will use to connect to a database
	 * @var String
	 */
	protected $password;
	/**
	 *
	 * The database you will use to connect
	 * @var String
	 */
	protected $dbName;
	/**
	 *
	 * String to connect to the database using PDO
	 * @var String
	 */
	protected $dsn;

	/**
	 *
	 * Array with the tables of the database
	 * @var Array
	 */
	protected $tables = array();

	/**
	 *
	 * Hold the connection
	 * @var ObjectConnection
	 */
	protected $handler;
	/**
	 *
	 * Array to hold the errors
	 * @var Array
	 */
	protected $error = array();

	/**
	 *
	 * The result string. String with all queries
	 * @var String
	 */
	protected $final;

    /**
     *
     * Some config options
     * @var Array
     */
    protected $config = array();
    /**
     *
     * To include only these tables 
     * @var Array
     */
    protected $includeTables = array();
    /**
     *
     * True include only these tables, false don't use include 
     * @var boolean
     */
    protected $useIncludeTables = false;
	/**
     *
     * To exclude only these tables 
     * @var Array
     */
    protected $excludeTables = array();
    /**
     *
     * True exclude only these tables, false don't use exclude 
     * @var boolean
     */
    protected $useExcludeTables = false;
    /**
     *
     * List of files that are written, folder => path, database => path, tables => array( names => path) 
     * @var Array
     */
    protected $filePathData = array();
    /**
	 *
	 * The main function
	 * @method DBBackup
	 * @uses Constructor
	 * @param Array $args{host, driver, user, password, database}
	 * @example $db = new DBBackup(array('host'=>'my_host', 'driver'=>'bd_type(mysql)', 'user'=>'db_user', 'password'=>'db_password', 'database'=>'db_name'));
	 */
	public function __construct($modx, $config=array()){
	    $this->modx = $modx;
	    $this->handler = $this->modx->pdo;
        $defaults = array(
                'comment_prefix' => '--',
                'comment_suffix' => '',
                'new_line' => "\n",
                'base_path' => MODX_CORE_PATH.'components/databackup/dumps/',
                'write_file' => true,
                'write_table_files' => true,
                'use_drop' => true,
                'connect' => false,
                'database' => 'modx',
                'create_database' => false,
                'includeTables' => null,
                'excludeTables' => null
            );
            

        $this->config = array_merge( $defaults, $config );
	    if ( isset($this->config['connect']) && $this->config['connect'] ) {
	        
    	    if( empty($this->config['host'])) {
    	        $this->error[] = 'Parameter host missing';
    	    }
    		if( empty($this->config['database'])) {
    		    $this->error[] = 'Parameter database missing';
    		}
    		if(empty($this->config['driver'])) {
    		    $this->error[] = 'Parameter driver missing';
		    }
    		//if(!$this->config['user']) $this->error[] = 'Parameter user missing';
    		//if(!isset($this->config['password'])) $this->error[] = 'Parameter password missing';
    
    		if(count($this->error)>0){
    			return;
    		}
    
    		$this->host = $this->config['host'];
    		$this->driver = $this->config['driver'];
    		$this->user = $this->config['user'];
    		$this->password = $this->config['password'];
    		$this->dbName = $this->config['database'];
    
    		
    		if ( $this->host=='localhost' ) {
    			// We have a little issue in unix systems when you set the host as localhost
    			$this->host = '127.0.0.1';
    		}
    		$this->dsn = $this->driver.':host='.$this->host.';dbname='.$this->dbName;
    
    		$this->_connect();
        } else {
            $this->dbName = $this->config['database'];
        }
        // set the include/exclude if any
        if ( !empty($this->config['includeTables']) ) {
            $this->includeTables = explode(',',$this->config['includeTables']);
            $this->useIncludeTables = true;
        } elseif ( !empty($this->config['excludeTables']) ) {
            $this->excludeTables = explode(',',$this->config['excludeTables']);
            $this->useExcludeTables = true;
        } 
	}

	/**
	 *
	 * Call this function to get the database backup
	 * @example DBBackup::backup();
	 */
	public function backup(){
	    if ( count($this->error) > 0 ){
	        //echo '<br>Error - backup: '.$this->dbName.' L:'.__LINE__;
	        return false;
	    }
        //echo '<br>Database: '.$this->dbName.' L: '.__LINE__;
		$this->_getTables();
		$this->_generate();
		//return $this->final;
		if ( count($this->error)>0 ) {
			return false;//, 'msg'=>$this->error);
		}
		return true;
	}
    /**
     * @description returns the folder/directory path that was created on for the backup files
     * @return string
     */
    public function folderPath() {
        if ( isset($this->filePathData['folder'])) {
            return $this->filePathData['folder'];
        } 
        return null;
    }
    /**
     * @description returns the database file path that was created on for the backup
     * @return string
     */
    public function DBFilePath() {
        if ( isset($this->filePathData['database'])) {
            return $this->filePathData['database'];
        } 
        return null;
    }
    /**
     * @description returns the database table file path that was created on for the backup
     * @param (string) the full table name
     * @return string
     */
    public function tableFilePath($table) {
        if ( isset($this->filePathData['tables'][$table])) {
            return $this->filePathData['tables'][$table];
        } 
        return null;
    }
    /**
     * Get the errors
     * @return string
     */
    public function getErrors(){
        return implode(', ', $this->error);
    }
    /**
     * Purge file records
     * @return void
     */
    public function purge($seconds=1814400){// 21 days is the default
        
        // purge data older then 3 weeks:
        $data_folder = $this->config['base_path'];
        $open_dir = opendir( $data_folder ) ;
        $last_date = time() - $seconds;// 3600*24*21;// 21 days
        
        while ( $tmp_file = readdir( $open_dir ) ) {
            if ( $tmp_file != '.' && $tmp_file != '..' ) {
                # dir
                //echo '<br>Folder: '.$tmp_file;
                if ( is_dir( $data_folder.$tmp_file ) ) {
                    $stats = lstat($data_folder.$tmp_file);
                    if ($stats['ctime'] < $last_date ) {
                        // delete old files
                        //echo ' - DELETE';
                        $this->_rmdir_files($data_folder.$tmp_file.'/');
                    }
                }
                # else files
            }
        }
        closedir($open_dir);
                
    }
    /**
     * Deletes directory files
     * 
     */
    protected function _rmdir_files($dir) {
        foreach( glob( $dir . '*', GLOB_MARK ) as $file) {
        //$open_dir = opendir( $dir ) ;
        //while ( $file = readdir( $open_dir ) ) {
            if (is_dir($file)) {
                $this->_rmdir_files($file."/");
                rmdir($file);
            } elseif( is_file($file) )  {
                //echo '<br> Unlink file: '.$file;
                unlink($file);
            }
        }
        //closedir($dir);
        
        if (is_dir($dir) ){
            if( rmdir( $dir ) ){
                return true;
            }
            return false;
        }
    }
	/**
	 *
	 * Connect to a database
	 * @uses Private use
	 */
	protected function _connect(){
		try {
		    if ( !empty($this->user) ){
		        $this->handler = new PDO($this->dsn, $this->user, $this->password);
		    } else {
		        $this->handler = new PDO($this->dsn);
            }
		} catch (PDOException $e) {
			$this->handler = null;
            //echo '<br>PDO not connected: '.$e->getMessage();
			$this->error[] = $e->getMessage();
			return false;
		}
	}
    /**
	 *
	 * Generate backup string
	 * @uses Private use
	 */
	protected function _generate(){
	    if ( $this->config['create_database'] ) {
	        $this->final = $this->config['comment_prefix'].'CREATING DATABASE '.$tbl['name'].$this->config['comment_suffix'].$this->config['new_line'];
            $this->final .= 'CREATE DATABASE ' . $this->dbName.";".$this->config['new_line'];
            $this->final .= 'USE ' . $this->dbName.';'.$this->config['new_line'].$this->config['new_line'];
        } else {
            $this->final = $this->config['comment_prefix'].'RESTORING TABLES '.$tbl['name'].$this->config['comment_suffix'].$this->config['new_line'];
        }
	    // create base folder - DB_backup_time()
	    if ( $this->config['write_file'] || $this->config['write_table_files'] ) {
	        $dir = $this->config['base_path'].''.$this->dbName.'_'.date('Y_m_d').'__'.time().'/';
            $this->filePathData['folder'] = $dir;
    	    if( !is_dir($dir) ){
                mkdir($dir);
            }
        }
		foreach ($this->tables as $tbl) {
		    $table_sql = $this->config['comment_prefix'].'CREATING TABLE '.$tbl['name'].$this->config['comment_suffix'].$this->config['new_line'];
			$table_sql .= $tbl['create'] . ";".$this->config['new_line'].$this->config['new_line'];
			$table_sql .= $this->config['comment_prefix'].'INSERTING DATA INTO '.$tbl['name'].$this->config['comment_suffix'].$this->config['new_line'];
			$table_sql .= $tbl['data'].$this->config['new_line'].$this->config['new_line'].$this->config['new_line'];
			$this->final .= $table_sql;
            // write table to file
            if ( $this->config['write_table_files'] ) {
                file_put_contents($dir.$tbl['name'].'.sql', $table_sql );
                $this->filePathData['tables'][$tbl['name']] = $dir.$tbl['name'].'.sql';
            }
		}
		$this->final .= $this->config['comment_prefix'].' THE END'.$this->config['new_line'].$this->config['comment_suffix'].$this->config['new_line'];
        if ( $this->config['write_file'] ) {
    	    file_put_contents($dir.'complete_db_backup.sql', $this->final );
            $this->filePathData['database'] = $dir.'complete_db_backup.sql';
	    }
	}
	/**
	 *
	 * Get the list of tables
	 * @uses Private use
	 */
	protected function _getTables(){
		try {
			$stmt = $this->handler->query('SHOW TABLES');
			$tbs = $stmt->fetchAll();
			$i=0;
			foreach($tbs as $table){
			    //echo '<br>Table: '. $table[0];
			    if ( $this->useIncludeTables ) {
			        //echo ' - useIncludes';
			        if ( !in_array($table[0],$this->includeTables)) {
			            //echo ' - exclude me';
			            continue;
			        }
			    } elseif ( $this->useExcludeTables ) {
                    if ( in_array($table[0],$this->excludeTables)) {
                        continue;
                    }
                }
				$this->tables[$i]['name'] = $table[0];
				$this->tables[$i]['create'] = $this->_getColumns($table[0]);
				$this->tables[$i]['data'] = $this->_getData($table[0]);
				$i++;
			}
			unset($stmt);
			unset($tbs);
			unset($i);

			return true;
		} catch (PDOException $e) {
			$this->handler = null;
			$this->error[] = $e->getMessage();
			return false;
		}
	}

	/**
	 *
	 * Get the list of Columns
	 * @uses Private use
	 */
	protected function _getColumns($tableName){
	    // also see: http://www.sitepoint.com/forums/php-application-design-147/pdo-getcolumnmeta-bug-497257.html#post3510380
		try {
		    $sql = '';
		    if ( $this->config['use_drop']) {
                 $sql = 'DROP TABLE IF EXISTS `'.$tableName.'`;'.$this->config['new_line'].$this->config['new_line'];
            }
			$stmt = $this->handler->query('SHOW CREATE TABLE '.$tableName);
			$q = $stmt->fetchAll();
            // reset the auto increment?
			$sql .= preg_replace("/AUTO_INCREMENT=[\w]*./", '', $q[0][1]);
			return $sql;
		} catch (PDOException $e){
			$this->handler = null;
			$this->error[] = $e->getMessage();
			return false;
		}
	}

	/**
	 *
	 * Get the insert data of tables
	 * @uses Private use
	 */
	protected function _getData($tableName){
		try {
			$stmt = $this->handler->query('SELECT * FROM '.$tableName);
			$q = $stmt->fetchAll(PDO::FETCH_NUM);
			$data = '';
			foreach ($q as $pieces){
			    $data .= 'INSERT INTO `'. $tableName .'` VALUES ( ';//.' (\'' . implode('\',\'', $pieces) . '\');'.$this->config['new_line'];
				$str = '';
				foreach($pieces as &$value){
				    // &acirc;€™
					//$value = htmlentities(addslashes($value));
					if ( !empty($str) ){
					    $str .= ', ';
					}
					if ( is_null($value) ) {
					    $str .= 'NULL';
					} else {
                        $str .= '\''.addslashes($value).'\'';
					}
				}
                $data .= $str.');'.$this->config['new_line'];
				//$data .= 'INSERT INTO `'. $tableName .'` VALUES '.( is_null($value)).' (\'' . implode('\',\'', $pieces) . '\');'.$this->config['new_line'];
			}
			return $data;
		} catch (PDOException $e){
			$this->handler = null;
			$this->error[] = $e->getMessage();
			return false;
		}
	}
}
?>