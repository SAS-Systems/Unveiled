#!/bin/bash

# upload each file via ftp
for file in $(find Backend-PHP-Stack -type f)
do
	echo "upload $file to $FTP_URL/test/";
	curl --ftp-create-dirs -T "$file" -u $FTP_USER:$FTP_PASSWORD "$FTP_URL/test/";
done; # file