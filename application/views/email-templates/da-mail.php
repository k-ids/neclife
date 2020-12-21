<style>
    .mail_body{
        border: 2px solid;
        border-color: #6293EC;
        border-radius: 8px;
        color: #6293EC;
        padding:10px;font-family: verdana;
    }
    .logo{
        width: 100%;
        float: left;
        position: relative;
        margin-bottom:10px;
        background-color: #6293EC;
        font-family: verdana;
    }
</style>
<div class="mail_body">
    <div class="logo">
        <img src="<?= base_url()?>resources/image/index.png" alt="logo image" style="padding:10px;">
    </div>
    <table border="0" cellspacing="5" cellpadding="1" width="100%">  
        <tr colspan="2" class="style3">
            <h4 style="display: block; margin: auto;margin-top: 50px;">WELCOME TO NECTAR LIFESCIENCES LTD.</h4>
        </tr>
        <tr>                                                                       
            <td colspan="2" class="style3"><p>Dear <?= $username ?>,<br/>      
                <p><?= $message ?></p>
            </td>           
        </tr>           
        <tr>                
            <td>&nbsp;&nbsp;</td>               
            <td align="left" valign="top">&nbsp;</td>           
        </tr>           
        <tr>                
            <td colspan="2" align="left" valign="top" class="style3">Regards,<br>             
                NECTAR LIFESCIENCES LTD.</td>           
        </tr>
    </table>
</div>