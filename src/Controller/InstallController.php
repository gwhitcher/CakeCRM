<?php
namespace App\Controller;

use Cake\Datasource\ConnectionManager;
use Cake\Event\Event;
use Cake\Auth\DefaultPasswordHasher;

class InstallController extends AppController {

    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        /* AUTHENTICATION */
        $this->Auth->allow([
            'index'
        ]);
    }

    public function index() {

        if ($this->request->is(['post', 'put'])) {
            $connection = ConnectionManager::get('default');
            
            $sql_clients = "CREATE TABLE IF NOT EXISTS clients(
								id INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT,
								title VARCHAR( 255 ) NOT NULL,
								address TEXT NOT NULL,
								body TEXT NOT NULL,
								PRIMARY KEY (id)
								)";
            $connection->query($sql_clients);

            $sql_invoices = "CREATE TABLE IF NOT EXISTS invoices(
								id INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT,
								client_id INT( 11 ) NOT NULL,
								i_date DATETIME NOT NULL,
								notes TEXT NOT NULL,
								status INT( 11 ) NOT NULL,
								PRIMARY KEY (id)
								)";
            $connection->query($sql_invoices);

            $sql_invoiceitems = "CREATE TABLE IF NOT EXISTS invoice_items(
								id INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT,
								invoice_id INT( 11 ) NOT NULL,
								body TEXT NOT NULL,
								time_billed VARCHAR( 255 ) NOT NULL,
								time_rate VARCHAR( 255 ) NOT NULL,
								PRIMARY KEY (id)
								)";
            $connection->query($sql_invoiceitems);

            $sql_users = "CREATE TABLE IF NOT EXISTS users(
								id INT( 11 ) UNSIGNED NOT NULL AUTO_INCREMENT,
								name VARCHAR( 255 ) NOT NULL,
								username VARCHAR( 255 ) NOT NULL,
								password VARCHAR( 255 ) NOT NULL,
								role VARCHAR( 255 ) NOT NULL,
								PRIMARY KEY (id)
								)";
            $connection->query($sql_users);

            $name = $this->request->data['name'];
            $username = $this->request->data['username'];
            $password_hash = new DefaultPasswordHasher;
            $password = $password_hash->hash($this->request->data['password']);
            $role = 'admin';
            $sql_insert_user = "INSERT INTO users (id, name, username, password, role) VALUES (NULL, '".$name."', '".$username."', '".$password."', '".$role."');";
            $connection->query($sql_insert_user);

            $this->Flash->set(SITE_TITLE.' has been installed.  Please delete "/src/InstallController.php" for your security.',
                ['element' => 'alert-box',
                    'params' => [
                        'class' => 'success'
                    ]]
            );
            return $this->redirect(['controller' => 'Pages', 'action' => 'display', 'home']);
        }
    }
}