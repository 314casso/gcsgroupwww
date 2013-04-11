<?

/*
 *  $Id: LOGIN.php,v 1.6 2004/12/19 22:54:34 dave Exp $
 *
 *  $Log: LOGIN.php,v $
 *  Revision 1.6  2004/12/19 22:54:34  dave
 *  Корректная отработка формы для logout
 *
 *
 */

global $login_html,$logged_info,$sitelogged,$doc;

if (!$sitelogged)
{
	if (!$loginhtml)
        {
                echo $login_html;
        }
        else
        {
                echo $loginhtml;
        }
}
else
{
        if (!$loggedinfo)
        {
                $loggedinfo=$logged_info;
        }

        foreach($sitelogged as $k=>$v)
        {
        	if (ctype_alpha($k))
        	{
        		$loggedinfo=str_replace("[$k]",$v,$loggedinfo);
			$loggedinfo=str_replace(strtoupper($k),$v,$loggedinfo);
		}
        }

        $loggedinfo=str_replace("[logout]","javascript:document.forms.logoutform.submit();",$loggedinfo);
        //Added by Meremin 17.12.04
        $loggedinfo=str_replace("LOGOUT","'javascript:document.forms.logoutform.submit();'",$loggedinfo);
        //End of addition
        if (!defined ('ENGINE_LOGOUT_FORM_EXISTS'))
        {
                echo '<form method="POST" style="display:none" id="logoutform" name="logoutform" action=""><input type="hidden" name="logout" value="1" /></form>';
                define ('ENGINE_LOGOUT_FORM_EXISTS', true);
        }

        echo $loggedinfo;
}



?>