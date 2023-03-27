<?php
/*
* Plugin Name: AI Chatbot
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
define('AI_CHATBOT_IMG_BOT', AI_CHATBOT_URL.'images/bot-chat.png');


add_action('admin_menu',  'ai_chatbot_admin_menu');

function ai_chatbot_admin_menu(){
    add_menu_page(__('AI Chatbot', 'ai-chatbot'), __('AI Chatboat', 'ai-chatbot'), 'manage_options', 'ai-chatbot', 'ai_chatbot',  '', 40);
}

function ai_chatbot_admin_enqueue() {
  wp_enqueue_style('ai-chatboat-bstyle', AI_CHATBOT_URL.'/css/backend.css');
  wp_enqueue_script( 'ai-chatboat-backend',  AI_CHATBOT_URL. '/js/backend.js', array('jquery') );

  wp_localize_script( 'ai-chatboat-backend', 'ai_chatbot', array( 
    'ajax_url' => admin_url( 'admin-ajax.php' ),
  '_anonce'       => wp_create_nonce( 'ai-chatbot-nonec-ajax' )
  ) );
}
add_action( 'admin_enqueue_scripts', 'ai_chatbot_admin_enqueue' );

include 'backend.php';
include 'open-ai.php';

define('AI_CHATBOT_API_KEY',ai_chatbot_get('api_key'));


function ai_chatbot(){
    echo "<div class='ai-wrap'>";
    ai_chatbot_backend_form();
    echo "<h2>".__('AI Chatbot Testing Data','ai-chatbot')."</h2>";
    ai_chatbot_backend_input();
    echo "<img class='ai-loader' width='80px' src='".esc_url(AI_CHATBOT_URL)."images/spinner.gif'/>";
    echo "<div id='re-compare-bar'></div>";
    echo "</div>";

  }
  
function ai_chatbot_enqueue() {

  wp_enqueue_style('ai-chatboat-style', AI_CHATBOT_URL.'/css/front.css');
  wp_enqueue_script( 'ai-chatboat-front',  AI_CHATBOT_URL. '/js/front.js', array('jquery') );
  wp_localize_script( 'ai-chatboat-front', 'ai_chatot_ajax', array(
     'ai_chatbot_url'=>AI_CHATBOT_URL,
     '_anonce'       => wp_create_nonce( 'ai-chatbot-nonec-ajax' ),
     'ai_chatbot_audio'=>AI_CHATBOT_ENTER_AUDIO,
     'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
}
add_action( 'wp_enqueue_scripts', 'ai_chatbot_enqueue' );




