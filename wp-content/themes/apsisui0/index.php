<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @package Bravada
 */
get_header();
?>
<!-- 网站统计面板 - 仅首页显示 -->
    <div class="home-stats-section">
    	<div class="home-stats-container">
    		<div class="home-stats-grid">
    			<div class="home-stat-item">
    				<div class="stat-icon">⏱️</div>
    				<div class="stat-number" id="site-running-time">0 天 0 小时 0 分 0 秒</div>
    				<div class="stat-desc">网站已运行</div>
    			</div>
    			<div class="home-stat-item">
    				<div class="stat-icon">📝</div>
    				<div class="stat-number">
    					<?php
    					$post_count = wp_count_posts();
    					echo $post_count->publish;
    					?>
    				</div>
    				<div class="stat-desc">文章总数</div>
    			</div>
    			<div class="home-stat-item">
    				<div class="stat-icon">📄</div>
    				<div class="stat-number">
    					<?php
    					$total_words = 0;
    					$all_posts = get_posts(array(
    						'post_type' => 'post',
    						'post_status' => 'publish',
    						'posts_per_page' => -1,
    						'ignore_sticky_posts' => 1,
    						'no_found_rows' => true,
    						'update_post_meta_cache' => false,
    						'update_post_term_cache' => false
    					));
    					foreach($all_posts as $p) {
    						$total_words += str_word_count(wp_strip_all_tags($p->post_content));
    					}
    					echo round($total_words / 1000, 1) . 'k';
    					?>
    				</div>
    				<div class="stat-desc">全站字数</div>
    			</div>
    			<div class="home-stat-item">
    				<div class="stat-icon">📂</div>
    				<div class="stat-number">
    					<?php
    					echo wp_count_terms('category');
    					?>
    				</div>
    				<div class="stat-desc">分类总数</div>
    			</div>
    			<div class="home-stat-item">
    				<div class="stat-icon">💬</div>
    				<div class="stat-number">
    					<?php
    					$comment_count = wp_count_comments();
    					echo $comment_count->approved;
    					?>
    				</div>
    				<div class="stat-desc">评论总数</div>
    			</div>
    			<div class="home-stat-item">
    				<div class="stat-icon">ApsisNode</div>
    				<div class="stat-number">
    					Hello, World!
    				</div>
    				<div class="stat-desc">wwww统计</div>
    			</div>
    		</div>
    	</div>
    </div>
    
<style>
/* 仅首页统计面板 */
body.home .home-stats-section {
    width: 100% !important;
    display: block !important;
    float: none !important;
    clear: both !important;
    background: rgba(255,255,255,0.02);
    border-bottom: 1px solid rgba(255,255,255,0.05);
    margin-top: 30px;
}
body.home .home-stats-container {
    max-width: 1200px;
    margin: 0 auto;
}
body.home .home-stats-grid {
    display: grid;
    grid-template-columns: repeat(6, 1fr);
    gap: 20px;
    justify-content: center;
    text-align: center;
}
body.home .home-stat-item {
    background-color: rgba(40, 40, 40, 0.75) !important;
    border-color: #444 !important;
    color: #e0e0e0 !important;
    backdrop-filter: blur(5px);
    -webkit-backdrop-filter: blur(5px);
    padding: 20px;
    box-shadow: 0 15px 60px rgba(255, 255, 255, 0.4) !important;
    transition: transform 0.3s cubic-bezier(0.2, 0.9, 0.3, 1.2);
    will-change: transform;
    z-index: 1;
}
body.home .home-stat-item:hover {
    transform: scale(1.05);
    z-index: 10;
}
body.home .stat-icon {
    font-size: 28px;
    margin-bottom: 8px;
}
body.home .stat-number {
    font-size: 22px;
    font-weight: 600;
    color: #fff;
    margin-bottom: 6px;
}
body.home .stat-desc {
    font-size: 14px;
    color: rgba(255,255,255,0.65);
}

/* 自适应关键代码 */
@media (max-width: 1152px) {
    body.home .home-stats-section {
        padding: 2em 2em;
    }
    body.home .home-stats-grid {
        grid-template-columns: repeat(3, 1fr);
    }
}
@media (max-width: 1024px) {
    body.home .home-stats-section {
        padding: 2em 2em;
    }
    body.home .home-stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}
@media (max-width: 640px) {
    body.home .home-stats-section {
        padding: 0 0;
    }
    body.home .home-stats-grid {
        grid-template-columns: repeat(1, 1fr);
    }
}
</style>
    
    <script>
    function siteRunningTime() {
        const createDate = new Date("2026-02-18 00:00:00").getTime();
        const nowDate = new Date().getTime();
        const timeDiff = nowDate - createDate;
    
        const days = Math.floor(timeDiff / (1000 * 60 * 60 * 24));
        const hours = Math.floor((timeDiff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((timeDiff % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((timeDiff % (1000 * 60)) / 1000);
    
        document.getElementById("site-running-time").innerText =
            days + " 天 " + hours + " 小时 " + minutes + " 分 " + seconds + " 秒";
    }
    setInterval(siteRunningTime, 1000);
    siteRunningTime();
    </script>
    
<div id="container" class="<?php bravada_get_layout_class(); ?>">
	<main id="main" class="main">
		<?php cryout_before_content_hook(); ?>

		<?php if ( have_posts() ) : ?>
			<div id="content-masonry" class="content-masonry" <?php cryout_schema_microdata( 'blog' ); ?>>
				<?php /* Start the Loop */
				while ( have_posts() ) : the_post();
					get_template_part( 'content/content', get_post_format() );
				endwhile;
				?>
			</div> <!-- content-masonry -->
			<?php bravada_pagination(); ?>

		<?php else :
			get_template_part( 'content/content', 'notfound' );
		endif; ?>

		<?php cryout_after_content_hook(); ?>
	</main><!-- #main -->

	<?php bravada_get_sidebar(); ?>
</div><!-- #container -->

<?php
get_footer();
