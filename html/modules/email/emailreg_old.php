<?php
$mailsubject  = _("Dear trader!");
$mailsubject  = "=?UTF-8?B?" . base64_encode($mailsubject) ."?=";
$mailbody_html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>' . sprintf(_("%s NEWSLETTER"), $this->m->config->sitename) . '</title>
</head>
<body>
        <table border="0" cellpadding="0" cellspacing="0" height="111" width="600">
            <tbody>
                <tr>
                    <td colspan="3" with="600" height="10" width="600">
                        <img src="http://' . $_SERVER["SERVER_NAME"] . '/html/' . XNAME . '/images/llog.jpg" alt="" style="display: block;" height="10" width="600">
                    </td>
                </tr>
                <tr>
                    <td colspan="3" with="600" valign="top">
                        <table border="0" cellpadding="0" cellspacing="0" width="600">
                            <tbody>
                                <tr>
                                    <td rowspan="2" bgcolor="#3e3e3e" width="8">&nbsp;</td>
                                    <td rowspan="2" bgcolor="#475580" width="33">&nbsp;</td>
                                    <td width="518">
                                        <table border="0" cellpadding="0" cellspacing="0" width="518">
                                            <tbody>
                                                <tr>
                                                    <td align="right" bgcolor="#475580" height="35">
                                                        <table border="0" cellpadding="0" cellspacing="0" height="33" width="450">
                                                            <tbody>
                                                                <tr>
                                                                    <td colspan="7" style="padding-right: 10px; font-family: arial; font-size: 10px; color: #ffffff;" align="right" height="25" width="487">' ._(" To:"). '' . $row->firstname . ',' ._(" To start trading click"). '<a href="http://' . $_SERVER["SERVER_NAME"] . '/" target="_blank" style="color: #ffffff ;" >' ._(" Here"). '</a> &raquo; </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td bgcolor="#475580" height="35"><img src="http://' . $_SERVER["SERVER_NAME"] . '/html/' . XNAME . '/images/logo_small.png" alt="" style="margin-top: 10px; margin-bottom: 20px;"></td>
                                                </tr>
                                                <tr>
                                                    <td style="font-family: Arial,Helvetica,sans-serif; font-size: 12px; color: #000000; line-height: 16px; padding: 10px 10px 0px;" bgcolor="#ffffff" valign="top">'
. _("Dear ").$row->firstname
. '<p>' . sprintf(_("%s welcomes you as a new customer at our advanced trading platform and thank you for choosing our service."), $this->m->config->sitename) . '</p>'
. '<p style="font-weight:600;">' . _("Account details.") . '</p>'
. '<p>' . _("Your trading account login username is the email you registered with.") . '</p>'
. '<p>' . _("Email: ") . $row->email . '</p>'
. '<p>' . _("Password").': ' . $this->pswrd . '</p>'
. '<p style="font-weight:600;">' . _("Getting started.") . '</p>'
. '<p>' . _("To start trading now, you can make a deposit to your account, or try a free demo account, switching a trade mode in the top of the site.") . '</p>'
. '<p>' . _("Follow this link to login and deposit funds to your account") . '</p>'      
. '<p>' . _("Site address:") . '<a href="http://' . $_SERVER["SERVER_NAME"] . '/account/deposit/">http://' . $_SERVER["SERVER_NAME"] . '/account/deposit/</a></p>'
. '<p>' . _("Click on \"Personal Cabinet\" and than \"Deposit funds\" where you can choose one of the many payment methods we offer: Credit Card, wire transfer and e-wallets.") . '</p>'
. '<p>' . _("If you want to make an offer or ask a question, please write to us at:") . '<a href="mailto: ' . $this->m->config->email . '">' . $this->m->config->email . '</a></p>'
. '<p>&nbsp;</p>'
. '<p>' . sprintf(_("Sincerely, Administration %s."), $this->m->config->sitename) . '</p>
<br>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                    <td rowspan="2" bgcolor="#475580" width="33">&nbsp;</td>
                                    <td rowspan="2" bgcolor="#2a2a2a" width="8">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td bgcolor="#475580" height="33"><br>
                                            <table border="0" cellpadding="0" cellspacing="0" height="33" width="450">
                                                <tbody>
                                                    <tr>
                                                        <td colspan="7" style="padding-left: 10px;" align="left" height="25" width="487">
                                                            <span style="font-weight: normal; text-decoration: none; font-style: normal; font-family: Arial; font-size: 10px; color: #ffffff;">' ._("This email was sent to") . ' ' . $row->email . '</span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        <br>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td with="600" colspan="3" height="6">
                        <img src="http://' . $_SERVER["SERVER_NAME"] . '/html/' . XNAME . '/images/newsletter_bottomcorners.jpg" alt="" style="display: block;" height="6" width="600">
                    </td>
                </tr>
            </tbody>
        </table>
</body>
</html>';

$mailbody_txt =  _("Dear") .$row->firstname. ".\n\n"
              . sprintf(_("%s welcomes you as a new customer to our advanced trading platform and thank you for choosing our service."), $this->m->config->sitename)."\n\n"
              . _("Account details.")."\n\n"
              . _("Your trading account login username is the email you registered with")."\n\n"
              . _("E-mail ") . $row->email . "\n\n"
              . _("Password") .': '. $this->pswrd . "\n\n"
              . _("Getting started.")."\n\n"
              . _("To start trading now, you must first deposit funds into your account.")."\n\n" 
              . _("Follow this link to login and deposit funds to your account")."\n\n"
              . _("Site address:")." http://" . $_SERVER["SERVER_NAME"] . "\n\n"
              . _("Click on \"Personal Cabinet\" and than \"Deposit funds\" where you can choose one of the many payment methods we offer: Credit Card, wire transfer and e-wallets .")."\n\n"
              
              . sprintf(_("If you want to make an offer or ask a question, please write to us at: support@%s"),$this->m->config->sitename). "\n\n"
                            . "\n"
              .sprintf(_("Sincerely, Administration %s."), $this->m->config->sitename)."\n"
              ;
?>