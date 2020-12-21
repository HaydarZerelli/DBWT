<?php
$link = mysqli_connect("127.0.0.1", // Host der Datenbank
        "root",                     // Benutzername zur Anmeldung
    "08101995",                 // Passwort
    "db_emensawerbeseite"       // Auswahl der Datenbanken (bzw. des Schemas)
);

if (!$link) {
    echo "Verbindung fehlgeschlagen: ", mysqli_connect_error();
    exit();
}

// Define a function to output files in a directory
function outputFiles($path, $link){
    // Check directory exists or not
    if(file_exists($path) && is_dir($path)){
        // Scan the files in this directory
        $result = scandir($path);

        // Filter out the current (.) and parent (..) directories
        $files = array_diff($result, array('.', '..'));

        if(count($files) > 0){
            // Loop through retuned array
            foreach($files as $file){
                if(is_file("$path/$file")){
                    // Display filename
                    $name = $file;
                    $id = substr($file,0, 2);
                    $stmt = $link->stmt_init();
                    $stmt = $link->prepare("update gericht set bildname=? where id=?");
                    $stmt->bind_param('ss', $name, $id);
                    $stmt->execute();
                    $stmt->close();

                } else if(is_dir("$path/$file")){
                    // Recursively call the function if directories found
                    outputFiles("$path/$file");
                }
            }
        } else{
            echo "ERROR: No files found in the directory.";
        }
    } else {
        echo "ERROR: The directory does not exist.";
    }
}

// Call the function
outputFiles("../emensa/public/img/gerichte/", $link);
?>
