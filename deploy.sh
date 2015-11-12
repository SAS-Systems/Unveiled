#!/bin/bash

#########################################
# upload each php file via ftp
#########################################

cd Backend-PHP-Stack
# branch-dependent folder:
#   --> extend if necessary <--
case "$BRANCH" in
	'Backend-PHP-Stack')
		FOLDER = 'php'
		;;
#	'someBranch' | 'otherBranch')
#		FOLDER = 'common/folder/for/both/branchs'
#		;;
	*)
		FOLDER = 'test/php'
		;;
esac

# iterate over files and upload them with curl
for FILE in $(find . -type f)
do
	printf "\nupload $file to server at php/test/$file";
	curl --ftp-create-dirs -T "$file" -u $FTP_USER:$FTP_PASSWORD "$FTP_URL/$FOLDER/$FILE";
done; # file