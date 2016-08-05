<?php
namespace framework;

// 多库访问
// @TODO: 读写分离
// @TODO: 分库分表
class MysqlDao
{
    private static $pool = array();
    private static $conf = array();
    private static $conn = NULL;

    public static function init($conf)
    {
    	if (!empty($conf)) 
    	{	
    		self::$conf = $conf;
    	}
    }
    
    public static function __callStatic($func, $args)
    {
    	// 访问限制
		static $allowed_methods = array(
			'getAll' => true, 'getOne' => true, 'delete' => true, 'insert' => true, 'update' => true,
			'begin' => true, 'commit' => true, 'rollback' => true, 'execute' => true
		);
		if (empty($allowed_methods[$func]))
		{
		    Logger::error("method $func not allowed");
		    return false;
		}

		$method = "_" . $func;
		if (!method_exists(__CLASS__, $method))
		{
		    Logger::error("method $method not exists");
		    return false;
		}

    	// 创建连接
    	$db_name = isset(static::$db) ? static::$db : 'default';
		if (!isset(self::$pool[$db_name]))
		{   
		    try
		    {
		    	if (!isset(self::$conf[$db_name]))
				{
					Logger::error("$db_name config not found");
					return false;
				}
				$conf = self::$conf[$db_name];
				$dsn = 'mysql:host='.$conf['host'].';port='.$conf['port'].';dbname='.$conf['dbname'].';charset='.$conf['charset'];
				$username = $conf['username'];
				$password = $conf['password'];
				$opts = array(
				    \PDO::ATTR_TIMEOUT => 5, // 5秒钟超时
				    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION // 出错抛异常
				);
				// 连接mysql
				self::$pool[$db_name] = new \PDO($dsn, $username, $password, $opts);
		    }
		    catch (\Exception $e)
		    {
				Logger::error("connect mysql failed, due to: $e");
				return false;
		    }
		}

		try
		{
			self::$conn = self::$pool[$db_name];
		    $ret = call_user_func_array("self::$method", $args);
		    return $ret;
		}
		catch (\Exception $e)
		{
			Logger::error("error occurred while calling $func, error: $e, args: ".json_encode(func_get_args()));
		}
		return false;
    }

    private static function _begin()
    {
    	return self::$conn->beginTransaction();
    }

    private static function _commit()
    {
    	return self::$conn->commit();
    }

    private static function _rollback()
    {
    	return self::$conn->rollBack();
    }

    private static function _execute($sql, $params)
    {
		$stmt = self::$conn->prepare($sql);
		$ret = $stmt->execute($params);
		if (false === $ret)
		{
			Logger::error(__FUNCTION__.' failed, args: ' . json_encode(func_get_args()));
			return false;
		}
		return $stmt;
    }

    // @TODO: 支持join、or等更多操作
    private static function _getAll($condition)
    {
		$params = array();

		$field = '*';
		if (!empty($condition['field']))
		{
		    $field = $condition['field'];
		}

		$tmp_table = empty($condition['table']) ? '' : $condition['table'];
		$table = self::_getTable($tmp_table);
	    
		$where = "";
		if (!empty($condition["where"]))
		{
		    $tmp_where = self::_buildWhere($condition["where"], $params);
		    $where = "where " . implode(" and ", $tmp_where);
		}
		
		$sort = "";
		if (!empty($condition["sort"]))
		{
		    foreach ($condition["sort"] as $tmp_field => $asc)
		    {
				$asc = $asc == 1 ? " asc " : " desc ";
				$tmp_sort[] = $tmp_field . $asc;
		    }
		    $sort = "order by " . implode(",", $tmp_sort);
		}
	    
		$limit = "";
		if (!empty($condition["limit"]))
		{
		    if (is_numeric($condition["limit"]))
		    {
				$limit = "limit " . (int)$condition["limit"];
		    }
		    elseif (strpos($condition["limit"], ",") === false)
		    {
				list($start, $length) = explode(",", $condition["limit"]);
				$limit = "limit " . (int)$start . "," . (int)$length;
		    }
		}
			
		$sql = implode(" ", array_filter(array(
		    'select',
		    $field,
		    'from',
		    $table,
		    $where,
		    $sort,
		    $limit
		)));
		
		Logger::debug("sql: $sql");
		$stmt = self::_execute($sql, $params);

		if (false === $stmt)
		{
		    Logger::error(__FUNCTION__.' failed, args: ' . json_encode(func_get_args()));
		    return false;
		}
		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    private static function _buildWhere($condition, &$params)
    {
		$ret = array();	
		foreach ($condition as $field => $value)
		{
		    if (is_scalar($value))
		    {
				$ret[] = $field . "= ?";
				$params[] = $value;
		    }
		    elseif (is_array($value))
		    {
				foreach ($value as $op => $tmp_value)
				{
				    $ret[] = $field . " " . $op . " ?";
				    $params[] = $tmp_value; 
				}
		    }
		}
		return $ret;
    }

    private static function _getOne($condition)
    {
		$ret = self::_getAll($condition);
		if (is_array($ret))
		{
		    return isset($ret[0]) ? $ret[0] : array();
		}
		Logger::error(__FUNCTION__.' failed, args: ' . json_encode(func_get_args()));
		return false;
	}

    private static function _update($condition, $data, $table = '')
    {
		$columns = array();
		$params = array();
		foreach ($data as $field => $value)
		{
		    $columns[] = "`" . $field . "` = ?";
		    $params[] = $value;
		}

		$columns = implode(",", $columns);
		$where = self::_buildWhere($condition, $params);
		$sql = implode(" ", array(
		    "update",
		    self::_getTable($table),
		    "set",
		    $columns,
		    $where,
		));

		Logger::debug("update sql: $sql");
		$ret = self::_execute($sql, $params);

		if (false === $ret)
		{
		    Logger::error(__FUNCTION__." failed, args: " . json_encode(func_get_args()));
		    return false;
		}
		return $ret->rowCount();
    }

    private static function _insert($data, $table = '')
    {
		$columns = array();
		$params = array();
		foreach ($data as $field => $value)
		{
		    $columns[] = "`" . $field . "` = ?";
		    $params[] = $value;
		}

		$columns = implode(",", $params);
		$sql = implode(" ", array(
		    "insert",
		    self::_getTable($table),
		    "set",
		    $columns,
		));

		Logger::debug("insert sql: $sql");
		$ret = self::_execute($sql, $params);

		if (false === $ret)
		{
		    Logger::error(__FUNCTION__." failed, args: " . json_encode(func_get_args()));
		    return false;
		}
		return self::$conn->lastInsertId(); // 如果表格没有自增ID，这里会返回什么？
    }

    private static function _delete($condition, $table = '')
    {
		$params = array();
		$where = self::_buildWhere($condition['where'], $params);
		
		$table = $condition['table'];
		$sql = implode(" ", array(
		    "delete from",
		    self::_getTable($table),
		    $where,
		));	

		Logger::debug($sql);
		$ret = self::_execute($sql, $params);
		
		if (false === $ret)
		{
		    Logger::error(__FUNCTION__." failed, args: " . json_encode(func_get_args()));
		    return false;
		}
		return $ret->rowCount();
    }

    private static function _getTable($table = '')
    {
    	if (!empty($table))
    	{
    		return $table;
    	}
    	if (isset(static::$table))
    	{
    		return static::$table;
    	}
    	$class_name = get_called_class();
    	return strtolower(substr($class_name, 0, -3));
    }
}
MysqlDao::init(ConfigManager::get('mysql'));
