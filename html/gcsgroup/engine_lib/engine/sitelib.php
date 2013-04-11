<?php

/*
 * $Id: sitelib.php,v 1.3 2004/12/26 11:47:28 dave Exp $
 *
 * Site Library Module (sitelib.php)                              **
 *                                                                **
 * Stores common functions using for database access, logging,    **
 * CGI wrapping and so on                                         **
 *
 * $Log: sitelib.php,v $
 * Revision 1.3  2004/12/26 11:47:28  dave
 * Переформатирование кода
 *
 * Revision 1.2  2004/12/20 22:25:10  dave
 * Создано
 *
 */

// Allow only one instance of sitelib
if (!defined('ENGINE_SITELIB_INCLUDED')) {
	define('ENGINE_SITELIB_INCLUDED', true);

	/*
	* ************************ Constants *******************************
	*/
	// Screen logging level:
	// 0 -- No logging output
	// 1 -- Fatal errors
	// 2 -- Warnings
	// 3 -- Messages
	// 4 -- Notices
	// 5 -- Debug stuff
	define("SITELIB_LOG_LEVEL", 2);
	// File logging level (values same as for screen logging level)
	define("SITELIB_LOG_LEVEL_FILE", 0);
	// Error level to terminate execution
	define("SITELIB_EXIT_LEVEL", 1);
	// File name to store debug output
	define("SITELIB_LOG_FILE", "site.log");

	$_sitelib_db_conn = null;
	$_sitelib_db_rs = null;
	$_sitelib_db_num_rows = null;

	/*
	* ************************ Database access (MySQL) *************************
	*/

	/*
	* Connects to the database (using default connection parameters)
	*
	* @return resource
	*/
	function db_connect ()
	{
		// todo: change to CMS configured connection parameters
		global $_sitelib_db_conn;
		if (!is_null($_sitelib_db_conn)) {
			return $_sitelib_db_conn;
		} 
		$_sitelib_db_conn = mysql_connect() or
		loge("Error connecting to MySQL database"); 
		// todo: implement database selection
		return $_sitelib_db_conn;
	} 
	// ___________________________________________________________________________
	/*
	* Executes SELECT statement
	* 
	* @param string $query 
	* @return resource 
	*/
	function db_select ($query)
	{
		global $_sitelib_db_conn;
		global $_sitelib_db_rs;
		global $_sitelib_db_num_rows;
		// Log statement as message
		logm("SQL_SELECT: " . $query); 
		// Perform query on default connection
		if (is_null($_sitelib_db_conn)) {
			$_sitelib_db_rs = mysql_query($query);
		} else {
			$_sitelib_db_rs = mysql_query($query, $_sitelib_db_conn);
		} 
		if ($_sitelib_db_rs === false) {
			// Raise Fatal Error if there was error while performing the query
			loge("SQL error " . mysql_error($_sitelib_db_conn) . " in: $query");
		}
		// Get number of rows affected
		$_sitelib_db_num_rows = mysql_num_rows($_sitelib_db_rs);
		logn("rows affected: " . $_sitelib_db_num_rows);
		return $_sitelib_db_rs;
	} 
	// ___________________________________________________________________________
	/*
	* Executes statement (like INSERT, UPDATE, etc.)
	* Avoid to use this function to INSERT autoincrement fields
	* 
	* @param string $query 
	* @return int 
	*/
	function db_exec ($query)
	{
		global $_sitelib_db_conn;
		global $_sitelib_db_num_rows;
		// Log statement as message
		logm("SQL_EXEC: " . $query); 
		// Perform query on default connection
		if (is_null($_sitelib_db_conn)) {
			$res = mysql_query($query);
		} else {
			$res = mysql_query($query, $_sitelib_db_conn);
		} 
		if ($res === false) {
			// Raise Fatal Error if there was error while performing the query
			loge("SQL error " . mysql_error($_sitelib_db_conn) . " in: $query");
		} 
		// Get number of rows affected
		$_sitelib_db_num_rows = is_null($_sitelib_db_conn) ? mysql_affected_rows() :
		mysql_affected_rows($_sitelib_db_conn);
		logn("rows affected: " . $_sitelib_db_num_rows);
		return $_sitelib_db_num_rows;
	}
	// ___________________________________________________________________________
	/*
	* Executes INSERT statement that returns a new autoincrement id
	* 
	* @return int 
	* @param string $query 
	*/
	function db_insert ($query)
	{ 
		// Log statement as message
		global $_sitelib_db_conn;
		global $_sitelib_db_num_rows;
		logm("SQL_INSERT: " . $query); 
		// Perform query on default connection
		if (is_null($_sitelib_db_conn)) {
			$res = mysql_query($query);
		} else {
			$res = mysql_query($query, $_sitelib_db_conn);
		} 
		if ($res === false) {
			// Raise Fatal Error if there was error while performing the query
			loge("SQL error " . mysql_error($_sitelib_db_conn) . " in: $query");
		} 
		// Return last new autoincrement id
		$id = is_null($_sitelib_db_conn) ? mysql_insert_id() :
		mysql_insert_id($_sitelib_db_conn);
		logn("new INSERT id = " . $id); 
		// Get number of rows affected
		// todo: implement support for BIGINT datatype
		$_sitelib_db_num_rows = is_null($_sitelib_db_conn) ? mysql_affected_rows() :
		mysql_affected_rows($_sitelib_db_conn);
		logn("rows affected: " . $_sitelib_db_num_rows);
		return $id;
	} 
	// ___________________________________________________________________________
	/*
	* Returns number of rous affected by INSERT/UPDATE/DELETE or
	* number of records fetched by SELECT statement
	* 
	* @return int 
	*/
	function db_get_rows_affected()
	{
		global $_sitelib_db_num_rows;
		return $_sitelib_db_num_rows;
	} 
	// ___________________________________________________________________________
	/*
	* Returns last recordset from SELECT statement
	* 
	* @param resource $recordset 
	* @return resource 
	*/
	function db_get_array($recordset = null)
	{
		global $_sitelib_db_rs;
		if (is_null($recordset)) {
			$recordset = $_sitelib_db_rs;
		} 
		return mysql_fetch_array($recordset, MYSQL_BOTH);
	} 
	// ___________________________________________________________________________
	/*
	* Returns quoted string to use in query
	*
	* @param string $string
	* @return string
	*/
	function db_quote($string)
	{
		global $_sitelib_db_conn;
		return is_null($_sitelib_db_conn) ? mysql_real_escape_string($string) :
		mysql_real_escape_string($string, $_sitelib_db_conn);
	}

	// ___________________________________________________________________________
	/*
	* Formats TIMESTAMP field to readable string
	*
	* @param string $string
	* @return string
	*/
	function db_format_timestamp($string)
	{
        if (preg_match("/(\d\d\d\d)(\d\d)(\d\d)(\d\d)(\d\d)(\d\d)/i", trim($string), $match)) {
            return $match[3].'.'.$match[2].'.'.$match[1].'&nbsp;'.$match[4].':'.$match[5].':'.$match[6];
        } else {
            return '';
        }
    }

	// ___________________________________________________________________________
	/*
	* Creates TIMESTAMP value for date
	*
	* @param int $time
	* @return string
	*/
	function db_create_timestamp ($time)
    {
        return date('Ymd000000', $time);
    }

	/*
	* ********************** Server parameters handling ************************
	*/

	/*
	* Get script execution server IP-address
	* 
	* @return string 
	*/
	function get_host_addr()
	{
		return $GLOBALS['SERVER_ADDR'];
	} 

	/*
	* ****************************** Logging ***********************************
	*/

	/*
	* Logs to stdout and log file
	* 
	* @return bool 
	* @param string $message 
	* @param int $level 
	*/
	function log_entry($message, $level = 4)
	{
		if ($level == 0)
			return true;
		if (SITELIB_LOG_LEVEL > 0 && $level <= SITELIB_LOG_LEVEL) {
			// Screen logging
			echo "$message<br><br>\n";
		}
		if (SITELIB_LOG_LEVEL_FILE > 0 && $level <= SITELIB_LOG_LEVEL_FILE) {
			// File logging
			// commented: Apache-style log format
			// $message = get_host_addr().' - - ['.date('j/M/Y G:i:s O]').' - '.$message."\n";
			// custom log format
			$message = date('r') . ' -- ' . $message . "\n";
			if ($level <= SITELIB_EXIT_LEVEL)
				$message .= "\nStop execution\n\n";
			if (!$__fh = @fopen(SITELIB_LOG_FILE, 'a'))
				return false;
			if (@!is_writable(SITELIB_LOG_FILE))
				return false;
			if (@fwrite($__fh, $message) === false)
				return false;
			@fclose($__fh);
		} 
		if ($level <= SITELIB_EXIT_LEVEL)
			die ("<br><br>Terminated.");
		return true;
	} 
	// ___________________________________________________________________________
	/*
	* Logs fatal error
	* 
	* @return bool 
	* @param string $message 
	*/
	function loge($message)
	{
		return log_entry($message, 1);
	} 
	// ___________________________________________________________________________
	/*
	* Logs warning
	* 
	* @return bool 
	* @param string $message 
	*/
	function logw($message)
	{
		return log_entry($message, 2);
	} 
	// ___________________________________________________________________________
	/*
	* Logs message
	* 
	* @return bool 
	* @param string $message 
	*/
	function logm($message)
	{
		return log_entry($message, 3);
	} 
	// ___________________________________________________________________________
	/*
	* Logs notice
	* 
	* @return bool 
	* @param string $message 
	*/
	function logn($message)
	{
		return log_entry($message, 4);
	} 
	// ___________________________________________________________________________
	/*
	* Logs debug message
	* 
	* @return bool 
	* @param string $message 
	*/
	function logd($message)
	{
		return log_entry($message, 5);
	} 
	// ___________________________________________________________________________
	/*
	* Custom logging
	* 
	* @return bool 
	* @param string $message 
	*/
	function log6($message)
	{
		return log_entry($message, 6);
	} 
	// ___________________________________________________________________________
	/*
	* Custom logging
	* 
	* @return bool 
	* @param string $message 
	*/
	function log7($message)
	{
		return log_entry($message, 7);
	} 
	// ___________________________________________________________________________
	/*
	*  Custom logging
	* 
	* @return bool 
	* @param string $message 
	*/
	function log8($message)
	{
		return log_entry($message, 8);
	} 
	// ___________________________________________________________________________
	/*
	* Custom logging
	* 
	* @return bool 
	* @param string $message 
	*/
	function log9 ($message)
	{
		return log_entry($message, 9);
	} 
	// ___________________________________________________________________________
	// Log final message
	//logn("sitelib loaded");
} 

?>