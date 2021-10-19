<hr class="my-5">
<div class="pa-comments">
	<div id="disqus_thread"></div>
	<script>
		/**
		*  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
		*  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables    */
		
		var disqus_config = function () {
			this.page.url = '<?= get_permalink(); ?>';  // Replace PAGE_URL with your page's canonical URL variable
			this.page.identifier = '<?= SITE; ?>_<?= LANG; ?>_<?= get_the_ID(); ?>'; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
			this.page.title = '<?= the_title() ?>';
		};
		
		(function() { // DON'T EDIT BELOW THIS LINE
		var d = document, s = d.createElement('script');
		s.src = 'https://adventistas<?= LANG; ?>.disqus.com/embed.js';
		s.setAttribute('data-timestamp', +new Date());
		(d.head || d.body).appendChild(s);
		})();
	</script>
	<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
</div>