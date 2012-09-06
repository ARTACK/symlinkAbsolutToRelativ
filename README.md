symlinkAbsolutToRelativ
=======================

Script to switch from absolute symlinks to relative symlinks.

How to use:
php app/console symlink:absolut-to-relativ startpoint

Replace startpoint with a folder. The script will crawl all symlinks beyond that startpoint and switches them to relative symlinks.