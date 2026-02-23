<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>

<?php if ($this->allow('comment')): ?>
<section class="comments-section" id="comments">
    <h3 class="comments-title">评论 (<?php $this->commentsNum('%d'); ?>)</h3>
    
    <?php $this->comments()->to($comments); ?>
    
    <?php if ($comments->have()): ?>
    <div class="comments-list">
        <?php $comments->listComments(array(
            'before'   => '',
            'after'    => '',
            'callback' => 'threadedComments'
        )); ?>
    </div>
    
    <!-- 评论分页 -->
    <?php $comments->pageNav('← 上一页', '下一页 →'); ?>
    <?php endif; ?>
    
    <div id="<?php $this->respondId(); ?>" class="comment-form">
        <form method="post" action="<?php $this->commentUrl() ?>" id="comment-form">
            <textarea name="text" id="comment-textarea" class="comment-textarea" placeholder="写下你的评论..." required><?php $this->remember('text'); ?></textarea>
            
            <?php if ($this->user->hasLogin()): ?>
            <div class="comment-form-footer">
                <div class="comment-form-info">
                    <span class="logged-in-as">以 <strong><?php $this->user->screenName(); ?></strong> 身份登录</span>
                </div>
                <div class="comment-form-actions">
                    <span class="cancel-comment-reply"><?php $comments->cancelReply('取消回复'); ?></span>
                    <button type="submit" class="comment-submit">发表评论</button>
                </div>
            </div>
            <?php else: ?>
            <div class="comment-form-footer">
                <div class="comment-form-info">
                    <input type="text" name="author" id="comment-author" class="comment-input" placeholder="昵称 *" value="<?php $this->remember('author'); ?>" required>
                    <input type="email" name="mail" id="comment-mail" class="comment-input" placeholder="邮箱 *" value="<?php $this->remember('mail'); ?>"<?php if ($this->options->commentsRequireMail): ?> required<?php endif; ?>>
                    <input type="url" name="url" id="comment-url" class="comment-input" placeholder="网站（选填）" value="<?php $this->remember('url'); ?>">
                </div>
                <div class="comment-form-actions">
                    <span class="cancel-comment-reply"><?php $comments->cancelReply('取消回复'); ?></span>
                    <button type="submit" class="comment-submit">发表评论</button>
                </div>
            </div>
            <?php endif; ?>
        </form>
    </div>
</section>
<?php else: ?>
<section class="comments-section" id="comments">
    <h3 class="comments-title">评论已关闭</h3>
</section>
<?php endif; ?>
