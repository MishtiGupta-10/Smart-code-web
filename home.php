<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form name = "myform" action="" method = "POST" enctype = "multipart/form-data">
        <table border = '1'>
            <tr>
                <td>Name of the file:</td>
                <td><input type="text" name = "name"><span id = "etext"></span></td>
            </tr>
            <tr>
                <td>Upload Files:</td>
                <td><input type = "file" name = "file" placeholder = "choose file"><span id = "efile"></span></td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type = "submit" value = "Upload" name = "upload">
                    <input type = "submit" value = "Get List" name = "get">

                </td>
            </tr>
        </table>
    </form>
</body>
</html>

<?php


if(isset($_POST['upload']))
    {
        $target_dir = "uploads/";
        $target_file = $target_dir.basename($_FILES['file']['name']);
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        $name = $_POST['name'];
        $file = $_FILES['file']['name'];

        //checking if directory exits
        if(!is_dir($target_file))
        {
            mkdir($target_dir);
        }

        // checking if file already exists
        if(file_exists($target_file))
        {
            echo "File already exists.";
            $error = 0;
        }

        //validating file type
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "pdf" && $imageFileType != "mp4" && $imageFileType != "docx" && $imageFileType != "csv")
        {
            echo "File type not permitted.";
            $error = 0;
        }

        if($error == 0)
        {
            echo "Sorry, file not uploaded.";
        }
        else
        {
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) 
            {
                echo "The file ". htmlspecialchars( basename( $_FILES["file"]["name"])). " has been uploaded.";
            }
            else 
            {
                echo "There was an error uploading the file.";
            }
        }

    }

    if (isset($_POST['get']))
    {
        $y = "<form method = 'POST'>";
        $y .= "<table border = '1' cellpadding = '5'>";
        $y .= "<tr>
                    <th>File</th>
                    <th>Size</th>
                    <th>Type</th>
                    <th>Download</th>
                    <th>Delete</th>
               </tr>";
        $dir = "uploads/";
        $files = scandir($dir);
        
        foreach($files as $file)
        {
            $filepath = $dir.$file;
            if(is_file($filepath))
            {
                $size = round(filesize($filepath)/1024,2);
                $type = mime_content_type($filepath);
                $downloadlink = $filepath;

                $y.= "<tr>
                            <td>".$file."</td>
                            <td>".$size."</td>
                            <td>".$type."</td>
                            <td><a href = '" .$downloadlink."' download>Download</a></td>
                            <td>
                                <button type = 'submit' name = 'delete' value = '".$file."'>Delete</button>
                            </td>
                    </tr>";
            }
        }
        $y .= "</table>";

        echo $y;
    }


?>