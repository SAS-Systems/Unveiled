#!/bin/bash

# upload each file via ftp
for file in Backend-PHP-Stack/*
do
	curl --ftp-create-dirs -T $file -u $FTP_USER:$FTP_PASSWORD $FTP_URL/test/;
done; # file