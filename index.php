<?php 
    /*
        22 - 05 - 2015 / 17:40  -> Son Güncellenme : 08 - 10 - 2015 : 09:50     
    
        Script Name : Kur.php

        Amac = Script Kurulum Dosyası. İnstall.php - Kur.php
        
        İzinsiz Kullanmayınız. 

        Coder Tolga TURAN

        E-Mail : tolqaturan@aol.com
    */

?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>Script Kurulumu - Tolga Turan</title>
	<link rel="stylesheet" type="text/css" href="Style.css">
	<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script type="text/javascript" src="form.js"></script>
</head>
<body>

<?php 
// Daha Önce Kurulum olmuş mu olmamış mı Kontrolü
if(file_exists("baglan.php")){
    echo '<h1><center>Daha Önce Bu Scripti Kurmuşsunuz.</center></h1>';
}else{

?>

<div id="orta">
<?php 

    if($_POST){
        // Formdan Gelen Değerler
        // Mysql Değerleri ;
        $host           = $_POST['host'];
        $mysql_username = $_POST['mysql_username'];
        $mysql_password = $_POST['mysql_password'];
        $vt_name        = $_POST['vt_name'];
        // Site Bilgiler Değerleri ;
        $site_url       = $_POST['site_url'];
        $site_baslik    = $_POST['site_baslik'];
        $site_logo      = $_POST['site_logo'];
        // Admin Bilgiler Değerleri ;
        $username       = $_POST['username'];
        $password       = $_POST['password'];
        $user_email     = $_POST['user_email'];
        $user_rank      = "Admin";

        // Formdan Gelen bilgiler ile Mysql Bağlantı Sağlama ;
        $baglan = @mysql_connect($host,$mysql_username,$mysql_password);
        // Bağlantı Sağlanmışmı Kontrolü ;
        if($baglan){
        // Mysql Bağlantısı Sağlandıysa ;
            // DB Tablo Oluştur;
            $tablo = @mysql_query("CREATE DATABASE $vt_name",$baglan);
                     mysql_select_db($vt_name,$baglan);

            // Oluşturduğumuz DB'ye Site_Ayar Tablosu ekleme ;
            $site_ayar = mysql_query("CREATE TABLE site_ayar (
                        id int(11) AUTO_INCREMENT PRIMARY KEY,
                        site_url varchar(225),
                        site_baslik varchar(225),
                        site_logo varchar(225) )",$baglan);
            // Oluşturduğumuz DB'ye Users Tablosu ekleme ;
            $users    = mysql_query("CREATE TABLE users (
                        id int(11) AUTO_INCREMENT PRIMARY KEY,
                        username varchar(225),
                        password varchar(225),
                        user_email varchar(225),
                        user_rank varchar(225) )",$baglan);
            $kontrol = $site_ayar.$users;
            if($kontrol){
            // Bağlan.php dosyasını oluşturup içine Bağlantı Dosyalarını girelim ;
            $dosya = touch("baglan.php"); // baglan.php ismi değiştirilebilir ve yeride.
                if($dosya){
                    $ac = fopen("baglan.php",'w');
                    $icerik = '<?php 
                    $host           = "'.$host.'";
                    $mysql_username = "'.$mysql_username.'";
                    $mysql_password = "'.$mysql_password.'";
                    $vt_name        = "'.$vt_name.'";
                    $baglan         = @mysql_connect($host,$mysql_username,$mysql_password);
                                      @mysql_select_db($vt_name,$baglan);
                    ?>';
                    $kaydet = fwrite($ac,$icerik);

                    // Site Ayar sütununa bilgileri ekleyelim ;
                    $site_ayar = mysql_query("insert into site_ayar (site_url,site_baslik,site_logo) 
                               values('$site_url','$site_baslik','$site_logo')");
                    // Admin Üye Bilgilerini Ekleyelim ;
                    $site_ayar = mysql_query("insert into users (username,password,user_email,user_rank) 
                               values('$username','$password','$user_email','$user_rank')");
                    echo'<div style="font-weight:bold;color:green;font-size:14px;Font-family:Georgia">Tebrikler Siteniz Başarıyla Kurulmuştur. Lütfen Bu Dosyayı Siliniz.</div>';
                }       
            }    

        }else{
            echo '<div style="font-weight:bold;color:red;font-size:14px;Font-family:Georgia">Mysql Bağlantı Sağlanamadı. Bilgilerinizi Kontrol Ediniz.</div>';
        }
    }
?>
<!-- Form Alanı -->
<form id="Turan" action="" method="post">
    <fieldset>
        <legend> DataBase Bilgileri</legend>
        <label for="Name">Host - İp</label>
        <input id="Name" name="host" type="text" required />
        <label for="name">Mysql Kullanıcı Adı</label>
        <input id="name" type="text" name="mysql_username" required />
        <label for="Password">Mysql Şifre</label>
        <input id="Password" type="password" name="mysql_password" />
        <label for="CompanyName">Veritabanı Adı</label>
        <input id="CompanyName" type="text" name="vt_name" required />
    </fieldset>
    <fieldset>
        <legend> Site Bilgileri</legend>
        <label for="Website">Site URL</label>
        <input id="Website" type="text" name="site_url" required />
        <label for="Website">Site Başlığı</label>
        <input id="Website" type="text" name="site_baslik" required />
        <label for="CompanyEmail">Site Logo</label>
        <input id="Name" type="text" name="site_logo" />
    </fieldset>
    <fieldset>
        <legend>Admin Bilgileri</legend>
        <label for="Website">Kullanıcı Adınız</label>
        <input id="Name" type="text" name="username" required />
        <label for="Website">Kullanıcı Şifreniz</label>
        <input id="Name" type="text" name="password" />
        <label for="CompanyEmail">E-Mail Adresiniz</label>
        <input id="CompanyEmail" type="text" name="user_email" required />
    </fieldset>
    <p>
        <input id="Kaydet" class="button" type="submit" value="Kurulum İşlemini Tamamlayınız..." />
    </p>
</form>
<!--#Form Alanı -->
</div>

</body>
</html>
<?php 
// Dosya var mı yok mu Kontrol Parantez Kapanışı
    }
?>