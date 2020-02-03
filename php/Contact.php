<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" async preload>

<div>
    <form id="ajax-contact" method="post" action="../php/mailer.php">
        <fieldset>
            <input type='submit' name='submit' value='Verzenden' id="SendEmailButton"/>
            <span id="NameLabel">
                <label for='name'>Name: *</label>
                <input type='text' name='name' id='name' required/>
            </span>
            <br>
            <span>
                <label for='subject' >Subject: *</label>
                <input type='text' name='subject' id='subject' required/>
            </span>
            <br>
            <span>
                <label for='email' >Email:</label>
                <input type='email' name='email' id='email' /><span id="labelspan">(nodig indien wij weer contact met u willen opnemen)</span>
            </span>
            <input type="text" name="Phone" id="Phone" value="" style="display:none" tabindex="-1" autocomplete="off">
            
            <div class='text'>
                <textarea id='txtEditor'></textarea>
            </div>
        </fieldset>
    </form>
</div>
<div>
    <h1>Social</h1>
    <iframe async src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2FDoctorWhoFansBE%2F&tabs=timeline&width=400&height=500&small_header=true&adapt_container_width=true&hide_cover=false&show_facepile=true&appId=939167599586628" width="400" height="500" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media"></iframe>      
</div>
