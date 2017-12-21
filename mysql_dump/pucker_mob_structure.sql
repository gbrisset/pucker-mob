-- phpMyAdmin SQL Dump
-- version 4.7.6
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 21, 2017 at 04:00 PM
-- Server version: 5.6.33-log
-- PHP Version: 5.5.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pucker_mob`
--

-- --------------------------------------------------------

--
-- Stand-in structure for view `active_user_contributors`
-- (See below for the actual view)
--
CREATE TABLE `active_user_contributors` (
`contributor_id` mediumint(11)
,`contributor_name` varchar(500)
,`contributor_seo_name` varchar(500)
,`contributor_location` varchar(500)
,`contributor_bio` longtext
,`contributor_image` varchar(500)
,`contributor_blog_link` varchar(500)
,`contributor_email_address` varchar(500)
,`contributor_twitter_handle` varchar(500)
,`contributor_facebook_link` varchar(500)
,`creation_date` timestamp
,`user_id` mediumint(11)
,`user_name` varchar(100)
,`user_hashed_password` varchar(255)
,`user_salt` varchar(255)
,`user_email` varchar(100)
,`user_first_name` varchar(100)
,`user_last_name` varchar(100)
,`user_type` mediumint(4)
,`user_login_count` int(11)
,`user_verified` tinyint(1)
,`tos_agreed` tinyint(1)
,`user_verification_code` varchar(100)
,`user_creation_date` timestamp
,`user_display_image` varchar(500)
,`user_display_name` varchar(500)
,`user_facebook_id` varchar(500)
,`remember_token` varchar(120)
);

-- --------------------------------------------------------

--
-- Table structure for table `ads`
--

CREATE TABLE `ads` (
  `id` bigint(20) NOT NULL,
  `label` varchar(500) NOT NULL,
  `default_position` int(11) NOT NULL DEFAULT '-1',
  `ad_tag` longtext NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 = Mobile | 1 = Desktop',
  `relation_num` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ad_matching_program`
--

CREATE TABLE `ad_matching_program` (
  `bonus_id` int(11) NOT NULL,
  `bonus_label` varchar(500) NOT NULL DEFAULT 'Bonus!',
  `bonus_month` int(11) NOT NULL,
  `bonus_year` int(11) NOT NULL,
  `bonus_user_pct` int(11) NOT NULL DEFAULT '0',
  `bonus_match_pct` int(11) NOT NULL DEFAULT '0',
  `user_type` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ad_matching_transactions`
--

CREATE TABLE `ad_matching_transactions` (
  `id` bigint(11) NOT NULL,
  `contributor_id` bigint(20) NOT NULL,
  `spent` float NOT NULL,
  `balance` float NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `receipt` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `article_id` mediumint(11) NOT NULL,
  `article_title` varchar(1000) NOT NULL,
  `article_seo_title` varchar(1000) NOT NULL,
  `article_body` longtext NOT NULL,
  `article_desc` longtext NOT NULL,
  `article_yield` varchar(500) NOT NULL,
  `article_prep_time` varchar(500) NOT NULL,
  `article_cook_time` varchar(500) NOT NULL,
  `article_ingredients` longtext NOT NULL,
  `article_instructions` longtext NOT NULL,
  `article_template_type` tinyint(4) NOT NULL DEFAULT '1',
  `article_tags` varchar(1500) NOT NULL,
  `article_additional_comments` longtext NOT NULL,
  `article_poll_id` varchar(500) NOT NULL,
  `article_status` tinyint(1) NOT NULL DEFAULT '3' COMMENT '1 = Live, 2 = Pending Review, 3 = Draft',
  `page_list_id` int(11) NOT NULL DEFAULT '0',
  `article_type` int(11) NOT NULL DEFAULT '2' COMMENT '2 = opinion articles  1 = straight news 0=Staff articles',
  `isTopic` tinyint(4) NOT NULL DEFAULT '0',
  `fb_shares` int(11) NOT NULL DEFAULT '0',
  `fb_shares_update` datetime DEFAULT NULL,
  `creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_updated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `posted_by` varchar(500) DEFAULT NULL,
  `article_img_credits` varchar(500) NOT NULL,
  `article_img_credits_url` varchar(500) NOT NULL,
  `article_disclaimer` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'yes = 1, no = 0',
  `article_read_more_pct` int(11) NOT NULL DEFAULT '35',
  `article_agree_edits` tinyint(4) NOT NULL DEFAULT '0',
  `article_video_script` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `articles_featured`
--

CREATE TABLE `articles_featured` (
  `featured_id` mediumint(11) NOT NULL,
  `cat_id` mediumint(11) NOT NULL,
  `article_id` mediumint(11) NOT NULL,
  `feature_type` mediumint(4) NOT NULL COMMENT '1 = Sidebar, 2 = Dish of the Day, 3=Slideshow, 4 = Ask The Chef',
  `feature_position` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Stand-in structure for view `articles_list`
-- (See below for the actual view)
--
CREATE TABLE `articles_list` (
`article_id` mediumint(11)
,`article_status` tinyint(1)
,`creation_date` timestamp
,`date_updated` timestamp
,`article_title` varchar(1000)
,`article_seo_title` varchar(1000)
,`cat_id` int(11)
,`cat_name` varchar(20)
,`cat_dir_name` varchar(500)
,`contributor_id` mediumint(11)
,`contributor_seo_name` varchar(500)
,`contributor_name` varchar(500)
,`contributor_image` varchar(500)
,`user_type` mediumint(4)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `articles_list_admin`
-- (See below for the actual view)
--
CREATE TABLE `articles_list_admin` (
`article_id` bigint(20)
,`article_title` varchar(1000)
,`article_seo_title` varchar(1000)
,`article_status` tinyint(1)
,`date_updated` timestamp
,`creation_date` timestamp
,`cat_id` mediumint(11)
,`cat_dir_name` varchar(500)
,`contributor_name` varchar(500)
,`contributor_seo_name` varchar(500)
,`contributor_email_address` varchar(500)
,`user_type` mediumint(4)
,`user_id` mediumint(11)
,`facebook_page_name` varchar(500)
,`promoted` tinyint(4)
,`facebook_page_id` int(11)
,`usa_pageviews` decimal(41,0)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `articles_list_admin_promote`
-- (See below for the actual view)
--
CREATE TABLE `articles_list_admin_promote` (
`article_id` bigint(20)
,`article_title` varchar(1000)
,`article_seo_title` varchar(1000)
,`article_status` tinyint(1)
,`date_updated` timestamp
,`creation_date` timestamp
,`cat_id` mediumint(11)
,`cat_dir_name` varchar(500)
,`contributor_name` varchar(500)
,`contributor_seo_name` varchar(500)
,`contributor_email_address` varchar(500)
,`user_type` mediumint(4)
,`user_id` mediumint(11)
,`facebook_page_name` varchar(500)
,`promoted` tinyint(4)
,`facebook_page_id` int(11)
,`usa_pageviews` decimal(41,0)
);

-- --------------------------------------------------------

--
-- Table structure for table `article_additional_images`
--

CREATE TABLE `article_additional_images` (
  `article_id` bigint(20) NOT NULL,
  `article_img_name` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `article_ads`
--

CREATE TABLE `article_ads` (
  `article_id` bigint(20) NOT NULL,
  `desktop_5` int(11) NOT NULL DEFAULT '-1',
  `desktop_4` int(11) NOT NULL DEFAULT '-1',
  `desktop_1` int(11) NOT NULL DEFAULT '2',
  `desktop_3` int(11) NOT NULL DEFAULT '-1',
  `desktop_2` int(11) NOT NULL DEFAULT '5',
  `mobile_1` int(11) NOT NULL DEFAULT '2',
  `mobile_2` int(11) NOT NULL DEFAULT '5',
  `mobile_3` int(11) NOT NULL DEFAULT '9',
  `mobile_4` int(11) NOT NULL DEFAULT '15',
  `mobile_5` int(11) NOT NULL DEFAULT '-1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `article_categories`
--

CREATE TABLE `article_categories` (
  `article_id` mediumint(11) NOT NULL,
  `cat_id` mediumint(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `article_category_page_featured_contributors`
--

CREATE TABLE `article_category_page_featured_contributors` (
  `featured_id` mediumint(11) NOT NULL,
  `category_page_id` mediumint(11) NOT NULL,
  `contributor_id` mediumint(11) NOT NULL,
  `feature_type` mediumint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `article_contributors`
--

CREATE TABLE `article_contributors` (
  `contributor_id` mediumint(11) NOT NULL,
  `contributor_name` varchar(500) NOT NULL,
  `contributor_seo_name` varchar(500) NOT NULL,
  `contributor_location` varchar(500) NOT NULL,
  `contributor_bio` longtext NOT NULL,
  `contributor_image` varchar(500) NOT NULL DEFAULT 'default_profile_img.png',
  `contributor_blog_link` varchar(500) NOT NULL,
  `contributor_email_address` varchar(500) NOT NULL,
  `contributor_twitter_handle` varchar(500) NOT NULL,
  `contributor_facebook_link` varchar(500) NOT NULL,
  `creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `article_contributor_articles`
--

CREATE TABLE `article_contributor_articles` (
  `article_id` mediumint(11) NOT NULL,
  `contributor_id` mediumint(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Stand-in structure for view `article_daily_earnings`
-- (See below for the actual view)
--
CREATE TABLE `article_daily_earnings` (
`article_id` bigint(20)
,`pageviews` bigint(20)
,`usa_pageviews` bigint(20)
,`pct_pageviews` bigint(20)
,`month` int(11)
,`year` bigint(20)
,`updated_date` timestamp
,`article_title` varchar(1000)
,`article_seo_title` varchar(1000)
,`cat_id` int(11)
,`cat_name` varchar(20)
,`contributor_id` mediumint(11)
);

-- --------------------------------------------------------

--
-- Table structure for table `article_images`
--

CREATE TABLE `article_images` (
  `article_id` mediumint(11) NOT NULL,
  `article_post_img` varchar(500) DEFAULT NULL,
  `article_preview_img` varchar(500) DEFAULT NULL,
  `article_main_img` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `article_moblogs_featured`
--

CREATE TABLE `article_moblogs_featured` (
  `article_id` bigint(20) NOT NULL,
  `article_cat` varchar(200) NOT NULL DEFAULT 'moblog',
  `article_featured_hp` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `article_pages`
--

CREATE TABLE `article_pages` (
  `article_page_id` mediumint(11) NOT NULL,
  `article_page_name` varchar(500) NOT NULL,
  `article_page_visible_name` varchar(500) NOT NULL,
  `article_page_desc` longtext,
  `article_page_tags` varchar(1500) DEFAULT NULL,
  `article_page_assets_directory` varchar(100) DEFAULT NULL,
  `article_page_full_url` varchar(500) DEFAULT NULL,
  `article_page_analytics` longtext,
  `article_page_video_label` varchar(100) NOT NULL,
  `article_page_video_url` varchar(500) DEFAULT NULL,
  `article_page_sidebar_text` varchar(1000) DEFAULT NULL,
  `article_page_featured_article_text` varchar(1000) DEFAULT NULL,
  `cat_id` mediumint(11) NOT NULL,
  `article_page_live` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `article_pages_navigation_links`
--

CREATE TABLE `article_pages_navigation_links` (
  `article_page_id` mediumint(11) NOT NULL,
  `article_link_id` mediumint(11) NOT NULL,
  `article_link_order` mediumint(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `article_page_ads`
--

CREATE TABLE `article_page_ads` (
  `article_page_id` mediumint(11) NOT NULL,
  `300_atf` longtext,
  `300_btf1` longtext,
  `300_btf2` longtext,
  `728_atf` longtext,
  `728_btf` longtext,
  `728_ctf` longtext NOT NULL,
  `728_dtf` longtext NOT NULL,
  `1050_btf` longtext,
  `300_mobile` longtext,
  `sponsored_placement` longtext,
  `ads_rotate` tinyint(1) NOT NULL DEFAULT '0',
  `ad_rotation_time` mediumint(4) NOT NULL DEFAULT '240',
  `has_sponsored_by` tinyint(4) NOT NULL DEFAULT '0',
  `has_google_ad_sense` tinyint(4) NOT NULL DEFAULT '0',
  `sponsored_by_img` varchar(500) NOT NULL,
  `sponsored_super_banner` varchar(500) NOT NULL,
  `sponsored_by_url` varchar(500) NOT NULL,
  `sponsored_super_banner_url` varchar(500) NOT NULL,
  `has_secondary_banner` tinyint(4) NOT NULL,
  `secondary_banner_img` varchar(500) NOT NULL,
  `secondary_banner_url` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `article_page_categories`
--

CREATE TABLE `article_page_categories` (
  `article_page_id` mediumint(11) NOT NULL,
  `category_page_id` mediumint(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `article_page_featured_articles`
--

CREATE TABLE `article_page_featured_articles` (
  `featured_id` mediumint(11) NOT NULL,
  `category_page_id` mediumint(11) NOT NULL,
  `article_id` mediumint(11) NOT NULL,
  `feature_type` mediumint(4) NOT NULL COMMENT '1 = Sidebar, 2 = Dish of the Day, 3=Slideshow, 4 = Ask The Chef',
  `feature_position` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `article_page_featured_contributors`
--

CREATE TABLE `article_page_featured_contributors` (
  `featured_id` mediumint(11) NOT NULL,
  `article_page_id` mediumint(11) NOT NULL,
  `contributor_id` mediumint(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `article_page_images`
--

CREATE TABLE `article_page_images` (
  `article_page_id` mediumint(11) NOT NULL,
  `article_page_logo` varchar(500) NOT NULL,
  `article_page_footer_logo` varchar(500) NOT NULL,
  `article_page_player_logo` varchar(500) NOT NULL,
  `featured_img` varchar(500) DEFAULT NULL,
  `featured_img_link` varchar(500) DEFAULT NULL,
  `sidebar_image` varchar(500) DEFAULT NULL,
  `sidebar_image_link` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `article_page_main_categories`
--

CREATE TABLE `article_page_main_categories` (
  `parent_child_rel_id` int(11) NOT NULL,
  `parent_category_id` mediumint(9) NOT NULL,
  `child_category_id` mediumint(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `article_page_navigation_links`
--

CREATE TABLE `article_page_navigation_links` (
  `navigation_link_id` mediumint(11) NOT NULL,
  `navigation_link_text` varchar(500) NOT NULL,
  `navigation_link_url` varchar(500) NOT NULL,
  `navigation_link_footer_only` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `article_page_player_settings`
--

CREATE TABLE `article_page_player_settings` (
  `article_page_id` mediumint(11) NOT NULL,
  `player_setting_debug` tinyint(1) NOT NULL DEFAULT '1',
  `player_setting_autoplay` tinyint(1) NOT NULL DEFAULT '1',
  `player_setting_randomize_playlist` tinyint(1) NOT NULL DEFAULT '1',
  `player_setting_countoff_start` tinyint(1) NOT NULL DEFAULT '1',
  `player_setting_withads` tinyint(1) NOT NULL DEFAULT '1',
  `player_setting_prerolls` tinyint(1) NOT NULL DEFAULT '1',
  `player_setting_postrolls` tinyint(1) NOT NULL DEFAULT '0',
  `player_setting_ad_server_key` varchar(100) DEFAULT NULL,
  `player_setting_ad_server_keywords` varchar(500) DEFAULT NULL,
  `player_setting_ad_server_categories` varchar(500) DEFAULT NULL,
  `player_setting_api_key` varchar(64) NOT NULL,
  `player_setting_playlist_slug` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `article_page_series`
--

CREATE TABLE `article_page_series` (
  `article_page_series_id` mediumint(9) NOT NULL,
  `article_page_series_title` varchar(500) NOT NULL,
  `article_page_series_desc` longtext NOT NULL,
  `article_page_series_prev_desc` varchar(500) NOT NULL,
  `article_page_series_seo` varchar(500) NOT NULL,
  `article_page_series_image` varchar(500) NOT NULL,
  `article_page_series_active` tinyint(4) NOT NULL DEFAULT '0',
  `article_page_series_visible_hp` tinyint(4) NOT NULL DEFAULT '0',
  `article_page_series_playlist` varchar(500) NOT NULL,
  `article_page_series_order` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `article_page_series_playlist`
--

CREATE TABLE `article_page_series_playlist` (
  `article_page_series_id` mediumint(9) NOT NULL,
  `syn_video_id` mediumint(9) NOT NULL,
  `article_page_series_featured_video` mediumint(9) NOT NULL DEFAULT '0' COMMENT '1 = Main Video, 2 = SlideShow',
  `article_page_series_video_prev_img` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `article_page_social_settings`
--

CREATE TABLE `article_page_social_settings` (
  `article_page_id` mediumint(11) NOT NULL,
  `article_page_facebook_url` varchar(500) DEFAULT NULL,
  `article_page_facebook_gallery_url` varchar(500) DEFAULT NULL,
  `article_page_facebook_gallery_text` varchar(500) DEFAULT NULL,
  `article_page_facebook_app_id` varchar(500) DEFAULT NULL,
  `article_page_twitter_url` varchar(500) DEFAULT NULL,
  `article_page_pinterest_url` varchar(500) DEFAULT NULL,
  `article_page_googleplus_url` varchar(500) DEFAULT NULL,
  `article_page_contact_email` varchar(500) DEFAULT NULL,
  `article_page_newletter_api_key` varchar(500) NOT NULL,
  `article_page_newletter_list_id` varchar(500) NOT NULL,
  `articles_have_facebook` tinyint(1) NOT NULL DEFAULT '1',
  `articles_have_twitter` tinyint(1) NOT NULL DEFAULT '1',
  `articles_have_pinterest` tinyint(1) NOT NULL DEFAULT '1',
  `articles_have_googleplus` tinyint(1) NOT NULL DEFAULT '0',
  `articles_have_linkedin` tinyint(1) NOT NULL DEFAULT '0',
  `articles_have_stumble` tinyint(4) NOT NULL DEFAULT '1',
  `articles_have_ziplist` tinyint(1) NOT NULL DEFAULT '0',
  `articles_have_print` tinyint(4) NOT NULL DEFAULT '0',
  `google_cxid` varchar(500) NOT NULL,
  `google_csoutput` varchar(20) NOT NULL,
  `google_csclient` varchar(20) NOT NULL,
  `google_csnum` int(11) NOT NULL,
  `article_page_info_contact_email` varchar(500) DEFAULT NULL,
  `article_page_advertise_contact_email` varchar(500) DEFAULT NULL,
  `article_page_sell_sheet` varchar(500) DEFAULT NULL,
  `article_page_featured_badge_logo` varchar(500) DEFAULT NULL,
  `article_page_featured_badge_label` varchar(500) DEFAULT NULL,
  `article_page_featured_badge_favicon` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `article_page_styling`
--

CREATE TABLE `article_page_styling` (
  `article_page_id` mediumint(11) NOT NULL,
  `article_page_bg_color` varchar(20) NOT NULL DEFAULT '#ffffff',
  `article_page_bar_color` varchar(20) NOT NULL DEFAULT '#7d2f2f',
  `article_page_player_accent_color` varchar(20) NOT NULL,
  `article_page_header_bg_color` varchar(20) NOT NULL DEFAULT '#ffffff',
  `article_page_header_link_color` varchar(20) NOT NULL DEFAULT '#3333333',
  `article_page_header_link_hover_color` varchar(20) NOT NULL DEFAULT '#000000'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `article_rates`
--

CREATE TABLE `article_rates` (
  `rate_id` int(11) NOT NULL,
  `rate_by_article` int(11) NOT NULL COMMENT '$10 = opinion articles  $5 = straight news $0 = Staff Articles',
  `rate_by_share` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `article_ratings`
--

CREATE TABLE `article_ratings` (
  `article_id` mediumint(11) NOT NULL,
  `rating` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `article_statuses`
--

CREATE TABLE `article_statuses` (
  `status_id` mediumint(11) NOT NULL,
  `status_label` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `article_todays_favorites`
--

CREATE TABLE `article_todays_favorites` (
  `todays_favorites_id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  `slot` tinyint(3) NOT NULL COMMENT '1=left, 2=center, 3=right'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `article_videos`
--

CREATE TABLE `article_videos` (
  `article_id` mediumint(11) NOT NULL,
  `syn_video_id` mediumint(11) NOT NULL,
  `visible_on_article` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ask_the_chef`
--

CREATE TABLE `ask_the_chef` (
  `ask_id` int(11) NOT NULL,
  `ask_title` varchar(255) NOT NULL,
  `ask_image` varchar(255) NOT NULL,
  `ask_question` text NOT NULL,
  `ask_article_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `cat_id` int(11) NOT NULL,
  `cat_name` varchar(20) NOT NULL,
  `cat_dir_name` varchar(500) NOT NULL,
  `cat_desc` longtext NOT NULL,
  `cat_tags` varchar(1500) NOT NULL,
  `cat_dropdown_article_id` int(11) NOT NULL,
  `lft` int(11) NOT NULL,
  `rgt` int(11) NOT NULL,
  `has_children` tinyint(1) NOT NULL DEFAULT '0',
  `cat_is_brand` int(11) NOT NULL DEFAULT '0',
  `category_header_slider_title` varchar(500) NOT NULL,
  `category_slider_live` tinyint(4) NOT NULL DEFAULT '1',
  `category_favorite_articles_title` varchar(500) NOT NULL,
  `cat_background_image` varchar(500) NOT NULL DEFAULT '',
  `cat_partner_banner_recipe_page` varchar(500) NOT NULL,
  `cat_menu_visible` tinyint(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `category_library`
--

CREATE TABLE `category_library` (
  `id` bigint(20) NOT NULL,
  `name` varchar(500) NOT NULL,
  `seo_name` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `collections`
--

CREATE TABLE `collections` (
  `collections_id` int(11) NOT NULL,
  `collections_name` varchar(500) NOT NULL,
  `collections_seoname` varchar(500) NOT NULL,
  `collections_desc` varchar(500) NOT NULL,
  `collections_tags` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `contributor_earnings`
--

CREATE TABLE `contributor_earnings` (
  `id` int(11) NOT NULL,
  `contributor_id` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `year` bigint(20) NOT NULL,
  `total_article_rate` float NOT NULL DEFAULT '0',
  `total_shares` int(11) NOT NULL DEFAULT '0',
  `share_rate` float NOT NULL DEFAULT '0',
  `total_us_pageviews` bigint(20) NOT NULL DEFAULT '0',
  `total_share_rev` float NOT NULL DEFAULT '0',
  `total_earnings` float NOT NULL DEFAULT '0',
  `paid` tinyint(4) NOT NULL DEFAULT '0',
  `to_be_pay` float NOT NULL DEFAULT '0',
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `payday_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `contributor_earnings_BAK_1006`
--

CREATE TABLE `contributor_earnings_BAK_1006` (
  `id` int(11) NOT NULL,
  `contributor_id` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `year` bigint(20) NOT NULL,
  `total_article_rate` float NOT NULL DEFAULT '0',
  `total_shares` int(11) NOT NULL DEFAULT '0',
  `share_rate` float NOT NULL DEFAULT '0',
  `total_us_pageviews` bigint(20) NOT NULL DEFAULT '0',
  `total_share_rev` float NOT NULL DEFAULT '0',
  `total_earnings` float NOT NULL DEFAULT '0',
  `paid` tinyint(4) NOT NULL DEFAULT '0',
  `to_be_pay` float NOT NULL DEFAULT '0',
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `payday_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `count`
--

CREATE TABLE `count` (
  `id` int(11) NOT NULL,
  `view_count` int(11) NOT NULL,
  `article_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `facebook_pages`
--

CREATE TABLE `facebook_pages` (
  `facebook_page_id` int(11) NOT NULL,
  `facebook_page_name` varchar(500) NOT NULL,
  `facebook_page_url` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `featured_article`
--

CREATE TABLE `featured_article` (
  `feature_id` int(11) NOT NULL,
  `article_id` mediumint(11) NOT NULL,
  `category_id` mediumint(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `foodfight`
--

CREATE TABLE `foodfight` (
  `foodfight_id` mediumint(9) NOT NULL,
  `foodfight_seo_name` varchar(500) NOT NULL,
  `foodfight_title` varchar(500) NOT NULL,
  `foodfight_image` varchar(500) NOT NULL,
  `foodfight_related_recipes` longtext NOT NULL,
  `foodfight_top_5_fb` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `google_analytics_data`
--

CREATE TABLE `google_analytics_data` (
  `article_id` bigint(20) NOT NULL,
  `pageviews` bigint(20) NOT NULL,
  `usa_pageviews` bigint(20) NOT NULL,
  `pct_pageviews` float NOT NULL,
  `month` int(11) NOT NULL,
  `year` bigint(20) NOT NULL,
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `google_analytics_data_daily`
--

CREATE TABLE `google_analytics_data_daily` (
  `article_id` bigint(20) NOT NULL,
  `pageviews` bigint(20) NOT NULL,
  `usa_pageviews` bigint(20) NOT NULL,
  `pct_pageviews` bigint(20) NOT NULL,
  `month` int(11) NOT NULL,
  `year` bigint(20) NOT NULL,
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `google_analytics_data_new`
--

CREATE TABLE `google_analytics_data_new` (
  `article_id` bigint(20) NOT NULL,
  `pageviews` bigint(20) NOT NULL,
  `usa_pageviews` bigint(20) NOT NULL,
  `pct_pageviews` float NOT NULL,
  `month` int(11) NOT NULL,
  `year` bigint(11) NOT NULL,
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `google_analytics_most_viewed_articles`
--

CREATE TABLE `google_analytics_most_viewed_articles` (
  `id` bigint(20) NOT NULL,
  `title` varchar(500) NOT NULL,
  `url` varchar(500) NOT NULL,
  `pageviews` bigint(20) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `seo_title` varchar(500) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `google_analytics_most_viewed_articles_always`
--

CREATE TABLE `google_analytics_most_viewed_articles_always` (
  `id` bigint(20) NOT NULL,
  `title` varchar(500) NOT NULL,
  `url` varchar(500) NOT NULL,
  `pageviews` bigint(20) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `seo_title` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `hottopics`
--

CREATE TABLE `hottopics` (
  `hot_topics_id` bigint(20) NOT NULL,
  `hot_topics_message` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `image_library`
--

CREATE TABLE `image_library` (
  `id` bigint(20) NOT NULL,
  `img_name` varchar(500) NOT NULL,
  `category` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `img_list_temp`
--

CREATE TABLE `img_list_temp` (
  `listitem_id` int(11) NOT NULL,
  `img_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `incentives`
--

CREATE TABLE `incentives` (
  `incentives_id` int(11) NOT NULL,
  `month` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `limit` int(11) NOT NULL,
  `bonus` varchar(500) NOT NULL,
  `start` int(11) NOT NULL,
  `end` int(11) NOT NULL,
  `user_type` varchar(200) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(11) NOT NULL,
  `message` longtext NOT NULL,
  `type` int(4) NOT NULL DEFAULT '0' COMMENT '1 = general notifications, 2= Upgrade-Downgrade-Wranings with user type notification from cron',
  `user_id` bigint(20) NOT NULL DEFAULT '0',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `notification_center`
--

CREATE TABLE `notification_center` (
  `notification_id` bigint(20) NOT NULL,
  `notification_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0= warnings, 1=announcements',
  `notification_msg` longtext NOT NULL,
  `notification_live` tinyint(4) NOT NULL DEFAULT '0',
  `notification_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `notify_users`
--

CREATE TABLE `notify_users` (
  `id` int(11) NOT NULL,
  `notification_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` int(11) DEFAULT '1' COMMENT '0 = Inactive 1 = Active'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `orders_ad_matching`
--

CREATE TABLE `orders_ad_matching` (
  `id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `contributor_id` int(11) NOT NULL,
  `month_relation` int(11) NOT NULL,
  `year_relation` int(11) NOT NULL,
  `total_earnings` int(11) NOT NULL,
  `amount_commit` int(11) NOT NULL,
  `amount_match` int(11) NOT NULL,
  `agree` int(11) NOT NULL,
  `bonus_id` int(11) NOT NULL,
  `bonus_pct` int(11) NOT NULL,
  `bonus_match` int(11) NOT NULL,
  `total_commit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `promote_articles`
--

CREATE TABLE `promote_articles` (
  `promote_articles_id` int(11) NOT NULL,
  `article_id` bigint(20) NOT NULL,
  `facebook_page_id` int(11) NOT NULL,
  `promoted` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `readers_authors`
--

CREATE TABLE `readers_authors` (
  `reader_email` varchar(500) NOT NULL,
  `author_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `related_articles`
--

CREATE TABLE `related_articles` (
  `main_article_id` bigint(20) NOT NULL,
  `related_article_id_1` bigint(20) NOT NULL,
  `related_article_id_2` bigint(20) NOT NULL,
  `related_article_id_3` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `shares_rate`
--

CREATE TABLE `shares_rate` (
  `id` bigint(20) NOT NULL,
  `month` int(11) NOT NULL,
  `month_label` varchar(200) NOT NULL,
  `year` int(11) NOT NULL,
  `rate` varchar(50) NOT NULL,
  `user_type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `smf_merit_rates`
--

CREATE TABLE `smf_merit_rates` (
  `merit_rate_id` int(11) NOT NULL,
  `level` varchar(100) NOT NULL,
  `month` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `threshold` int(11) NOT NULL DEFAULT '0',
  `slice` int(11) NOT NULL DEFAULT '0',
  `tier` varchar(100) NOT NULL DEFAULT '',
  `cpm_rate_threshold` float NOT NULL DEFAULT '0',
  `cpm_rate_slice` float NOT NULL DEFAULT '0',
  `cpm_rate_tier` float NOT NULL DEFAULT '0',
  `flat_rate_threshold` float NOT NULL DEFAULT '0',
  `flat_rate_slice` float NOT NULL DEFAULT '0',
  `flat_rate_tier` float NOT NULL DEFAULT '0',
  `rate_txt` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `smf_user_rates`
--

CREATE TABLE `smf_user_rates` (
  `rate_id` int(11) NOT NULL,
  `user_type` int(11) NOT NULL,
  `rate_start_date` date NOT NULL DEFAULT '0000-00-00',
  `user_rate` decimal(4,2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `social_media_records`
--

CREATE TABLE `social_media_records` (
  `id` bigint(20) NOT NULL,
  `category` varchar(500) NOT NULL,
  `article_id` bigint(20) NOT NULL,
  `facebook_shares` int(11) NOT NULL DEFAULT '0',
  `facebook_likes` int(11) NOT NULL DEFAULT '0',
  `facebook_comments` int(11) NOT NULL DEFAULT '0',
  `twitter_shares` int(11) NOT NULL DEFAULT '0',
  `pinterest_shares` int(11) NOT NULL DEFAULT '0',
  `google_shares` int(11) NOT NULL DEFAULT '0',
  `linkedin_shares` int(11) NOT NULL DEFAULT '0',
  `delicious_shares` int(11) NOT NULL DEFAULT '0',
  `stumbleupon_shares` int(11) NOT NULL DEFAULT '0',
  `facebook_shares_org` int(11) NOT NULL DEFAULT '0',
  `facebook_likes_org` int(11) NOT NULL DEFAULT '0',
  `facebook_comments_org` int(11) NOT NULL DEFAULT '0',
  `twitter_shares_org` int(11) NOT NULL DEFAULT '0',
  `pinterest_shares_org` int(11) NOT NULL DEFAULT '0',
  `google_shares_org` int(11) NOT NULL DEFAULT '0',
  `delicious_shares_org` int(11) NOT NULL DEFAULT '0',
  `stumbleupon_shares_org` int(11) NOT NULL DEFAULT '0',
  `linkedin_shares_org` int(11) NOT NULL DEFAULT '0',
  `month` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `date_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `id` bigint(20) NOT NULL,
  `email_address` varchar(500) NOT NULL,
  `article_id` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `syndication_playlists`
--

CREATE TABLE `syndication_playlists` (
  `syn_playlist_id` mediumint(11) NOT NULL,
  `syn_playlist_name` varchar(500) NOT NULL,
  `syn_playlist_desc` varchar(500) NOT NULL,
  `syn_playlist_directory` varchar(500) NOT NULL,
  `syn_playlist_ad_keywords` varchar(500) NOT NULL,
  `syn_playlist_ad_categories` varchar(500) NOT NULL,
  `syn_playlist_facebook_url` varchar(1000) NOT NULL,
  `syn_playlist_twitter_url` varchar(1000) NOT NULL,
  `syn_playlist_email_url` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `syndication_playlist_videos`
--

CREATE TABLE `syndication_playlist_videos` (
  `syn_playlist_id` mediumint(11) NOT NULL,
  `syn_video_id` mediumint(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `syndication_sites`
--

CREATE TABLE `syndication_sites` (
  `syn_id` mediumint(11) NOT NULL,
  `syn_api_key` varchar(64) NOT NULL,
  `syn_name` varchar(500) NOT NULL,
  `syn_url` varchar(500) NOT NULL,
  `syn_ad_keywords` varchar(1000) NOT NULL,
  `syn_ad_categories` varchar(1000) NOT NULL,
  `syn_facebook_url` varchar(500) NOT NULL,
  `syn_twitter_url` varchar(500) NOT NULL,
  `syn_email_url` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `syndication_sites_playlist`
--

CREATE TABLE `syndication_sites_playlist` (
  `syn_id` mediumint(11) NOT NULL,
  `syn_playlist_id` mediumint(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `syndication_sites_whitelist`
--

CREATE TABLE `syndication_sites_whitelist` (
  `syn_id` mediumint(11) NOT NULL,
  `syn_whitelist_id` mediumint(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `syndication_videos`
--

CREATE TABLE `syndication_videos` (
  `syn_video_id` mediumint(11) NOT NULL,
  `syn_video_title` varchar(1000) NOT NULL,
  `syn_video_desc` longtext NOT NULL,
  `syn_video_tags` varchar(1000) NOT NULL,
  `syn_video_aspect` varchar(10) NOT NULL DEFAULT '16:9',
  `syn_video_thumb_filename` varchar(200) NOT NULL,
  `syn_video_filename` varchar(200) NOT NULL,
  `syn_video_has_flv` tinyint(1) NOT NULL DEFAULT '1',
  `syn_video_has_mp4` tinyint(1) NOT NULL DEFAULT '1',
  `syn_video_has_webm` tinyint(1) NOT NULL DEFAULT '1',
  `syn_video_has_ogg` tinyint(1) NOT NULL DEFAULT '0',
  `syn_video_ad_keywords` varchar(500) NOT NULL,
  `syn_video_ad_categories` varchar(500) NOT NULL,
  `syn_video_ad_midrolls` varchar(500) NOT NULL,
  `syn_video_facebook_url` varchar(1000) NOT NULL,
  `syn_video_twitter_url` varchar(1000) NOT NULL,
  `syn_video_email_url` varchar(1000) NOT NULL,
  `creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `syndication_video_views`
--

CREATE TABLE `syndication_video_views` (
  `syn_view_id` mediumint(12) NOT NULL,
  `syn_video_id` mediumint(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `syndication_whitelists`
--

CREATE TABLE `syndication_whitelists` (
  `syn_whitelist_id` mediumint(11) NOT NULL,
  `syn_whitelist_entry` varchar(500) NOT NULL,
  `syn_whitelist_ip_match` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` mediumint(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `user_hashed_password` varchar(255) NOT NULL,
  `user_salt` varchar(255) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_first_name` varchar(100) NOT NULL,
  `user_last_name` varchar(100) DEFAULT NULL,
  `user_type` mediumint(4) NOT NULL DEFAULT '30',
  `user_login_count` int(11) NOT NULL DEFAULT '0',
  `user_verified` tinyint(1) NOT NULL DEFAULT '0',
  `tos_agreed` tinyint(1) NOT NULL DEFAULT '1',
  `user_verification_code` varchar(100) DEFAULT NULL,
  `user_creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_display_image` varchar(500) NOT NULL,
  `user_display_name` varchar(500) NOT NULL,
  `user_facebook_id` varchar(500) NOT NULL,
  `remember_token` varchar(120) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_billing_info`
--

CREATE TABLE `user_billing_info` (
  `user_id` bigint(20) NOT NULL,
  `paypal_email` varchar(500) NOT NULL,
  `w9_live` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0, none; 1, submitted; 2, exempt;'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_logins`
--

CREATE TABLE `user_logins` (
  `user_login_id` mediumint(11) NOT NULL,
  `user_id` mediumint(11) NOT NULL,
  `user_login_ip` varchar(500) NOT NULL,
  `user_login_hash` varchar(100) NOT NULL,
  `user_login_ua` longtext NOT NULL,
  `user_login_valid` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1 = Live session, 0 = Pending login, -1 = Session invalid',
  `user_login_creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_password_resets`
--

CREATE TABLE `user_password_resets` (
  `reset_id` int(11) NOT NULL,
  `reset_user_email` varchar(255) NOT NULL,
  `reset_user_ip` varchar(255) NOT NULL,
  `reset_verification_code` varchar(255) NOT NULL,
  `reset_valid` tinyint(1) NOT NULL DEFAULT '0',
  `reset_creation_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_permissions`
--

CREATE TABLE `user_permissions` (
  `user_type` mediumint(11) NOT NULL,
  `user_permission_show_manage_site` tinyint(1) NOT NULL DEFAULT '0',
  `user_permission_show_generic_settings` tinyint(1) NOT NULL DEFAULT '0',
  `user_permission_show_search_settings` tinyint(1) NOT NULL DEFAULT '0',
  `user_permission_show_player_settings` tinyint(1) NOT NULL DEFAULT '0',
  `user_permission_show_social_settings` tinyint(1) NOT NULL DEFAULT '0',
  `user_permission_show_ad_settings` tinyint(1) NOT NULL DEFAULT '0',
  `user_permission_show_styling_settings` tinyint(1) NOT NULL DEFAULT '0',
  `user_permission_show_manage_categories` tinyint(1) NOT NULL DEFAULT '0',
  `user_permission_show_view_categories` tinyint(1) NOT NULL DEFAULT '0',
  `user_permission_show_edit_category` tinyint(1) NOT NULL DEFAULT '0',
  `user_permission_show_manage_articles` tinyint(1) NOT NULL DEFAULT '0',
  `user_permission_show_other_user_articles` tinyint(1) NOT NULL DEFAULT '0',
  `user_permission_show_view_articles` tinyint(1) NOT NULL DEFAULT '0',
  `user_permission_publish_own_articles` tinyint(4) NOT NULL DEFAULT '0',
  `user_permission_show_edit_article` tinyint(1) NOT NULL DEFAULT '0',
  `user_permission_show_add_article` tinyint(1) NOT NULL DEFAULT '0',
  `user_permission_show_add_recipe` tinyint(1) NOT NULL DEFAULT '0',
  `user_permission_show_manage_lists` tinyint(1) NOT NULL DEFAULT '0',
  `user_permission_show_view_lists` tinyint(1) NOT NULL DEFAULT '0',
  `user_permission_show_edit_lists` tinyint(1) NOT NULL DEFAULT '0',
  `user_permission_show_add_lists` tinyint(1) NOT NULL DEFAULT '0',
  `user_permission_show_manage_contributors` tinyint(1) NOT NULL DEFAULT '0',
  `user_permission_show_view_contributors` tinyint(1) NOT NULL DEFAULT '0',
  `user_permission_show_other_contributors` tinyint(1) NOT NULL DEFAULT '0',
  `user_permission_show_edit_contributor` tinyint(1) NOT NULL DEFAULT '0',
  `user_permission_show_add_contributor` tinyint(1) NOT NULL DEFAULT '0',
  `user_permission_show_global_settings` tinyint(1) NOT NULL DEFAULT '0',
  `user_permission_show_edit_media` tinyint(4) NOT NULL DEFAULT '0',
  `user_permission_show_add_media` tinyint(4) NOT NULL DEFAULT '0',
  `user_permission_show_manage_media` tinyint(4) NOT NULL DEFAULT '0',
  `user_permission_show_add_notifications` tinyint(4) NOT NULL,
  `user_permission_show_earnings` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_rate`
--

CREATE TABLE `user_rate` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_type` int(9) NOT NULL,
  `month` varchar(100) NOT NULL,
  `month_label` varchar(100) NOT NULL,
  `year` int(11) NOT NULL,
  `rate` varchar(100) NOT NULL DEFAULT '2.00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_type`
--

CREATE TABLE `user_type` (
  `user_type` int(11) NOT NULL,
  `label` varchar(100) NOT NULL DEFAULT 'Basic'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_types`
--

CREATE TABLE `user_types` (
  `user_type` mediumint(4) NOT NULL,
  `user_type_label` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure for view `active_user_contributors`
--
DROP TABLE IF EXISTS `active_user_contributors`;

CREATE ALGORITHM=UNDEFINED DEFINER=`seq_db_user`@`%` SQL SECURITY DEFINER VIEW `active_user_contributors`  AS  select `article_contributors`.`contributor_id` AS `contributor_id`,`article_contributors`.`contributor_name` AS `contributor_name`,`article_contributors`.`contributor_seo_name` AS `contributor_seo_name`,`article_contributors`.`contributor_location` AS `contributor_location`,`article_contributors`.`contributor_bio` AS `contributor_bio`,`article_contributors`.`contributor_image` AS `contributor_image`,`article_contributors`.`contributor_blog_link` AS `contributor_blog_link`,`article_contributors`.`contributor_email_address` AS `contributor_email_address`,`article_contributors`.`contributor_twitter_handle` AS `contributor_twitter_handle`,`article_contributors`.`contributor_facebook_link` AS `contributor_facebook_link`,`article_contributors`.`creation_date` AS `creation_date`,`users`.`user_id` AS `user_id`,`users`.`user_name` AS `user_name`,`users`.`user_hashed_password` AS `user_hashed_password`,`users`.`user_salt` AS `user_salt`,`users`.`user_email` AS `user_email`,`users`.`user_first_name` AS `user_first_name`,`users`.`user_last_name` AS `user_last_name`,`users`.`user_type` AS `user_type`,`users`.`user_login_count` AS `user_login_count`,`users`.`user_verified` AS `user_verified`,`users`.`tos_agreed` AS `tos_agreed`,`users`.`user_verification_code` AS `user_verification_code`,`users`.`user_creation_date` AS `user_creation_date`,`users`.`user_display_image` AS `user_display_image`,`users`.`user_display_name` AS `user_display_name`,`users`.`user_facebook_id` AS `user_facebook_id`,`users`.`remember_token` AS `remember_token` from (`article_contributors` join `users` on((`users`.`user_email` = `article_contributors`.`contributor_email_address`))) where (`users`.`user_login_count` > 1) order by `users`.`user_login_count` desc ;

-- --------------------------------------------------------

--
-- Structure for view `articles_list`
--
DROP TABLE IF EXISTS `articles_list`;

CREATE ALGORITHM=UNDEFINED DEFINER=`seq_db_user`@`%` SQL SECURITY DEFINER VIEW `articles_list`  AS  select `articles`.`article_id` AS `article_id`,`articles`.`article_status` AS `article_status`,`articles`.`creation_date` AS `creation_date`,`articles`.`date_updated` AS `date_updated`,`articles`.`article_title` AS `article_title`,`articles`.`article_seo_title` AS `article_seo_title`,`categories`.`cat_id` AS `cat_id`,`categories`.`cat_name` AS `cat_name`,`categories`.`cat_dir_name` AS `cat_dir_name`,`article_contributors`.`contributor_id` AS `contributor_id`,`article_contributors`.`contributor_seo_name` AS `contributor_seo_name`,`article_contributors`.`contributor_name` AS `contributor_name`,`article_contributors`.`contributor_image` AS `contributor_image`,`users`.`user_type` AS `user_type` from (`articles` join ((((`article_categories` join `categories`) join `article_contributor_articles`) join `article_contributors`) join `users`) on(((`articles`.`article_id` = `article_categories`.`article_id`) and (`article_categories`.`cat_id` = `categories`.`cat_id`) and (`article_contributor_articles`.`article_id` = `articles`.`article_id`) and (`article_contributors`.`contributor_id` = `article_contributor_articles`.`contributor_id`) and (`article_contributors`.`contributor_email_address` = `users`.`user_email`)))) ;

-- --------------------------------------------------------

--
-- Structure for view `articles_list_admin`
--
DROP TABLE IF EXISTS `articles_list_admin`;

CREATE ALGORITHM=UNDEFINED DEFINER=`seq_db_user`@`%` SQL SECURITY DEFINER VIEW `articles_list_admin`  AS  select `promote_articles`.`article_id` AS `article_id`,`articles`.`article_title` AS `article_title`,`articles`.`article_seo_title` AS `article_seo_title`,`articles`.`article_status` AS `article_status`,`articles`.`date_updated` AS `date_updated`,`articles`.`creation_date` AS `creation_date`,`article_categories`.`cat_id` AS `cat_id`,`categories`.`cat_dir_name` AS `cat_dir_name`,`article_contributors`.`contributor_name` AS `contributor_name`,`article_contributors`.`contributor_seo_name` AS `contributor_seo_name`,`article_contributors`.`contributor_email_address` AS `contributor_email_address`,`users`.`user_type` AS `user_type`,`users`.`user_id` AS `user_id`,`facebook_pages`.`facebook_page_name` AS `facebook_page_name`,`promote_articles`.`promoted` AS `promoted`,`facebook_pages`.`facebook_page_id` AS `facebook_page_id`,sum(`google_analytics_data_new`.`usa_pageviews`) AS `usa_pageviews` from ((`promote_articles` join ((((((`articles` join `article_categories`) join `categories`) join `article_contributor_articles`) join `article_contributors`) join `facebook_pages`) join `users`) on(((`articles`.`article_id` = `promote_articles`.`article_id`) and (`article_categories`.`article_id` = `promote_articles`.`article_id`) and (`categories`.`cat_id` = `article_categories`.`cat_id`) and (`article_contributor_articles`.`article_id` = `promote_articles`.`article_id`) and (`article_contributors`.`contributor_id` = `article_contributor_articles`.`contributor_id`) and (`article_contributors`.`contributor_email_address` = `users`.`user_email`) and (`facebook_pages`.`facebook_page_id` = `promote_articles`.`facebook_page_id`)))) left join `google_analytics_data_new` on((`google_analytics_data_new`.`article_id` = `promote_articles`.`article_id`))) group by `promote_articles`.`article_id` order by `promote_articles`.`article_id` desc ;

-- --------------------------------------------------------

--
-- Structure for view `articles_list_admin_promote`
--
DROP TABLE IF EXISTS `articles_list_admin_promote`;

CREATE ALGORITHM=UNDEFINED DEFINER=`seq_db_user`@`%` SQL SECURITY DEFINER VIEW `articles_list_admin_promote`  AS  select `promote_articles`.`article_id` AS `article_id`,`articles`.`article_title` AS `article_title`,`articles`.`article_seo_title` AS `article_seo_title`,`articles`.`article_status` AS `article_status`,`articles`.`date_updated` AS `date_updated`,`articles`.`creation_date` AS `creation_date`,`article_categories`.`cat_id` AS `cat_id`,`categories`.`cat_dir_name` AS `cat_dir_name`,`article_contributors`.`contributor_name` AS `contributor_name`,`article_contributors`.`contributor_seo_name` AS `contributor_seo_name`,`article_contributors`.`contributor_email_address` AS `contributor_email_address`,`users`.`user_type` AS `user_type`,`users`.`user_id` AS `user_id`,`facebook_pages`.`facebook_page_name` AS `facebook_page_name`,`promote_articles`.`promoted` AS `promoted`,`facebook_pages`.`facebook_page_id` AS `facebook_page_id`,sum(`google_analytics_data_new`.`usa_pageviews`) AS `usa_pageviews` from ((`promote_articles` join ((((((`articles` join `article_categories`) join `categories`) join `article_contributor_articles`) join `article_contributors`) join `facebook_pages`) join `users`) on(((`articles`.`article_id` = `promote_articles`.`article_id`) and (`article_categories`.`article_id` = `promote_articles`.`article_id`) and (`categories`.`cat_id` = `article_categories`.`cat_id`) and (`article_contributor_articles`.`article_id` = `promote_articles`.`article_id`) and (`article_contributors`.`contributor_id` = `article_contributor_articles`.`contributor_id`) and (`article_contributors`.`contributor_email_address` = `users`.`user_email`) and (`facebook_pages`.`facebook_page_id` = `promote_articles`.`facebook_page_id`)))) left join `google_analytics_data_new` on((`google_analytics_data_new`.`article_id` = `promote_articles`.`article_id`))) group by `promote_articles`.`article_id` order by `promote_articles`.`article_id` desc ;

-- --------------------------------------------------------

--
-- Structure for view `article_daily_earnings`
--
DROP TABLE IF EXISTS `article_daily_earnings`;

CREATE ALGORITHM=UNDEFINED DEFINER=`seq_db_user`@`%` SQL SECURITY DEFINER VIEW `article_daily_earnings`  AS  select `google_analytics_data_daily`.`article_id` AS `article_id`,`google_analytics_data_daily`.`pageviews` AS `pageviews`,`google_analytics_data_daily`.`usa_pageviews` AS `usa_pageviews`,`google_analytics_data_daily`.`pct_pageviews` AS `pct_pageviews`,`google_analytics_data_daily`.`month` AS `month`,`google_analytics_data_daily`.`year` AS `year`,`google_analytics_data_daily`.`updated_date` AS `updated_date`,`articles`.`article_title` AS `article_title`,`articles`.`article_seo_title` AS `article_seo_title`,`categories`.`cat_id` AS `cat_id`,`categories`.`cat_name` AS `cat_name`,`article_contributor_articles`.`contributor_id` AS `contributor_id` from (`google_analytics_data_daily` join (((`article_contributor_articles` join `articles`) join `article_categories`) join `categories`) on(((`article_contributor_articles`.`article_id` = `google_analytics_data_daily`.`article_id`) and (`articles`.`article_id` = `google_analytics_data_daily`.`article_id`) and (`article_categories`.`article_id` = `google_analytics_data_daily`.`article_id`) and (`categories`.`cat_id` = `article_categories`.`cat_id`)))) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ads`
--
ALTER TABLE `ads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ad_matching_program`
--
ALTER TABLE `ad_matching_program`
  ADD PRIMARY KEY (`bonus_id`);

--
-- Indexes for table `ad_matching_transactions`
--
ALTER TABLE `ad_matching_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contributor_id` (`contributor_id`);

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`article_id`),
  ADD KEY `article_id_index` (`article_id`),
  ADD KEY `article_seo_title_index` (`article_seo_title`(767)),
  ADD KEY `article_status_index` (`article_status`);
ALTER TABLE `articles` ADD FULLTEXT KEY `article_title` (`article_title`,`article_body`);
ALTER TABLE `articles` ADD FULLTEXT KEY `article_title_2` (`article_title`);
ALTER TABLE `articles` ADD FULLTEXT KEY `article_body` (`article_body`);
ALTER TABLE `articles` ADD FULLTEXT KEY `article_desc` (`article_desc`,`article_tags`);

--
-- Indexes for table `articles_featured`
--
ALTER TABLE `articles_featured`
  ADD PRIMARY KEY (`featured_id`),
  ADD KEY `article_page_id` (`article_id`);

--
-- Indexes for table `article_categories`
--
ALTER TABLE `article_categories`
  ADD KEY `article_id` (`article_id`),
  ADD KEY `article_id_index` (`article_id`);

--
-- Indexes for table `article_category_page_featured_contributors`
--
ALTER TABLE `article_category_page_featured_contributors`
  ADD PRIMARY KEY (`featured_id`),
  ADD KEY `category_page_id` (`category_page_id`,`contributor_id`);

--
-- Indexes for table `article_contributors`
--
ALTER TABLE `article_contributors`
  ADD PRIMARY KEY (`contributor_id`),
  ADD KEY `contributor_id_index` (`contributor_id`),
  ADD KEY `contributor_email_address_index` (`contributor_email_address`);

--
-- Indexes for table `article_contributor_articles`
--
ALTER TABLE `article_contributor_articles`
  ADD KEY `article_id` (`article_id`,`contributor_id`),
  ADD KEY `contributor_id_index` (`contributor_id`);

--
-- Indexes for table `article_images`
--
ALTER TABLE `article_images`
  ADD KEY `article_id` (`article_id`);

--
-- Indexes for table `article_moblogs_featured`
--
ALTER TABLE `article_moblogs_featured`
  ADD KEY `article_featured_hp_index` (`article_featured_hp`),
  ADD KEY `article_id_index` (`article_id`);

--
-- Indexes for table `article_pages`
--
ALTER TABLE `article_pages`
  ADD PRIMARY KEY (`article_page_id`);
ALTER TABLE `article_pages` ADD FULLTEXT KEY `article_page_name` (`article_page_name`);
ALTER TABLE `article_pages` ADD FULLTEXT KEY `article_page_desc` (`article_page_desc`);
ALTER TABLE `article_pages` ADD FULLTEXT KEY `article_page_tags` (`article_page_tags`);
ALTER TABLE `article_pages` ADD FULLTEXT KEY `article_page_name_2` (`article_page_name`,`article_page_desc`,`article_page_tags`);
ALTER TABLE `article_pages` ADD FULLTEXT KEY `article_page_name_4` (`article_page_name`,`article_page_desc`);
ALTER TABLE `article_pages` ADD FULLTEXT KEY `article_page_name_5` (`article_page_name`,`article_page_tags`);
ALTER TABLE `article_pages` ADD FULLTEXT KEY `article_page_desc_2` (`article_page_desc`,`article_page_tags`);
ALTER TABLE `article_pages` ADD FULLTEXT KEY `article_page_desc_3` (`article_page_desc`);
ALTER TABLE `article_pages` ADD FULLTEXT KEY `article_page_tags_2` (`article_page_tags`);
ALTER TABLE `article_pages` ADD FULLTEXT KEY `article_page_url` (`article_page_assets_directory`);

--
-- Indexes for table `article_pages_navigation_links`
--
ALTER TABLE `article_pages_navigation_links`
  ADD KEY `article_page_id` (`article_page_id`),
  ADD KEY `article_link_id` (`article_link_id`);

--
-- Indexes for table `article_page_ads`
--
ALTER TABLE `article_page_ads`
  ADD PRIMARY KEY (`article_page_id`);

--
-- Indexes for table `article_page_categories`
--
ALTER TABLE `article_page_categories`
  ADD KEY `article_page_id` (`article_page_id`,`category_page_id`);

--
-- Indexes for table `article_page_featured_articles`
--
ALTER TABLE `article_page_featured_articles`
  ADD PRIMARY KEY (`featured_id`),
  ADD KEY `article_page_id` (`article_id`);

--
-- Indexes for table `article_page_featured_contributors`
--
ALTER TABLE `article_page_featured_contributors`
  ADD PRIMARY KEY (`featured_id`),
  ADD KEY `article_page_id` (`article_page_id`,`contributor_id`);

--
-- Indexes for table `article_page_images`
--
ALTER TABLE `article_page_images`
  ADD PRIMARY KEY (`article_page_id`);

--
-- Indexes for table `article_page_main_categories`
--
ALTER TABLE `article_page_main_categories`
  ADD PRIMARY KEY (`parent_child_rel_id`);

--
-- Indexes for table `article_page_navigation_links`
--
ALTER TABLE `article_page_navigation_links`
  ADD PRIMARY KEY (`navigation_link_id`);

--
-- Indexes for table `article_page_player_settings`
--
ALTER TABLE `article_page_player_settings`
  ADD PRIMARY KEY (`article_page_id`);

--
-- Indexes for table `article_page_series`
--
ALTER TABLE `article_page_series`
  ADD PRIMARY KEY (`article_page_series_id`);

--
-- Indexes for table `article_page_social_settings`
--
ALTER TABLE `article_page_social_settings`
  ADD PRIMARY KEY (`article_page_id`);

--
-- Indexes for table `article_page_styling`
--
ALTER TABLE `article_page_styling`
  ADD PRIMARY KEY (`article_page_id`);

--
-- Indexes for table `article_ratings`
--
ALTER TABLE `article_ratings`
  ADD KEY `article_id` (`article_id`);

--
-- Indexes for table `article_statuses`
--
ALTER TABLE `article_statuses`
  ADD PRIMARY KEY (`status_id`);

--
-- Indexes for table `article_todays_favorites`
--
ALTER TABLE `article_todays_favorites`
  ADD PRIMARY KEY (`todays_favorites_id`);

--
-- Indexes for table `article_videos`
--
ALTER TABLE `article_videos`
  ADD KEY `syn_video_id` (`syn_video_id`),
  ADD KEY `article_id` (`article_id`);

--
-- Indexes for table `ask_the_chef`
--
ALTER TABLE `ask_the_chef`
  ADD PRIMARY KEY (`ask_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`),
  ADD KEY `cat_id_index` (`cat_id`);

--
-- Indexes for table `category_library`
--
ALTER TABLE `category_library`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `collections`
--
ALTER TABLE `collections`
  ADD PRIMARY KEY (`collections_id`);

--
-- Indexes for table `contributor_earnings`
--
ALTER TABLE `contributor_earnings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contributor_earnings_BAK_1006`
--
ALTER TABLE `contributor_earnings_BAK_1006`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `count`
--
ALTER TABLE `count`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `article_id` (`article_id`),
  ADD KEY `article_id_2` (`article_id`);

--
-- Indexes for table `featured_article`
--
ALTER TABLE `featured_article`
  ADD PRIMARY KEY (`feature_id`);

--
-- Indexes for table `foodfight`
--
ALTER TABLE `foodfight`
  ADD PRIMARY KEY (`foodfight_id`);

--
-- Indexes for table `google_analytics_data_daily`
--
ALTER TABLE `google_analytics_data_daily`
  ADD KEY `article_id_index` (`article_id`);

--
-- Indexes for table `google_analytics_data_new`
--
ALTER TABLE `google_analytics_data_new`
  ADD KEY `article_id_index` (`article_id`);

--
-- Indexes for table `google_analytics_most_viewed_articles`
--
ALTER TABLE `google_analytics_most_viewed_articles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `google_analytics_most_viewed_articles_always`
--
ALTER TABLE `google_analytics_most_viewed_articles_always`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hottopics`
--
ALTER TABLE `hottopics`
  ADD PRIMARY KEY (`hot_topics_id`);

--
-- Indexes for table `image_library`
--
ALTER TABLE `image_library`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `img_list_temp`
--
ALTER TABLE `img_list_temp`
  ADD PRIMARY KEY (`listitem_id`);

--
-- Indexes for table `incentives`
--
ALTER TABLE `incentives`
  ADD PRIMARY KEY (`incentives_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`);

--
-- Indexes for table `notification_center`
--
ALTER TABLE `notification_center`
  ADD PRIMARY KEY (`notification_id`);

--
-- Indexes for table `notify_users`
--
ALTER TABLE `notify_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders_ad_matching`
--
ALTER TABLE `orders_ad_matching`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `promote_articles`
--
ALTER TABLE `promote_articles`
  ADD PRIMARY KEY (`promote_articles_id`);

--
-- Indexes for table `related_articles`
--
ALTER TABLE `related_articles`
  ADD KEY `main_article_id_index` (`main_article_id`);

--
-- Indexes for table `shares_rate`
--
ALTER TABLE `shares_rate`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `smf_merit_rates`
--
ALTER TABLE `smf_merit_rates`
  ADD PRIMARY KEY (`merit_rate_id`);

--
-- Indexes for table `smf_user_rates`
--
ALTER TABLE `smf_user_rates`
  ADD PRIMARY KEY (`rate_id`);

--
-- Indexes for table `social_media_records`
--
ALTER TABLE `social_media_records`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `syndication_playlists`
--
ALTER TABLE `syndication_playlists`
  ADD PRIMARY KEY (`syn_playlist_id`),
  ADD UNIQUE KEY `syn_playlist_directory` (`syn_playlist_directory`);

--
-- Indexes for table `syndication_playlist_videos`
--
ALTER TABLE `syndication_playlist_videos`
  ADD KEY `syn_playlist_id` (`syn_playlist_id`,`syn_video_id`);

--
-- Indexes for table `syndication_sites`
--
ALTER TABLE `syndication_sites`
  ADD PRIMARY KEY (`syn_id`),
  ADD KEY `syn_api_key` (`syn_api_key`);

--
-- Indexes for table `syndication_sites_playlist`
--
ALTER TABLE `syndication_sites_playlist`
  ADD KEY `syn_id` (`syn_id`,`syn_playlist_id`);

--
-- Indexes for table `syndication_sites_whitelist`
--
ALTER TABLE `syndication_sites_whitelist`
  ADD KEY `syn_id` (`syn_id`,`syn_whitelist_id`);

--
-- Indexes for table `syndication_videos`
--
ALTER TABLE `syndication_videos`
  ADD PRIMARY KEY (`syn_video_id`);

--
-- Indexes for table `syndication_video_views`
--
ALTER TABLE `syndication_video_views`
  ADD PRIMARY KEY (`syn_view_id`),
  ADD KEY `syn_video_id` (`syn_video_id`);

--
-- Indexes for table `syndication_whitelists`
--
ALTER TABLE `syndication_whitelists`
  ADD PRIMARY KEY (`syn_whitelist_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `user_email_index` (`user_email`);

--
-- Indexes for table `user_logins`
--
ALTER TABLE `user_logins`
  ADD PRIMARY KEY (`user_login_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_password_resets`
--
ALTER TABLE `user_password_resets`
  ADD PRIMARY KEY (`reset_id`);

--
-- Indexes for table `user_permissions`
--
ALTER TABLE `user_permissions`
  ADD PRIMARY KEY (`user_type`);

--
-- Indexes for table `user_rate`
--
ALTER TABLE `user_rate`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_type`
--
ALTER TABLE `user_type`
  ADD PRIMARY KEY (`user_type`);

--
-- Indexes for table `user_types`
--
ALTER TABLE `user_types`
  ADD PRIMARY KEY (`user_type`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ads`
--
ALTER TABLE `ads`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `ad_matching_program`
--
ALTER TABLE `ad_matching_program`
  MODIFY `bonus_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `ad_matching_transactions`
--
ALTER TABLE `ad_matching_transactions`
  MODIFY `id` bigint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `article_id` mediumint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40218;

--
-- AUTO_INCREMENT for table `articles_featured`
--
ALTER TABLE `articles_featured`
  MODIFY `featured_id` mediumint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2662;

--
-- AUTO_INCREMENT for table `article_category_page_featured_contributors`
--
ALTER TABLE `article_category_page_featured_contributors`
  MODIFY `featured_id` mediumint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `article_contributors`
--
ALTER TABLE `article_contributors`
  MODIFY `contributor_id` mediumint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27591;

--
-- AUTO_INCREMENT for table `article_pages`
--
ALTER TABLE `article_pages`
  MODIFY `article_page_id` mediumint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `article_page_featured_articles`
--
ALTER TABLE `article_page_featured_articles`
  MODIFY `featured_id` mediumint(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `article_page_featured_contributors`
--
ALTER TABLE `article_page_featured_contributors`
  MODIFY `featured_id` mediumint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `article_page_main_categories`
--
ALTER TABLE `article_page_main_categories`
  MODIFY `parent_child_rel_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `article_page_navigation_links`
--
ALTER TABLE `article_page_navigation_links`
  MODIFY `navigation_link_id` mediumint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `article_page_series`
--
ALTER TABLE `article_page_series`
  MODIFY `article_page_series_id` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `article_statuses`
--
ALTER TABLE `article_statuses`
  MODIFY `status_id` mediumint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `article_todays_favorites`
--
ALTER TABLE `article_todays_favorites`
  MODIFY `todays_favorites_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ask_the_chef`
--
ALTER TABLE `ask_the_chef`
  MODIFY `ask_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `category_library`
--
ALTER TABLE `category_library`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `collections`
--
ALTER TABLE `collections`
  MODIFY `collections_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `contributor_earnings`
--
ALTER TABLE `contributor_earnings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=242603;

--
-- AUTO_INCREMENT for table `contributor_earnings_BAK_1006`
--
ALTER TABLE `contributor_earnings_BAK_1006`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=218021;

--
-- AUTO_INCREMENT for table `count`
--
ALTER TABLE `count`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `featured_article`
--
ALTER TABLE `featured_article`
  MODIFY `feature_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `foodfight`
--
ALTER TABLE `foodfight`
  MODIFY `foodfight_id` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `google_analytics_most_viewed_articles`
--
ALTER TABLE `google_analytics_most_viewed_articles`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17478;

--
-- AUTO_INCREMENT for table `google_analytics_most_viewed_articles_always`
--
ALTER TABLE `google_analytics_most_viewed_articles_always`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31401;

--
-- AUTO_INCREMENT for table `hottopics`
--
ALTER TABLE `hottopics`
  MODIFY `hot_topics_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `image_library`
--
ALTER TABLE `image_library`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=404;

--
-- AUTO_INCREMENT for table `img_list_temp`
--
ALTER TABLE `img_list_temp`
  MODIFY `listitem_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22057;

--
-- AUTO_INCREMENT for table `incentives`
--
ALTER TABLE `incentives`
  MODIFY `incentives_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16047;

--
-- AUTO_INCREMENT for table `notification_center`
--
ALTER TABLE `notification_center`
  MODIFY `notification_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `notify_users`
--
ALTER TABLE `notify_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders_ad_matching`
--
ALTER TABLE `orders_ad_matching`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT for table `promote_articles`
--
ALTER TABLE `promote_articles`
  MODIFY `promote_articles_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16021;

--
-- AUTO_INCREMENT for table `shares_rate`
--
ALTER TABLE `shares_rate`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `smf_merit_rates`
--
ALTER TABLE `smf_merit_rates`
  MODIFY `merit_rate_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=182;

--
-- AUTO_INCREMENT for table `smf_user_rates`
--
ALTER TABLE `smf_user_rates`
  MODIFY `rate_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT for table `social_media_records`
--
ALTER TABLE `social_media_records`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92168;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `syndication_playlists`
--
ALTER TABLE `syndication_playlists`
  MODIFY `syn_playlist_id` mediumint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `syndication_sites`
--
ALTER TABLE `syndication_sites`
  MODIFY `syn_id` mediumint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `syndication_videos`
--
ALTER TABLE `syndication_videos`
  MODIFY `syn_video_id` mediumint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=202;

--
-- AUTO_INCREMENT for table `syndication_video_views`
--
ALTER TABLE `syndication_video_views`
  MODIFY `syn_view_id` mediumint(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `syndication_whitelists`
--
ALTER TABLE `syndication_whitelists`
  MODIFY `syn_whitelist_id` mediumint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` mediumint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26522;

--
-- AUTO_INCREMENT for table `user_logins`
--
ALTER TABLE `user_logins`
  MODIFY `user_login_id` mediumint(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=208372;

--
-- AUTO_INCREMENT for table `user_password_resets`
--
ALTER TABLE `user_password_resets`
  MODIFY `reset_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2043;

--
-- AUTO_INCREMENT for table `user_rate`
--
ALTER TABLE `user_rate`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT for table `user_types`
--
ALTER TABLE `user_types`
  MODIFY `user_type` mediumint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
