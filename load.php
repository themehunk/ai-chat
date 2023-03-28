<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

add_action('admin_menu',  'ai_chatbot_admin_menu');

function ai_chatbot_admin_menu(){
    add_menu_page(__('AI Chatbot', 'ai-chatbot'), __('AI Chatbot', 'ai-chatbot'), 'manage_options', 'ai-chatbot','ai_chatbot', AI_CHATBOT_URL.'/images/icon-bot.png',66);

}

function ai_chatbot(){
    echo "<div class='ai-wrap'>";
    ai_chatbot_backend_form();
    echo "<h2>".__('AI Chatbot Testing Data','ai-chatbot')."</h2>";
    ai_chatbot_backend_input();
    echo "<img class='ai-loader' width='80px' src='".esc_url(AI_CHATBOT_URL)."images/spinner.gif'/>";
    echo "<div id='re-compare-bar'></div>";
    echo "</div>";

  }

function ai_chatbot_admin_enqueue($hook) {
  if($hook != 'toplevel_page_ai-chatbot') return;
  wp_enqueue_style('ai-chatbot-bstyle', AI_CHATBOT_URL.'/css/backend.css');
  wp_enqueue_script( 'ai-chatbot-backend',  AI_CHATBOT_URL. '/js/backend.js', array('jquery') );

  wp_localize_script( 'ai-chatbot-backend', 'ai_chatbot', array( 
    'ajax_url' => admin_url( 'admin-ajax.php' ),
  '_anonce'       => wp_create_nonce( 'ai-chatbot-nonec-ajax' )
  ) );
}
add_action( 'admin_enqueue_scripts', 'ai_chatbot_admin_enqueue' );


function ai_chatbot_enqueue() {

  wp_enqueue_style('ai-chatbot-style', AI_CHATBOT_URL.'/css/front.css');
  wp_enqueue_script( 'ai-chatbot-front',  AI_CHATBOT_URL. '/js/front.js', array('jquery') );
  wp_localize_script( 'ai-chatbot-front', 'ai_chatot_ajax', array(
     'ai_chatbot_url'=>AI_CHATBOT_URL,
     '_anonce'       => wp_create_nonce( 'ai-chatbot-nonec-ajax' ),
     'ai_chatbot_audio'=>AI_CHATBOT_ENTER_AUDIO,
     'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
}
add_action( 'wp_enqueue_scripts', 'ai_chatbot_enqueue' );

require_once AI_CHATBOT_PATH . '/backend.php';
require_once AI_CHATBOT_PATH . '/open-ai.php';
