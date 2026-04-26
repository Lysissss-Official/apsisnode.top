<?php
/**
 * 自定义404页面模板
 * 基于 Bravada 主题风格
 */

get_header('404'); // 调用页眉
?>

<div id="container" class="one-column">
    <main id="main" class="main">
        <div class="content-masonry">
            <article id="post-404" class="hentry post-404 error404 not-found">
                <div class="article-inner">
                    
                    <!--h1 class="entry-title" style="font-size: 8em; text-align: center; line-height: 1; margin: 0.5em 0 0.2em;">404</h1-->
                    <h2 class="entry-subtitle" style="text-align: center; font-size: 2em; color: #0F8B8D;"><?php _e( '404 错误 - 页面未找到', 'bravada' ); ?></h2>
                    
                    <div class="entry-content" style="text-align: center; max-width: 600px; margin: 2em auto;">
                        <p><?php _e( '很抱歉，您访问的页面可能已被移动、删除或从未存在过。', 'bravada' ); ?></p>
                        <p><?php _e( '您可以尝试搜索，或者返回首页继续浏览。', 'bravada' ); ?></p>

                        <div class="search-404" style="margin: 2em 0;">
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

