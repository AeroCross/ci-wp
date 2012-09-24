### Instructions:

Just copy the __wp.php__ file into application/models and load it into your controller:

		$this->load->model('wp');

Then you can just use it as a normal Codeigniter model, passing the objects to (or from) the controllers:

```php
<?php
	$this->data->posts = $this->wp->latest(5)->posts()->getAll();
	$this->load->view('blog/posts', $this->data);

	// and then in your view...
	
	foreach($posts as $post): ?>
	
	<h1><?php echo anchor($post->guid, $post->post_title); ?></h1>
	<p><?php echo $post->post_excerpt; ?></p>
	
	<p class="post_meta">	<?php echo $post->post_date; ?></p>

	<?php endforeach; ?>
```

You can also auto-load it editing the appropiate variable inside autoload.php.

If you don't have the __WP\_DATABASE__ constant defined in your __config/constants.php__ file, then you should substitute the __$cdb__ variable with the name of your _database group_ contaning the connection info of your Wordpress installation.