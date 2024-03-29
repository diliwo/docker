<link rel="stylesheet" href="style/menu.css" />
<div class="menu" style='text-align:center;font-size:20px;'><b>Mutation Médiprima</b></div>
<div class="container" >
    <nav class="collapse navbar-collapse" style='padding-left:0px;padding-right:0px;'>
      <ul class="nav navbar-nav">
        <li>
          <a href="index.php?ctrl=new">Voir les nouvelles mutations à traiter</a>
        </li>
        <li>
          <a href="index.php?ctrl=search">Rechercher une mutation</a>
        </li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="index.php?ctrl=import">Importer les nouvelles mutations (<?php echo $compte_new_mut; ?>)</a></li>
      </ul>
    </nav>
</div>
<div style='border-bottom:2px #0269C2 solid;width:100%;'></div>
<div class="container" style='min-height:500px;'>