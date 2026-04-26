<?php
/**
 * 自定义500页面模板
 * 基于 Bravada 主题风格
 */

get_header('500'); // 调用页眉
?>

<div id="container" class="one-column">
    <main id="main" class="main">
        <div class="content-masonry">
            <article id="post-500" class="hentry post-500 error500 not-found">
                <div class="article-inner">
                    
                    <!--h1 class="entry-title" style="font-size: 8em; text-align: center; line-height: 1; margin: 0.5em 0 0.2em;">500</h1-->
                    <h2 class="entry-subtitle" style="text-align: center; font-size: 2em; color: #0F8B8D;"><?php _e( '500 错误 - 服务器内部错误', 'bravada' ); ?></h2>
                    
                    <div class="entry-content" style="text-align: center; max-width: 600px; margin: 2em auto;">
                        <p><?php _e( '很抱歉，服务器暂时无法处理您的请求，这可能是由临时问题或配置错误引起的，请稍后刷新重试。', 'bravada' ); ?></p>
                        <p><?php _e( '您可以尝试搜索，或者返回首页继续浏览。', 'bravada' ); ?></p>

                        <div class="search-500" style="margin: 2em 0;">
                            <?php get_search_form(); // 调用搜索表单 ?>
                        </div>

                        <a class="continue-reading-link" href="<?php echo esc_url( home_url( '/' ) ); ?>" style="display: inline-block; margin-top: 1em;">
                            <span><?php _e( '返回首页', 'bravada' ); ?></span>
                            <i class="icon-continue-reading"></i>
                        </a>
                    </div>
                </div>
            </article>
        </div>
    </main>
</div><!-- #container -->

<?php
get_footer(); // 调用页脚
?>

