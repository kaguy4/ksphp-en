<!-- くずはすくりぷとPHP  HTMLテンプレート  管理モード用 -->
<!-- 管理メニュー画面 -->
<patTemplate:tmpl name="adminmenu">
<header><span class="pagetitle"><a href="{CGIURL}" style="text-decoration: none;">{BBSTITLE}</a></span> <a href="{DEFURL}">←bbs</a></header>
<h1>Administration Menu</h1>
<p><strong>Warning:</strong> Unauthorized access to the admin menu is strictly prohibited.Violators will be tracked, identified and detained.</p>
<form method="post" action="{CGIURL}">
	<input type="hidden" name="m" value="ad" />
	<input type="hidden" name="ad" value="k" />
	<input type="hidden" name="u" value="{U}" />
	<input type="hidden" name="v" value="{V}" />
	<input type="submit" value="Delete Message" class="btn" />
</form>
<form method="post" action="{CGIURL}">
	<input type="hidden" name="m" value="ad" />
	<input type="hidden" name="ad" value="l" />
	<input type="hidden" name="u" value="{U}" />
	<input type="hidden" name="v" value="{V}" />
	<input type="submit" value="Log File browsing" class="btn" />
</form>
<form method="post" action="{CGIURL}">
	<input type="hidden" name="m" value="ad" />
	<input type="hidden" name="ad" value="p" />
	<input type="hidden" name="u" value="{U}" />
	<input type="hidden" name="v" value="{V}" />
	<input type="submit" value="Encrypted password regeneration" class="btn" />
</form>
<form method="post" action="{CGIURL}">
	<input type="hidden" name="m" value="ad" />
	<input type="hidden" name="ad" value="phpinfo" />
	<input type="hidden" name="u" value="{U}" />
	<input type="hidden" name="v" value="{V}" />
	<input type="submit" value="Server PHP Configuration Information" class="btn" />
</form>
<br>
<form method="post" action="{CGIURL}">
	<input type="submit" value="End" class="btn" />
</form>
</patTemplate:tmpl>

<!-- メッセージ削除モードメイン画面 -->
<patTemplate:tmpl name="killlist">
<header><span class="pagetitle"><a href="{CGIURL}" style="text-decoration: none;">{BBSTITLE}</a></span></header>
<h1>Message Deletion Mode</h1>
<form method="post" action="{CGIURL}">
	<input type="hidden" name="m" value="ad" />
	<input type="hidden" name="u" value="{U}" />
	<input type="hidden" name="v" value="{V}" />
	<a href="{DEFURL}">bbs</a>
	<input type="button" onclick="location.href='#bottom'" accesskey="B" value="▼" class="btn" title="Alt(+Shift)+B">
</form>
<form method="post" action="{CGIURL}">
	<input type="hidden" name="m" value="ad" />
	<input type="hidden" name="ad" value="x" />
	<input type="hidden" name="u" value="{U}" />
	<input type="hidden" name="v" value="{V}" />
	<p>Check the post you want to delete and press the "Delete Run" button at the bottom.</p>
	<hr>
	<span class="medium">Delete-Display-Posting date-Title-Contributor-Content (some）</span>
	<pre>
<patTemplate:tmpl name="killmessage">
<input type="checkbox" name="x[]" value="{POSTID}" /> - <a href="{CGIURL}?m=f&amp;s={POSTID}" target="link">{POSTID}</a> - [{WDATE}] - {TITLE} - {USER_NOTAG} - {MSGDIGEST}
</patTemplate:tmpl>
</pre>
<hr>
<input type="submit" value="　[!]Run Delete　" class="btn" />
</form>
<form method="post" action="{CGIURL}">
	<input type="hidden" name="m" value="ad" />
	<input type="hidden" name="u" value="{U}" />
	<input type="hidden" name="v" value="{V}" />
	<a href="{DEFURL}">bbs</a>
	<input type="button" onclick="location.href='#TOP'" accesskey="T" value="▲" class="btn" title="Alt(+Shift)+T"></form>
</patTemplate:tmpl>

<!-- 暗号化パスワード生成画面 -->
<patTemplate:tmpl name="setpass">
<header><span class="pagetitle">{BBSTITLE}</span> - password setting screen<header><br>
<form method="post" action="{CGIURL}">
	<input type="hidden" name="m" value="ad" />
	<input type="hidden" name="ad" value="ps" />
	<input type="hidden" name="u" value="{U}" />
	<input type="hidden" name="v" value="{V}" />
<div class = "bbsmsg"> Set the password.<br>
Please enter the"Administrative password"to be used in the management of the bulletin board from now on.<br>
The password you enter here is used for posting with the administrator's name and authentication in admin mode.</div>
	<br><br>
	<table border="2" cellspacing="4">
		<tr>
			<td align="center">Administrative password</td>
			<td align="center"><input size="30" type="text" name="ps" maxlength="127" value="" class="text" /></td>
		</tr>
	</table>
	<br><br>
	<input type="submit" value="Settings" class="btn" />　<input type="reset" value="Reset" class="btn" />
</form>
</patTemplate:tmpl>

<!-- 暗号化パスワード表示画面 -->
<patTemplate:tmpl name="pass">
<header><span class="pagetitle">{BBSTITLE}</span> - Password setting screen</header>
<form method="post" action="{CGIURL}">
	<div class="bbsmsg">We have generated an encrypted password!<br>
	Paste the following encrypted password string into the place of the bulletin board script body.</div>
	<br><br>
	<table border="2" cellspacing="4">
		<tr>
			<td align="center">Administrative password</td>
			<td align="center"><input size="{INPUTSIZE}" type="text" name="cp" value="{CRYPTPASS}" readonly="readonly" class="text" /></td>
		</tr>
	</table>
	<br><br>
	<a href="{CGIURL}">bbs</a>
</form>
</patTemplate:tmpl>
