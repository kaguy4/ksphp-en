<?php

if (ini_get('register_globals') == 1) {
    #print 'エラー：register_globalsがonになっています。セキュリティのためPHPの設定でoffにしてください。';
    #exit();
}

/*
くずはすくりぷとPHP+

くずはすくりぷとをPHP版に移植したものを改良しました。
PHP version4.1.0以上で動作すると思います。

mailto  strangeworld@vivaldi.net    /   linksh@outlook.jp
webpage https://hiru.coresv.com/ksphp-plus/     /   https://prev.strangeworld.icu/

設置の流れ(参考程度に)
1.ダウンロードしたZIPを解凍する
2.conf.phpを開いて設定する
4.FTPクライアント等でサーバにアップロードする
5.bbs.phpに記載されている通りにパーミッションを設定する
6.ブラウザを開き、bbs.phpにアクセスし、管理用パスワードを設定する
7.ローカルのconf.phpを開き、6.で生成された管理用パスワードを36行辺りの 'ADMINPOST' => 'ここ', に張り付けFTPクライアントで上書きアップロード
8.ブラウザを開き、bbs.phpにアクセスし、投稿できるか確認する
9.ログファイルなどがあるURLにアクセスし、見えていないかチェックする(もし見えていたら.htaccess等で隠してください)

* インストール方法
conf.php の設定を必要に応じて書き換え、
以下のパーミッションでファイルを設置してください。
パーミッションは不具合と情報漏洩防止の為、正しく設定してください。

[ファイル構成]
|-- bbs.php   644 (読込可)     掲示板スクリプト本体
|-- conf.php  644 (読込可)     設定用
|-- bbs.log   606 (書換可)     ログファイル(空のテキストファイル)
|-- bbs.cnt   606 (書換可)     参加者一覧記録ファイル(空のテキストファイル)
|-- bbs.cgi   755 (実行可)     間違ってbbs.cgiにアクセスした場合にbbs.phpに転送するスクリプト
|
|-- vanish.js                NGワード用スクリプト
|
|-- index.html                広報室などのHTML
|-- favicon.ico               ブックマークなどのアイコン
|
+-- archive/  707 (書換可)     ZIPアーカイブ格納ディレクトリ
+-- count/    707 (書換可)     カウンター出力用ディレクトリ
+-- log/      707 (書換可)     過去ログファイル(生ログ)格納ディレクトリ
+-- sub/      755 (読込可)     サブモジュール格納ディレクトリ
    |
    |-- bbsadmin.php    644 (読込可)     管理モジュール
    |-- bbslog.php      644 (読込可)     過去ログ閲覧モジュール
    |-- bbstree.php     644 (読込可)     ツリービューモジュール
    |-- phpzip.inc.php  644 (読込可)     Zipファイル作成用ライブラリ

PHPがApacheモジュールとして動作する場合はbbs.phpは読込可で動作しますが、
CGIとして動作する場合はbbs.phpのみ755(実行可)にする必要があります。

* Memo:
bbs.php?m=* の意味一覧
m=g     過去ログ検索
m=ad    管理モード
m=tree  ツリービュー
m=p     投稿／リロード
m=c     環境設定
m=f     フォロー画面
m=t     スレッド表示
m=s     投稿者検索
m=u     UNDO実行

* Current Fixes
・検索語のハイライトの修正（/を含む検索語）
・HTML出力にテンプレートモジュールpatTemplateを採用した
//(蛭ヶ岳版)
・UIの修正、スマホなどで使いやすく
・UTF-8化(＠Links)
・PHPZipをv1.2にアップデート
//
・コーディングスタイルちょっと変更
・フォロー投稿時のバグ潰し
・jcode-LE削除
・個人用設定未反映を解消(?)
・テーンプレートに余計なお世話
・Funcクラスの謎実装を解消(不完全)
・PHP7.x系対応の用意
//20181012
・フォームデータの欠落のチェックに不具合がある為無効化
・UIの細かな修正
//20181118
・擬古猫氏のツリー表示修正適用
・vanish.jsの組み込み
//20191102
・EZweb表示(HDML)を削除
・imode表示を削除
//20200211
・擬古猫氏のツリー表示バグ修正を適用
//20200315
・カウンターをカンマ区切りに
//20200329
・擬古猫氏のYouTube埋め込み機能を追加
//20210308
・デザインの変更（テキストボックスなど）
・conf.php（表現とデフォルト値の変更）

* Todo:
・スレッドごとに記事を表示
・ツリー未読の速度改善
・ツリー表示の使用有無設定
・携帯モジュールの使用有無設定
・リンクtargetの改善
・新規投稿画面でフォームが表示されない
・「匿名プロクシのみ記録」設定
・マルチバイト関数とjcodeの使い分け
・UNDOの有効期限設定
・自動改行のチェックボックス

* Known Bugs:
・過去ログ検索時の&nbsp;大量出現
・自分の投稿を消したときに「消去完了」では無く「該当記事は見つかりませんでした。」のエラーが出る事がある

* History:
2003/01/21 作成開始
2003/01/31 0.0.1alpha
2003/02/03 0.0.2alpha
2003/02/11 0.0.3alpha
2003/02/13 0.0.4alpha
2003/02/14 0.0.5alpha
2003/02/16 0.0.6alpha
2003/02/18 0.0.7alpha
2005/04/01 0.0.8alpha(Unofficial) 有志による修正版が出される(http://www.freak.ne.jp/~lunatica/home/up/freak/dauso0073.zip)

2018/10/12 くずはすくりぷとPHP+
2020/12/14

* $Id: bbs.php,v 1.0 2003/02/14 05:17:02 cion Exp $
*/


// 設定ファイル
require_once("./conf.php");

// バージョン（著作権表示用）
$CONF['VERSION'] = '[20210308] (ヶ, ＠Links, 擬古猫)';

/* 起動 */

// エラー出力レベルを設定
error_reporting(E_ERROR | E_WARNING | E_PARSE);

if ($CONF['RUNMODE'] == 2) {
    print 'この掲示板は現在停止中です。';
    exit();
}
/* ホスト名によるアクセス禁止処理 */
if (Func::hostname_match($CONF['HOSTNAME_BANNED'])) {
    print 'You are banned, retard.';
    exit();
}

// インクルードファイルパス

/**
 * 過去ログ検索モジュール
 * @const PHP_GETLOG
 */
define('PHP_GETLOG', './sub/bbslog.php');

/**
 * 管理モジュール
 * @const PHP_BBSADMIN
 */
define('PHP_BBSADMIN', './sub/bbsadmin.php');

/**
 * ツリービューモジュール
 * @const PHP_TREEVIEW
 */
define('PHP_TREEVIEW', './sub/bbstree.php');

/**
 * 画像アップロード機能つきBBSモジュール
 * @const PHP_IMAGEBBS
 */
define('PHP_IMAGEBBS', './sub/bbsimage.php');

/**
 * HTMLテンプレートライブラリ
 * @const LIB_TEMPLATE
 */
define('LIB_TEMPLATE', './sub/patTemplate.php');

/**
 * Zipファイル作成ライブラリ
 * @const LIB_PHPZIP
 */
define('LIB_PHPZIP', './sub/phpzip.inc.php');

/**
 * ファイルインクルード検出用定数
 * @const INCLUDED_FROM_BBS
 */
define('INCLUDED_FROM_BBS', TRUE);

/**
 * 現在時刻定数
 * @const CURRENT_TIME
 */
define('CURRENT_TIME', time() - $CONF['DIFFTIME'] * 60 * 60 + $CONF['DIFFSEC']);

/* 実行 */
{
    require_once(LIB_TEMPLATE);
    script_run();
}

/**
 * スクリプト実行メイン処理
 *
 * モジュールの分岐は基本的にここに記述してください。
 */
function script_run() {

    $CONF = &$GLOBALS['CONF'];
    # パスワード設定画面 (bbsadmin.php)
    if ($CONF['ADMINPOST'] == '') {
        require_once(PHP_BBSADMIN);
        $bbsadmin = new Bbsadmin();
        $bbsadmin->procForm();
        $bbsadmin->refcustom();
        $bbsadmin->setusersession();
        if ($_POST['ad'] == 'ps') {
            $bbsadmin->prtpass($_POST['ps']);
        }
        else {
            $bbsadmin->prtsetpass();
        }
    }

    # 過去ログ検索モード (sub/bbslog.php)
    elseif ($_GET['m'] == 'g' or $_POST['m'] == 'g') {
        require_once(PHP_GETLOG);
        $getlog = new Getlog();
        $getlog->main();
    }
    # 管理モード (sub/bbsadmin.php)
    elseif ($_POST['m'] == 'ad') {
        if ($CONF['ADMINPOST'] and $CONF['ADMINKEY'] and $_POST['v'] == $CONF['ADMINKEY']
            and crypt($_POST['u'], $CONF['ADMINPOST']) == $CONF['ADMINPOST']) {
            require_once(PHP_BBSADMIN);
            $bbsadmin = new Bbsadmin();
            $bbsadmin->main();
        }
        elseif ($CONF['BBSMODE_IMAGE'] == 1) {
            require_once(PHP_IMAGEBBS);
            $imagebbs = new Imagebbs();
            $imagebbs->main();
        }
        else {
            $bbs = new Bbs();
            $bbs->main();
        }
    }
    # ツリービュー (sub/bbstree.php)
    elseif ($_GET['m'] == 'tree' or $_POST['m'] == 'tree') {
        require_once(PHP_TREEVIEW);
        $treeview = new Treeview();
        $treeview->main();
    }
    # 画像掲示板 (sub/bbsimage.php)
    elseif ($CONF['BBSMODE_IMAGE'] == 1) {
        require_once(PHP_IMAGEBBS);
        $imagebbs = new Imagebbs();
        $imagebbs->main();
    }
    # 掲示板モード (bbs.php)
    else {
        $bbs = new Bbs();
        $bbs->main();
    }
    exit();

}

/**
 * 基底Webアプリケーションクラス Webapp
 *
 * 各モードのスーパークラスです。各モードに共通する処理を記述します。
 *
 * @package strangeworld.cnscript
 * @access  public
 */
class Webapp {

    var $c; /* 設定情報 */
    var $f; /* フォーム入力 */
    var $s = array(); /* 投稿者ホストなどのセッション固有情報 */
    var $t; /* HTMLテンプレートオブジェクト */

    /**
     * コンストラクタ
     *
     */
    function __construct() {
        $this->c = &$GLOBALS['CONF'];
        $this->t = new patTemplate();
        $this->t->readTemplatesFromFile($this->c['TEMPLATE']);
    }

    /**
     * デストラクタ
     */
    function destroy() {
    }

    /**
     * フォーム取得前処理
     */
    function procForm() {
        if (!$this->c['BBSMODE_IMAGE'] and $_SERVER['CONTENT_LENGTH'] > $this->c['MAXMSGSIZE'] * 5) {
            $this->prterror('投稿内容が大きすぎます。1');
        }
        if ($this->c['BBSHOST'] and $_SERVER['HTTP_HOST'] != $this->c['BBSHOST']) {
            $this->prterror('呼び出し元が不正です。');
        }
        # POSTかGETのみに限定
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->f = $_POST;
        }
        else {
            $this->f = $_GET;
        }
        # 文字列置換
        foreach ($this->f as $name => $value) {
            if (is_array($value)) {
                foreach (array_keys($value) as $valuekey) {
                    $value[$valuekey] = Func::html_escape($value[$valuekey]);
                }
            }
            else {
                $value = Func::html_escape($value);
            }
            $this->f[$name] = $value;
        }
    }

    /**
     * セッション固有情報設定
     */
    function setusersession() {

        $this->s['U'] = $this->f['u'];
        $this->s['I'] = $this->f['i'];
        $this->s['C'] = $this->f['c'];
        $this->s['MSGDISP'] = $this->f['d'];
        $this->s['TOPPOSTID'] = $this->f['p'];
        # 設定情報Cookie取得
        if ($this->c['COOKIE'] and $_COOKIE['c']
            and preg_match("/u=([^&]*)&i=([^&]*)&c=([^&]*)/", $_COOKIE['c'], $matches)) {
            if (!isset($this->f['u'])) {
                $this->s['U'] = urldecode($matches[1]);
            }
            if (!isset($this->f['i'])) {
                $this->s['I'] = urldecode($matches[2]);
            }
            if (!isset($this->f['c'])) {
                $this->s['C'] = $matches[3];
            }
        }
        # UNDOボタン用Cookie取得
        if ($this->c['COOKIE'] and $this->c['ALLOW_UNDO'] and $_COOKIE['undo']
            and preg_match("/p=([^&]*)&k=([^&]*)/", $_COOKIE['undo'], $matches)) {
            $this->s['UNDO_P'] = $matches[1];
            $this->s['UNDO_K'] = $matches[2];
        }
        # デフォルトクエリ
        $this->s['QUERY'] = "c=".$this->s['C'];
        if ($this->s['MSGDISP']) {
            $this->s['QUERY'] .= "&amp;d=".$this->s['MSGDISP'];
        }
        if ($this->s['TOPPOSTID']) {
            $this->s['QUERY'] .= "&amp;p=".$this->s['TOPPOSTID'];
        }
        # デフォルトURL
        $this->s['DEFURL'] = $this->c['CGIURL'] . '?' . $this->s['QUERY'];
        # テンプレート変数設定
        $this->t->addGlobalVars($this->c);
        $this->t->addGlobalVars($this->s);
    }

    /**
     * エラー表示
     *
     * @access  public
     * @param   String  $err_message  エラーメッセージ
     */
    function prterror($err_message) {
        $this->sethttpheader();
        print $this->prthtmlhead ($this->c['BBSTITLE'] . ' エラー');
        $this->t->addVar('error', 'ERR_MESSAGE', $err_message);
        if (isset($this->s['DEFURL'])) {
            $this->t->setAttribute('backnavi', 'visibility', 'visible');
        }
        $this->t->displayParsedTemplate('error');
        print $this->prthtmlfoot ();
        $this->destroy();
        exit();
    }

    /**
     * HTMLヘッダ部分表示
     *
     * @access  public
     * @param   String  $title        HTMLタイトル
     * @param   String  $customhead   headタグ内のカスタムヘッダ
     * @param   String  $customstyle  styleタグ内のカスタムスタイルシート
     * @return  String  HTMLデータ
     */
    function prthtmlhead($title = "", $customhead = "", $customstyle = "") {
        $this->t->clearTemplate('header');
        $this->t->addVars('header', array(
            'TITLE' => $title,
            'CUSTOMHEAD' => $customhead,
            'CUSTOMSTYLE' => $customstyle,
        ));
        $htmlstr = $this->t->getParsedTemplate('header');
        return $htmlstr;
    }

    /**
     * HTMLフッタ部分表示
     *
     * @access  public
     * @return  String  HTMLデータ
     */
    function prthtmlfoot() {
        if ($this->c['SHOW_PRCTIME'] and $this->s['START_TIME']) {
            $duration = Func::microtime_diff($this->s['START_TIME'], microtime());
            $duration = sprintf("%0.6f", $duration);
            $this->t->setAttribute('duration', 'visibility', 'visible');
            $this->t->addVar('duration', 'DURATION', $duration);
        }
        $htmlstr = $this->t->getParsedTemplate('footer');
        return $htmlstr;
    }

    /**
     * 著作権表示
     */
    function prtcopyright() {
        $copyright = $this->t->getParsedTemplate('copyright');
        return $copyright;
    }

    /**
     * METAタグによるリダイレクター出力
     *
     * @access  public
     * @param   String  $redirecturl    リダイレクトするURL
     */
    function prtredirect($redirecturl) {
        $this->sethttpheader();
        print $this->prthtmlhead ($this->c['BBSTITLE'] . ' - URLリダイレクト',
            "<meta http-equiv=\"refresh\" content=\"1;url={$redirecturl}\">\n");
        $this->t->addVar('redirect', 'REDIRECTURL', $redirecturl);
        $this->t->displayParsedTemplate('redirect');
        print $this->prthtmlfoot ();
    }

    /**
     * メッセージ表示内容定義
     */
    function setmessage($message, $mode = 0, $tlog = '') {

        if (count($message) < 10) {
            return;
        }
        $message['WDATE'] = Func::getdatestr($message['NDATE'], $this->c['DATEFORMAT']);
		#20181102 擬古猫 特殊文字をエスケープする
		$message['MSG'] = preg_replace("/{/i","&#123;", $message['MSG'], -1);
        $message['MSG'] = preg_replace("/}/i","&#125;", $message['MSG'], -1);

        #20200524 擬古猫 youtube埋め込み
        $message['MSG'] = preg_replace("/<a href=\"https:\/\/youtu.be\/([^\"]+?)\" target=\"link\">([^<]+?)<\/a>/",
        "<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/$1\" frameborder=\"0\" allow=\"autoplay; encrypted-media\" allowfullscreen></iframe>\r<a href=\"https://youtu.be/$1\">$2</a>", $message['MSG']);
        #20200524 擬古猫 youtube埋め込み2
        $message['MSG'] = preg_replace("/<a href=\"https:\/\/www.youtube.com\/watch\?v=([^\"]+?)\" target=\"link\">([^<]+?)<\/a>/",
        "<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/$1\" frameborder=\"0\" allow=\"autoplay; encrypted-media\" allowfullscreen></iframe>\r<a href=\"https://www.youtube.com/watch?v=$1\">$2</a>", $message['MSG']);
        #20200524 擬古猫 youtube埋め込み3
        $message['MSG'] = preg_replace("/<a href=\"https:\/\/m.youtube.com\/watch\?v=([^\"]+?)\" target=\"link\">([^<]+?)<\/a>/",
        "<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/$1\" frameborder=\"0\" allow=\"autoplay; encrypted-media\" allowfullscreen></iframe>\r<a href=\"https://m.youtube.com/watch?v=$1\">$2</a>", $message['MSG']);

        # 「参考」
        if (!$mode) {
            $message['MSG'] = preg_replace("/<a href=\"m=f&s=(\d+)[^>]+>([^<]+)<\/a>$/i",
                "<a href=\"{$this->c['CGIURL']}?m=f&amp;s=$1&amp;{$this->s['QUERY']}\">$2</a>", $message['MSG'], 1);
            $message['MSG'] = preg_replace("/<a href=\"mode=follow&search=(\d+)[^>]+>([^<]+)<\/a>$/i",
                "<a href=\"{$this->c['CGIURL']}?m=f&amp;s=$1&amp;{$this->s['QUERY']}\">$2</a>", $message['MSG'], 1);
        } else {
            $message['MSG'] = preg_replace("/<a href=\"m=f&s=(\d+)[^>]+>([^<]+)<\/a>$/i",
                "<a href=\"#a$1\">$2</a>", $message['MSG'], 1);
            $message['MSG'] = preg_replace("/<a href=\"mode=follow&search=(\d+)[^>]+>([^<]+)<\/a>$/i",
                "<a href=\"#a$1\">$2</a>", $message['MSG'], 1);
        }
        if ($mode == 0 or ($mode == 1 and $this->c['OLDLOGBTN'])) {

            if (!$this->c['FOLLOWWIN']) { $newwin = " target=\"link\""; }
            else { $newwin = ''; }
            $spacer = "&nbsp;&nbsp;&nbsp;";
            $lnk_class = "class=\"internal\"";
            # フォロー投稿ボタン
            $message['BTNFOLLOW'] = '';
            if ($this->c['BBSMODE_ADMINONLY'] != 1) {
                $message['BTNFOLLOW'] = "$spacer<a href=\"{$this->c['CGIURL']}"
                    ."?m=f&amp;s={$message['POSTID']}&amp;".$this->s['QUERY'];
                if ($this->f['w']) {
                    $message['BTNFOLLOW'] .= "&amp;w=".$this->f['w'];
                }
                if ($mode == 1) {
                    $message['BTNFOLLOW'] .= "&amp;ff=$tlog";
                }
                $message['BTNFOLLOW'] .= "\"$newwin $lnk_class title=\"フォロー投稿(返信)\" >{$this->c['TXTFOLLOW']}</a>";
            }
            # 投稿者検索ボタン
            $message['BTNAUTHOR'] = '';
            if ($message['USER'] != $this->c['ANONY_NAME'] and $this->c['BBSMODE_ADMINONLY'] != 1) {
                $message['BTNAUTHOR'] = "$spacer<a href=\"{$this->c['CGIURL']}"
                    ."?m=s&amp;s=". urlencode(preg_replace("/<[^>]*>/", '', $message['USER'])) ."&amp;".$this->s['QUERY'];
                if ($this->f['w']) {
                    $message['BTNAUTHOR'] .= "&amp;w=".$this->f['w'];
                }
                if ($mode == 1) {
                    $message['BTNAUTHOR'] .= "&amp;ff=$tlog";
                }
                $message['BTNAUTHOR'] .= "\" target=\"link\" $lnk_class title=\"投稿者検索\" >{$this->c['TXTAUTHOR']}</a>";
            }
            # スレッド表示ボタン
            if (!$message['THREAD']) {
                $message['THREAD'] = $message['POSTID'];
            }
            $message['BTNTHREAD'] = '';
            if ($this->c['BBSMODE_ADMINONLY'] != 1) {
                $message['BTNTHREAD'] = "$spacer<a href=\"{$this->c['CGIURL']}?m=t&amp;s={$message['THREAD']}&amp;".$this->s['QUERY'];
                if ($mode == 1) {
                    $message['BTNTHREAD'] .= "&amp;ff=$tlog";
                }
                $message['BTNTHREAD'] .= "\" target=\"link\" $lnk_class title=\"スレッド表示\" >{$this->c['TXTTHREAD']}</a>";
            }
            # ツリー表示ボタン
            $message['BTNTREE'] = '';
            if ($this->c['BBSMODE_ADMINONLY'] != 1) {
                $message['BTNTREE'] = "$spacer<a href=\"{$this->c['CGIURL']}?m=tree&amp;s={$message['THREAD']}&amp;".$this->s['QUERY'];
                if ($mode == 1) {
                    $message['BTNTREE'] .= "&amp;ff=$tlog";
                }
                $message['BTNTREE'] .= "\" target=\"link\" $lnk_class title=\"Tree View\" >{$this->c['TXTTREE']}</a>";
            }
            # UNDOボタン
            $message['BTNUNDO'] = '';
            if ($this->c['ALLOW_UNDO'] and isset($this->s['UNDO_P']) and $this->s['UNDO_P'] == $message['POSTID']) {
                $message['BTNUNDO'] = "$spacer<a href=\"{$this->c['CGIURL']}?m=u&amp;s={$message['POSTID']}&amp;".$this->s['QUERY'];
                $message['BTNUNDO'] .= "\" $lnk_class title=\"投稿を消す\" >{$this->c['TXTUNDO']}</a>";
            }
            # ボタンの統合
            $message['BTN'] = $message['BTNFOLLOW']. $message['BTNAUTHOR']. $message['BTNTHREAD']. $message['BTNTREE']. $message['BTNUNDO'];
        }
        # メールアドレス
        if ($message['MAIL']) {
            $message['USER'] = "<a href=\"mailto:{$message['MAIL']}\">{$message['USER']}</a>";
        }
        # 引用色変更
        $message['MSG'] = preg_replace("/(^|\r)(\&gt;[^\r]*)/", "$1<span class=\"q\">$2</span>", $message['MSG']);
        $message['MSG'] = str_replace("</span>\r<span class=\"q\">", "\r", $message['MSG']);
        # 環境変数
        $message['ENVADDR'] = '';
        $message['ENVUA'] = '';
        $message['ENVBR'] = '';
        if ($this->c['IPPRINT'] or $this->c['UAPRINT']) {
            if ($this->c['IPPRINT']) {
                $message['ENVADDR'] = $message['PHOST'];
            }
            if ($this->c['UAPRINT']) {
                $message['ENVUA'] = $message['AGENT'];
            }
            if ($this->c['IPPRINT'] and $this->c['UAPRINT']) {
                $message['ENVBR'] = '<br>';
            }
            if ($message['ENVADDR'] or $message['ENVUA']) {
                $this->t->clearTemplate('envlist');
                $this->t->setAttribute("envlist", "visibility", "visible");
                $this->t->addVars('envlist', array(
                    'ENVADDR' => $message['ENVADDR'],
                    'ENVUA' => $message['ENVUA'],
                    'ENVBR' => $message['ENVBR'],
                ));
            }
        }
        # 画像BBSの画像表示有無
        if (!$this->c['SHOWIMG']) {
            $message['MSG'] = Func::conv_imgtag($message['MSG']);
        }
        # 画像ファイルがない場合もIMGタグを変換
        elseif (preg_match("/<a href=[^>]+><img [^>]*?src=\"([^\"]+)\"[^>]+><\/a>/i", $message['MSG'], $matches)) {
            if (!file_exists($matches[1])) {
                $message['MSG'] = Func::conv_imgtag($message['MSG']);
            }
        }
        # メッセージ表示内容定義
        $this->t->clearTemplate('message');
        $this->t->addVars('message', $message);
    }

    /**
     * メッセージ１件出力
     *
     * メッセージ配列を元にメッセージのHTMLを出力します。
     * 過去ログモジュールに対応しています。
     *
     * @access  public
     * @param   Array   $message    メッセージ
     * @param   Integer $mode       0:掲示板 / 1:過去ログ検索(ボタン表示あり) / 2:過去ログ検索(ボタン表示なし) / 3:過去ログファイル出力用
     * @param   String  $tlog       ログファイル指定
     * @return  String  メッセージのHTMLデータ
     */
    function prtmessage($message, $mode = 0, $tlog = '') {
        $this->setmessage($message, $mode, $tlog);
        $prtmessage = $this->t->getParsedTemplate('message');
        return $prtmessage;
    }

    /**
     * ログ読み込み
     *
     * ログファイルを読み込み、行配列にして返します。
     *
     * @access  public
     * @param   String  $logfilename  ログファイル名（オプション）
     * @return  Array   ログの行配列
     */
    function loadmessage($logfilename = "") {
        if ($logfilename) {
            preg_match("/^([\w.]*)$/", $logfilename, $matches);
            $logfilename = $this->c['OLDLOGFILEDIR']."/".$matches[1];
        }
        else {
            $logfilename = $this->c['LOGFILENAME'];
        }
        if (!file_exists($logfilename)) {
            $this->prterror('メッセージ読み込みに失敗しました');
        }
        $logdata = file($logfilename);
        return $logdata;
    }

    /**
     * メッセージ１件取得
     *
     * ログ行をメッセージ配列に変換して返します。
     *
     * @access  public
     * @param   String  $logline  ログ行
     * @return  Array   メッセージ配列
     */
    function getmessage($logline) {

        $logsplit = @explode (',', rtrim($logline));
        if (count($logsplit) < 10) {
            return;
        }
        $i = 6;
        while ($i <= 9) {
            $logsplit[$i] = strtr ($logsplit[$i], "\0", ",");
            $logsplit[$i] = str_replace ("&#44;", ",", $logsplit[$i]);
            $i++;
        }
        $message = array();
        $messagekey = array('NDATE', 'POSTID', 'PROTECT', 'THREAD', 'PHOST', 'AGENT', 'USER', 'MAIL', 'TITLE', 'MSG', 'REFID', 'RESERVED1', 'RESERVED2', 'RESERVED3', );
        $logsplitcount = count($logsplit);
        $i = 0;
        while ($i < $logsplitcount) {
            if ($i > 12) { break; }
            $message[$messagekey[$i]] = $logsplit[$i];
            $i++;
        }
        return $message;
    }

    /**
     * 個人用設定反映
     */
    function refcustom() {

        $this->c['LINKOFF'] = 0;
        $this->c['HIDEFORM'] = 0;
        $this->c['RELTYPE'] = 0;
        if (!isset($this->c['SHOWIMG'])) {
            $this->c['SHOWIMG'] = 0;
        }
        $flgcolorchanged = FALSE;

        $colors = array(
            'C_BACKGROUND',
            'C_TEXT',
            'C_A_COLOR',
            'C_A_VISITED',
            'C_SUBJ',
            'C_QMSG',
            'C_A_ACTIVE',
            'C_A_HOVER',
        );
        $flags = array(
            'GZIPU',
            'RELTYPE',
            'AUTOLINK',
            'FOLLOWWIN',
            'COOKIE',
            'LINKOFF',
            'HIDEFORM',
            'SHOWIMG',
        );
        # 設定文字列からの更新
        if ($this->f['c']) {
            $strflag = '';
            $formc = $this->f['c'];
            if (strlen($formc) > 5) {
                $formclen = strlen($formc);
                $strflag = substr($formc, 0, 2);
                $currentpos = 2;
                foreach ($colors as $confname) {
                    $colorval = Func::base64_threebytehex(substr($formc, $currentpos, 4));
                    if (strlen($colorval) == 6 and strcasecmp($this->c[$confname], $colorval) != 0) {
                        $flgcolorchanged = TRUE;
                        $this->c[$confname] = $colorval;
                    }
                    $currentpos += 4;
                    if ($currentpos > $formclen) {
                        break;
                    }
                }
            }
            elseif (strlen($formc) == 2) {
                $strflag = $formc;
            }
            if ($strflag) {
                $flagbin = str_pad(base_convert ($strflag, 32, 2), count($flags), "0", STR_PAD_LEFT);
                $currentpos = 0;
                foreach ($flags as $confname) {
                    $this->c[$confname] = substr($flagbin, $currentpos, 1);
                    $currentpos++;
                }
            }
        }
        # 設定情報の更新
        if ($this->f['m'] == 'p' or $this->f['m'] == 'c' or $this->f['m'] == 'g') {
            $this->f['a'] ? $this->c['AUTOLINK'] = 1 : $this->c['AUTOLINK'] = 0;
            $this->f['g'] ? $this->c['GZIPU'] = 1 : $this->c['GZIPU'] = 0;
            $this->f['loff'] ? $this->c['LINKOFF'] = 1 : $this->c['LINKOFF'] = 0;
            $this->f['hide'] ? $this->c['HIDEFORM'] = 1 : $this->c['HIDEFORM'] = 0;
            $this->f['sim'] ? $this->c['SHOWIMG'] = 1 : $this->c['SHOWIMG'] = 0;
            if ($this->f['m'] == 'c') {
                $this->f['fw'] ? $this->c['FOLLOWWIN'] = 1 : $this->c['FOLLOWWIN'] = 0;
                $this->f['rt'] ? $this->c['RELTYPE'] = 1 : $this->c['RELTYPE'] = 0;
                $this->f['cookie'] ? $this->c['COOKIE'] = 1 : $this->c['COOKIE'] = 0;
            }
        }
        # 特別な条件
        if ($this->c['BBSMODE_ADMINONLY'] != 0) {
            ($this->f['m'] == 'f' or ($this->f['m'] == 'p' and $this->f['write'])) ? $this->c['HIDEFORM'] = 0 : $this->c['HIDEFORM'] = 1;
        }
        # 設定文字列の更新
        {
            $flagbin = '';
            foreach ($flags as $confname) {
                $this->c[$confname] ? $flagbin .= '1' : $flagbin .= '0';
            }
            $flagvalue = str_pad(base_convert ($flagbin, 2, 32), 2, "0", STR_PAD_LEFT);

            if ($flgcolorchanged) {
                $this->f['c'] = $flagvalue . substr($this->f['c'], 2);
            }
            else {
                $this->f['c'] = $flagvalue;
            }
        }
    }

    /**
     * HTTPヘッダー設定
     */
    function sethttpheader() {
        header('Content-Type: text/html; charset=UTF-8');
        header("X-XSS-Protection: 1; mode=block");
    }

    /**
     * 実行時間測定開始
     */
    function setstarttime() {
        $this->s['START_TIME'] = microtime();
    }

}

/**
 * 標準掲示板クラス Bbs
 *
 * PC用の掲示板表示クラスです。
 * 掲示板機能自体をカスタマイズ・拡張する場合はこのクラスを継承します。
 *
 * @package strangeworld.cnscript
 * @access  public
 */
class Bbs extends Webapp {

    /**
     * コンストラクタ
     *
     */
    function __construct() {
        parent::__construct();
    }

    /**
     * メイン処理
     */
    function main() {
        # 実行時間測定開始
        $this->setstarttime();
        # フォーム取得前処理
        $this->procForm();
        # 個人用設定反映
        $this->refcustom();
        $this->setusersession();
        # gzip圧縮転送
        if ($this->c['GZIPU']) {
            ob_start("ob_gzhandler");
        }
        # 書き込み処理
        if ($this->f['m'] == 'p' and trim($this->f['v'])) {
            # 環境変数取得
            $this->setuserenv();
            # パラメータチェック
            $posterr = $this->chkmessage();
            # 書き込み処理
            if (!$posterr) {
                $posterr = $this->putmessage($this->getformmessage());
            }
            # ２重書き込みエラーなど
            if ($posterr == 1) {
                $this->prtmain();
            }
            # プロテクトコード時間経過のため再表示
            elseif ($posterr == 2) {
                if ($this->f['f']) {
                    $this->prtfollow(TRUE);
                }
                elseif ($this->f['write']) {
                    $this->prtnewpost(TRUE);
                }
                else {
                    $this->prtmain(TRUE);
                }
            }
            # 管理モード移行
            elseif ($posterr == 3) {
                define('BBS_ACTIVATED', TRUE);
                require_once(PHP_BBSADMIN);
                $bbsadmin = new Bbsadmin($this);
                $bbsadmin->main();
            }
            # 書き込み完了画面
            elseif ($this->f['f']) {
                $this->prtputcomplete();
            }
            else {
                $this->prtmain();
            }
        }
        # フォロー画面表示
        elseif ($this->f['m'] == 'f') {
            $this->prtfollow();
        }
        # 投稿検索
        elseif ($this->f['m'] == 't' or $this->f['m'] == 's') {
            $this->prtsearchlist();
        }
        # 環境設定画面表示
        elseif ($this->f['setup']) {
            $this->prtcustom();
        }
        # 環境設定処理
        elseif ($this->f['m'] == 'c') {
            $this->setcustom();
        }
        # 新規投稿
        elseif ($this->f['m'] == 'p' and $this->f['write']) {
            $this->prtnewpost();
        }
        # UNDO処理
        elseif ($this->f['m'] == 'u') {
            $this->prtundo();
        }
        # デフォルト：掲示板表示
        else {
            $this->prtmain();
        }

        if ($this->c['GZIPU']) {
            ob_end_flush();
        }
    }

    /**
     * 掲示板の表示
     *
     * @access  public
     * @param   Boolean  $retry  リトライフラグ
     */
    function prtmain($retry = FALSE) {
        # 表示メッセージ取得
        list ($logdatadisp, $bindex, $eindex, $lastindex) = $this->getdispmessage();
        # フォーム部分設定
        $dtitle = "";
        $dmsg = "";
        $dlink = "";
        if ($retry) {
            $dtitle = $this->f['t'];
            $dmsg = $this->f['v'];
            $dlink = $this->f['l'];
        }
        $this->setform ($dtitle, $dmsg, $dlink);
        # HTMLヘッダ部分出力
        $this->sethttpheader();
        print $this->prthtmlhead ($this->c['BBSTITLE']);
        # メイン上部
        $this->t->displayParsedTemplate('main_upper');
        # メッセージ表示
        while ($msgdata = each($logdatadisp)) {
            print $this->prtmessage($this->getmessage($msgdata[1]), 0, 0);
        }
        # メッセージ情報
        if ($this->s['MSGDISP'] < 0) {
            $msgmore = '';
        }
        elseif ($eindex > 0) {
            $msgmore = "";
        }
        else {
            $msgmore = '未読メッセージはありません。';
        }
        if ($eindex >= $lastindex) {
            $msgmore .= 'これ以下の記事はありません。';
        }
        $this->t->addVar('main_lower', 'MSGMORE', $msgmore);
        # ナビゲートボタン
        if ($eindex > 0) {
            if ($eindex >= $lastindex) {
                $this->t->setAttribute("nextpage", "visibility", "hidden");
            }
            else {
                $this->t->addVar('nextpage', 'EINDEX', $eindex);
            }
            if (!$this->c['SHOW_READNEWBTN']) {
                $this->t->setAttribute("readnew", "visibility", "hidden");
            }
        }
        # 管理者投稿
        if ($this->c['BBSMODE_ADMINONLY'] == 0) {
            $this->t->setAttribute("adminlogin", "visibility", "hidden");
        }
        # メイン下部
        $this->t->displayParsedTemplate('main_lower');
        print $this->prthtmlfoot ();
    }

    /**
     * 表示範囲のメッセージとパラメータの取得
     *
     * @access  public
     * @return  Array   $logdatadisp  ログ行配列
     * @return  Integer $bindex       開始index
     * @return  Integer $eindex       終端index
     * @return  Integer $lastindex    全ログの終端index
     */
    function getdispmessage() {

        $logdata = $this->loadmessage();
        # 未読ポインタ（最新POSTID）
        $items = @explode (',', $logdata[0], 3);
        $toppostid = $items[1];
        # 表示件数
        $msgdisp = Func::fixnumberstr($this->f['d']);
        if ($msgdisp === FALSE) {
            $msgdisp = $this->c['MSGDISP'];
        }
        elseif ($msgdisp < 0) {
            $msgdisp = -1;
        }
        elseif ($msgdisp > $this->c['LOGSAVE']) {
            $msgdisp = $this->c['LOGSAVE'];
        }
        if ($this->f['readzero']) {
            $msgdisp = 0;
        }
        # 開始index
        $bindex = $this->f['b'];
        if (!$bindex) {
            $bindex = 0;
        }
        # 次ページ以降の場合
        if ($bindex > 1) {
            # 新着投稿があったら開始indexをずらす
            if ($toppostid > $this->f['p']) {
                $bindex += ($toppostid - $this->f['p']);
            }
            # 未読ポインタは更新させない
            $toppostid = $this->f['p'];
        }
        # 終端index
        $eindex = $bindex + $msgdisp;
        # 未読リロード
        if ($this->f['readnew'] or ($msgdisp == '0' and $bindex == 0)) {
            $bindex = 0;
            $eindex = $toppostid - $this->f['p'];
        }
        # 最後のページの場合、切り詰め
        $lastindex = count($logdata);
        if ($eindex > $lastindex) {
            $eindex = $lastindex;
        }
        # -1件表示
        if ($msgdisp < 0) {
            $bindex = 0;
            $eindex = 0;
        }
        # 表示メッセージ
        if ($bindex == 0 and $eindex == 0) {
            $logdatadisp = array();
        }
        else {
            $logdatadisp = array_splice ($logdata, $bindex, ($eindex - $bindex));
            if ($this->c['RELTYPE'] and ($this->f['readnew'] or ($msgdisp == '0' and $bindex == 0))) {
                $logdatadisp = array_reverse($logdatadisp);
            }
        }
        $this->s['TOPPOSTID'] = $toppostid;
        $this->s['MSGDISP'] = $msgdisp;
        $this->t->addGlobalVars(array(
            'TOPPOSTID' => $this->s['TOPPOSTID'],
            'MSGDISP' => $this->s['MSGDISP']
        ));
        return array($logdatadisp, $bindex + 1, $eindex, $lastindex);
    }

    /**
     * フォーム部分の設定
     *
     * @access  public
     * @param   String  $dtitle     題名のフォーム初期値
     * @param   String  $dmsg       内容のフォーム初期値
     * @param   String  $dlink      リンクのフォーム初期値
     */
    function setform($dtitle, $dmsg, $dlink, $mode = '') {
        # プロテクトコード生成
        $pcode = Func::pcode();
        if (!$mode) {
            $mode = '<input type="hidden" name="m" value="p" />';
        }
        $this->t->addVars('form', array(
            'MODE' => $mode,
            'PCODE' => $pcode,
        ));
        # 投稿フォームの非表示
        if ($this->c['HIDEFORM'] and $this->f['m'] != 'f' and !$this->f['write']) {
            $this->t->addVar('postform', 'mode', 'hide');
        }
        else {
            $this->t->addVars('postform', array(
                'DTITLE' => $dtitle,
                'DMSG' => $dmsg,
                'DLINK' => $dlink,
            ));
        }
        # 設定行とリンク行
        if ($this->f['m'] != 'f' and !isset($this->f['f']) and !$this->f['write']) {
            # カウンタ
            if ($this->c['SHOW_COUNTER']) {
                $counter = $this->counter();
                $counter = number_format($counter);
                $this->t->addVar("counter", 'COUNTER', $counter);
                $this->t->setAttribute("counter", "visibility", "visible");
            }
            if ($this->c['CNTFILENAME']) {
                $mbrcount = $this->mbrcount();
                $mbrcount = number_format($mbrcount);
                $this->t->addVar("mbrcount", 'MBRCOUNT', $mbrcount);
                $this->t->setAttribute("mbrcount", "visibility", "visible");
            }
            if (!$this->c['SHOW_COUNTER'] and !$this->c['CNTFILENAME']) {
                $this->t->setAttribute("counterrow", "visibility", "hidden");
            }
            if ($this->c['BBSMODE_ADMINONLY'] == 0) {
                if ($this->c['AUTOLINK']) $this->t->addVar('formconfig', 'CHK_A', ' checked="checked"');
                if ($this->c['HIDEFORM']) $this->t->addVar('formconfig', 'CHK_HIDE', ' checked="checked"');
            }
            else {
                $this->t->setAttribute("formconfig", "visibility", "hidden");
            }
            # リンク行の非表示
            if ($this->c['LINKOFF']) {
                $this->t->addVar('extraform', 'CHK_LOFF', ' checked="checked"');
                $this->t->setAttribute("linkrow", "visibility", "hidden");
            }
            # ヘルプ行の非表示
            if ($this->c['BBSMODE_ADMINONLY'] != 1) {
                if (!$this->c['ALLOW_UNDO']) {
                    $this->t->setAttribute("helpundo", "visibility", "hidden");
                }
            }
            else {
                $this->t->setAttribute("helprow", "visibility", "hidden");
            }
            # ナビゲートボタン行
            if (!$this->c['SHOW_READNEWBTN']) {
                $this->t->setAttribute("readnewbtn", "visibility", "hidden");
            }
            if (!($this->c['HIDEFORM'] and $this->c['BBSMODE_ADMINONLY'] == 0)) {
                $this->t->setAttribute("newpostbtn", "visibility", "hidden");
            }
        }
        else {
            $this->t->setAttribute("extraform", "visibility", "hidden");
        }
    }

    /**
     * フォロー画面表示
     *
     * @access  public
     * @param   Boolean $retry  リトライフラグ
     */
    function prtfollow($retry = FALSE) {

        if (!$this->f['s']) {
            $this->prterror ( 'パラメータがありません。' );
        }

        # 管理人認証
        if ($this->c['BBSMODE_ADMINONLY'] == 1
            and crypt($this->f['u'], $this->c['ADMINPOST']) != $this->c['ADMINPOST']) {
            $this->prterror('パスワードが違います。');
        }
        $filename = '';
        if ($this->f['ff']) {
            $filename = trim($this->f['ff']);
        }
        $result = $this->searchmessage('POSTID', $this->f['s'], FALSE, $filename);
        if (!$result) {
            $this->prterror ( '指定されたメッセージが見つかりません。' );
        }
        # メッセージの取得
        $message = $this->getmessage($result[0]);

        if (!$retry) {
            $formmsg = $message['MSG'];
            $formmsg = preg_replace ("/&gt; &gt;[^\r]+\r/", "", $formmsg);
            $formmsg = preg_replace ("/<a href=\"m=f\S+\"[^>]*>[^<]+<\/a>/i", "", $formmsg);
            $formmsg = preg_replace ("/<a href=\"[^>]+>([^<]+)<\/a>/i", "$1", $formmsg);
            $formmsg = preg_replace ("/\r*<a href=[^>]+><img [^>]+><\/a>/i", "", $formmsg);
            $formmsg = preg_replace ("/\r/", "\r> ", $formmsg);
            $formmsg = "> $formmsg\r";
            $formmsg = preg_replace ("/\r>\s+\r/", "\r", $formmsg);
            $formmsg = preg_replace ("/\r>\s+\r$/", "\r", $formmsg);
        } else {
            $formmsg = $this->f['v'];
            $formmsg = preg_replace ("/<a href=\"m=f\S+\"[^>]*>[^<]+<\/a>/i", "", $formmsg);
        }
        $formmsg .= "\r";

        $this->setform ( "＞" . preg_replace("/<[^>]*>/", '', $message['USER']) . $this->c['FSUBJ'], $formmsg, '');

        if (!$message['THREAD']) {
            $message['THREAD'] = $message['POSTID'];
        }
        $filename ? $mode = 1 : $mode = 0;
        $this->setmessage ($message, $mode, $filename);

        if ($this->c['AUTOLINK']) $this->t->addVar('follow', 'CHK_A', ' checked="checked"');
        $this->t->addVar('follow', 'FOLLOWID', $message['POSTID']);
        $this->t->addVar('follow', 'SEARCHID', $this->f['s']);
        $this->t->addVar('follow', 'FF', $this->f['ff']);
        # 表示
        $this->sethttpheader();
        print $this->prthtmlhead ($this->c['BBSTITLE'] . ' フォロー投稿');
        $this->t->displayParsedTemplate('follow');
        print $this->prthtmlfoot ();

    }

    /**
     * 新規投稿画面表示
     *
     * @access  public
     */
    function prtnewpost($retry = FALSE) {

        # 管理人認証
        if ($this->c['BBSMODE_ADMINONLY'] != 0
            and crypt($this->f['u'], $this->c['ADMINPOST']) != $this->c['ADMINPOST']) {
            $this->prterror('パスワードが違います。');
        }
        # フォーム部分
        $dtitle = "";
        $dmsg = "";
        $dlink = "";
        if ($retry) {
            $dtitle = $this->f['t'];
            $dmsg = $this->f['v'];
            $dlink = $this->f['l'];
        }
        $this->setform ($dtitle, $dmsg, $dlink);

        if ($this->c['AUTOLINK']) $this->t->addVar('newpost', 'CHK_A', ' checked="checked"');

        $this->sethttpheader();
        print $this->prthtmlhead ( "{$this->c['BBSTITLE']} 新規投稿" );
        $this->t->displayParsedTemplate('newpost');
        print $this->prthtmlfoot ();

    }

    /**
     * 投稿検索
     *
     * @param   Integer $mode       0:掲示板 / 1:過去ログ検索(ボタン表示あり) / 2:過去ログ検索(ボタン表示なし) / 3:過去ログファイル出力用
     */
    function prtsearchlist($mode = "") {

        if (!$this->f['s']) {
            $this->prterror ( 'パラメータがありません。' );
        }
        if (!$mode) {
            $mode = $this->f['m'];
        }
        $this->sethttpheader();
        print $this->prthtmlhead ($this->c['BBSTITLE'] . ' 投稿検索');
        $this->t->displayParsedTemplate('searchlist_upper');

        $result = $this->msgsearchlist($mode);
        while ($message = each($result)) {
            print $this->prtmessage ($message[1], $mode, $this->f['ff']);
        }
        $success = count($result);

        $this->t->addVar('searchlist_lower', 'SUCCESS', $success);
        $this->t->displayParsedTemplate('searchlist_lower');
        print $this->prthtmlfoot ();

    }

    /**
     * 投稿検索処理
     */
    function msgsearchlist($mode) {

        if ($this->f['ff']) {
            $fh = NULL;
            if (preg_match("/^[\w.]+$/", $this->f['ff'])) {
                $fh = @fopen($this->c['OLDLOGFILEDIR'] . $this->f['ff'], "rb");
            }
            if (!$fh) {
                $this->prterror ("{$this->f['ff']}を開けませんでした。");
            }
            flock ($fh, 1);
        }

        $result = array();

        if ($fh) {
            $linecount = 0;
            $threadstart = FALSE;
            while (($logline = Func::fgetline($fh)) !== FALSE) {
                if ($threadstart) {
                    $linecount++;
                }
                if ($linecount > $this->c['LOGSAVE']) {
                    break;
                }
                $message = $this->getmessage($logline);
                # 投稿者検索
                if ($mode == 's' and preg_replace("/<[^>]*>/", '', $message['USER']) == $this->f['s']) {
                    $result[] = $message;
                }
                # スレッド検索
                elseif ($mode == 't'
                    and ($message['THREAD'] == $this->f['s'] or $message['POSTID'] == $this->f['s'])) {
                    $result[] = $message;
                    if (!$threadstart) {
                        $threadstart = TRUE;
                    }
                }
            }
            flock ($fh, 3);
            fclose ($fh);
        }
        else {
            $logdata = $this->loadmessage();
            foreach ($logdata as $logline) {
                $message = $this->getmessage($logline);
                # 投稿者検索
                if ($mode == 's' and preg_replace("/<[^>]*>/", '', $message['USER']) == $this->f['s']) {
                    $result[] = $message;
                }
                # スレッド検索
                elseif ($mode == 't'
                    and ($message['THREAD'] == $this->f['s'] or $message['POSTID'] == $this->f['s'])) {
                    $result[] = $message;
                    if ($message['POSTID'] == $this->f['s']) {
                        break;
                    }
                }
            }
        }
        return $result;
    }

    /**
     * 書き込み完了
     */
    function prtputcomplete() {

        $this->sethttpheader();
        print $this->prthtmlhead ($this->c['BBSTITLE'] . ' 書き込み完了');
        $this->t->displayParsedTemplate('postcomplete');
        print $this->prthtmlfoot ();

    }

    /**
     * 環境設定画面表示
     */
    function prtcustom($mode = '') {

        if ($this->c['GZIPU']) $this->t->addVar('custom', 'CHK_G', ' checked="checked"');
        if ($this->c['AUTOLINK']) $this->t->addVar('custom', 'CHK_A', ' checked="checked"');
        if ($this->c['LINKOFF']) $this->t->addVar('custom', 'CHK_LOFF', ' checked="checked"');
        if ($this->c['HIDEFORM']) $this->t->addVar('custom', 'CHK_HIDE', ' checked="checked"');
        if ($this->c['SHOWIMG']) $this->t->addVar('custom', 'CHK_SI', ' checked="checked"');
        if ($this->c['COOKIE']) $this->t->addVar('custom', 'CHK_COOKIE', ' checked="checked"');

        $this->c['FOLLOWWIN'] ? $this->t->addVar('custom', 'CHK_FW_1', ' checked="checked"')
            : $this->t->addVar('custom', 'CHK_FW_0', ' checked="checked"');
        $this->c['RELTYPE'] ? $this->t->addVar('custom', 'CHK_RT_1', ' checked="checked"')
            : $this->t->addVar('custom', 'CHK_RT_0', ' checked="checked"');

        $this->t->addVar('custom_hide', 'BBSMODE_ADMINONLY', $this->c['BBSMODE_ADMINONLY']);
        $this->t->addVar('custom_a', 'BBSMODE_ADMINONLY', $this->c['BBSMODE_ADMINONLY']);
        $this->t->addVar('custom', 'MODE', $mode);

        $this->sethttpheader();
        print $this->prthtmlhead ($this->c['BBSTITLE'] . ' 個人用環境設定');
        $this->t->displayParsedTemplate('custom');
        print $this->prthtmlfoot ();
    }

    /**
     * 環境設定処理
     */
    function setcustom() {

        $redirecturl = $this->c['CGIURL'];

        # Cookie消去
        if ($this->f['cr']) {
            $this->f['c'] = '';
            setcookie('c');
            setcookie('undo');
            $this->s['UNDO_P'] = '';
            $this->s['UNDO_K'] = '';
        }
        else {
            $colors = array(
                'C_BACKGROUND',
                'C_TEXT',
                'C_A_COLOR',
                'C_A_VISITED',
                'C_SUBJ',
                'C_QMSG',
                'C_A_ACTIVE',
                'C_A_HOVER',
            );

            $flgchgindex = -1;
            $cindex = 0;
            foreach ($colors as $confname) {
                if (strlen($this->f[$confname]) == 6 and preg_match("/^[0-9a-fA-F]{6}$/", $this->f[$confname])
                    and $this->f[$confname] != $this->c[$confname]) {
                    $this->c[$confname] = $this->f[$confname];
                    $flgchgindex = $cindex;
                }
                $cindex++;
            }

            $cbase64str = '';
            for ($i = 0; $i <= $flgchgindex; $i++) {
                $cbase64str .= Func::threebytehex_base64($this->c[$colors[$i]]);
            }
            $this->refcustom();

            $this->f['c'] = substr($this->f['c'], 0, 2) . $cbase64str;

            $redirecturl .= "?c=".$this->f['c'];
            foreach (array('w', 'd',) as $key) {
                if ($this->f[$key] != '') {
                    $redirecturl .= "&{$key}=".$this->f[$key];
                }
            }
            if ($this->f['nm']) {
                $redirecturl .= "&m=".$this->f['nm'];
            }
            if ($this->c['COOKIE']) {
                $this->setbbscookie();
            }
        }
        # リダイレクト
        if (preg_match("/^(https?):\/\//", $this->c['CGIURL'])) {
            header ("Location: {$redirecturl}");
        }
        else {
            $this->prtredirect(htmlentities($redirecturl));
        }
    }

    /**
     * UNDO処理
     */
    function prtundo() {
        if (!$this->f['s']) {
            $this->prterror ('パラメータがありません。');
        }
        if (isset($this->s['UNDO_P']) and $this->s['UNDO_P'] == $this->f['s']) {
            $loglines = $this->searchmessage('POSTID', $this->s['UNDO_P']);
            if (count($loglines) < 1) {
                $this->prterror ('該当記事は見つかりませんでした。');
            }
            $message = $this->getmessage($loglines[0]);
            $undokey = substr (preg_replace("/\W/", "", crypt($message['PROTECT'], $this->c['ADMINPOST'])), -8);
            if ($undokey != $this->s['UNDO_K']) {
                $this->prterror ('該当記事の消去は許可されていません。');
            }
            # 消去実行
            require_once(PHP_BBSADMIN);
            $bbsadmin = new Bbsadmin();
            $bbsadmin->killmessage($this->s['UNDO_P']);

            $this->s['UNDO_P'] = '';
            $this->s['UNDO_K'] = '';
            setcookie('undo');
        }
        else {
            $this->prterror ('該当記事の消去は許可されていません。');
        }
        $this->sethttpheader();
        print $this->prthtmlhead ($this->c['BBSTITLE'] . ' 消去完了');
        $this->t->displayParsedTemplate('undocomplete');
        print $this->prthtmlfoot ();
    }

    /**
     * メッセージ検索（完全一致）
     *
     * @access  public
     * @param   String  $varname      変数名
     * @param   String  $searchvalue  検索文字列
     * @param   Boolean $ismultiple   複数検索フラグ
     * @return  Array   ログ行配列
     */
    function searchmessage($varname, $searchvalue, $ismultiple = FALSE, $filename = "") {
        $result = array();
        $logdata = $this->loadmessage($filename);
        while ($logline = each($logdata)) {
            $message = $this->getmessage($logline[1]);
            if (isset($message[$varname]) and $message[$varname] == $searchvalue) {
                $result[] = $logline[1];
                if (!$ismultiple) {
                    break;
                }
            }
        }
        return $result;
    }

    /**
     * 投稿チェック
     *
     * @access  public
     * @param   Boolean   $limithost  同一ホストチェックをするかどうか
     * @return  Integer   エラーコード
     */
    function chkmessage($limithost = TRUE) {
        $posterr = 0;
        if ($this->c['RUNMODE'] == 1) {
            $this->prterror('この掲示板は現在投稿機能停止中です。');
        }
        /* ホスト名によるアクセス禁止処理 */
        if (Func::hostname_match($this->c['HOSTNAME_POSTDENIED'])) {
            $this->prterror ( 'Posting disabled.');
        }
        if ($this->c['BBSMODE_ADMINONLY'] == 1 or ($this->c['BBSMODE_ADMINONLY'] == 2 and !$this->f['f'])) {
            if (crypt($this->f['u'], $this->c['ADMINPOST']) != $this->c['ADMINPOST']) {
                $this->prterror ( '掲示板への投稿は管理者のみ許可されています。');
            }
        }
        if ($_SERVER['HTTP_REFERER'] and $this->c['REFCHECKURL']
            and (strpos($_SERVER['HTTP_REFERER'], $this->c['REFCHECKURL']) === FALSE
            or strpos($_SERVER['HTTP_REFERER'], $this->c['REFCHECKURL']) > 0)) {
            $this->prterror ( "投稿画面のＵＲＬが<br>{$this->c['REFCHECKURL']}<br>以外からの投稿はできません。" );
        }
        foreach (explode ("\r", $this->f['v']) as $line) {
            if (strlen ($line) > $this->c['MAXMSGCOL']) {
                $this->prterror ('投稿内容の桁数が大きすぎます。');
            }
        }
        if (substr_count ($this->f['v'], "\r") > $this->c['MAXMSGLINE'] - 1) {
            $this->prterror ('投稿内容の行数が大きすぎます。');
        }
        if (strlen ($this->f['v']) > $this->c['MAXMSGSIZE']) {
            $this->prterror ( '投稿内容が大きすぎます。' );
        }
        {
            $timestamp = Func::pcode_verify ($this->f['pc'], $limithost);

            if ((CURRENT_TIME - $timestamp ) < $this->c['MINPOSTSEC'] ) {
                $this->prterror ( '投稿間隔が短すぎます。もう一度やり直して下さい。');
            }
/*            if ((CURRENT_TIME - $timestamp ) > $this->c['MAXPOSTSEC'] ) {
                $this->prterror ( '投稿間隔が長すぎます。もう一度やり直して下さい。');
                $posterr = 2;
                return $posterr;
            } */
        }

        if (trim($this->f['v']) == '') {
            $posterr = 2;
            return $posterr;
        }

        if ($this->c['NGWORD']) {
            foreach ($this->c['NGWORD'] as $ngword) {
                if (strpos($this->f['v'], $ngword) !== FALSE
                    or strpos($this->f['l'], $ngword) !== FALSE
                    or strpos($this->f['t'], $ngword) !== FALSE
                    or strpos($this->f['u'], $ngword) !== FALSE
                    or strpos($this->f['i'], $ngword) !== FALSE) {
                    $this->prterror ( '投稿禁止語句が含まれています。' );
                }
            }
        }
        return $posterr;
    }

    /**
     * フォーム入力からのメッセージ取得
     *
     * @access  public
     * @return  Array  メッセージ配列
     */
    function getformmessage() {

        $message = array();
        $message['PCODE'] = $this->f['pc'];
        $message['USER'] = $this->f['u'];
        $message['MAIL'] = $this->f['i'];
        $message['TITLE'] = $this->f['t'];
        $message['MSG'] = $this->f['v'];
        $message['URL'] = $this->f['l'];
        $message['PHOST'] = $this->s['HOST'];
        $message['AGENT'] = $this->s['AGENT'];
        # 参照ID
        if ($this->f['f']) {
            $message['REFID'] = $this->f['f'];
        }
        else {
            $message['REFID'] = '';
        }
        # プロテクトコード
        $message['PCODE'] = substr($message['PCODE'], 8, 4);
        # 題名
        if (!$message['TITLE']) {
            $message['TITLE'] = ' ';
        }
        # 投稿者
        if (!$message['USER']) {
            $message['USER'] = $this->c['ANONY_NAME'];
        }
        else {
            # 管理人チェック
            if ($this->c['ADMINPOST'] and crypt($message['USER'], $this->c['ADMINPOST']) == $this->c['ADMINPOST']) {
                $message['USER'] = "<span class=\"muh\">{$this->c['ADMINNAME']}</span>";
                # 管理モードへの移行
                if ($this->c['ADMINKEY'] and trim($message['MSG']) == $this->c['ADMINKEY']) {
                    return 3;
                }
            }
            elseif ($this->c['ADMINPOST'] and $message['USER'] == $this->c['ADMINPOST']) {
                $message['USER'] = $this->c['ADMINNAME'] . '<span class="muh">（ハカー）</span>';
            }
            elseif (!(strpos($message['USER'], $this->c['ADMINNAME']) === FALSE)) {
                $message['USER'] = $this->c['ADMINNAME'] . '<span class="muh">（Fake Kuz）</span>';
            }
            # 固定ハンドル名チェック
            elseif ($this->c['HANDLENAMES'][trim($message['USER'])]) {
                $message['USER'] .= '<span class="muh">（Fake Kuz）</span>';
            }
            # トリップ機能(簡易騙り防止機能)
            elseif (strpos($message['USER'], '#') !== FALSE) {
                $message['USER'] = substr($message['USER'], 0, strpos($message['USER'], '#')) . ' <span class="mut">◆'
                . substr(preg_replace("/\W/", '', crypt(substr($message['USER'], strpos($message['USER'], '#')), '00')), -7) . '</span>';
            }
            elseif (strpos($message['USER'], '◆') !== FALSE) {
                $message['USER'] .= '（Fake Kuznetsov）';
            }
            # 固定ハンドル名変換
            elseif (isset($this->c['HANDLENAMES'])) {
                $handlename = array_search(trim($message['USER']), $this->c['HANDLENAMES']);
                if ($handlename !== FALSE) {
                    $message['USER'] = "<span class=\"muh\">{$handlename}</span>";
                }
            }
        }
        $message['MSG'] = rtrim ($message['MSG']);

        # URL自動リンク
        if ( $this->c['AUTOLINK'] ) {
            $message['MSG'] = preg_replace("/((https?|ftp|news):\/\/[-_.,!~*'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)/",
                "<a href=\"$1\" target=\"link\">$1</a>", $message['MSG']);
        }
        # URL欄
        $message['URL'] = trim($message['URL']);
        if ($message['URL']) {
            $message['MSG'] .= "\r\r<a href=\"".Func::escape_url($message['URL'])."\" target=\"link\">{$message['URL']}</a>";
        }
        # 参考
        if ($message['REFID']) {
            $refdata = $this->searchmessage('POSTID', $message['REFID'], FALSE, $this->f['ff']);
            if (!$refdata) {
                $this->prterror ('参照記事が見つかりません。');
            }
            $refmessage = $this->getmessage($refdata[0]);
            $refmessage['WDATE'] = Func::getdatestr($refmessage['NDATE'], $this->c['DATEFORMAT']);
            $message['MSG'] .= "\r\r<a href=\"bbs.php?m=f&s={$message['REFID']}&r=&\">Linkto：{$refmessage['WDATE']}</a>";
            # 簡易自作自演防止機能
            if ($this->c['IPREC'] and $this->c['SHOW_SELFFOLLOW']
                and $refmessage['PHOST'] != '' and $refmessage['PHOST'] == $message['PHOST']) {
                    $message['USER'] = "<span class=\"muh\">{$handlename}</span>";
            }
        }
        # チェック
        if (strlen ($message['MSG']) > $this->c['MAXMSGSIZE']) {
            $this->prterror ( '投稿内容が大きすぎます。' );
        }
        return $message;
    }

    /**
     * メッセージ登録処理
     *
     * @access  public
     * @return  Integer  エラーコード
     */
    function putmessage($message) {
        if (!is_array($message)) {
            return $message;
        }
        $fh = @fopen($this->c['LOGFILENAME'], "rb+");
        if (!$fh) {
            $this->prterror ( 'メッセージ読み込みに失敗しました' );
        }
        flock ($fh, 2);
        fseek ($fh, 0, 0);

        $logdata = array();
        while (($logline = Func::fgetline($fh)) !== FALSE) {
                $logdata[] = $logline;
        }
        $posterr = 0;
        if ($this->f['ff']) {
            $refdata = $this->searchmessage('THREAD', $message['REFID'], FALSE, $this->f['ff']);
            if (isset($refdata[0])) {
                $refmessage = $this->getmessage($refdata[0]);
                if ($refmessage) {
                    $message['THREAD'] = $refmessage['thread'];
                }
                else {
                    $message['THREAD'] = '';
                }
            }
            else {
                $message['THREAD'] = '';
            }
        }
        else {
            for ($i = 0; $i < count($logdata); $i++) {
                $items = @explode(',', $logdata[$i]);
                if (count($items) > 8) {
                    $items[9] = rtrim($items[9]);
                    if ($i < $this->c['CHECKCOUNT'] and $message['MSG'] == $items[9]) {
                        $posterr = 1;
                        break;
                    }
                    if ($this->c['IPREC'] and CURRENT_TIME < ($items[0] + $this->c['SPTIME'])
                        and $this->s['HOST'] == $items[4]) {
                        $posterr = 2;
                        break;
                    }
                    if ($message['PCODE'] == $items[2]) {
                        $posterr = 2;
                        break;
                    }
                    if ($message['REFID'] and $items[1] == $message['REFID']) {
                        $message['THREAD'] = $items[3];
                        if (!$message['THREAD']) {
                            $message['THREAD'] = $items[1];
                        }
                    }
                }
            }
        }
        if ($posterr) {
            flock ($fh, 3);
            fclose ($fh);
            return $posterr;
        }
        else {
            $items = @explode (',', $logdata[0], 3);
            $message['POSTID'] = $items[1] + 1;
            if (!$message['REFID']) {
                $message['THREAD'] = $message['POSTID'];
            }
            $msgdata = implode (',', array(
                CURRENT_TIME,
                $message['POSTID'],
                $message['PCODE'],
                $message['THREAD'],
                $message['PHOST'],
                $message['AGENT'],
                $message['USER'],
                $message['MAIL'],
                $message['TITLE'],
                $message['MSG'],
                $message['REFID'],
            ));
            $msgdata = strtr ($msgdata, "\n", "") . "\n";
            if (count($logdata) >= $this->c['LOGSAVE']) {
                $logdata = array_slice($logdata, 0, $this->c['LOGSAVE'] - 2);
            }
            {
                $logdata = $msgdata . implode ('', $logdata);
                fseek ($fh, 0, 0);
                ftruncate ($fh, 0);
                fwrite ($fh, $logdata);
            }
            flock ($fh, 3);
            fclose ($fh);
            # Cookie登録
            if ($this->c['COOKIE']) {
                $this->setbbscookie();
                if ($this->c['ALLOW_UNDO']) {
                    $this->setundocookie($message['POSTID'], $message['PCODE']);
                }
            }

            # 過去ログ出力
            if ($this->c['OLDLOGFILEDIR']) {
                $dir = $this->c['OLDLOGFILEDIR'];

                if ($this->c['OLDLOGFMT']) {
                    $oldlogext = 'dat';
                }
                else {
                    $oldlogext = 'html';
                }
                if ($this->c['OLDLOGSAVESW']) {
                    $oldlogfilename = $dir . date("Ym", CURRENT_TIME) . ".$oldlogext";
                    $oldlogtitle = $this->c['BBSTITLE'] . date(" Y.m", CURRENT_TIME);
                }
                else {
                    $oldlogfilename = $dir . date("Ymd", CURRENT_TIME) . ".$oldlogext";
                    $oldlogtitle = $this->c['BBSTITLE'] . date(" Y.m.d", CURRENT_TIME);
                }
                if (@filesize($oldlogfilename) > $this->c['MAXOLDLOGSIZE']) {
                    $this->prterror ( '過去ログファイルがサイズ制限を超えています' );
                }
                $fh = @fopen($oldlogfilename, "ab");
                if (!$fh) {
                    $this->prterror ( '過去ログ出力に失敗しました' );
                }
                flock ($fh, 2);
                $isnewdate = FALSE;
                if (!@filesize($oldlogfilename)) {
                    $isnewdate = TRUE;
                }
                if ($this->c['OLDLOGFMT']) {
                    fwrite ($fh, $msgdata);
                }
                else {
                    # HTML出力用HTMLヘッダ
                    if ($isnewdate) {
                        $oldloghtmlhead = $this->prthtmlhead($oldlogtitle);
                        $oldloghtmlhead .= "<span class=\"pagetitle\">$oldlogtitle</span>\n\n<hr />\n";
                        fwrite ($fh, $oldloghtmlhead);
                    }
                    $msghtml = $this->prtmessage($this->getmessage($msgdata), 3);
                    fwrite ($fh, $msghtml);
                }
                flock ($fh, 3);
                fclose ($fh);
                if (@filesize($oldlogfilename) > $this->c['MAXOLDLOGSIZE']) {
                    @chmod ($oldlogfilename, 0400);
                }
                # 古いログファイルを削除
                if (!$this->c['OLDLOGSAVESW'] and $isnewdate) {
                    $limitdate = CURRENT_TIME - $this->c['OLDLOGSAVEDAY'] * 60 * 60 * 24;
                    $limitdate = date("Ymd", $limitdate);
                    $dh = opendir($dir);
                    while ($entry = readdir($dh)) {
                        $matches = array();
                        if (is_file($dir . $entry)
                            and preg_match("/(\d+)\.$oldlogext$/", $entry, $matches)) {
                            $timestamp = $matches[1];
                            if (strlen($timestamp) == strlen($limitdate) and $timestamp < $limitdate) {
                                unlink ($dir . $entry);
                            }
                        }
                    }
                    closedir ($dh);
                }

                # アーカイブの作成
                if ($this->c['ZIPDIR'] and @function_exists('gzcompress')) {
                    # datの場合、Zipに保存するためのテンポラリファイルとしてHTML形式の過去ログ書き込みも行う
                    if ($this->c['OLDLOGFMT']) {
                        if ($this->c['OLDLOGSAVESW']) {
                            $tmplogfilename = $this->c['ZIPDIR'] . date("Ym", CURRENT_TIME) . ".html";
                        }
                        else {
                            $tmplogfilename = $this->c['ZIPDIR'] . date("Ymd", CURRENT_TIME) . ".html";
                        }

                        $fhtmp = @fopen($tmplogfilename, "ab");
                        if (!$fhtmp) {
                            return;
                        }
                        flock ($fhtmp, 2);

                        if (!@filesize($tmplogfilename)) {
                            $oldloghtmlhead = $this->prthtmlhead($oldlogtitle);
                            $oldloghtmlhead .= "<span class=\"pagetitle\">$oldlogtitle</span>\n\n<hr />\n";
                            fwrite ($fhtmp, $oldloghtmlhead);
                        }
                        $msghtml = $this->prtmessage($this->getmessage($msgdata), 3);
                        fwrite ($fhtmp, $msghtml);
                        flock ($fhtmp, 3);
                        fclose ($fhtmp);
                    }
                    $tmpdir = $dir;
                    if ($this->c['OLDLOGFMT']) {
                        $tmpdir = $this->c['ZIPDIR'];
                    }
                    if ($this->c['OLDLOGSAVESW']) {
                        $currentfile = date("Ym", CURRENT_TIME) . ".html";
                    }
                    else {
                        $currentfile = date("Ymd", CURRENT_TIME) . ".html";
                    }

                    $files = array();
                    $dh = opendir($tmpdir);
                    if (!$dh) {
                        return;
                    }
                    while ($entry = readdir($dh)) {
                        if ($entry != $currentfile and is_file($tmpdir . $entry) and preg_match("/^\d+\.html$/", $entry)) {
                            $files[] = $entry;
                        }
                    }
                    closedir ($dh);

                    # 現ログ以外で更新時間が最新のファイル
                    $maxftime = 0;
                    foreach ($files as $filename) {
                        $fstat = stat ($tmpdir . $filename);
                        if ($fstat[9] > $maxftime) {
                            $maxftime = $fstat[9];
                            $checkedfile = $tmpdir . $filename;
                        }
                    }
                    if (!$checkedfile) {
                        return;
                    }
                    $zipfilename = preg_replace("/\.\w+$/", ".zip", $checkedfile);

                    # Zipファイルを作成
                    require_once(LIB_PHPZIP);
                    $zip = new PHPZip();
                    $zipfiles[] = $checkedfile;
                    $zip->Zip($zipfiles, $zipfilename);

                    # テンポラリファイルの削除
                    if ($this->c['OLDLOGFMT']) {
                        unlink ($checkedfile);
                    }
                }
            }
        }
        return 0;
    }

    /**
     * 環境変数取得
     */
    function setuserenv() {

        if ($this->c['UAREC']) {
            $agent = $_SERVER['HTTP_USER_AGENT'];
            $agent = Func::html_escape($agent);
            $this->s['AGENT'] = $agent;
        }
        if (!$this->c['IPREC']) {
            return;
        }
        list ($addr, $host, $proxyflg, $realaddr, $realhost) = Func::getuserenv();

        $this->s['ADDR'] = $addr;
        $this->s['HOST'] = $host;
        $this->s['PROXYFLG'] = $proxyflg;
        $this->s['REALADDR'] = $realaddr;
        $this->s['REALHOST'] = $realhost;
    }

    /**
     * 掲示板Cookie登録
     */
    function setbbscookie() {
        $cookiestr = "u=" . urlencode($this->f['u']);
        $cookiestr .= "&i=" . urlencode($this->f['i']);
        $cookiestr .= "&c=" . $this->f['c'];
        setcookie('c', $cookiestr, CURRENT_TIME + 7776000); // expires in 90 days
    }

    /**
     * 投稿UNDO用Cookie登録
     */
    function setundocookie($undoid, $pcode) {
        $undokey = substr (preg_replace("/\W/", "", crypt($pcode, $this->c['ADMINPOST'])), -8);
        $cookiestr = "p=$undoid&k=$undokey";
        $this->s['UNDO_P'] = $undoid;
        $this->s['UNDO_K'] = $undokey;
        setcookie('undo', $cookiestr, CURRENT_TIME + 86400); // expires in 24 hours
    }

    /**
     * こわれにくいカウンター処理
     *
     * @access  public
     * @param   Integer こわれにくさレベル
     * @return  String  カウンター数値
     */
    function counter($countlevel = 0) {
        if (!$countlevel) {
            if (isset($this->c['COUNTLEVEL'])) {
                $countlevel = $this->c['COUNTLEVEL'];
            }
            if ($countlevel < 1) {
                $countlevel = 1;
            }
        }
        $count = array();
        for ($i = 0; $i < $countlevel; $i++) {
            $filename = "{$this->c['COUNTFILE']}{$i}.dat";
            if (is_writable ($filename) and $fh = @fopen ($filename, "r")) {
                $count[$i] = fgets ($fh, 10);
                fclose ($fh);
            }
            else {
                $count[$i] = 0;
            }
            $filenumber[$count[$i]] = $i;
        }
        sort ($count, SORT_NUMERIC);
        $mincount = $count[0];
        $maxcount = $count[$countlevel-1] + 1;
        if ($fh = @fopen("{$this->c['COUNTFILE']}{$filenumber[$mincount]}.dat", "w")) {
            fputs ($fh, $maxcount);
            fclose ($fh);
            return $maxcount;
        } else {
            return 'カウンターエラー';
        }
    }

    /**
     * 参加者カウント
     *
     * @access  public
     * @param   $cntfilename  記録ファイル名
     * @return  String  参加者数
     */
    function mbrcount($cntfilename = "") {
        if (!$cntfilename) {
            $cntfilename = $this->c['CNTFILENAME'];
        }
        if ($cntfilename) {
            $mbrcount = 0;
            $remoteaddr = '0.0.0.0';
            if ($_SERVER['REMOTE_ADDR']) {
                $remoteaddr = $_SERVER['REMOTE_ADDR'];
            }
            $addrdec = @explode ('.', $remoteaddr);
            $ukey = @array_sum($addrdec)
                * @bindec(@decbin($addrdec[0]) ^ @decbin($addrdec[1]) & @decbin($addrdec[2]) ^ @decbin($addrdec[3]));
            $newcntdata = array();
            if (is_writable ($cntfilename)) {
                $cntdata = file ($cntfilename);
                $cadd = 0;
                foreach ($cntdata as $cntvalue) {
                    if (strrpos($cntvalue, ',') !== FALSE) {
                        list ($cuser, $ctime,) = @explode (',', trim ($cntvalue));
                        if ($cuser == $ukey) {
                            $newcntdata[] = "$ukey,".CURRENT_TIME."\n";
                            $cadd = 1;
                            $mbrcount++;
                        }
                        elseif (($ctime + $this->c['CNTLIMIT']) >= CURRENT_TIME) {
                            $newcntdata[] = "$cuser,$ctime\n";
                            $mbrcount++;
                        }
                    }
                }
                if (!$cadd) {
                    $newcntdata[] = "$ukey,".CURRENT_TIME."\n";
                    $mbrcount++;
                }
            }
            else {
                $newcntdata[] = "$ukey,".CURRENT_TIME."\n";
                $mbrcount++;
            }
            if ($fh = @fopen ($cntfilename, "w")) {
                $cntdatastr = implode('', $newcntdata);
                flock ($fh, 2);
                fwrite ($fh, $cntdatastr);
                flock ($fh, 3);
                fclose ($fh);
            }
            else {
                return ('参加者ファイル出力エラー');
            }
            return $mbrcount;
        }
        else {
            return;
        }
    }
}
/* end of class Bbs */

/**
 * 共用関数クラス
 *
 * 設定情報に依存しない、汎用的な関数を格納したクラスです。
 *
 * @package strangeworld.cnscript
 * @access  public
 */
function getUserIpAddr(){
    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }else{
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

class Func {

    /**
     * Constructor
     *
     */
    public function __construct() {
    }

    public static function getuserenv() {
        $addr = getUserIpAddr();
        $host = getUserIpAddr();
        $agent = $_SERVER['HTTP_USER_AGENT'];
        if ($addr == $host or !$host) {
            $host = gethostbyaddr ($addr);
        }

        $proxyflg = 0;

        if ($_SERVER['HTTP_CACHE_CONTROL']) { $proxyflg = 1; }
        if ($_SERVER['HTTP_CACHE_INFO']) { $proxyflg += 2; }
        if ($_SERVER['HTTP_CLIENT_IP']) { $proxyflg += 4; }
        if ($_SERVER['HTTP_FORWARDED']) { $proxyflg += 8; }
        if ($_SERVER['HTTP_FROM']) { $proxyflg += 16; }
        if ($_SERVER['HTTP_PROXY_AUTHORIZATION']) { $proxyflg += 32; }
        if ($_SERVER['HTTP_PROXY_CONNECTION']) { $proxyflg += 64; }
        if ($_SERVER['HTTP_SP_HOST']) { $proxyflg += 128; }
        if ($_SERVER['HTTP_VIA']) { $proxyflg += 256; }
        if ($_SERVER['HTTP_X_FORWARDED_FOR']) { $proxyflg += 512; }
        if ($_SERVER['HTTP_X_LOCKING']) { $proxyflg += 1024; }
        if (preg_match ("/cache|delegate|gateway|httpd|proxy|squid|www|via/i", $agent)) {
            $proxyflg += 2048;
        }
        if (preg_match ("/cache|^dns|dummy|^ns|firewall|gate|keep|mail|^news|pop|proxy|smtp|w3|^web|www/i", $host)) {
            $proxyflg += 4096;
        }
        if ($host == $addr) {
            $proxyflg += 8192;
        }
        $realaddr = '';
        $realhost = '';
        if ( $proxyflg > 0 ) {
            $matches = array();
            if (preg_match ("/^(\d+)\.(\d+)\.(\d+)\.(\d+)/", $_SERVER['HTTP_X_FORWARDED_FOR'], $matches)) {
                $realaddr = "{$matches[1]}.{$matches[2]}.{$matches[3]}.{$matches[4]}";
            }
            elseif (preg_match ("/(\d+)\.(\d+)\.(\d+)\.(\d+)/", $_SERVER['HTTP_FORWARDED'], $matches)) {
                $realaddr = "{$matches[1]}.{$matches[2]}.{$matches[3]}.{$matches[4]}";
            }
            elseif (preg_match ("/(\d+)\.(\d+)\.(\d+)\.(\d+)/", $_SERVER['HTTP_VIA'], $matches)) {
                $realaddr = "{$matches[1]}.{$matches[2]}.{$matches[3]}.{$matches[4]}";
            }
            elseif (preg_match ("/(\d+)\.(\d+)\.(\d+)\.(\d+)/", $_SERVER['HTTP_CLIENT_IP'], $matches)) {
                $realaddr = "{$matches[1]}.{$matches[2]}.{$matches[3]}.{$matches[4]}";
            }
            elseif (preg_match ("/(\d+)\.(\d+)\.(\d+)\.(\d+)/", $_SERVER['HTTP_SP_HOST'], $matches)) {
                $realaddr = "{$matches[1]}.{$matches[2]}.{$matches[3]}.{$matches[4]}";
            }
            elseif (preg_match ("/.*\sfor\s(.+)/", $_SERVER['HTTP_FORWARDED'], $matches)) {
                $realhost = $matches[1];
            }
            elseif (preg_match ("/\-\@(.+)/", $_SERVER['HTTP_FROM'], $matches)) {
                $realhost = $matches[1];
            }
            if (!$realaddr and $realhost) {
                $realaddr = gethostbyname ($realhost);
            }
        }
        return array($addr, $host, $proxyflg, $realaddr, $realhost);
    }

    /**
     * プロテクトコード生成
     *
     * @access  public
     * @param   Integer $timestamp  タイムスタンプ
     * @param   Boolean $limithost  同一ホストチェックをするかどうか
     * @return  String  プロテクトコード（英数１２文字）
     */
    public static function pcode($timestamp = 0, $limithost = TRUE) {
        if (!$timestamp) {
            $timestamp = CURRENT_TIME;
        }
        $ukey = 0;
        if ($limithost) {
            $remoteaddr = '0.0.0.0';
            if ($_SERVER['REMOTE_ADDR']) {
                $remoteaddr = $_SERVER['REMOTE_ADDR'];
            }
            $addrdec = @explode ('.', $remoteaddr);
            $ukey = @array_sum($addrdec)
                * @bindec(@decbin($addrdec[0]) ^ @decbin($addrdec[1]) & @decbin($addrdec[2]) ^ @decbin($addrdec[3]));
        }

        $basecode =  dechex ($timestamp + $ukey);
        $cryptcode = crypt ($basecode . substr($GLOBALS['CONF']['ADMINPOST'], -4), substr($GLOBALS['CONF']['ADMINPOST'], -4) . $basecode);
        $cryptcode = substr (preg_replace ("/\W/", "", $cryptcode), -4);
        $pcode = dechex ($timestamp) . $cryptcode;
        return $pcode;
    }

    /**
     * プロテクトコード照合
     *
     * @access  public
     * @param   String  $pcode  プロテクトコード（英数１２文字）
     * @param   Boolean $limithost  同一ホストチェックをするかどうか
     * @return  Integer タイムスタンプ
     */
    public static function pcode_verify($pcode, $limithost = TRUE) {

        if (strlen($pcode) != 12) {
            return;
        }
        $timestamphex = substr($pcode, 0, 8);
        $cryptcode = substr($pcode, 8, 4);

        $ukey = 0;
        if ($limithost) {
            $remoteaddr = '0.0.0.0';
            if ($_SERVER['REMOTE_ADDR']) {
                $remoteaddr = $_SERVER['REMOTE_ADDR'];
            }
            $addrdec = @explode ('.', $remoteaddr);
            $ukey = @array_sum($addrdec)
                * @bindec(@decbin($addrdec[0]) ^ @decbin($addrdec[1]) & @decbin($addrdec[2]) ^ @decbin($addrdec[3]));
        }

        $timestamp = hexdec ($timestamphex);
        $basecode = dechex ($timestamp + $ukey);
        $verifycode = crypt ($basecode . substr($GLOBALS['CONF']['ADMINPOST'], -4), substr($GLOBALS['CONF']['ADMINPOST'], -4) . $basecode);
        $verifycode = substr (preg_replace ("/\W/", "", $verifycode), -4);
        if ($cryptcode != $verifycode) {
            return;
        }
        return $timestamp;
    }

    /**
     * チェックボックス用 フラグ出力処理
     *
     * @access  public
     * @param   Integer $flag  チェックボックスフラグ
     * @return  String  チェックボックス用文字列
     */
    public static function chkval($flag = 0, $attrvalue = FALSE) {
        if ($flag) {
            if ($attrvalue) {
                return 'checked';
            }
            else {
                return ' checked="checked"';
            }
        }
    }

    /**
     * HTML表示用エスケープ
     *
     * @access  public
     * @param   String  $value  元の文字列
     * @return  String  エスケープ処理後文字列
     */
    public static function html_escape($value) {
        if ($value == '') {
            return $value;
        }
        if (get_magic_quotes_gpc()) {
            $value = stripslashes($value);
        }
        if (!preg_match("/^\w+$/", $value)) {
            $value = htmlspecialchars($value, ENT_QUOTES);
        }
        $value = str_replace("\015\012", "\015", $value);
        $value = str_replace("\012", "\015", $value);
        $value = str_replace("\015$", "", $value);
        $value = str_replace(",", "&#44;", $value);

        return $value;
    }

    /**
     * HTML表示用エスケープ解除
     *
     * @access  public
     * @param   String  $value  元の文字列
     * @return  String  エスケープ解除処理後文字列
     */
    public static function html_decode($value) {
        if ($value == '') {
            return $value;
        }

        if (!preg_match("/^\w+$/", $value)) {
            $value = strtr($value, array_flip(get_html_translation_table(HTML_ENTITIES)));
            $value = preg_replace("/&#([0-9]+);/me", "chr('\\1')", $value);
        }
        return $value;
    }

    /**
     * 時刻フォーマット変換
     *
     * @access  public
     * @param   Integer $timestamp  タイムスタンプ
     * @return  String  日付文字列
     */
    public static function getdatestr($timestamp, $format = "") {
        if (!$format) {
            $format = "Y/m/d(-) H:i:s";
        }
        $datestr = date($format, $timestamp);
        if (strrpos($format, '-') !== FALSE) {
            if (!isset($wdays)) {
                static $wdays = array('日', '月', '火', '水', '木', '金', '土');
            }
            $datestr = str_replace('-', $wdays[date("w", $timestamp)], $datestr);
        }
        return $datestr;
    }

    /**
     * 数値文字の整形
     *
     * @access  public
     * @param   Integer $numberstr  元の文字列
     * @return  String  整形後文字列
     */
    public static function fixnumberstr($numberstr) {
        $numberstr = trim($numberstr);
        $twobytenumstr = array ('０', '１', '２', '３', '４', '５', '６', '７', '８', '９', );
        for ($i = 0; $i < count($twobytenumstr); $i++) {
            $numberstr = str_replace($twobytenumstr[$i], "$i", $numberstr);
        }
        if (is_numeric ($numberstr)) {
            return $numberstr;
        }
        else {
            return FALSE;
        }
    }

    /**
     * リンク文字列のエスケープ
     *
     * XSS脆弱性への対応処理です
     *
     * @access  public
     * @param   Integer $numberstr  元の文字列
     * @return  String  エスケープ処理後文字列
     */
    public static function escape_url($src_url) {
        $src_url = preg_replace("/script:/i", "script", $src_url);
        $src_url = urlencode($src_url);
        $src_url = str_replace ("%2F", "/", $src_url);
        $src_url = str_replace ("%3A", ":", $src_url);
        $src_url = str_replace ("%3D", "=", $src_url);
        $src_url = str_replace ("%23", "#", $src_url);
        $src_url = str_replace ("%26", "&", $src_url);
        $src_url = str_replace ("%3B", ";", $src_url);
        $src_url = str_replace ("%3F", "?", $src_url);
        $src_url = str_replace ("%25", "%", $src_url);

        return $src_url;
    }

    /**
     * 画像タグをリンクに変換
     *
     * @access  public
     * @param   String  $value  元の文字列
     * @return  String  タグ変換後文字列
     */
    public static function conv_imgtag ($value) {
        if ($value == '') {
            return $value;
        }
        while (preg_match("/(<a href=[^>]+>)<img ([^>]+)>(<\/a>)/i", $value, $matches)) {
            if (preg_match("/alt=\"([^\"]+)\"/", $matches[2], $submatches)) {
                $altvalue = $submatches[1];
            }
            elseif (preg_match("/src=\"([^\"]+)\"/", $matches[2], $submatches)) {
                $altvalue = substr($submatches[1], strrpos($submatches[1], '/'));
            }
            $value = str_replace($matches[0], " [{$matches[1]}{$altvalue}{$matches[3]}] ", $value);
        }
        return $value;
    }

    /**
     * 16進文字列６文字をbase64エンコード
     *
     * @access  public
     * @param   String  $inputhex  16進文字列６文字
     * @return  String  base64文字列４文字
     */
    public static function threebytehex_base64($inputhex) {
        $inputdec = hexdec($inputhex);

        $a = floor($inputdec / 262144);
        $tmp_a = $inputdec - 262144 * $a;
        $b = floor($tmp_a / 4096);
        $tmp_b = $tmp_a - 4096 * $b;
        $c = floor($tmp_b / 64);
        $d = $tmp_b - 64 * $c;

        $basestr = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-_';
        $base64val = $basestr[$a] . $basestr[$b] . $basestr[$c] . $basestr[$d];
        return $base64val;
    }

    /**
     * 16進文字列６文字をbase64デコード
     *
     * @access  public
     * @param   String  $str  base64文字列４文字
     * @return  String  16進文字列６文字
     */
    public static function base64_threebytehex($str) {
        if (strlen($str) != 4) {
            return '';
        }
        $basestr = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-_';
        $decval =
            262144 * @strrpos($basestr, substr($str, 0, 1))
            + 4096 * @strrpos($basestr, substr($str, 1, 1))
            + 64 * @strrpos($basestr, substr($str, 2, 1))
            + @strrpos($basestr, substr($str, 3, 1));
        $hexval = str_pad(@dechex($decval), 6, "0", STR_PAD_LEFT);
        return $hexval;
    }

    /**
     * microtime()間の時差を測定
     *
     * @access  public
     * @param   String  $a  測定開始時間のmicrotime()文字列
     * @param   String  $b  測定終了時間のmicrotime()文字列
     * @return  String  時差文字列
     */
    public static function microtime_diff($a, $b) {
        list($a_dec, $a_sec) = explode(" ", $a);
        list($b_dec, $b_sec) = explode(" ", $b);
        return $b_sec - $a_sec + $b_dec - $a_dec;
    }

    /**
     * ファイルから行を取得
     *
     * @access  public
     * @param   Integer $fh             ファイルポインタ
     * @param   Integer $maxbuffersize  読み込みバッファサイズ
     * @return  String  行文字列
     */
    public static function fgetline(&$fh, $maxbuffersize = 16000) {
        $line = '';
        do {
            $line .= fgets($fh, $maxbuffersize);
        } while (strrpos($line, "\n") === FALSE and !feof($fh));
        return strlen ($line) == 0 ? FALSE : $line;
    }


    /**
     * 指定のIPアドレス帯域にIPアドレスがあるかチェックする
     * @param   String  $cidraddr   CIDR形式のIPアドレス帯域(例: 210.153.84.0/24)
     * @param   String  $checkaddr  チェックするIPアドレス(例: 210.153.84.7)
     * @return  Boolean 結果
     */
    public static function checkiprange($cidraddr, $checkaddr) {
        list($netaddr, $cidrmask) = explode("/", $cidraddr);
        $netaddr_long = ip2long($netaddr);
        $cidrmask = pow(2, 32 - $cidrmask) - 1;
        $bits1 = str_pad(decbin($netaddr_long), 32, "0", "STR_PAD_LEFT");
        $bits2 = str_pad(decbin($cidrmask), 32, "0", "STR_PAD_LEFT");
        $final = '';
        for ($i = 0; $i < 32; $i++) {
            if ($bits1[$i] == $bits2[$i]) {
                $final .= $bits1[$i];
            }
            if ($bits1[$i] == 1 and $bits2[$i] == 0) {
                $final .= $bits1[$i];
            }
            if ($bits1[$i] == 0 and $bits2[$i] == 1) {
                $final .= $bits2[$i];
            }
        }
        $final_long = ip2long(long2ip(bindec($final)));
        $checkaddr_long = ip2long($checkaddr);
        if ($checkaddr_long >= $netaddr_long and $checkaddr_long <= $final_long) {
            return TRUE;
        }
        else {
            return FALSE;
        }
    }

    /**
     * ホスト名のパターンリストマッチ
     *
     * @access  public
     * @param   Array   $hostlist ホスト名のパターンリスト
     * @return  Boolean マッチ有無
     */
    public static function hostname_match($hostlist) {
        if (!$hostlist or !is_array($hostlist)) {
            return;
        }
        $hit = FALSE;
        list ($addr, $host, $proxyflg, $realaddr, $realhost) = Func::getuserenv();
        foreach ($hostlist as $hostpattern) {
            if (preg_match("/$hostpattern/", $host) or preg_match("/$hostpattern/", $realhost)) {
                $hit = TRUE;
                break;
            }
        }
        return $hit;
    }

    /**
     * デバッグ用
     *
     */
    public static function debugwrite($debugstr, $printdate = TRUE, $debugfile = "debug.txt") {
        $fhdebug = @fopen($debugfile, "ab");
        if (!$fhdebug) {
            return;
        }
        flock ($fhdebug, 2);
        if ($printdate) {
            fwrite ($fhdebug, date("Y/m/d H:i:s\t (T)", CURRENT_TIME));
        }
        fwrite ($fhdebug, "$debugstr\n");
        flock ($fhdebug, 3);
        fclose ($fhdebug);
    }
}
/* end of class Func */
