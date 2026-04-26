<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if ( !function_exists( 'chld_thm_cfg_locale_css' ) ):
    function chld_thm_cfg_locale_css( $uri ){
        if ( empty( $uri ) && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) )
            $uri = get_template_directory_uri() . '/rtl.css';
        return $uri;
    }
endif;
add_filter( 'locale_stylesheet_uri', 'chld_thm_cfg_locale_css' );

if ( !function_exists( 'chld_thm_cfg_parent_css' ) ):
    function chld_thm_cfg_parent_css() {
        wp_enqueue_style( 'chld_thm_cfg_parent', trailingslashit( get_template_directory_uri() ) . 'style.css', array( 'bravada-themefonts' ) );
    }
endif;
add_action( 'wp_enqueue_scripts', 'chld_thm_cfg_parent_css', 10 );

// END ENQUEUE PARENT ACTION


// 用户属地显示
include("useragent/show-useragent.php");
include("useragent/ip2c-text.php");

function bravada_comment_replace( $comment, $args, $depth ) {
	switch ( $comment->comment_type ) :
		case 'pingback'  :
		case 'trackback' :
		?>
			<li class="post pingback">
			<p><?php _e( 'Pingback: ', 'bravada' ); ?><?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'bravada' ), ' ' ); ?></p>
		<?php
		break;
		case '' :
		default :
		?>
			<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>"<?php cryout_schema_microdata( 'comment' ); ?>>

				<article>

					<header class="comment-header vcard">

						<div class="comment-meta">
						    
						    <!-- ADDS -->
									
							
									
							<!-- ADDS END -->
							
							<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
							<time datetime="<?php comment_time( 'c' );?>" <?php cryout_schema_microdata( 'time' );?>>

								<span class="comment-date">
									<?php /* translators: 1: date, 2: time */
									printf(  '%1$s ' . __( 'at', 'bravada' ) . ' %2$s', get_comment_date(),  get_comment_time() ); ?>
								</span>
								<span class="comment-timediff">
									<?php printf( _x( '%1$s ago', '%s = human-readable time difference', 'bravada' ), esc_html( human_time_diff( get_comment_time( 'U' ), current_time( 'timestamp' ) ) ) ); ?>
								</span>

							</time>
							</a>
							<?php edit_comment_link( __( '(Edit)', 'bravada' ), ' ' ); ?>
							
						</div><!-- .comment-meta -->

					</header><!-- .comment-header .vcard -->

					<div class="comment-area">
						<?php if ( $comment->comment_approved == '0' ) : ?>
							<span class="comment-await"><em><?php _e( 'Your comment is awaiting moderation.', 'bravada' ); ?></em></span>
						<?php endif; ?>
						<div class="comment-avatar">
								<?php echo get_avatar( $comment, 80, '', '', array( 'extra_attr' => cryout_schema_microdata('image', 0) )  ); ?>
								<div class="comment-author" <?php cryout_schema_microdata( 'comment-author' ); ?>>
									<?php printf(  '%s ', sprintf( '<span class="author-name fn"' . cryout_schema_microdata( 'author-name', 0) . '>%s</span>', get_comment_author_link() ) ); ?>
									<!-- ADDS -->
									
									<span id="comment_ua_info" class="comment_ua_info" style="white-space: nowrap;overflow: hidden;display: inline;">
									<?php echo '&nbsp;&nbsp;&nbsp'; //CID_print_comment_flag(); echo ' '; CID_print_comment_browser(); ?>
									<?php echo "<span id='ua-info-text' style='font-size: 14px;font-weight: normal;color: #aaa;'>"; echo convertip(get_comment_author_ip()); ?>
									<?php echo '</span>'; ?>
									<!-- ADDS END -->
								</div> <!-- .comment-author -->
						</div>
						<div class="comment-body" <?php cryout_schema_microdata( 'text' ); ?>>
							<?php comment_text(); ?>
						</div><!-- .comment-body -->
					</div>

					<footer class="comment-footer">
						<div class="reply">
							<?php comment_reply_link( array_merge( $args, array(
									'reply_text' 	=> '<i class="icon-reply-comments"></i> ' . __( 'Reply', 'bravada' ),
									'depth'			=> $depth,
									'max_depth'		=> $args['max_depth'] ) ) );
							?>
						</div><!-- .reply -->
					</footer><!-- .comment-footer -->

				</article>
		<?php
		break;
	endswitch;

	// </li><!-- #comment-##  -->  closed by wp_comments_list()
} // bravada_comment()

add_filter( 'wp_list_comments_args', 'use_my_bravada_comment' );
function use_my_bravada_comment( $args ) {
    if ( ! is_admin() ) {
        $args['callback'] = 'bravada_comment_replace'; // 这里要和你新函数的名字一致
    }
    return $args;
}

function my_child_theme_scripts() {
    // 确保只在需要的地方加载，例如只在首页
    if ( true ) { // 或 is_home()，根据你的首页类型调整
        wp_enqueue_script(
            'mouse-parallax',
            get_stylesheet_directory_uri() . '/js/mouse-parallax.js',
            array(), // 无依赖
            '1.0',
            true // 在页脚加载
        );
    }
}
add_action( 'wp_enqueue_scripts', 'my_child_theme_scripts' );

function custom_redirects() {
    // 获取当前请求的 URI 路径
    $request_uri = $_SERVER['REQUEST_URI'];

    if ( $request_uri == '/index.php/about/' || $request_uri == '/index.php/about' ) {
        wp_redirect( home_url('/index.php/about/about-major/'), 301 );
        exit();
    }
}
add_action( 'init', 'custom_redirects' );

// 统计全站所有已发布文章的总字数
function alp_total_word_count() {
    $total_words = 0;
    $args = array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => -1,
    );
    $all_posts = get_posts($args);
    foreach ($all_posts as $post) {
        $word_count = str_word_count(wp_strip_all_tags($post->post_content));
        $total_words += $word_count;
    }
    return $total_words;
}





// 临时触发 403 错误以测试自定义模板
add_action('template_redirect', function() {
    // 可选：限制只在特定条件下触发，避免影响所有页面
    // 例如只在访问特定 URL 参数时触发
    if ( isset($_GET['test403']) ) {
        status_header(403);
        get_template_part('403'); // 模板文件名为 403.php
        exit;
    }
});

// 临时触发 500 错误以测试自定义模板
add_action('template_redirect', function() {
    if ( isset($_GET['test500']) ) {
        // 主动抛出一个致命错误来模拟 500 状态
        status_header(500);
        get_template_part('500'); // 模板文件名为 500.php
        // 确保在调用模板后停止执行
        exit;
    }
});

