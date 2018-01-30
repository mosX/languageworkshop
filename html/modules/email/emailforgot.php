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
                            <img src="http://' . $_SERVER["SERVER_NAME"] . '/html/' . XNAME . '/images/newsletter_topcorners.jpg" alt="" style="display: block;" height="10" width="600">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" with="600" valign="top">
                            <table border="0" cellpadding="0" cellspacing="0" width="600">
                                <tbody>
                                    <tr>
                                        <td rowspan="2" bgcolor="#3e3e3e" width="8">&nbsp;</td>
                                        <td rowspan="2" bgcolor="#000000" width="33">&nbsp;</td>
                                        <td width="518">
                                            <table border="0" cellpadding="0" cellspacing="0" width="518">
                                                <tbody>
                                                    <tr>
                                                        <td align="right" bgcolor="#000000" height="35">
                                                            <table border="0" cellpadding="0" cellspacing="0" height="33" width="450">
                                                                <tbody>
                                                                    <tr>
                                                                        <td colspan="7" style="padding-right: 10px; font-family: arial; font-size: 10px; color: #ffffff;" align="right" height="25" width="487">' ._("Username:"). '' . $row->firstname . ',' ._(" Forgot password? Click"). '<a href="http://' . $_SERVER["SERVER_NAME"] . '/?act=forgot" target="_blank" style="color: #ffffff ;" >' ._("here"). '</a> &raquo; </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td bgcolor="#000000" height="35"><img src="http://' . $_SERVER["SERVER_NAME"] . '/html/' . XNAME . '/images/logo.png" alt="" height="61" width="309" style="margin-top: 10px; margin-bottom: 20px;"></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="font-family: Arial,Helvetica,sans-serif; font-size: 12px; color: #000000; line-height: 16px; padding: 10px 10px 0px;" bgcolor="#ffffff" valign="top">'
    . _("Dear").$row->firstname
    . '<p>' . _(".") . '</p>'
    . '<p>' . _("According to request, your account password has being changed.") . '</p>'
    . '<p>' . _("The new password you have chosen is: .") .$password. '</p>'
    . '<p>' . sprintf(_("If you did not change your account password, or you have any suspicion that it has being hacked: please contact our support team at: %s."),$this->m->config->siteemail) . '</p>'
    . '<p>' . sprintf(_("Sincerely, Administration %s."), $this->m->config->sitename) . '</p>
    <br>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                        <td rowspan="2" bgcolor="#000000" width="33">&nbsp;</td>
                                        <td rowspan="2" bgcolor="#2a2a2a" width="8">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td bgcolor="#000000" height="33"><br>
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
                . _("According to request, your account password has being changed.")."\n\n"
                . _("The new password you have chosen is: ") . $password . "\n\n"
                . sprintf(_("If you did not change your account password, or you have any suspicion that it has being hacked: please contact our support team at: %s"),$this->m->config->siteemail)."\n\n"
                . sprintf(_("Sincerely, Administration %s."), $this->m->config->sitename)."\n"
                ;
?>