Reviews module
==============

This module allows you to manage feedback from your visitors on your site. In order to start using it, you need to create a static page and lead its controller to `Reviews:Reviews@showAction`. Then inside a template you'd have two variables `$reviews` and `$paginator`. First variable is an array of entities, and the second is an instance of paginator. Each review's entity has the following methods:

# getTimestamp()

Returns UNIX timestamp of creation

# getName()

Returns a name of reviewer

# getEmail()

Returns an email of reviewer

# getContent()

Returns a message of reviewer

# Example: Rendering reviews

    <?php if (!empty($reviews)): ?>
    <?php foreach ($reviews as $review): ?>
    
    <h2><?php echo $review->getName(); ?> / <?php echo $review->getEmail(); ?></h2>
    <article><?php echo $review->getContent(); ?>
    
    <?php endforeach; ?>
    <?php endif; ?>

# Form

For your users, you would want to display a form that sends a data. The form itself typically looks like this:

    <form class="form-horizontal" method="POST">
      <fieldset>
    	<legend><?php $this->show('Leave your review'); ?></legend>
    	
    	<div class="form-group">
    	  <label for="inputName" class="col-lg-2 control-label"><?php $this->show('Name'); ?></label>
    	  <div class="col-lg-10">
    		<input type="text" class="form-control" name="name" id="inputName" placeholder="<?php $this->show('Type your name'); ?>" />
    	  </div>
    	</div>
    	
    	<div class="form-group">
    	  <label for="inputEmail" class="col-lg-2 control-label"><?php $this->show('Email'); ?></label>
    	  <div class="col-lg-10">
    		<input class="form-control" name="email" id="inputEmail" placeholder="<?php $this->show('Type your email here. It will never be shown'); ?>" />
    	  </div>
    	</div>
    
    	<div class="form-group">
    	  <label for="inputReview" class="col-lg-2 control-label"><?php $this->show('Review'); ?></label>
    	  <div class="col-lg-10">
    		<textarea class="form-control" name="review" id="inputReview" placeholder="<?php $this->show('Type your review here'); ?>"></textarea>
    	  </div>
    	</div>
    	
    	<div class="form-group">
    		<label for="inputCaptcha" class="col-lg-3 control-label"></label>
    		<div class="col-lg-9">
    			<a href="#" title="Click to refresh" data-captcha="button-refresh"><img data-captcha="image" src="/captcha/render/" /></a>
    		</div>
    	</div>
    	
    	<div class="form-group">
    		<label for="inputCaptcha" class="col-lg-2 control-label"></label>
    		<div class="col-lg-10">
    			<input type="text" class="form-control" name="captcha" placeholder="<?php $this->show('Enter what you see on image'); ?>" />
    		</div>
    	</div>
    	
    	<div class="form-group">
    	  <div class="col-lg-10 col-lg-offset-2">
    		<button type="reset" class="btn btn-default"><i class="glyphicon glyphicon-remove"></i> <?php $this->show('Cancel'); ?></button>
    		<button type="submit" class="btn btn-primary" data-button="submit"><i class="glyphicon glyphicon-envelope"></i> <?php $this->show('Submit'); ?></button>
    	  </div>
    	</div>
    	
      </fieldset>
    </form>

