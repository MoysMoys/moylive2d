<?php
/*
Plugin Name: moylive2d
Plugin URI: https://blog.moyus.cn/
Description: 添加一个Live2D人物在你的博客里。基于戴兜的PoiLive2d插件修改而来。<a href="https://daidr.me/archives/code-176.html" target="_blank">原版插件下载地址</a>
Version: 1.0
Author: MoYus
Author URI: https://www.moyus.cn/
License: GPLv2
*/

defined('ABSPATH') or exit;
define('LIVE2D_VERSION', '1.0');
define('LIVE2D_URL', plugins_url('', __FILE__));
define('LIVE2D_PATH', dirname(__FILE__));

register_activation_hook(__FILE__, 'moylive2d_plugin_activate');
add_action('admin_init', 'moylive2d_plugin_redirect');


function moylive2d_plugin_redirect()
{
    if (get_option('do_activation_redirect', false)) {
        delete_option('do_activation_redirect');
        wp_redirect(admin_url('options-general.php?page=moylive2d'));
    }
}

function moylive2d_register_plugin_settings_link($links)
{
    $settings_link = '<a href="options-general.php?page=moylive2d">设置</a>';
    array_unshift($links, $settings_link);
    return $links;
}
$plugin = plugin_basename(__FILE__);
add_filter("plugin_action_links_{$plugin}", 'moylive2d_register_plugin_settings_link');

if (is_admin()) {
    add_action('admin_menu', 'moylive2d_menu');
}

function moylive2d_menu()
{
    add_options_page('moylive2d 控制面板', 'moylive2d 设置', 'administrator', 'moylive2d', 'moylive2d_pluginoptions_page');
}

function moylive2d_pluginoptions_page()
{
    require "option.php";
}

//设定默认值
$live2d_setting_default = array(
    'maincolor' => '#ce00ff'
);

//写入默认设置
if (!get_option('live2d_maincolor')) {
    update_option('live2d_maincolor', $live2d_setting_default['maincolor']);
}
if (!get_option('live2d_nohitokoto')) {
    update_option('live2d_nohitokoto', '');
}
if (!get_option('live2d_nospecialtip')) {
    update_option('live2d_nospecialtip', '');
}
if (!get_option('live2d_nocatalog')) {
    update_option('live2d_nocatalog', '');
}
if (!get_option('live2d_custommsg')) {
    $json = "{\"mouseover\":[{\"selector\":\".entry-content a\",\"text\":[\"要看看 <span style='color:#0099cc;'>「{text}」</span> 么？\"]},{\"selector\":\".post .post-title\",\"text\":[\"主人写的<s>爽文</s> <span style='color:#0099cc;'>「{text}」</span> ，要看看嘛？\"]},{\"selector\":\".feature-content a\",\"text\":[\"超级热门的 <span style='color:#0099cc;'>「{text}」</span> ，要看看么？\"]},{\"selector\":\".searchbox\",\"text\":[\"在找什么东西呢，需要帮忙吗？\"]},{\"selector\":\".top-social\",\"text\":[\"这里是主人的社交账号啦！不关注一波嘛？\"]},{\"selector\":\".zilla-likes\",\"text\":[\"听说点这个主人会很开心哦~\"]},{\"selector\":\".cd-top\",\"text\":[\"你想要返回顶部嘛？\"]},{\"selector\":\".site-title\",\"text\":[\"你要返回首页是吗？\"]},{\"selector\":\".comments\",\"text\":[\"看了这么久，是时候评论一下啦！\"]},{\"selector\":\".post-nepre.previous\",\"text\":[\"看看主人的上一篇文章怎么样？\"]},{\"selector\":\".post-nepre.next\",\"text\":[\"看看主人的下一篇文章怎么样？\"]},{\"selector\":\".reward-open\",\"text\":[\"你看主人把我扔在这么慢的服务器上，打赏了解一下？\"]},{\"selector\":\".moyplay.playing\",\"text\":[\"这是播放按钮啦~\"]},{\"selector\":\".moy-open-list\",\"text\":[\"戳一下就可以看到歌词哦！\"]},{\"selector\":\"#open-moy-player\",\"text\":[\"听说点这个按钮可以显示/隐藏播放器？\"]},{\"selector\":\".hide-button\",\"text\":[\"我有话唠属性，觉得我烦可以关掉我哦~\"]},{\"selector\":\"#pagination\",\"text\":[\"想看看更久远的内容？\"]}],\"click\":[{\"selector\":\"#landlord #live2d\",\"text\":[\"不要动手动脚的！快把手拿开~~\",\"真…真的是不知羞耻！\",\"Hentai！\",\"再摸的话我可要报警了！⌇●﹏●⌇\",\"110吗，这里有个变态一直在摸我(ó﹏ò｡)\"]}]}";
    update_option('live2d_custommsg', $json);
}
if (!get_option('live2d_localkoto')) {
    $customkoto = "{\n\t\"localkoto\": [\n\t\t\"絶対、大丈夫！\",\n\t\t\"奇迹的驱逐舰？唔唔，才不是奇迹！\",\n\t\t\"感受到幸运女神之吻了！！\",\n\t\t\"是！我会加油的！\"\n\t]\n}";
    update_option('live2d_customkoto', $customkoto);
}
if (!get_option('live2d_custommoymodel')) {
    $custommoymodel = "[\"chino\",\"diana\",\"kanna\",\"kazuha\",\"kurumi\",\"mikoto\",\"moonrabbit\",\"pio\",\"platelet\",\"rem\",\"sagiri\",\"umaru\"]";
    update_option('live2d_custommoymodel', $custommoymodel);
}

require LIVE2D_PATH . '/main.php';
?>