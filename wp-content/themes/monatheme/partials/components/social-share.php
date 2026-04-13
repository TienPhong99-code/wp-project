<?php
    $link = get_the_permalink();
    $link_encoded = urlencode($link);
?>
<div class="postdt-share">
    <span><?php esc_html_e('Chia sẻ:', 'monamedia'); ?></span>
    <ul class="postdt-share_list">
        <li>
            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $link_encoded; ?>" target="_blank" rel="noopener">
                <img src="<?php echo MONA_THEME_PATH_URI; ?>/assets/images/post/icon_fb.png" alt="Image" title="Image" loading="lazy">
            </a>
        </li>
        <li>
            <a href="https://zalo.me/share?url=<?php echo $link_encoded; ?>" target="_blank" rel="noopener">
                <img src="<?php echo MONA_THEME_PATH_URI; ?>/assets/images/post/icon_zalo.png" alt="Image" title="Image" loading="lazy">
            </a>
        </li>
        <li>
            <a class="copy-btn" href="<?php echo $link; ?>" 
                data-success="<?php esc_html_e('Đã sao chép', 'monamedia'); ?>"
                data-fail="<?php esc_html_e('Copy không được', 'monamedia'); ?>">
                <img src="<?php echo MONA_THEME_PATH_URI; ?>/assets/images/post/icon_share.png" alt="Image" title="Image" loading="lazy">
                <span class="tooltip"></span>
            </a>
        </li>
    </ul>
</div>