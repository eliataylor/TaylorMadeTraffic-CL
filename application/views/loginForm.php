<div style="width:300px; margin:20px auto;">
    <form method="POST" action="/lenguaplus/login" accept-charset="UTF-8">        
        <h2><?php echo $this->lang->en('Enter your credentials')?></h2>
        <p><label for="username"><?php echo $this->lang->en('Email')?></label></p>
        <p><input type="text" name="username" id="username"></p>
        <p><label for="password"><?php echo $this->lang->en('Password')?></label></p>
        <p><input type="password" name="password" id="password"></p>
        <p><button type="submit"><?php echo $this->lang->en('Submit')?></button></p>
    </form>
</div>