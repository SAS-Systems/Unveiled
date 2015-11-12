#!/bin/bash

# upload each file via ftp
cd Backend-PHP-Stack
for file in $(find . -type f)
do
	printf "\nupload $file to server at php/test/";
	curl --ftp-create-dirs -T "$file" -u $FTP_USER:$FTP_PASSWORD "$FTP_URL/php/test/$file";
done; # file