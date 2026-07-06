<?php
/**
 * Title: Hero
 * Slug: jorriss/hero
 * Categories: jorriss
 * Description: Dark hero with grid + glow, headline, lede, buttons, photo and a tech strip.
 */
?>
<!-- wp:group {"tagName":"section","className":"jr-hero","align":"full","backgroundColor":"dark","layout":{"type":"constrained","contentSize":"1180px"}} -->
<section class="wp-block-group alignfull jr-hero has-dark-background-color has-background"><!-- wp:columns {"align":"wide","verticalAlignment":"center","style":{"spacing":{"padding":{"top":"30px","bottom":"50px"},"blockGap":{"left":"56px"}}}} -->
<div class="wp-block-columns alignwide are-vertically-aligned-center" style="padding-top:30px;padding-bottom:50px"><!-- wp:column {"verticalAlignment":"center","width":"58%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:58%"><!-- wp:paragraph {"className":"jr-badge"} -->
<p class="jr-badge">databases · code · the space between</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1,"fontSize":"xx-large","style":{"spacing":{"margin":{"top":"26px","bottom":"22px"}}}} -->
<h1 class="wp-block-heading has-xx-large-font-size" style="margin-top:26px;margin-bottom:22px">Richie Rump<br>is a <span class="jr-accent-text">dataveloper.</span></h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"jr-lede"} -->
<p class="jr-lede">Wedged happily between application code and the database — building tools that shine a light into the dark corners of your data.</p>
<!-- /wp:paragraph -->

<!-- wp:buttons {"style":{"spacing":{"margin":{"top":"34px"},"blockGap":"12px"}}} -->
<div class="wp-block-buttons" style="margin-top:34px"><!-- wp:button {"className":"jr-btn"} -->
<div class="wp-block-button jr-btn"><a class="wp-block-button__link wp-element-button" href="#writing">read the blog →</a></div>
<!-- /wp:button -->

<!-- wp:button {"className":"jr-btn-ghost"} -->
<div class="wp-block-button jr-btn-ghost"><a class="wp-block-button__link wp-element-button" href="/about/">about me</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column -->

<!-- wp:column {"verticalAlignment":"center","width":"42%"} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:42%"><!-- wp:group {"className":"jr-photo-wrap","layout":{"type":"constrained"}} -->
<div class="wp-block-group jr-photo-wrap"><!-- wp:image {"aspectRatio":"4/3","scale":"cover","sizeSlug":"large","className":"jr-hero-photo"} -->
<figure class="wp-block-image size-large jr-hero-photo"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/placeholder.svg' ) ); ?>" alt="Richie Rump" style="aspect-ratio:4/3;object-fit:cover"/></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"className":"jr-chip"} -->
<p class="jr-chip">SELECT * FROM Jorriss;</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:group {"tagName":"div","className":"jr-techstrip","align":"full","layout":{"type":"constrained","contentSize":"1180px"}} -->
<div class="wp-block-group alignfull jr-techstrip"><!-- wp:paragraph {"align":"wide","style":{"spacing":{"padding":{"top":"16px","bottom":"16px"}}}} -->
<p class="alignwide" style="padding-top:16px;padding-bottom:16px"><span>SQL&nbsp;Server</span><span>PostgreSQL</span><span>C#&nbsp;/&nbsp;.NET</span><span>Cloud&nbsp;Solutions</span><span>Query&nbsp;Tuning</span><span>Data&nbsp;Pipelines</span><span class="jr-accent-text">— currently building tooling</span></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></section>
<!-- /wp:group -->
