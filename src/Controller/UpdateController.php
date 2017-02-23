<?php
namespace App\Controller;

use Cake\Datasource\ConnectionManager;

class UpdateController extends AppController
{

    public function index() {
        $base_dir = str_replace("webroot", "", getcwd());

        $zip_url = 'https://github.com/gwhitcher/cakecrm/archive/'; //Url to zip
        $zip_name = 'master.zip'; //Zip filename
        $zip_folder = 'CakeCRM-master';
        $zip_dir = $base_dir.'/webroot/'.$zip_name;
        $src_dir = $base_dir.'/.cakecrm'; //Directory for update files

        //Make dir if it doesn't exist already
        if (!file_exists($src_dir)) {
            mkdir($src_dir, 0777, true);
        }

        //Download zip
        $hostfile = fopen($zip_url . $zip_name, 'r');
        $fh = fopen($zip_name, 'w');
        while (!feof($hostfile)) {
            $output = fread($hostfile, 8192);
            fwrite($fh, $output);
        }
        fclose($hostfile);
        fclose($fh);

        //Extract zip
        $zip = new \ZipArchive;
        $res = $zip->open($zip_dir);
        if ($res === TRUE) {
            $zip->extractTo($src_dir);
            $zip->close();
        }

        unlink($zip_dir); //Delete zip
        $this->recursive_copy($src_dir.'/'.$zip_folder.'/',$base_dir); //Copy files
        $this->recursive_delete($src_dir.'/'.$zip_folder); //Delete files

        //Mysql update
        $this->mysql_update();

        $this->Flash->set('CakeCRM updated from GIT repository.',
            ['element' => 'alert-box',
                'params' => [
                    'class' => 'success'
                ]]
        );
        return $this->redirect(['controller' => 'Pages', 'action' => 'display', 'home']);
    }

    public function recursive_copy($src,$dst) {
        $dir = opendir($src);
        @mkdir($dst);
        while(false !== ( $file = readdir($dir)) ) {
            if (( $file != '.' ) && ( $file != '..' )) {
                if ( is_dir($src . '/' . $file) ) {
                    $this->recursive_copy($src . '/' . $file,$dst . '/' . $file);
                }
                else {
                    copy($src . '/' . $file,$dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    }

    public function recursive_delete($dir) {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (is_dir($dir."/".$object))
                        $this->recursive_delete($dir."/".$object);
                    else
                        unlink($dir."/".$object);
                }
            }
            rmdir($dir);
        }
    }

    public function mysql_update() {
        $conn = ConnectionManager::get('default');
        $base_dir = str_replace("webroot", "", getcwd());
        $mysql_dir = $base_dir.'/.cakecrm/mysql'; //DESTINATION TO MYSQL UPDATE FILES
        if (!file_exists($mysql_dir)) {
            mkdir($mysql_dir, 0777, true);
        }
        $mysql_order = 0; //CHANGE TO 1 TO REVERSE ORDER
        $files = array_diff(scandir($mysql_dir, $mysql_order), array(".", ".."));
        foreach ($files as $file) {
            $contents = file_get_contents(''.$mysql_dir.'/'.$file.'');
            $conn->execute($contents);
        }
    }

}