<?php
if (extension_loaded('zip')) {
    echo "ZIP extension is loaded\n";
} else {
    echo "ZIP extension is NOT loaded\n";
}

if (class_exists('ZipArchive')) {
    echo "ZipArchive class exists\n";
} else {
    echo "ZipArchive class does NOT exist\n";
}