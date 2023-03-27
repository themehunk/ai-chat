<?php
/*
* Plugin Name: AI Chatboat
  Version: 0.1
  Author: ThemeHunk
  Text Domain: ai-chatboat
  Author URI: http://www.themehunk.com/
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
define('AI_CHATBOT_URL', plugin_dir_url(__FILE__));
define('AI_CHATBOT_PATH', plugin_dir_path(__FILE__));
define('AI_CHATBOT_ENTER_AUDIO', AI_CHATBOT_URL.'audio/enter.mp3');
define('AI_CHATBOT_AI_AUDIO', AI_CHATBOT_URL.'audio/ai-send.mp3');
define('AI_CHATBOT_IMG_BOAT', AI_CHATBOT_URL.'images/bot-chat.png');


add_action('admin_menu',  'ai_chatboat_admin_menu');

function ai_chatboat_admin_menu(){
    add_menu_page(__('AI Chatboat', 'ai-chatboat'), __('AI Chatboat', 'ai-chatboat'), 'manage_options', 'remote-post', 'ai_chatboat',  '', 40);
}

function ai_chatboat_admin_enqueue() {
  wp_enqueue_style('ai-chatboat-bstyle', AI_CHATBOT_URL.'/css/backend.css');
  wp_enqueue_script( 'ai-chatboat-backend',  AI_CHATBOT_URL. '/js/backend.js', array('jquery') );

  wp_localize_script( 'ai-chatboat-backend', 'ai_chatboat', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
}
add_action( 'admin_enqueue_scripts', 'ai_chatboat_admin_enqueue' );

include 'backend.php';
include 'open-ai.php';

define('AI_CHATBOT_API_KEY',ai_chatboat_get('api_key'));


function ai_chatboat(){

  echo "<h1>AI Chatboat (Open AI Chatgpt)</h1>";
    ai_chatboat_backend_form();
    open_ai_input();
    echo "<h2>AI Data Testing</h2>";
    echo "<img class='ai-loader' width='80px' src='http://localhost/wp572/wp-content/uploads/2023/03/loader.gif'/>";
    echo "<div id='re-compare-bar'></div>";
  
  }
  



function ai_chatboat_enqueue() {

  wp_enqueue_style('ai-chatboat-style', AI_CHATBOT_URL.'/css/front.css');
  wp_enqueue_script( 'ai-chatboat-front',  AI_CHATBOT_URL. '/js/front.js', array('jquery') );
  wp_localize_script( 'ai-chatboat-front', 'ai_chatoat_ajax', array(
     'ai_chatbot_url'=>AI_CHATBOT_URL,
     'ai_chatbot_audio'=>AI_CHATBOT_ENTER_AUDIO,
     'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
}
add_action( 'wp_enqueue_scripts', 'ai_chatboat_enqueue' );


function ai_chatboat_live_chat() {
 ?> <button class="open-button" onclick="openForm()"><img src="<?php echo AI_CHATBOT_URL; ?>/images/bot.png"></button>

<div class="chat-popup" id="chatForm">
  <div class="form-container ">
    <div class="ai-header" onclick="closeForm()"> <h2><img class="ai-head-img" id="user-0" src="https://blogwings.com/wpdemo/wp-content/plugins/ai-chatbot/images/bot-chat.png">Live AI Chatbot
		
		</h2></div>


     <section class="chat-window" id="chat-window">
        <article class="msg-container msg-remote first-msg" id="msg-0">
        <div class="msg-box">
          <div class="flr">
            <div class="messages">
              <p class="msg" id="msg-0"><?php _e('This is a Ai Chatbot. You can ask anything to this Chatbot Like What is the theory of evolution.
');?>
              </p>
            </div>
            <span class="timestamp"><span class="username">AI Chatbot</span></span>
          </div>
        </div>
      </article>
    </section>


  </div>

      <form class="chat-input" id="chat-input" onsubmit="return false;">
      <input type="text" autocomplete="on" placeholder="Type a message" id="chatbox" name="chatbox"/>
      <button id="chatClick">
                    <svg style="width:24px;height:24px" viewBox="0 0 24 24"><path fill="rgba(0,0,0,.38)" d="M17,12L12,17V14H8V10H12V7L17,12M21,16.5C21,16.88 20.79,17.21 20.47,17.38L12.57,21.82C12.41,21.94 12.21,22 12,22C11.79,22 11.59,21.94 11.43,21.82L3.53,17.38C3.21,17.21 3,16.88 3,16.5V7.5C3,7.12 3.21,6.79 3.53,6.62L11.43,2.18C11.59,2.06 11.79,2 12,2C12.21,2 12.41,2.06 12.57,2.18L20.47,6.62C20.79,6.79 21,7.12 21,7.5V16.5M12,4.15L5,8.09V15.91L12,19.85L19,15.91V8.09L12,4.15Z" /></svg>
                </button>
		   <div class="ai-chat-powerd-by">Powerd by <a href="https://themehunk.com" target="_blank">ThemeHunk</a></div>
    </form>
   
</div>
<?php
}
add_action( 'wp_footer', 'ai_chatboat_live_chat', 100 );