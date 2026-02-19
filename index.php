<?php
/**
 * 这是一款单栏博客主题 - 刻画kehua.me
 *
 * @package whitespace - 留白主题
 * @author 刻画kehua.me
 * @version 1.0.0
 * @link https://kehua.me
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
?>

    <!-- 主要内容 -->
    <main class="main">
        <div class="container">
            <?php 
            // 置顶文章 - 通过主题设置的文章ID显示
            $featuredPostId = $this->options->featuredPostId;
            if ($this->is('index') && $this->_currentPage == 1 && !empty($featuredPostId)): 
                $this->widget('Widget_Archive@featured', 'pageSize=1&type=post', 'cid=' . intval($featuredPostId))->to($featured);
                if ($featured->have()):
                    while($featured->next()):
                        $featuredViews = getPostViewsCount($featured->cid);
            ?>
            <article class="post post-featured">
                <h2 class="post-title">
                    <a href="<?php $featured->permalink(); ?>"><?php $featured->title(); ?></a>
                </h2>
                <p class="post-excerpt">
                    <?php echo getExcerpt($featured->content, 200); ?>
                </p>
                <div class="post-meta">
                    <span class="post-date"><?php echo getRelativeTime($featured->created); ?></span>
                    <span class="post-meta-sep">·</span>
                    <span class="post-category"><?php $featured->category(','); ?></span>
                    <?php if ($featuredViews > 0): ?>
                    <span class="post-meta-sep">·</span>
                    <span class="post-views"><?php echo number_format($featuredViews); ?> 次浏览</span>
                    <?php endif; ?>
                </div>
            </article>
            <?php 
                    endwhile;
                endif;
            endif; 
            ?>

            <!-- 文章列表 -->
            <div class="post-list">
                <?php while($this->next()): ?>
                <?php $thumb = getThumb($this); ?>
                <?php $postViews = getPostViewsCount($this->cid); ?>
                <article class="post<?php if ($thumb): ?> post-with-thumb<?php endif; ?>">
                    <?php if ($thumb): ?>
                    <div class="post-thumb">
                        <a href="<?php $this->permalink(); ?>">
                            <img src="<?php echo $thumb; ?>" alt="<?php $this->title(); ?>" loading="lazy">
                        </a>
                    </div>
                    <div class="post-content">
                    <?php endif; ?>
                        <h2 class="post-title">
                            <a href="<?php $this->permalink(); ?>"><?php $this->title(); ?></a>
                        </h2>
                        <p class="post-excerpt">
                            <?php echo getExcerpt($this->content, 150); ?>
                        </p>
                        <div class="post-meta">
                            <span class="post-date"><?php echo getRelativeTime($this->created); ?></span>
                            <span class="post-meta-sep">·</span>
                            <span class="post-category"><?php $this->category(','); ?></span>
                            <?php if ($postViews > 0): ?>
                            <span class="post-meta-sep">·</span>
                            <span class="post-views"><?php echo number_format($postViews); ?> 次浏览</span>
                            <?php endif; ?>
                        </div>
                    <?php if ($thumb): ?>
                    </div>
                    <?php endif; ?>
                </article>
                <?php endwhile; ?>
            </div>

            <!-- 分页 -->
            <?php $this->pageNav('← 上一页', '下一页 →'); ?>
        </div>
    </main>

<?php $this->need('footer.php'); ?>

