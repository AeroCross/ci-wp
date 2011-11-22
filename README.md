# ci-wp

Small and simple Codeigniter model that serves as an interface for Wordpress. It performs basic operations such as getting an users information, getting the latest posts or retrieving comments or categories.

### Requirements

- [Codeigniter 2.1](http://codeigniter.com) - tested with the latest commit of the develop branch as of 21/11/2011.
- [Wordpress 3.1](http://wordpress.org) - database only. You don't actually _need_ the application, but it will make a lot easier to post stuff into the database through it.

It might be backwards compatible with previous versions of Wordpress and Codeigniter.

### To-do's:

1. Add full CRUD functionality
2. Add getComments, getPage, and getTags

### Instructions:

Just copy the __wp.php__ file into application/models and load it into your controller:

		$this->load->model('wp.php');

Then you can just use it as a normal Codeigniter model, passing the objects to (or from) the controllers:

```php
<?php
	$data['posts'] = $this->wp->getLatestPosts(5);
	$this->load->view('blog/posts', $data);

	// and then in your view...
	
	foreach($posts->result() as $post): ?>
	
	<h1><?php echo anchor($post->guid, $post->post_title); ?></h1>
	<p><?php echo $post->post_excerpt; ?></p>
	
	<p class="post_meta">	<?php echo $post->post_date; ?></p>

	<?php endforeach; ?>
```

You can also auto-load it editing the appropiate variable inside autoload.php.

If you don't have the __WP\_DATABASE__ constant defined in your __config/constants.php__ file, then you should substitute the __$cdb__ variable with the name of your _database group_ contaning the connection info of your Wordpress installation.

#### Curent methods (as of 21/11/2011):

- getLatestPosts
- getPost
- getTotalComments
- getPostMeta
- getCategories
- getUserData