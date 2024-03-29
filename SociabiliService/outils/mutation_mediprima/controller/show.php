<?php 
    $fileList = scandir("flux");
    $files = array();
    
    foreach($fileList as $file)
    {
        if(strpos($file, "FO") === 0)
        {
            $type = substr($file,3,strpos($file,".",3) -3);
            $files[$type][] = $file;
        }
    }
    
    foreach($files as $key => $array_files)
    {
        echo $key." : <form action='index.php?ctrl=show.php' method='post'><select name='file'>";
        foreach($array_files as $file)
        {
            echo "<option value='".$file."' >".$file."</option>";
        }
        echo "</select> <input type='submit' value='Go' /></form>";
    }