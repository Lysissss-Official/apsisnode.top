<?php
/**
 * Template Name: 分类导航页面
 * Description: 以首页文章网格样式显示全部分类，并包含正确的侧边栏
 */

get_header(); // 调用头部
?>

<div id="container" class="two-columns-right">
    <main id="main" class="main" style="background-color: transparent !important;">

        <header class="page-header pad-container" itemscope itemtype="http://schema.org/WebPageElement">
            <h1 class="page-title" itemprop="headline">
                <?php the_title(); // 显示页面标题 ?>
            </h1>
        </header><!-- .page-header -->

        <div id="content-masonry" class="content-masonry masonry" itemscope itemtype="http://schema.org/Blog">

            <?php
            // 获取全部分类（按名称升序，显示空分类）
            $categories = get_categories( array(
                'orderby'    => 'count',
                'order'      => 'DESC',
                'hide_empty' => 0, // 设为 1 则隐藏无文章的分类
            ) );

            if ( ! empty( $categories ) ) :
                foreach ( $categories as $category ) :
                    $category_link = get_category_link( $category->term_id );
                    $post_count    = $category->count;
                    $description   = category_description( $category->term_id );
                    ?>

                    <article id="category-<?php echo $category->term_id; ?>" class="hentry masonry-brick" itemscope itemtype="http://schema.org/BlogPosting" itemprop="blogPost">

                        <div class="article-inner">

                            <!-- 元信息区 -->
                            <div class="entry-meta">
                                <span class="bl_categ">
                                    <i class="icon-category icon-metas" title="分类"></i>
                                    <span class="category-metas">
                                        <a href="<?php echo esc_url( $category_link ); ?>" rel="category tag"><?php echo esc_html( $category->slug ); ?></a>
                                    </span>
                                </span>
                                <span class="comments-link">
                                    <i class="icon-comments icon-metas" title="文章数量"></i>
                                    <a href="<?php echo esc_url( $category_link ); ?>"><?php echo $post_count; ?> 篇文章</a>
                                </span>
                            </div><!-- .entry-meta -->

                            <div class="entry-after-image">

                                <header class="entry-header">
                                    <h2 class="entry-title" itemprop="headline">
                                        <a href="<?php echo esc_url( $category_link ); ?>" itemprop="mainEntityOfPage" rel="bookmark">
                                            <?php echo esc_html( $category->name ); ?>
                                        </a>
                                    </h2>
                                    <div class="entry-meta aftertitle-meta">
                                        <!-- 可留空或添加额外信息 -->
                                    </div><!-- .entry-meta -->
                                </header><!-- .entry-header -->

                                <?php if ( ! empty( $description ) ) : ?>
                                <div class="entry-summary" itemprop="description">
                                    <p><?php echo wp_kses_post( $description ); ?></p>
                                </div><!-- .entry-summary -->
                                <?php endif; ?>

                                <footer class="post-continue-container">
                                    <a class="continue-reading-link" href="<?php echo esc_url( $category_link ); ?>">
                                        <span>查看该分类下的文章</span>
                                        <i class="icon-continue-reading"></i>
                                        <em class="screen-reader-text">"<?php echo esc_html( $category->name ); ?>"</em>
                                    </a>
                                </footer>

                            </div><!-- .entry-after-image -->
                        </div><!-- .article-inner -->
                    </article><!-- #category-<?php echo $category->term_id; ?> -->

                <?php endforeach; ?>
            <?php else : ?>
                <p style="padding: 20px; text-align: center;">暂无分类</p>
            <?php endif; ?>

        </div><!-- #content-masonry -->

    </main><!-- #main -->
    
    <aside id="secondary" class="widget-area sidey" itemscope itemtype="http://schema.org/WPSideBar">
        <?php dynamic_sidebar(); ?>
    </aside>
    <?php //get_sidebar(); // 调用侧边栏（会自动输出正确的 <aside id="secondary">） ?>

</div><!-- #container -->

<?php
get_footer(); // 调用底部
?>