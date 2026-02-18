<?php
/**
 * 科华博客主题 for Typecho
 * 
 * @package Kehua Theme
 * @author Kehua
 * @version 1.0.0
 * @link https://example.com
 */

if (!defined('__TYPECHO_ROOT_DIR__')) exit;

/**
 * 主题启用时的初始化
 */
function themeInit($archive) {
    Helper::options()->commentsMaxNestingLevels = 3;
    Helper::options()->commentsOrder = 'DESC';
}

/**
 * 主题配置面板
 */
function themeConfig($form) {
    // Logo 图片地址
    $logoUrl = new Typecho_Widget_Helper_Form_Element_Text(
        'logoUrl',
        NULL,
        '',
        _t('Logo 图片'),
        _t('导航栏 Logo 图片地址，留空则显示站点名称首字')
    );
    $form->addInput($logoUrl);
    
    // 导航菜单设置
    $navMenu = new Typecho_Widget_Helper_Form_Element_Textarea(
        'navMenu',
        NULL,
        '',
        _t('导航菜单'),
        _t('自定义导航菜单，每行一个菜单项，格式：菜单名称|链接地址<br>例如：<br>首页|/<br>关于|/about.html<br>归档|/archives.html<br><br>留空则不显示导航菜单')
    );
    $form->addInput($navMenu);
    
    // 置顶文章ID
    $featuredPostId = new Typecho_Widget_Helper_Form_Element_Text(
        'featuredPostId',
        NULL,
        '',
        _t('置顶文章ID'),
        _t('首页置顶显示的文章ID，留空则不显示置顶文章')
    );
    $form->addInput($featuredPostId);
    
    // 自定义版权信息
    $customCopyright = new Typecho_Widget_Helper_Form_Element_Textarea(
        'customCopyright',
        NULL,
        '',
        _t('自定义版权信息'),
        _t('页脚自定义版权信息，支持HTML代码，留空不显示')
    );
    $form->addInput($customCopyright);
    
    // 社交链接 - GitHub
    $githubUrl = new Typecho_Widget_Helper_Form_Element_Text(
        'githubUrl',
        NULL,
        '',
        _t('GitHub 链接'),
        _t('您的 GitHub 主页链接')
    );
    $form->addInput($githubUrl);
    
    // 社交链接 - Twitter
    $twitterUrl = new Typecho_Widget_Helper_Form_Element_Text(
        'twitterUrl',
        NULL,
        '',
        _t('Twitter 链接'),
        _t('您的 Twitter 主页链接')
    );
    $form->addInput($twitterUrl);
    
    // 联系邮箱
    $contactEmail = new Typecho_Widget_Helper_Form_Element_Text(
        'contactEmail',
        NULL,
        '',
        _t('联系邮箱'),
        _t('用于关于页面显示')
    );
    $form->addInput($contactEmail);
    
    // 头像URL
    $avatarUrl = new Typecho_Widget_Helper_Form_Element_Text(
        'avatarUrl',
        NULL,
        '',
        _t('博主头像'),
        _t('关于页面显示的头像URL')
    );
    $form->addInput($avatarUrl);
    
    // 关于页面简介
    $aboutBio = new Typecho_Widget_Helper_Form_Element_Textarea(
        'aboutBio',
        NULL,
        '一个热爱生活、热爱技术的普通人',
        _t('个人简介'),
        _t('关于页面显示的个人简介')
    );
    $form->addInput($aboutBio);
}

/**
 * 文章自定义字段
 */
function themeFields($layout) {
    // 文章缩略图
    $thumb = new Typecho_Widget_Helper_Form_Element_Text(
        'thumb',
        NULL,
        NULL,
        _t('文章缩略图'),
        _t('输入图片URL，在列表页显示缩略图')
    );
    $layout->addItem($thumb);
}

/**
 * 解析自定义导航菜单
 */
function parseNavMenu($navMenu) {
    if (empty($navMenu)) {
        return array();
    }
    
    $menus = array();
    $lines = explode("\n", trim($navMenu));
    
    foreach ($lines as $line) {
        $line = trim($line);
        if (empty($line)) {
            continue;
        }
        
        $parts = explode('|', $line);
        if (count($parts) >= 2) {
            $menus[] = array(
                'name' => trim($parts[0]),
                'url' => trim($parts[1])
            );
        }
    }
    
    return $menus;
}

/**
 * 获取文章缩略图
 */
function getThumb($widget) {
    $thumb = $widget->fields->thumb;
    if ($thumb) {
        return $thumb;
    }
    
    // 尝试从文章内容中提取第一张图片
    $pattern = '/\<img.*?src\=\"(.*?)\"[^>]*>/i';
    if (preg_match($pattern, $widget->content, $matches)) {
        return $matches[1];
    }
    
    return false;
}

/**
 * 获取相对时间
 */
function getRelativeTime($timestamp) {
    $diff = time() - $timestamp;
    
    if ($diff < 60) {
        return '刚刚';
    } elseif ($diff < 3600) {
        return floor($diff / 60) . ' 分钟前';
    } elseif ($diff < 86400) {
        return floor($diff / 3600) . ' 小时前';
    } elseif ($diff < 2592000) {
        return floor($diff / 86400) . ' 天前';
    } elseif ($diff < 31536000) {
        return floor($diff / 2592000) . ' 月前';
    } else {
        return floor($diff / 31536000) . ' 年前';
    }
}

/**
 * 阅读统计
 * 在文章页面调用此函数来统计阅读次数
 * 调用方式：<?php getPostViews($this); ?>
 */
function getPostViews($archive)
{
    $db = \Typecho\Db::get();
    $cid = $archive->cid;
    
    // 检查 views 字段是否存在，如果不存在则创建
    $tableInfo = $db->fetchRow($db->select()->from('table.contents')->limit(1));
    if (!array_key_exists('views', $tableInfo)) {
        $db->query('ALTER TABLE `' . $db->getPrefix() . 'contents` ADD `views` INT(10) DEFAULT 0;');
    }
    
    // 获取当前阅读次数
    $views = $db->fetchRow($db->select('views')->from('table.contents')->where('cid = ?', $cid));
    $exist = isset($views['views']) ? (int)$views['views'] : 0;
    
    // 如果是文章页面，则增加阅读次数（通过 Cookie 防止重复统计）
    if ($archive->is('single')) {
        $cookie = \Typecho\Cookie::get('contents_views');
        $cookie = $cookie ? explode(',', $cookie) : array();
        if (!in_array($cid, $cookie)) {
            $db->query($db->update('table.contents')
                ->rows(array('views' => $exist + 1))
                ->where('cid = ?', $cid));
            $exist = $exist + 1;
            array_push($cookie, $cid);
            $cookie = implode(',', $cookie);
            \Typecho\Cookie::set('contents_views', $cookie);
        }
    }
    
    return $exist;
}

/**
 * 获取文章的阅读次数（不增加计数）
 * 用于在列表页显示阅读次数
 * 调用方式：<?php echo getPostViewsCount($postCid); ?>
 */
function getPostViewsCount($cid)
{
    $db = \Typecho\Db::get();
    
    // 检查 views 字段是否存在
    $tableInfo = $db->fetchRow($db->select()->from('table.contents')->limit(1));
    if (!array_key_exists('views', $tableInfo)) {
        return 0;
    }
    
    $views = $db->fetchRow($db->select('views')->from('table.contents')->where('cid = ?', $cid));
    return isset($views['views']) ? (int)$views['views'] : 0;
}

/**
 * 截取文章摘要
 */
function getExcerpt($content, $length = 150) {
    $content = strip_tags($content);
    $content = preg_replace('/\s+/', ' ', $content);
    $content = trim($content);
    
    if (mb_strlen($content, 'UTF-8') > $length) {
        $content = mb_substr($content, 0, $length, 'UTF-8') . '...';
    }
    
    return $content;
}

/**
 * 获取评论者头像（支持QQ头像，带备用方案）
 * @param string $email 邮箱地址
 * @param int $size 头像尺寸
 * @return array 包含 url, fallback1, fallback2 的数组
 */
function getCommentAvatarData($email, $size = 48) {
    $avatarUrl = '';
    $avatarFallback1 = '';
    $avatarFallback2 = '';
    
    if ($email) {
        $email = strtolower(trim($email));
        $mailHash = md5($email);
        
        // 检查是否为QQ邮箱
        if (preg_match('/^(\d{5,11})@qq\.com$/i', $email, $matches)) {
            // QQ邮箱：使用QQ头像，失败时回退到Cravatar
            $qqNumber = $matches[1];
            $avatarUrl = 'https://q1.qlogo.cn/g?b=qq&nk=' . $qqNumber . '&s=640';
            // 备用源1：cravatar.cn
            $avatarFallback1 = 'https://cravatar.cn/avatar/' . $mailHash . '?s=' . $size . '&d=mp';
            // 备用源2：cn.cravatar.com
            $avatarFallback2 = 'https://cn.cravatar.com/avatar/' . $mailHash . '?s=' . $size . '&d=mp';
        } else {
            // 非QQ邮箱：使用Cravatar作为主源
            $avatarUrl = 'https://cravatar.cn/avatar/' . $mailHash . '?s=' . $size . '&d=mp';
            // 备用源：cn.cravatar.com
            $avatarFallback1 = 'https://cn.cravatar.com/avatar/' . $mailHash . '?s=' . $size . '&d=mp';
        }
    } else {
        // 没有邮箱：使用默认头像
        $avatarUrl = 'https://cravatar.cn/avatar/?s=' . $size . '&d=mp';
        $avatarFallback1 = 'https://cn.cravatar.com/avatar/?s=' . $size . '&d=mp';
    }
    
    return array(
        'url' => $avatarUrl,
        'fallback1' => $avatarFallback1,
        'fallback2' => $avatarFallback2
    );
}

/**
 * 自定义评论回调函数
 */
function threadedComments($comments, $options) {
    $commentClass = '';
    if ($comments->authorId) {
        if ($comments->authorId == $comments->ownerId) {
            $commentClass .= ' comment-by-author';
        } else {
            $commentClass .= ' comment-by-user';
        }
    }
    
    // 获取头像数据（支持QQ头像，带备用方案）
    $avatarData = getCommentAvatarData($comments->mail, 48);
    $avatarUrl = $avatarData['url'];
    $avatarFallback1 = $avatarData['fallback1'];
    $avatarFallback2 = $avatarData['fallback2'];
?>
    <div id="<?php $comments->theId(); ?>" class="comment<?php 
        if ($comments->levels > 0) {
            echo ' comment-child comment-level-' . $comments->levels;
        }
        echo $commentClass;
    ?>">
        <div class="comment-avatar">
            <img src="<?php echo htmlspecialchars($avatarUrl); ?>" 
                 alt="<?php echo htmlspecialchars($comments->author); ?>"
                 <?php if ($avatarFallback1 || $avatarFallback2): ?>
                 onerror="var img=this;var tryCount=parseInt(img.getAttribute('data-try')||'0');tryCount++;img.setAttribute('data-try',tryCount);if(tryCount==1&&'<?php echo htmlspecialchars($avatarFallback1 ?: ''); ?>'){img.src='<?php echo htmlspecialchars($avatarFallback1); ?>';}else if(tryCount==2&&'<?php echo htmlspecialchars($avatarFallback2 ?: ''); ?>'){img.src='<?php echo htmlspecialchars($avatarFallback2); ?>';}else{img.onerror=null;}"
                 <?php endif; ?>>
        </div>
        <div class="comment-body">
            <div class="comment-header">
                <span class="comment-author">
                    <?php 
                    $commentUrl = $comments->url;
                    $authorName = $comments->author;
                    if ($commentUrl) {
                        echo '<a href="' . htmlspecialchars($commentUrl, ENT_QUOTES, 'UTF-8') . '" target="_blank" rel="noopener noreferrer">' . htmlspecialchars($authorName, ENT_QUOTES, 'UTF-8') . '</a>';
                    } else {
                        echo htmlspecialchars($authorName, ENT_QUOTES, 'UTF-8');
                    }
                    ?>
                </span>
                <?php if ($comments->authorId == $comments->ownerId): ?>
                <span class="comment-badge">作者</span>
                <?php endif; ?>
                <span class="comment-date"><?php $comments->date('Y-m-d H:i'); ?></span>
            </div>
            <div class="comment-content">
                <?php $comments->content(); ?>
            </div>
            <div class="comment-actions">
                <?php $comments->reply('回复'); ?>
            </div>
            <?php if ($comments->children) { ?>
            <div class="comment-children">
                <?php $comments->threadedComments($options); ?>
            </div>
            <?php } ?>
        </div>
    </div>
<?php
}

/**
 * 输出分页导航
 */
function outputPagination($widget) {
    $options = Typecho_Widget::widget('Widget_Options');
    $currentPage = $widget->getCurrentPage();
    $totalPage = ceil($widget->getTotal() / $options->pageSize);
    
    if ($totalPage <= 1) {
        return;
    }
    
    echo '<div class="pagination">';
    
    // 上一页
    if ($currentPage > 1) {
        echo '<a href="' . $widget->pageLink($currentPage - 1) . '" class="pagination-item">← 上一页</a>';
    }
    
    // 页码
    $start = max(1, $currentPage - 2);
    $end = min($totalPage, $currentPage + 2);
    
    if ($start > 1) {
        echo '<a href="' . $widget->pageLink(1) . '" class="pagination-item">1</a>';
        if ($start > 2) {
            echo '<span class="pagination-ellipsis">...</span>';
        }
    }
    
    for ($i = $start; $i <= $end; $i++) {
        $active = $i == $currentPage ? ' active' : '';
        echo '<a href="' . $widget->pageLink($i) . '" class="pagination-item' . $active . '">' . $i . '</a>';
    }
    
    if ($end < $totalPage) {
        if ($end < $totalPage - 1) {
            echo '<span class="pagination-ellipsis">...</span>';
        }
        echo '<a href="' . $widget->pageLink($totalPage) . '" class="pagination-item">' . $totalPage . '</a>';
    }
    
    // 下一页
    if ($currentPage < $totalPage) {
        echo '<a href="' . $widget->pageLink($currentPage + 1) . '" class="pagination-item pagination-next">下一页 →</a>';
    }
    
    echo '</div>';
}

/**
 * 获取归档统计
 */
function getArchiveStats() {
    $db = Typecho_Db::get();
    $prefix = $db->getPrefix();
    
    // 文章数
    $postCount = $db->fetchObject($db->select(array('COUNT(cid)' => 'num'))
        ->from('table.contents')
        ->where('type = ?', 'post')
        ->where('status = ?', 'publish'))->num;
    
    // 分类数
    $categoryCount = $db->fetchObject($db->select(array('COUNT(mid)' => 'num'))
        ->from('table.metas')
        ->where('type = ?', 'category'))->num;
    
    // 标签数
    $tagCount = $db->fetchObject($db->select(array('COUNT(mid)' => 'num'))
        ->from('table.metas')
        ->where('type = ?', 'tag'))->num;
    
    // 年份数
    $yearCount = $db->fetchObject($db->select(array('COUNT(DISTINCT FROM_UNIXTIME(created, "%Y"))' => 'num'))
        ->from('table.contents')
        ->where('type = ?', 'post')
        ->where('status = ?', 'publish'))->num;
    
    return array(
        'posts' => $postCount,
        'categories' => $categoryCount,
        'tags' => $tagCount,
        'years' => $yearCount
    );
}

