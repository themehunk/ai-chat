<?php
/*
* Plugin Name: AI Chat
  Version: 1.0
  Author: ThemeHunk
  Description:AI Chatbot plugin integrated with OpenAI ChatGPT technology! Engage your website visitors like never before with a personalized chat experience.
  Text Domain: ai-chat
  Author URI: http://www.themehunk.com/
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
define('AI_CHAT_URL', plugin_dir_url(__FILE__));
define('AI_CHAT_PATH', plugin_dir_path(__FILE__));
define('AI_CHAT_ENTER_AUDIO', AI_CHAT_URL.'audio/enter.mp3');
define('AI_CHAT_AI_AUDIO', AI_CHAT_URL.'audio/ai-send.mp3');
define('AI_CHAT_IMG_BOT', AI_CHAT_URL.'images/bot-chat.png');

require_once AI_CHAT_PATH . '/load.php';





