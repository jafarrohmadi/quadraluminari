<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
    <title>Quadra Luminary</title>
    <style>
        a:hover {
            text-decoration: underline !important;
        }
    </style>
</head>

<body style="margin: 0px; background-color: #f2f3f8;" topmargin="0" marginwidth="0" marginheight="0" leftmargin="0">
<table
    style="@import url(https://fonts.googleapis.com/css?family=Rubik:300,400,500,700|Open+Sans:300,400,600,700); font-family: 'Open Sans', sans-serif;"
    width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#f2f3f8">
    <tbody>
    <tr>
        <td>
            <table style="background-color: #f2f3f8; max-width:670px; margin:0 auto;" width="100%" cellspacing="0"
                   cellpadding="0" border="0" align="center">
                <tbody>
                <tr>
                    <td style="height:80px;">&nbsp;</td>
                </tr>
                <!-- Logo -->
                <tr>
                    <td style="text-align:center;">
                        <a href="#">
                            <img
                                src="{{ asset('img/logo.png') }}" width="210">
                        </a>
                    </td>
                </tr>
                <tr>
                    <td style="height:40px;">&nbsp;</td>
                </tr>
                <!-- Email Content -->
                @foreach($data as $key => $datas)
                <tr>
                    <td>

                        <table
                            style="max-width:670px; background:#fff; border-radius:3px;-webkit-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);-moz-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);box-shadow:0 6px 18px 0 rgba(0,0,0,.06);padding:0 40px;"
                            width="95%" cellspacing="0" cellpadding="0" border="0" align="center">
                            <tbody>
                            <tr>
                                <td style="height:40px;">&nbsp;</td>
                            </tr>
                            <!-- Title -->
                            <tr>
                                <td style="padding:0 15px; text-align:center;">
                                    <h1 style="color:#1e1e2d; font-weight:400; margin:0;font-size:32px;font-family:'Rubik',sans-serif;">Act Reminder : {{ $key + 1 }} </h1>
                                    <span style="display:inline-block; vertical-align:middle; margin:29px 0 26px; border-bottom:1px solid #cecece;
                                        width:100px;"></span>
                                </td>
                            </tr>
                            <!-- Details Table -->

                                <tr>
                                    <td>
                                        <table style="width: 100%; border: 1px solid #ededed" cellspacing="0"
                                               cellpadding="0">
                                            <tbody>
                                            <tr>
                                                <td style="padding: 10px; border-bottom: 1px solid #ededed; border-right: 1px solid #ededed; width: 35%; font-weight:500; color:rgba(0,0,0,.64)">
                                                    Company Name :
                                                </td>
                                                <td style="padding: 10px; border-bottom: 1px solid #ededed; color: #455056;">
                                                    {{ $datas->activeOpportunityData->activeClientData->name }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 10px; border-bottom: 1px solid #ededed; border-right: 1px solid #ededed; width: 35%; font-weight:500; color:rgba(0,0,0,.64)">
                                                    Act :
                                                </td>
                                                <td style="padding: 10px; border-bottom: 1px solid #ededed; color: #455056;">
                                                    {{ $datas->act_history_reminder != \App\Models\ActiveOpportunity::ACT_HISTORY_OTHER ? (new \App\Models\ActiveOpportunity)->getActHistory($datas->act_history_reminder) : $datas->act_history_other_name_reminder}}

                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 10px; border-bottom: 1px solid #ededed; border-right: 1px solid #ededed; width: 35%; font-weight:500; color:rgba(0,0,0,.64)">
                                                    Order :
                                                </td>
                                                <td style="padding: 10px; border-bottom: 1px solid #ededed; color: #455056;">
                                                    {{ $datas->act_history_order_reminder }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 10px; border-bottom: 1px solid #ededed; border-right: 1px solid #ededed; width: 35%; font-weight:500; color:rgba(0,0,0,.64)">
                                                    Notes :
                                                </td>
                                                <td style="padding: 10px; border-bottom: 1px solid #ededed; color: #455056;">
                                                    {{ $datas->act_history_notes_reminder }}
                                                </td>
                                            </tr>


                                            </tbody>
                                        </table>
                                    </td>
                                </tr>

                            <tr>
                                <td style="height:40px;">&nbsp;</td>
                            </tr>
                            </tbody>
                        </table>

                    </td>
                </tr>
                <br>
                @endforeach

                <tr>
                    <td style="height:20px;">&nbsp;</td>
                </tr>
                <tr>
                    <td style="text-align:center;">
                        <p style="font-size:14px; color:#455056bd; line-height:18px; margin:0 0 0;">Powered by <strong>Quadraluminari</strong>
                        </p>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
    <br>
</table>

</body>
</html>
