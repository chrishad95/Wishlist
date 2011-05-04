<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
echo form_open();
echo form_input('first_name','First Name');
echo form_input('last_name','Last Name');
echo form_input('username','Username');
echo form_password('password','Password');
echo form_password('password2','Password Confirm');
echo form_input('email_address','Email Address');
echo form_submit('submit','Create Account');
echo form_close();

?>
