<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>Board List Issue Reminder</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>
    <body style="margin:0; padding:10px 0 0 0;" bgcolor="#F8F8F8">
        <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable">
            <tr>
                <td align="center" valign="top">
                    <table border="0" cellpadding="20" cellspacing="10" width="600" id="emailContainer">
                        <tr>
                            <td align="center" valign="top">
                                <table border="0" cellpadding="20" cellspacing="0" width="100%" id="emailHeader">
                                    <tr>
                                        <td align="center" style="padding: 5px 5px 5px 5px;">
                                            <a href="{{_url('')}}" target="_blank">
                                                <!--<img src="http://v2.icons-agency.com/public/front/images/home-services/iconsLogo.png" alt="ICONS AGENCY" style="width:186px;border:0;"/>-->
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td align="center" valign="top" style="border: 1px solid #fbbc05;">
                                <table border="0" cellpadding="20" cellspacing="10" width="100%" id="emailBody">
                                    <tr>
                                        <td align="center" valign="top" style="background-color: #ccc;color: #ffffff;">
                                            Issue
                                        </td>
                                        <td align="center" valign="top">
                                            {{$data['title']}}
                                        </td>

                                    </tr>
                                    <tr>
                                        <td align="center" valign="top" style="background-color: #ccc;color: #ffffff;">
                                            Due Date
                                        </td>
                                        <td align="center" valign="top">
                                            {{$data['due_date']}}
                                        </td>
                                    </tr>
                                   

                                </table>
                            </td>
                        </tr>

                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>