<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"/>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset={$const.global.encodingHTML}" />
        <link href="{$factory->stylesheet_dir}index.css" rel="stylesheet" type="text/css" />
		<link href="{$factory->stylesheet_dir}fonts.css" rel="stylesheet" type="text/css" />
		<link href="{$factory->stylesheet_dir}xpdiagram.css" rel="stylesheet" type="text/css" />
        <link rel="shortcut icon" href="{$factory->img_admin_dir}admin_logo.ico"/>
        <title>Вход в {$const.admin.name}</title>
    </head>
    <body>
        <table width="100%" border="0">
            <tr>
                <td align="center" colspan="2">
                    <img id="logo" src="{$factory->img_admin_dir}logo.gif" alt="{$const.admin.name}"/>
                </td>
            </tr>
            <tr>
                <td align="center" valign="middle" colspan="2">
                    <h1>Войти в {$const.admin.name}</h1>
                    {if $mess eq fail}
                    <p style="color:#FF0000">Учетная запись и/или пароль не верны</p>
                    {/if}
                    <form method="post" action="" id="formsec">
                        Учетная запись:
                        <input type="text" value="" name="login" id="login"/>
                        Пароль:
                        <input type="password" value="" name="pass" id="pass"/>
                        <input type="submit" value="Войти..." name="sub" id="name" class="corp"/>
                    </form>
                </td>
            </tr>
        </table>
	<br/>
        <center>
            <img alt="powered by xhtml" src="{$factory->img_admin_dir}xhtml.png"/>
            <img alt="powered by css" src="{$factory->img_admin_dir}css.png"/>
            <img alt="powered by php" src="{$factory->img_admin_dir}php.png"/>
            <img alt="powered by smarty" src="{$factory->img_admin_dir}smarty.png"/>
            <img alt="powered by ajax" src="{$factory->img_admin_dir}ajax.png"/>
            <img alt="powered by natali" src="{$factory->img_admin_dir}natali.png"/>
        </center>
    </body>
</html>
