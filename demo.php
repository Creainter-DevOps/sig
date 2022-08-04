<?php


echo "FREE:" . disk_free_space('/') . "\n";
echo "TOTAL: " . disk_total_space('/') . "\n";
echo "%%%: " . ((disk_total_space('/') - disk_free_space('/')) / disk_total_space('/')) . "\n";
exit;

function normalizePath($path)
{
    $parts = array();// Array to build a new path from the good parts
    $path = str_replace('\\', '/', $path);// Replace backslashes with forwardslashes
    $path = preg_replace('/\/+/', '/', $path);// Combine multiple slashes into a single slash
    $segments = explode('/', $path);// Collect path segments
    $test = '';// Initialize testing variable
    foreach($segments as $segment)
    {
        if($segment != '.')
        {
            $test = array_pop($parts);
            if(is_null($test))
                $parts[] = $segment;
            else if($segment == '..')
            {
                if($test == '..')
                    $parts[] = $test;

                if($test == '..' || $test == '')
                    $parts[] = $segment;
            }
            else
            {
                $parts[] = $test;
                $parts[] = $segment;
            }
        }
    }
    return implode('/', $parts);
}

$path = "/var/www/html/sig.creainter.com.pe/config/../public/storage/demo/123/slaida.docx";

$cmd = pathinfo($path);

print_r($cmd);
exit;

$cmd  = dirname($cmd);

echo "\n" . $cmd . "\n";
