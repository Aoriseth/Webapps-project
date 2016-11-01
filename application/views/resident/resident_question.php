<p>
	Displaying all questions from category <?php echo $category ?>.
</p>
<p>
	<i>Still work in progress here...</i>
</p>

<ol>
<?php foreach( $questions as $question) { ?>

	<li><?php echo htmlspecialchars( $question->question ) ?></li>

<?php } ?>
</ol>
