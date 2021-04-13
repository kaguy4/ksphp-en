<?php

# Items marked with "*" need to be changed and confirmed.

/* Common settings */
$CONF = array(

  #------------------------- URLなど -------------------------

  'CGIURL' => './bbs.php',      # * 掲示板スクリプトのURL（相対パス可）
  'REFCHECKURL' => '',      # 掲示板スクリプトのURL（Refererチェック用、フルURLを記述。空にするとチェックしません）
  'BBSHOST' => '',      # スクリプトを設置するホストアドレス（呼び出し元チェック用。空にするとチェックしません）

  #------------------------- ファイルとディレクトリ -------------------------

  'LOGFILENAME' => './bbs.log',   # ログファイル名
  'OLDLOGFILEDIR' => './log/',    # 過去ログ保存用ディレクトリの名前（最後に/を入れてください。空の場合は過去ログを保存しません）
  'ZIPDIR' => '',       # 過去ログファイルのZIPアーカイブディレクトリ（最後に/を入れてください。空の場合かgzcompress関数が使用不可の場合はZIPアーカイブを作成しません）

  # ----HTMLテンプレートファイル名----
  'TEMPLATE' => './sub/template.html',
  'TEMPLATE_ADMIN' => './sub/tmpladmin.html',
  'TEMPLATE_LOG' => './sub/tmpllog.html',
  'TEMPLATE_TREEVIEW' => './sub/tmpltree.html',

  #------------------------- 掲示板名称など -------------------------

  'BBSTITLE' => 'Strange World',           # * 掲示板の名前
  'INFOPAGE' => 'https://yoursite.com/info.htm',   # * 広報室のURL

  #------------------------- 管理設定 -------------------------

  'ADMINNAME' => 'yourname',                               # * 管理人の名前
  'ADMINMAIL' => 'youremail@gmail.com',                # * 管理人のメールアドレス
  'ADMINPOST' => '',   # * 管理用パスワード（暗号化パスワード。最初は空にしておいてください）
  'ADMINKEY' => '',         # * 管理モード移行用キーワード（半角英数字推奨、空の場合管理モードを使用できません）

  #------------------------- 検索エンジン -------------------------

  # 検索エンジンに掲示板の概要を教えます。短い文章にするといいでしょう
  'META_DESCRIPTION' => 'description here',

  # 掲示板に関連した単語をカンマ区切りで入力します。あまり多すぎるとペナルティを食らう場合もあるようです
  'META_KEYWORDS' => 'あやしいわーるど,あやわー,strangeworld,あやしい,ぁゃιぃ,strange,掲示板,BBS',

  # コンテンツの言語を指定してください。通常は日本語(ja)
  # 日本語：ja
  # English：en
  'META_LANGUAGE' => 'ja',

  #------------------------- 動作設定 -------------------------
  # 0 is no, 1 is yes
 
  # run? 
  'RUNMODE' => 0,

  # Image Upload Function (THIS DOES NOT WORK AND BREAK BOARD.)
  'BBSMODE_IMAGE' => 0,

  # diary function
  # 0: Anyone can post - 1: admins only - 2: admins can make threads, regular people can make replies
  'BBSMODE_ADMINONLY' => 0,

  # allow users to undo their recent post?
  'ALLOW_UNDO' => 1,

  # show "last x" button
  'SHOW_READNEWBTN' => 1,

  # use gzip?
  'GZIPU' => 1,

  # how many posts to log?
  'LOGSAVE' => 10000,

  # How many posts to display per page
  'MSGDISP' => 40,

  # Number of double write checks
  'CHECKCOUNT' => 20,

  # Maximum number of characters in the message
  'MAXMSGCOL' => 500,

  # Max lines in message
  'MAXMSGLINE' => 120,

  # max msg size in byes
  'MAXMSGSIZE' => 9000,

  # Min. Post interval
  'MINPOSTSEC' => 0,

  # Max. Post interval
  'MAXPOSTSEC' => 1,

  # embed links?
  'AUTOLINK' => 1,

# Follow post screen display
# 0: Open and show a new window(Rebirth)
# 1: Displayed on the same screen(Head office)
  'FOLLOWWIN' => 0,

# Record the author's IP address
# 0: Do not record
# 1: Anonymous Proxy only record
# 2: Record All
  'IPREC' => 2,

  # User Agent record?
  'UAREC' => 0,

# Display the author's IP address(deprecated for privacy reasons)
# (Contributor IP address recording must be enabled）
# 0 : Disabled
# 1 : Enabled
  'IPPRINT' => 0,

# Display User Agent (browser name)
# (User Agent logging must be enabled）
# 0 : Disabled
# 1 : Enabled
  'UAPRINT' => 0,

  #   same ip post interval
  'SPTIME' => 0,

# Using cookies to store the author / email address
# 0 : Disabled
# 1 : Enabled
  'COOKIE' => 1,

# Use of Simple self-play prevention function
# (Function to display (self-less)in the name field when the IP address of the reply source and the reply destination are the same
# Contributor IP address recording must be enabled）
# 0 : Disabled
# 1 : Enabled
  'SHOW_SELFFOLLOW' => 1,

  #------------------------- Counter -------------------------

  # * count date
  'COUNTDATE' => '1997/03/08',

  # path to counter
  'COUNTFILE' => './count/count',

# Anti-break level of the counter
# (Recommended value 2 ~ 5 The higher the value, the less likely the error will occur, but the server load will be higher)
  'COUNTLEVEL' => 3,

  # bbc count file path
  'CNTFILENAME' => './bbs.cnt',

# Real-time participant count interval (seconds)
# (Participants who exceed this time from the last page view are excluded from the aggregation）
  'CNTLIMIT' => 300,

  #------------------------- Time -------------------------

# Time difference between server location and Japan
# Japan: 0
# Greenwich Mean Time: -9
# USA : -14 (Washington)
# : -20 (Midway Islands)
# New Zealand : 3
  'DIFFTIME' => 0,

# Time difference in seconds (for fine tuning, negative value allowed）
  'DIFFSEC' => 0,

  #------------------------- Color settings(specified in decimal 16), etc. -------------------------

# Background color
# Classic: 007f7f (Teal)
# Rebirth System: 004040 (Blackboard)
# Head office: 303c6d (蔵 藍 藍)
  'C_BACKGROUND' => '004040',

  'C_TEXT' => 'efefef',  # text color

  # url colors
  'C_A_COLOR' => 'cfe',   
  'C_A_VISITED' => 'ddd', 
  'C_A_ACTIVE' => 'f00',  
  'C_A_HOVER' => '1ee',   

  'C_SUBJ' => 'fffffe',   # Title color
  'C_QMSG' => 'ccc',   # quotes
  'C_ERROR' => 'f00',  # error collor

  'TXTFOLLOW' => '■',    
  'TXTAUTHOR' => '★',    
  'TXTTHREAD' => '◆',    
  'TXTTREE' => '木',      
  'TXTUNDO' => 'Del',      

  'FSUBJ' => '-san',          # end poster name
  'ANONY_NAME' => 'Anonymous',   # default name (anonymous or nameless, ideal.)

  #------------------------- log warehouse -------------------------

# Past log storage format
# (Past log search will not be available if it is in HTML format)
# 0 : HTML format
# 1: Binary format
  'OLDLOGFMT' => 1,

# Follow posts from past logs・Search for contributors
# (Valid only if the past log is in binary format)
# 0: Not allowed
# 1: Yes
  'OLDLOGBTN' => 1,

# How to save the past log
# 0: Daily
# 1: Monthly
  'OLDLOGSAVESW' => 1,

# Number of days saved in the past log
# (Valid only if the method of storing the past log is daily)
  'OLDLOGSAVEDAY' => 12,

  # max size in mb
  'MAXOLDLOGSIZE' => 4 * 10024 * 10024,

  #------------------------- extra  -------------------------

  # * links
  'BBSLINK' => '
<!-- 例:  |  <a href="http://strange.egoism.jp/script/" target="_blank">くずはすくりぷとPHP</a> -->
|| <a href="https://kuz.lol/" target="_blank">kuz.lol</a> |
<a href="https://0chan.vip/" target="_blank">0chan.vip</a> | We are seedling board.
',

# Message templates
# 'TMPL_MSG' => '
#<div class="m" id="m{val postid}">
# {val postid}<span class="nw"><span class="ms">{val title}</span>&nbsp;&nbsp;<span class="mu">Contributor:<span class="mun">{val user}</span></span > &nbsp;
# &nbsp;<span class="md">Posted date: {val wdate}<a id="a{val postid}">&nbsp;</a>
# {val btn}</span></span>
# <blockquote>
# <pre>{val msg}</pre>
# </blockquote>
#{val envlist}</div>
#
#<hr /><!-- -->
#',

# Environment variable display template
# 'TMPL_ENVLIST' => "<div class=\"env\">{val envaddr}{val envbr}{val envua}</div>\n",

#------------------------- Access restrictions, etc. -------------------------

  # Forbidden host name pattern list(Perl5 compatible regular expression)
  'HOSTNAME_POSTDENIED' => array(
    #例: 'npa\.go\.jp$', */
      '.example.com',
      '.example.net',
  ),

  # Forbidden host name pattern list(Perl5 compatible regular expression)
  'HOSTNAME_BANNED' => array(
    #例: '\.npa\.go\.jp$',
    '.example.com',
    '148.72.133.207',
  ),

  # Bad Words
  'NGWORD' => array(
  #例: 'Viagra','スーパーコピー'
  'Ð','viagra','Viagra','a href=','meridia','casino','Casino','スーパーコピー'
  ),

# Whether or not posts from mobile modules are restricted by the IP of the mobile device
# Because the posting function of the mobile version does not check the same IP address of the protection code、
# It is recommended to limit by the IP address of the mobile device.
# (because the IP address changes every time you access it in i-mode etc.)
  'RESTRICT_MOBILEIP' => 0,

  #------------------------- handle -------------------------

# 'Handle name' = > 'Password',
#Please list it in the form of#.Please write the password as it is.
#If you post with a password in the # contributor name field, it will be converted to a handle name.
# If you post by writing the handle name as it is in the contributor name field,"(trick)"will be added.
  'HANDLENAMES' => array(
    'しぱ' => 'kuz',
    'NOT THE REAL KUZ' => 'Administrator',
  ),

  #------------------------- Advanced settings (usually no change required） -------------------------

  'SHOW_COUNTER' => 1,  
  'DATEFORMAT' => '',  

  #------------------------- debug -------------------------

  'SHOW_PRCTIME' => 1,  
);
?>
