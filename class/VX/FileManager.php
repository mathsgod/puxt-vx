<?php

namespace VX;

use League\MimeTypeDetection\GeneratedExtensionToMimeTypeMap;

class FileManager
{
    static $DisallowExt = ['zip', 'js', 'jsp', 'jsb', 'mhtml', 'mht', 'xhtml', 'xht', 'php', 'phtml', 'php3', 'php4', 'php5', 'phps', 'shtml', 'jhtml', 'pl', 'sh', 'py', 'cgi', 'exe', 'application', 'gadget', 'hta', 'cpl', 'msc', 'jar', 'vb', 'jse', 'ws', 'wsf', 'wsc', 'wsh', 'ps1', 'ps2', 'psc1', 'psc2', 'msh', 'msh1', 'msh2', 'inf', 'reg', 'scf', 'msp', 'scr', 'dll', 'msi', 'vbs', 'bat', 'com', 'pif', 'cmd', 'vxd', 'cpl', 'htpasswd', 'htaccess'];
    static function LookupMimeType(string $file_type): array
    {
        $map = new GeneratedExtensionToMimeTypeMap();

        $type = [];
        switch ($file_type) {
            case "image":
                $ext = ["jpg", "png", "gif", "tiff"];
                break;
            case "document":
                $ext = ["pdf", "doc", "docx", "xls", "xlsx", "txt"];
                break;
            case "video":
                $ext = ["mp4", "wmv", "avi", "flv", "mov"];
                break;
            case "audio":
                $ext = ["mp3", "wma", "wav", "aac"];
                break;
            case "archive":
                $ext = ["zip", "rar", "tar", "7z"];
                break;
        }


        foreach ($ext as $e) {
            $type[] = $map->lookupMimeType($e);
        }


        return $type;
    }



    static function FormatBytes($bytes, $precision = 2)
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        // Uncomment one of the following alternatives
        $bytes /= pow(1024, $pow);
        // $bytes /= (1 << (10 * $pow)); 

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
