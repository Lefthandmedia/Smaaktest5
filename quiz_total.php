<?php
require_once('classes/db.class.php');
$db = new db_class;

// Open up the database connection. 

if (!$db->connect())
$db->print_last_error(false);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/base.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<!-- InstanceBeginEditable name="doctitle" -->
    <title>Smaaktest Texel</title>
    <!-- InstanceEndEditable -->
<link href="/_css/bootstrap.css" rel="stylesheet" type="text/css" />
<link href="/_css/smaaktest.css" rel="stylesheet" type="text/css" />
<!-- InstanceBeginEditable name="head" -->
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script type="text/javascript" src="http://jzaefferer.github.com/jquery-validation/jquery.validate.js"></script>
    <script type="text/javascript" src="/_scripts/swfobject.js"></script>

    <link href="_css/smaaktest.css" rel="stylesheet" type="text/css"/>
    <link href="_css/forms.css" rel="stylesheet" type="text/css"/>

    <style type="text/css">
        label.error {
            display: inline;
            color: red;
            padding-left: .5em;
            vertical-align: top;
            font-weight: normal
        }

        p {
            clear: both;
        }

        .submit {
            margin-left: 12em;
        }

        em {
            font-weight: bold;
            padding-right: 1em;
            vertical-align: top;
        }
    </style>


    <script id="demo" type="text/javascript">
        $(document).ready(function ()
        {
            // alert('ready');
            // validate signup form on keyup and submit
            var validator = $("#subscribeform").validate({
                rules:{
                    geboortejaar:"required",
                    geslacht:"required",
                    samenstelling:"required",
                    opleiding:"required",
                    woningtype:"required",
                    postcode:"required",
                    ervaring:"required"
                },
                messages:{
                    geboortejaar:"verplicht veld",
                    geslacht:"verplicht veld",
                    samenstelling:"verplicht veld",
                    opleiding:"verplicht veld",
                    woningtype:"verplicht veld",
                    postcode:"verplicht veld",
                    ervaring:"verplicht veld"
                },
                errorPlacement:function (error, element)
                    {
                        if (element.is(":radio"))
                            error.appendTo(element.parent());
                         else
                            error.appendTo(element.parent());
                    }
            });
        });
    </script>
    <!-- InstanceEndEditable -->
</head>
<body>
<div id="wrapper">
  <div>
    <div style="float:left;width:500px"><a href="/" ><img src="/images/header2.gif" alt="Smaaktest Texel" width="700" height="65" border="0" /></a></div>
    <div class='clear'></div>
  </div>
  <div id="container"><!-- InstanceBeginEditable name="content" -->
        <p>
            <?php  if(isset($_POST['Submit'])) {
  $data = array(
   'user_ervaring' => $_POST['ervaring'],
            'user_geb_datum' => $_POST['geboortejaar'],
            'user_postcodegebied' => $_POST['postcode'],
            'user_samenstelling' => $_POST['samenstelling'],
            'user_auto' => $_POST['autobezit'],
            'user_geslacht' => $_POST['geslacht'],
            'user_opleiding' => $_POST['opleiding'],
            'user_woningtype' => $_POST['woningtype']
            );
            $id = $db->insert_array('users', $data);
            $_SESSION['user_id'] = $id;
            $data2 = array(
            'user_id' => $id);
            $id2 = $db->insert_array('app_stemmentotaal', $data2);
            $active_session = "_".$id;
            // maketable($active_session);
            ?>

        <div id="myAlternativeContent">
            <img src="images/header2.gif" width="700" height="65" alt="Smaaktest Haarlem"/><br/>
            <br/>
            De test maakt gebruik van Adobe flashplayer. download hier de flashplayer<br/><br/>
            <a href="http://www.adobe.com/go/getflashplayer"> <img
                    src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif"
                    alt="Get Adobe Flash player"/> </a></div>
        <script type="text/javascript">
            var flashvars = {};
            var params = {};
            var attributes = {};
            swfobject.embedSWF("/bin/Main.swf", "myAlternativeContent", "997", "770", "9.0.0", "/_scripts/expressInstall.swf", flashvars, params, attributes);
        </script>
        <!--[if !IE]>-->
        </object>
        <!--<![endif]-->
        </object>


        <script type="text/javascript">
            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', 'UA-18928182-1']);
            _gaq.push(['_trackPageview']);

            (function ()
            {
                var ga = document.createElement('script');
                ga.type = 'text/javascript';
                ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0];
                s.parentNode.insertBefore(ga, s);
            })();

        </script>

        <?php }  else { ?>

        <p><strong>Vul hier onder uw gegevens in</strong></p>

        <div id='startForm' style='background-color:#eee; padding:20px;'><br/>

            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="subscribeform" name="subscribeform">
                <table width="800" border="0" cellspacing="0" cellpadding="2">
                    <tr>
                        <td width="300" height="44" align="right"><label>Geboortejaar</label></td>
                        <td width="5">&nbsp;</td>
                        <td>
                            <select name="geboortejaar">
                                <?php
		for ($minyear = 1900; $minyear < date("Y"); $minyear++) {
		?>
                                <option value="<?php echo $minyear; ?>"><?php echo $minyear; ?></option>
                                <?php } ?>
                            </select>
                            <!--<input type="text" name="geboortejaar" size="4" maxlength="4" class="required validate-digits" />-->
                        </td>
                    </tr>
                    <tr>
                        <td align="right"><label>Geslacht</label></td>
                        <td>&nbsp;</td>
                        <td><?php $db->pulldown_query_geslacht("SELECT * FROM user_geslacht"); ?></td>
                    </tr>

                    <!-- tr>
                     <td align="right"><label>Woonplaats Veenendaal?</label></td>
                     <td>&nbsp;</td>
                     <td>JA
                       <?php $db->pulldown_query_auto("SELECT * FROM user_auto"); ?></td>
                   </tr -->


                    <tr>
                        <td align="right"><label>Mijn voorkeur gaat uit naar…</label></td>
                        <td>&nbsp;</td>
                        <td><?php $db->pulldown_query_samenstelling("SELECT * FROM user_voorkeur"); ?></td>
                    </tr>

                    <tr>
                        <td align="right"><label>Ik zou mezelf omschrijven als een…</label></td>
                        <td>&nbsp;</td>
                        <td><?php $db->pulldown_query_opleiding("SELECT * FROM user_opleidingen"); ?></td>
                    </tr>

                    <tr>
                        <td align="right"><label>Texel heeft een sterke identiteit.. </label></td>
                        <td>&nbsp;</td>
                        <td><?php $db->pulldown_query_woningtype("SELECT * FROM user_woningtype"); ?></td>
                    </tr>

                    <tr>
                        <td align="right"><label>Duurzaamheid versterkt toerisme op Texel...</label></td>
                        <td>&nbsp;</td>
                        <td><?php $db->pulldown_query_postcode("SELECT * FROM user_postcode"); ?></td>
                    </tr>

                    <tr>
                        <td align="right"><label>Mijn belangrijkste binding met Texel is..</label>
<!--<span class="small"> <br/>
Een bouwprofessional is werkzaam in een beroep gerelateerd aan de ‘architectuur’ of de bouw (zoals projectontwikkelaar, makelaar, architectuurhistoricus, beleidsmedewerker RO, etc.)</span>-->
                        </td>
                        <td>&nbsp;</td>
                        <td valign="top"><?php $db->pulldown_query_ervaring("SELECT * FROM user_ervaring"); ?></td>
                    </tr>


                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td><input name="Submit" type="submit" value="Verder" class="btn btn-primary"/></td>
                    </tr>
                </table>


            </form>

        </div>

        <script type="text/javascript">

            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', 'UA-18928182-1']);
            _gaq.push(['_trackPageview']);

            (function ()
            {
                var ga = document.createElement('script');
                ga.type = 'text/javascript';
                ga.async = true;
                ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                var s = document.getElementsByTagName('script')[0];
                s.parentNode.insertBefore(ga, s);
            })();

        </script>

        <?php } ?>
        <!-- InstanceEndEditable --></div>
  <div id="footer">
  <span style="float:left;">
  <a href="http://www.texel.nl/"><img src="images/gemTxl-footer.gif" alt="Gemeente Texel" width="320" height="47" border="0" /></a> &nbsp;&nbsp; <a href="http://www.iabr.nl"><img src="images/IABR-logo.gif" alt="IABR-2014" /></a> <img src="images/ism.gif" width="71" height="47" /> 
  <a href="http://www.faro.nl"><img src="/images/faro.gif" alt="FARO architecten" width="130" height="47" border="0" /></a> 
  <a href="http://www.la4sale.nl"><img src="images/la4sale.gif" alt="La4sale" /></a> 
  
  </span> <a href="colofon.htm" class="colofon">colofon</a></div>
</div>
</div>
</body>
<!-- InstanceEnd --></html>