#!/bin/bash

#########################################
# upload each php file via ftp
#########################################

cd Backend-PHP-Stack
# branch-dependent folder:
#   --> extend if necessary <--
case "$BRANCH" in
	'Backend-PHP-Stack')
		PATH = "php"
		;;
#	'someBranch' | 'otherBranch')
#		PATH = "common/folder/for/both/branches"
#		;;
	*)
		PATH = "test/php"
		;;
esac

# iterate over files and upload them with curl
for FILE in $(find . -type f)
do
	printf "\nupload $FILE to server at $PATH/$FILE";
	curl --ftp-create-dirs -T "$FILE" -u $FTP_USER:$FTP_PASSWORD "$FTP_URL/$PATH/$FILE";
done; # file