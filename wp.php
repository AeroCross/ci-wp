<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* WordPress model for Codeigniter
*
* This class adds interaction to the website and a WordPress database.
* Contains common operations such as fetch posts, comments, and the modification of such.
*
* This library shouldn't have any dependencies other than a correctly formed WordPress database - not even the actual WordPress installation.
*
* @author	Mario Cuba <mario@mariocuba.net>
* @see		http://mariocuba.net, http://github.com/AeroCross
*/
class Wp extends CI_Model {	
	// the name of the WordPress database to use
	private $cdb = WP_DATABASE;
	
	function __construct() {
		parent::__construct();
		
		// load the database
		$this->cdb = $this->load->database($this->cdb, TRUE);
	}
	
	/*
	 * method getLatestPosts($amount, [$fields]) - fetches the last $amount posts from Wordpress.
	 *
	 * Fetches the last $amount posts from Wordpress, with the $fields data.
	 *
	 * @param int[$amount] - the number of posts to fetch.
	 * @param array[$fields] - the database fields to fetch. Must be named correctly after Wordpress-based databases.  
	 *
	 * @return object - a Codeigniter MySQL Object containing the $fields data. FALSE if there are no records.
	 * @author Mario Cuba <mario@mariocuba.net>
	 *
	 * @since 23/09/2011
	 *
	 */
	 
	function getLatestPosts($amount, $fields = array('ID', 'post_title', 'post_date', 'guid')) {
		$fields = implode(', ', $fields);
		
		$this->cdb
		->select($fields)
		->where('post_type', 'post')
		->where('post_status', 'publish')
		->order_by('post_date', 'desc');
		
		$sql = $this->cdb->get('posts', $amount);
		
		if ($sql->num_rows() > 0) {
			return $sql;
		} else {
			return FALSE;
		}
	}
	
	/*
 	* method getPost($id, $fields) - fetches a single post from the database.
 	*
 	* This method gets $fields from the post $id from the database, and returns the whole row if the data was found - false otherwise.
 	*
 	* @param int[$id] - the post to fetch.
 	* @param array[$fields] - the database fields to fetch.
 	*
 	* @return object - a MySQL object with the $id post. 
 	* @author Mario Cuba <mario@mariocuba.net>
 	*
 	* @since  21/11/2011 
 	*
 	*/
	
	function getPost($id, $fields = array('ID', 'post_title', 'post_content', 'post_date', 'guid', 'post_author')) {
		$this->cdb
		->select($fields)
		->where('ID', $id)
		->where('post_type', 'post')
		->where('post_status', 'publish')
		->limit(1);
		
		$sql = $this->cdb->get('posts');
		
		if ($sql->num_rows() > 0) {
			$sql = $sql->row();
			
			return $sql;
		} else {
			return FALSE;
		}
	}
	
	
	/*
 	* method getTotalComments($id) - calculates the amount of comments of a single post.
 	*
 	* @param int[$id] - the post used to calculate comments.
 	* @return int - the number of comments.
 	*
 	* @author Mario Cuba <mario@mariocuba.net>
 	* @since  21/11/2011
 	*
 	*/
 	
	function getTotalComments($id) {
		$this->cdb
		->select('comment_ID')
		->from('comments')
		->where('comment_post_ID', $id);
		
		return $this->cdb->get()->num_rows();
	}
	
	/*
 	* method getPostMeta($key, $post) - fetches the meta information of a post.
 	*
 	* This method will get the meta information string from a post, matching $key.
 	* The meta information of a post is a special value that must be set apart from the regular post information.
 	*
 	* @param string[$key] - the meta key that holds the info
 	* @param int[$post] - the post to fetch the meta info.
 	*
 	* @return object - a MySQL object with the meta post. 
 	* @author Mario Cuba <mario@mariocuba.net>
 	*
 	* @since  21/11/2011 
 	*
 	*/
 	
	function getPostMeta($key, $post) {
		$this->cdb
		->select('meta_value')
		->where('meta_key', $key)
		->where('post_id', $post);
		
		$sql = $this->cdb->get('postmeta');
		
		if ($sql->num_rows() > 0) {
			$sql = $sql->row();
			return $sql->meta_value;
		} else {
			return FALSE;
		}
	}
	
	/*
 	* method getCategories($order) - gets the list of categories.
 	*
 	* @param string[$order] - the database column to order by. It takes a "table.column" string (usually form the terms table")
 	* @return object - a MySQL object with the list of categories.
	*
 	* @author Mario Cuba <mario@mariocuba.net>
 	* @since  21/11/2011 
 	*
 	* @todo: Code an easier way to order the result set.
 	*
 	*/
 	
	function getCategories($order = 'terms.term_id') {
		$this->cdb
		->select('name', 'slug')
		->from('terms')
		->join('term_taxonomy', 'terms.term_id = term_taxonomy.term_id')
		->where('taxonomy', 'category')
		->order_by($order);
		
		$sql = $this->cdb->get();
		
		if ($sql->num_rows() > 0) {
			return $sql;
		} else {
			return FALSE;
		}
	}
	
	/*
 	* method getUserData($id, $fields) - fetches the user information from the database.
 	*
 	* @param int[$id] - the user id.
 	* @param array[$fields] - the database fields to fetch.
 	*
 	* @return object - a MySQL object with the user information. 
 	* @author Mario Cuba <mario@mariocuba.net>
 	*
 	* @since  21/11/2011 
 	*
 	*/
 	
	function getUserData($id, $fields = array('user_login', 'user_nicename', 'user_email', 'display_name', 'user_url')) {
		$this->cdb
		->select($fields)
		->where('ID', $id)
		->limit(1);
		
		$sql = $this->cdb->get('users');
		
		if ($sql->num_rows() > 0) {
			$sql = $sql->row();
			return $sql;
		} else {
			return FALSE;
		}
	}
}