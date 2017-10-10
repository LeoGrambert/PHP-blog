# Projet3_CPMDev

<h4>Create a blog to a writter without framework or CMS</h4>

<hr>

<h4>How to download and use this project ?</h4>

<h5>1. Download zip</h5>
<h5>2. Unzip it where you want</h5>
<h5>3. Connect to mysql <code>mysql -u yourUsername -p</code> and create database <code>CREATE DATABASE blog_JF;</code>
<br>Import the sql files (you can find those in docs/) and copy paste the content in your command prompt</h5>
<h5>4. Change the constants in the App_dev.php file (DB_USER, DB_PASS and DB_HOST) and change the file name to App.php (don't forget to also change the class name)</h5>
<h5>5. In your command prompt, go in blog/ (don't forget, otherwise you'll get an 404 error) and run php server <code>php -S localhost:8080 -ddisplay_errors=1 -dzend_extension=xdebug.so -dxdebug.remote_enable=1 -dxdebug.remote_autostart=1 -dxdebug.remote_port=3004</code></h5>

Now, you can go to this adress : http://127.0.0.1:8080/web/index.php?p=1

To access the administration interface, use this : "username" "password"

<hr>

<strong>Architecture logic :</strong>

![diagram](https://github.com/LeoGrambert/projet3_CPMDev/blob/master/docs/logique_mvc.png?raw=true)

<hr>

Find instructions here : https://openclassrooms.com/projects/creez-un-blog-pour-un-ecrivain-1

Leo Grambert
