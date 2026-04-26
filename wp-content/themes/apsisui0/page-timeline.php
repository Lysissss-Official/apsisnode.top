<?php
/**
 * Template Name: 修订版本时间线
 * Description: 展示文章的每一次修改记录（修订版本），从新到旧
 */

get_header();
?>

<div id="container" class="one-column">
    <main id="main" class="main">
        <div class="page">
            <article id="post-revision-timeline" class="hentry post-timeline">
                <div class="article-inner">
                    <header class="entry-header">
                        <h1 class="entry-title"><?php the_title(); ?></h1>
                    </header>
                    <div class="entry-content">
                        <?php
                        // 分页设置：每页显示 30 条修订
                        $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
                        $args = array(
                            'post_type'      => 'revision',
                            'post_status'    => 'inherit', // 修订版本状态为 inherit
                            'posts_per_page' => 30,
                            'paged'          => $paged,
                            'orderby'        => 'date',
                            'order'          => 'DESC',
                            // 可选：排除自动保存（自动保存的 post_name 包含 'autosave'）
                            'post_name__not_in' => array( 'autosave' ), // 简单方式，但不完全准确
                        );
                        // 更精确排除自动保存：使用 meta_query，但效率较低，暂不采用

                        $revision_query = new WP_Query( $args );

                        if ( $revision_query->have_posts() ) : ?>
                            <div class="timeline">
                                <?php while ( $revision_query->have_posts() ) : $revision_query->the_post();
                                      // 获取父文章（原始文章）信息
                                    $parent_id   = wp_get_post_parent_id( get_the_ID() );
                                    $parent_post = get_post( $parent_id );
                                    if ( ! $parent_post || $parent_post->post_type !== 'post' ) {
                                        continue; // 只展示文章的修订，忽略页面或其他类型的修订
                                    }
                                    $parent_title = $parent_post->post_title;
                                    $parent_link  = get_permalink( $parent_id );
                                    $author_id    = get_the_author_meta( 'ID' );
                                    $author_name  = get_the_author_meta( 'display_name', $author_id );
                                    $mod_time     = get_the_modified_time( 'Y-m-d H:i:s' );
                                
                                    // 获取当前修订版本的内容
                                    $rev_content = get_the_content();
                                    $rev_title   = get_the_title();
                                
                                    // 比较与父文章的差异，生成修改描述
                                    $changes = array();
                                    if ( $rev_title !== $parent_title ) {
                                        $changes[] = '标题修改';
                                    }
                                    if ( $rev_content !== $parent_post->post_content ) {
                                        // 计算内容字符数变化（简单估算）
                                        $rev_len   = strlen( wp_strip_all_tags( $rev_content ) );
                                        $parent_len = strlen( wp_strip_all_tags( $parent_post->post_content ) );
                                        $diff = $rev_len - $parent_len;
                                        if ( $diff > 0 ) {
                                            $changes[] = '内容增加 ' . $diff . ' 字符';
                                        } elseif ( $diff < 0 ) {
                                            $changes[] = '内容减少 ' . abs($diff) . ' 字符';
                                        } else {
                                            $changes[] = '内容修改（字数不变）';
                                        }
                                    }
                                    $change_text = ! empty( $changes ) ? implode( ' · ', $changes ) : '细微修改';
                                ?>
                                <div class="timeline-item">
                                    <div class="timeline-date">
                                        <div class="date-large"><?php echo get_the_date( 'Y-m-d' ); ?></div>
                                        <div class="time-small"><?php echo get_the_time( 'H:i' ); ?></div>
                                    </div>
                                    <div class="timeline-content">
                                        <h2 class="entry-title" itemprop="headline">
                                            <a href="<?php echo esc_url( $parent_link ); ?>" itemprop="mainEntityOfPage" rel="bookmark">
                                                <?php echo esc_html( $parent_title ); ?>
                                            </a>
                                        </h2>
                                        <div class="timeline-author">
                                            <?php printf( '修改者：%s', esc_html( $author_name ) ); ?>
                                            <span style="margin-left: 15px; color: #0F8B8D;"><?php echo $change_text; ?></span>
                                        </div>
                                    </div>
                                </div>
                                <?php endwhile; ?>
                            </div>
                            <?php
                            // 分页导航
                            the_posts_pagination( array(
                                'mid_size'  => 2,
                                'prev_text' => __( '上一页', 'bravada' ),
                                'next_text' => __( '下一页', 'bravada' ),
                            ) );
                        else :
                            echo '<p>暂无修订记录</p>';
                        endif;
                        wp_reset_postdata();
                        ?>
                    </div>
                </div>
            </article>
        </div>
    </main>
</div><!-- #container -->

<?php
get_footer();
?>