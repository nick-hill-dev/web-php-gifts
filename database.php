<?

class Database {

	var $connection;
	
	function __construct($config) {
        
        // Create the database if necessary
        $createdDatabase = false;
        if (!file_exists('config.php')) {
            $this->createDatabase($config);
            $createdDatabase = true;
        }
        
        // Connect to the database
		$this->connection = pg_connect('dbname='.pg_escape_string($config['databaseName']).' '.
                                       'user='.pg_escape_string($config['databaseUser']).' '.
                                       'password='.pg_escape_string($config['databasePassword']));
		if (!$this->connection) {
			die('Could not connect to the database.');
		}
        
        // Ensure there is a migration table
        if ($createdDatabase) {
            $this->execute('CREATE TABLE migration (id BIGSERIAL PRIMARY KEY, schema_version INT, migration_date DATE NOT NULL, file_name VARCHAR(250) NOT NULL)');
        }
        
        // Schema migration
        $version = $this->executeScalar('SELECT COALESCE((SELECT schema_version FROM migration ORDER BY schema_version DESC LIMIT 1), 0)');
        foreach (glob('sql/*') as $fileName) {
            $thisVersion = basename($fileName, '.sql');
            if ($version < $thisVersion) {
                $sql = explode("\n", file_get_contents($fileName));
                foreach ($sql as $sqlLine) {
                    $this->execute($sqlLine);
                }
                $this->execute('INSERT INTO migration (schema_version, migration_date, file_name) VALUES ($1, CURRENT_DATE, $2)', array($thisVersion, $fileName));
            }
        }
	}
	
    function createDatabase($connectionInfo) {
        
        // Open a connection to the database server
        $databaseName = $connectionInfo['databaseName'];
        $databaseUser = $connectionInfo['databaseUser']; 
        $databasePassword = $connectionInfo['databasePassword'];
        $log = array();
        $connection = pg_connect('user='.pg_escape_string($databaseUser).' password='.pg_escape_string($databasePassword));
        if (!$connection) {
            die('Could not connect to the database server to create a database.');
        }

        // Does the specified database already exist?
        $result = pg_query($connection, "SELECT 1 AS result FROM pg_database WHERE datname = '".pg_escape_string($databaseName)."'");
        if (!$result) {
            die('Could not check whether or not the database exists.');
        }
        $databaseExists = pg_num_rows($result) > 0;

        // If necessary, create a new empty database (otherwise, we will use the existing one)
        if (!$databaseExists) {
            $result = pg_query($connection, 'CREATE DATABASE '.pg_escape_string($databaseName));
            if (!$result) {
                die('Could not create the '.$databaseName.' database.');
            }
            
        }
        
        // Write config file
        file_put_contents('config.php', '');
    }
    
	function execute($query, $parameters = null) {
		if ($parameters == null) {
		
			// Non prepared query
			$data = pg_query($this->connection, $query);
			if (!$data) {
				die('Could not execute the query: '.$query);
			}
			
		} else {
			
			// Prepared query
			$data = pg_query_params($this->connection, $query, $parameters);
			if (!$data) {
				die('Could not execute a parameterised query: '.$query);
			}
		}
		return $data;
	}
	
	function executeScalar($query, $parameters = null) {
		$result = $this->execute($query, $parameters);
		return pg_fetch_result($result, 0);
	}
	
	function executeSelect($query, $parameters = null, $keyFieldName = null) {
		$data = $this->execute($query, $parameters);
		
		// Fetch results
		$result = array();
		while ($row = pg_fetch_array($data, NULL, PGSQL_ASSOC)) {
            if ($keyFieldName == null) {
                $result[] = $row;
            } else {
                $result[$row[$keyFieldName]] = $row;
            }
		}
		return $result;
	}
	
	function executeSelectSingle($query, $parameters = null) {
		$result = $this->executeSelect($query, $parameters);
        if (count($result) == 0) {
            return null;
        }
		if (count($result) > 1) {
			die('Too many results returned.');
		}
		return $result[0];
	}
	
	function executeStrip($query, $parameters = null) {
        $records = $this->execute($query, $parameters);
        $strip = array();
        for ($i = 0; $i < pg_num_rows($records); $i++) {
            $strip[] = pg_fetch_result($records, $i, 0);
        }
		return $strip;
	}
    
    function executeUpdate($tableName, $updates, $where = array()) {
        
        // Assign field values for the where clause
        $conditions = array();
        $parameters = array();
        $i = 1;
        foreach ($where as $fieldName => $fieldValue) {
            $conditions[] = pg_escape_string($fieldName).' = $'.$i++;
            $parameters[] = $fieldValue;
        }
        
        // Assign replacement field values
        $fragments = array();
        foreach ($updates as $fieldName => $fieldValue) {
            $fragments[] = '"'.pg_escape_string($fieldName).'" = $'.$i++;
            $parameters[] = $fieldValue;
        }
        
        // Build and execute a statement
        if (count($fragments) > 0) {
            $sql = 'UPDATE '.pg_escape_string($tableName).' SET '.implode(', ', $fragments);
            if (count($where) > 0) {
                $sql .= ' WHERE '.implode(' AND ', $conditions);
            }
            $this->execute($sql, $parameters);
        }
    }
    
    function filterArray($data, $keys) {
        $result = array();
        foreach ($keys as $key) {
            if (isset($data[$key])) {
                $result[$key] = $data[$key];
            }
        }
        return $result;
    }
    
    function registerAccount($data) {
        return $this->executeScalar('INSERT INTO account (user_name, email, first_name, last_name, password) VALUES ($1, $2, $3, $4, $5) RETURNING id', array($data['userName'], $data['emailAddress'], $data['firstName'], $data['lastName'], password_hash($data['password'], PASSWORD_DEFAULT)));
    }
    
    function login($data) {
        $details = $this->executeSelectSingle('SELECT id, password FROM account WHERE user_name = $1', array($data['userName']));
        if ($details == null) {
            return null;
        }
        $verified = password_verify($data['password'], $details['password']);
        if (!$verified) {
            return null;
        }
        return array('accountID' => $details['id']);
    }
    
    function getUser($data) {
        if (isset($data['userID'])) {
            return $this->executeSelectSingle('SELECT * FROM account WHERE id = $1', array($data['userID']));
        } else {
            return $this->executeSelectSingle('SELECT * FROM account WHERE user_name = $1', array($data['userName']));
        }
    }
    
    function createList($data) {
        return $this->executeScalar('INSERT INTO list (account_id, name, visibility) VALUES ($1, $2, $3) RETURNING id', array($data['accountID'], $data['name'], $data['visibility']));
    }
    
    function getLists($data) {
        $query = 'SELECT *, (SELECT COUNT(*) FROM list_item WHERE list_item.list_id = list.id) AS gift_count FROM list WHERE account_id = $1';
        $parameters = array($data['accountID']);
        if (isset($data['visibility'])) {
            $query .= ' AND visibility = $2';
            $parameters[] = $data['visibility'];
        }
        $query .= ' ORDER BY id';
        return $this->executeSelect($query, $parameters);
    }
    
    function getGiftPurchases($data) {
        return $this->executeSelect('SELECT A.id AS user_id, A.user_name, A.first_name, A.last_name, G.* FROM list_item_purchase P INNER JOIN list_item G ON G.id = P.gift_id INNER JOIN account A ON A.id = P.account_id WHERE P.gift_id = $1', array($data['giftID']));
    }
    
    function getList($data) {
        $list = $this->executeSelectSingle('SELECT * FROM list WHERE id = $1', array($data['listID']));
        if ($list != null) {
            $list['items'] = $this->executeSelect('SELECT * FROM list_item WHERE list_id = $1 ORDER BY id', array($data['listID']));
            foreach ($list['items'] as &$item) {
                $item['links'] = $this->executeSelect('SELECT * FROM list_item_link WHERE item_id = $1 ORDER BY id', array($item['id']));
                $item['purchases'] = $this->getGiftPurchases(array('giftID' => $item['id']));
            }
        }
        return $list;
    }
    
    function deleteList($data) {
        $this->execute('DELETE FROM list WHERE id = $1', array($data['listID']));
    }
    
    function createGift($data) {
        return $this->executeScalar('INSERT INTO list_item (list_id, title, notes) VALUES ($1, $2, $3) RETURNING id', array($data['listID'], $data['title'], $data['notes']));
    }
    
    function getGift($data) {
        $gift = $this->executeSelectSingle('SELECT * FROM list_item WHERE id = $1', array($data['giftID']));
        if ($gift != null) {
            $gift['links'] = $this->executeSelect('SELECT * FROM list_item_link WHERE item_id = $1 ORDER BY id', array($data['giftID']));
            $gift['purchases'] = $this->getGiftPurchases(array('giftID' => $data['giftID']));
        }
        return $gift;
    }
    
    function createGiftLink($data) {
        return $this->executeScalar('INSERT INTO list_item_link (item_id, page_url, page_title, image_url) VALUES ($1, $2, $3, $4) RETURNING id', array($data['giftID'], $data['pageUrl'], $data['pageTitle'], $data['imageUrl']));
    }
    
    function deleteGiftLink($data) {
        $this->execute('DELETE FROM list_item_link WHERE id = $1', array($data['linkID']));
    }
    
    function deleteGift($data) {
        $this->execute('DELETE FROM list_item WHERE id = $1', array($data['giftID']));
    }
    
    function copyGift($data) {
        $newGiftID = $this->executeScalar('INSERT INTO list_item (list_id, title, notes) SELECT $2, title, notes FROM list_item WHERE id = $1 RETURNING id', array($data['giftID'], $data['listID']));
        $this->execute('INSERT INTO list_item_link (item_id, page_url, page_title, image_url) SELECT $2, page_url, page_title, image_url FROM list_item_link WHERE item_id = $1', array($data['giftID'], $newGiftID));
        return $newGiftID;
    }
    
    function searchForFriends($data) {
        return $this->executeSelect('SELECT * FROM account WHERE (user_name ilike $1 OR first_name ilike $1 OR last_name ilike $1) AND id != $2 ORDER BY last_name, first_name', array($data['term'], $data['userID']));
    }
    
    function addFriendRequest($data) {
        return $this->execute('INSERT INTO friend_request (requesting_friend_id, requested_friend_id) VALUES ($1, $2) RETURNING id', array($data['requestingFriendID'], $data['requestedFriendID']));
    }
    
    function getFriendRequests($data) {
        $forMe = $this->executeSelect('SELECT F.* FROM friend_request R INNER JOIN account F ON F.id = R.requesting_friend_id WHERE R.requested_friend_id = $1', array($data['userID']));
        $forOthers = $this->executeSelect('SELECT F.* FROM friend_request R INNER JOIN account F ON F.id = R.requested_friend_id WHERE R.requesting_friend_id = $1', array($data['userID']));
        return array('forMe' => $forMe, 'forOthers' => $forOthers);
    }
   
    function confirmFriendRequest($data) {
        $this->execute('INSERT INTO friend (account_id, friend_id) VALUES ($1, $2)', array($data['userID'], $data['friendID']));
        $this->execute('INSERT INTO friend (account_id, friend_id) VALUES ($1, $2)', array($data['friendID'], $data['userID']));
    }
    
    function deleteFriendRequest($data) {
        $this->execute('DELETE FROM friend_request WHERE requesting_friend_id = $1 AND requested_friend_id = $2', array($data['userID'], $data['friendID']));
    }
    
    function getFriends($data) {
        $friends = $this->executeSelect('SELECT A.* FROM account A INNER JOIN friend F ON F.friend_id = A.id WHERE F.account_id = $1 ORDER BY A.last_name, A.first_name', array($data['userID']));
        foreach ($friends as &$friend) {
            $friend['lists'] = $this->getLists(array('accountID' => $friend['id'], 'visibility' => 'friends'));
        }
        return $friends;
    }
    
    function unfriend($data) {
        $this->execute('DELETE FROM friend WHERE account_id = $1 AND friend_id = $2', array($data['userID'], $data['friendID']));
    }
    
    function markAsPurchased($data) {
        return $this->execute('INSERT INTO list_item_purchase (gift_id, account_id) VALUES ($1, $2) RETURNING id', array($data['giftID'], $data['userID']));
    }
    
    function markAsUnpurchased($data) {
        $this->execute('DELETE FROM list_item_purchase WHERE gift_id = $1 AND account_id = $2', array($data['giftID'], $data['userID']));
    }
    
    function editList($data) {
        $this->execute('UPDATE list SET name = $2, visibility = $3 WHERE id = $1', array($data['listID'], $data['name'], $data['visibility']));
    }
    
    function editGift($data) {
        $this->execute('UPDATE list_item SET title = $2, notes = $3 WHERE id = $1', array($data['giftID'], $data['title'], $data['notes']));
    }
    
    function createPasswordResetCode($data) {
        $this->execute("INSERT INTO account_reset (account_id, code, expires) VALUES ($1, $2, current_timestamp + interval '1' day)", array($data['userID'], $data['code']));
    }
    
    function getPasswordResetCode($data) {
        return $this->executeScalar('SELECT code FROM account_reset WHERE account_id = $1 AND CURRENT_TIMESTAMP < expires ORDER BY expires DESC LIMIT 1', array($data['userID']));
    }
    
    function changePassword($data) {
        $this->execute('UPDATE account SET password = $2 WHERE id = $1', array($data['userID'], password_hash($data['password'], PASSWORD_DEFAULT)));
    }
    
}

?>